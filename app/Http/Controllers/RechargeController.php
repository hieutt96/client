<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\RequestJWT;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;
use Cookie;
use App\Libs\Config;
use Session;
use Illuminate\Support\Facades\Redis;
use App\User;
use Log;

class RechargeController extends Controller
{
	const RECHARGE_VNPAY = 1;
	const RECHARGE_MOMO = 2;

    public function getRecharge(Request $request) {
   		
    	$jwt = RequestJWT::encodeJWT();
    	$rs = RequestAPI::requestSetting('GET', '/api/recharge-type-amount/list', [
    		'query' => ['jwt' => $jwt],
    	]);
    	if($rs->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
    	$amounts = $rs->data;
    	$response = RequestAPI::requestSetting('GET', '/api/recharge-type/list', [
    		'query' => ['jwt' => $jwt],
    	]);
    	if($response->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
    	$types = $response->data;
    	return view('recharge.create', compact('amounts', 'types'));
    }

    public function postRecharge(Request $request) {

    	$request->validate([
    		'recharge_type_id' => 'required|numeric',
    		'amount' => 'required|numeric',
    	]);
    	$jwt = RequestJWT::encodeJWT();

    	$data = [
    		'recharge_type_id' => $request->recharge_type_id,
    		'amount' => $request->amount,
    	];
    	$accessToken = Cookie::get('access_token');

    	if($request->recharge_type_id == Config::VNPAY_TYPE) {
    		$urlReturn = Config::CLIENT_DOMAIN.'/recharge/url_return_vnpay';
	    	$data = [
	    		'amount' => (int) $request->amount,
				'recharge_type_id' => (int) $request->recharge_type_id,
				'url_return' => $urlReturn,
	    	];
    	}
    	if($request->recharge_type_id == Config::MOMO_TYPE) {
	    	$urlReturn = Config::CLIENT_DOMAIN.'/recharge/url_return_momo';
	    	$urlNotify = Config::CLIENT_DOMAIN.'/recharge/url_notify';
	    	$data = [
	    		'amount' => (int) $request->amount,
				'recharge_type_id' => (int) $request->recharge_type_id,
				'url_return' => $urlReturn,
				'url_notify' => $urlNotify,
	    	];
    	}
        if($request->recharge_type_id == Config::ONEPAY_TYPE) {
            $urlReturn = Config::CLIENT_DOMAIN.'/recharge/url_return_onepay';
            $urlNotify = Config::CLIENT_DOMAIN.'/recharge/url_notify_onepay';
            $data = [
                'amount' => (int) $request->amount,
                'recharge_type_id' => (int) $request->recharge_type_id,
                'url_return' => $urlReturn,
                'url_notify' => $urlNotify,
            ];
        }
        // dd([Cookie::get('access_token'),$data]);
    	$response = RequestAPI::requestLedger('POST', '/api/recharge', [
    		'headers' => ['Authorization'=> 'Bearer '.$accessToken],
    		'form_params' => $data,
    	]);
    	if($response->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
    	// dd($response->data);
    	$redis = Redis::connection();
    	// dd($redis->getConnection()->getParameters()->port);
    	// dd($request->user);
    	$redis->set('recharge_id_user_id_'.$request->user->id, $response->data->recharge_id);
    	// dd($redis->get('recharge_id_user_id_'.$request->user->id));

    	if($request->recharge_type_id == Config::VNPAY_TYPE) {

    		header('Location: '.$response->data->vpn_url_checkout.$response->data->vnp_url);
	        die();
    	}elseif($request->recharge_type_id == Config::MOMO_TYPE) {
    		header('location:'. $response->data->pay_url);
            die();
    	}elseif($request->recharge_type_id = Config::ONEPAY_TYPE) {

            header('location:'. $response->data->vpc_url_checkout.$response->data->pay_url);
            die();
        }
    	
        // Thông tin thẻ test (Chọn Ngân hàng NCB để thanh toán)

        // Số thẻ: 9704198526191432198

        // Tên chủ thẻ: NGUYEN VAN A

        // Ngày phát hành: 07/15

        // Mật khẩu OTP mặc định: 123456

        //https://developers.momo.vn/#thong-tin-testing-ung-dung-momo
        //phone 0917003000
    }

    public function responseDataVnp(Request $request) {
    	$data = $request->all();

    	$rechargeId = Redis::get('recharge_id_user_id_'.$request->user->id);
        // dd($rechargeId);
    	if(!$rechargeId) {
    		return redirect()->route('user.recharge');
    	}

    	$data['recharge_id'] = $rechargeId;
    	// dd(Cookie::get('access_token'));
    	if($data['vnp_ResponseCode'] != '00') {
            return redirect()->route('recharge.fail');
        }
        $accessToken = Cookie::get('access_token');
  		$response = RequestAPI::requestLedger('POST', '/api/recharge/complete', [
    		'headers' => ['Authorization'=> 'Bearer '.$accessToken],
    		'form_params' => $data,
    	]);

    	if($response->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
        $request->session()->put('recharge_id', $rechargeId);
    	if($response->data->code = '00') {
    		return redirect()->route('recharge.success');

    	}else {
    		return redirect()->route('recharge.fail');
    	}
    }

    public function responseDataMoMo(Request $request) {

    	$data = $request->all();
        Log::info(json_encode($data));
        $rechargeId = Redis::get('recharge_id_user_id_'.$request->user->id);
        // dd($rechargeId);
        if(!$rechargeId) {
            return redirect()->route('user.recharge');
        }

        $data['recharge_id'] = $rechargeId;
        // dd(Cookie::get('access_token'));
        
        $accessToken = Cookie::get('access_token');
        $response = RequestAPI::requestLedger('POST', '/api/recharge/complete', [
            'headers' => ['Authorization'=> 'Bearer '.$accessToken],
            'form_params' => $data,
        ]);
        $request->session()->forget('recharge_id');

        if($response->data->code == '00') {
            return redirect()->route('recharge.success');

        }else {
            return redirect()->route('recharge.fail');
        }
    }

    public function responseDataMoMoNotify(Request $request) {

        $data = $request->all();
        Log::info(json_encode($data));
        $rechargeId = $request->session()->get('recharge_id');
        // dd($rechargeId);
        if(!$rechargeId) {
            return ;
        }

        $data['recharge_id'] = $rechargeId;
        // dd(Cookie::get('access_token'));

        $accessToken = Cookie::get('access_token');
        $response = RequestAPI::requestLedger('POST', '/api/recharge/complete', [
            'headers' => ['Authorization'=> 'Bearer '.$accessToken],
            'form_params' => $data,
        ]);
        $request->session()->forget('recharge_id');
    }

    public function success(Request $request) {

    	if(Redis::get('recharge_id_user_id_'.$request->user->id)) {
    		Redis::del('recharge_id_user_id_'.$request->user->id);

    		Session::flash('success', 'Nạp tiền thành công');
    		return view('recharge.success');
    	}else {
    		return redirect()->route('user.recharge');
    	}
    }

    public function fail(Request $request) {

    	if(Redis::get('recharge_id_user_id_'.$request->user->id)) {
    		Redis::del('recharge_id_user_id_'.$request->user->id);

    		Session::flash('error', 'Nạp tiền thất bại');
    		return view('recharge.fail');
    	}else {

    		return redirect()->route('user.recharge');
    	}
    }
}
