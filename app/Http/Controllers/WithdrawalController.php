<?php

namespace App\Http\Controllers;
use App\Libs\RequestJWT;
use Illuminate\Http\Request;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;
use App\Libs\Config;
use Cookie;
use Illuminate\Support\Facades\Redis;
use App\User;
use Session;
use Log;

class WithdrawalController extends Controller
{

	const RECHARGE_VNPAY = 1;
	const RECHARGE_MOMO = 2;

    public function create(Request $request) {

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
    	return view('withdrawal.create', compact('amounts', 'types'));
    }

    public function postCreate(Request $request) {

    	$request->validate([
    		'withdrawal_type_id' => 'required|numeric',
    		'amount' => 'required|numeric',
    	]);

    	$data = [
    		'withdrawal_type_id' => $request->withdrawal_type_id,
    		'amount' => $request->amount,
    	];
    	$accessToken = Cookie::get('access_token');

        $user = User::getUserInfo();
        $rs = RequestAPI::requestLedger('GET', '/api/user-balance', [
            'headers' => ['Authorization' => 'Bearer '.$accessToken],
            'query' => [
                'user_id' => $user->id,
            ],
        ]);
        if($rs->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        if($rs->data->balance < $request->amount) {
            throw new AppException(AppException::ERR_ENOUGH_BALANCE);
            
        }

    	if($request->withdrawal_type_id == Config::VNPAY_TYPE) {
    		$urlReturn = Config::CLIENT_DOMAIN.'/withdrawal/url_return_vnpay';
	    	$data = [
	    		'amount' => (int) $request->amount,
				'withdrawal_type_id' => (int) $request->withdrawal_type_id,
				'url_return' => $urlReturn,
	    	];
    	}
    	if($request->withdrawal_type_id == Config::MOMO_TYPE) {
	    	$urlReturn = Config::CLIENT_DOMAIN.'/withdrawal/url_return_momo';
	    	$urlNotify = Config::CLIENT_DOMAIN.'/withdrawal/url_notify';
	    	$data = [
	    		'amount' => (int) $request->amount,
				'withdrawal_type_id' => (int) $request->withdrawal_type_id,
				'url_return' => $urlReturn,
				'url_notify' => $urlNotify,
	    	];
    	}
        // dd([$data, $accessToken]);
    	$response = RequestAPI::requestLedger('POST', '/api/withdrawal', [
    		'headers' => ['Authorization'=> 'Bearer '.$accessToken],
    		'form_params' => $data,
    	]);
    	if($response->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
        // dd($response);
    	$redis = Redis::connection();
    	// dd($redis->getConnection()->getParameters()->port);
    	// dd($request->user);
    	$redis->set('withdrawal_id_user_id_'.$request->user->id, $response->data->withdrawal_id);
    	// dd($redis->get('withdrawal_id_user_id_'.$request->user->id));

    	if($request->withdrawal_type_id == Config::VNPAY_TYPE) {

    		header('Location: '.$response->data->vpn_url_checkout.$response->data->vnp_url);
	        die();
    	}elseif($request->withdrawal_type_id == Config::MOMO_TYPE) {
    		header('location:'. $response->data->pay_url);
            die();
    	}
    }

    public function responseDataVnp(Request $request) {

        $data = $request->all();

        $withdrawalId = Redis::get('withdrawal_id_user_id_'.$request->user->id);
        // dd($rechargeId);
        if(!$withdrawalId) {
            return redirect()->route('withdrawal.create');
        }

        $data['withdrawal_id'] = $withdrawalId;
        // dd(Cookie::get('access_token'));
        if($data['vnp_ResponseCode'] != '00') {
            return redirect()->route('withdrawal.fail');
        }

        $accessToken = Cookie::get('access_token');

        $response = RequestAPI::requestLedger('POST', '/api/withdrawal/complete', [
            'headers' => ['Authorization'=> 'Bearer '.$accessToken],
            'form_params' => $data,
        ]);

        if($response->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }

        if($response->data->code = '00') {
            return redirect()->route('withdrawal.success');

        }else {
            return redirect()->route('withdrawal.fail');
        }
    }

    public function responseDataMoMo(Request $request) {

        $data = $request->all();
        Log::info(json_encode($data));
        $withdrawalId = Redis::get('withdrawal_id_user_id_'.$request->user->id);
        // dd($rechargeId);
        if(!$withdrawalId) {
            return redirect()->route('withdrawal.create');
        }

        $data['withdrawal_id'] = $withdrawalId;
        // dd(Cookie::get('access_token'));
        
        $accessToken = Cookie::get('access_token');
        $response = RequestAPI::requestLedger('POST', '/api/withdrawal/complete', [
            'headers' => ['Authorization'=> 'Bearer '.$accessToken],
            'form_params' => $data,
        ]);

        if($response->code != AppException::ERR_NONE) {

            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        // dd($response);

        if($response->data->code == '00') {
            return redirect()->route('withdrawal.success');

        }else {
            return redirect()->route('withdrawal.fail');
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

        if(Redis::get('withdrawal_id_user_id_'.$request->user->id)) {
            Redis::del('withdrawal_id_user_id_'.$request->user->id);

            Session::flash('success', 'Rút tiền thành công');
            return view('withdrawal.success');
        }else {
            return redirect()->route('withdrawal.create');
        }
    }

    public function fail(Request $request) {

        if(Redis::get('withdrawal_id_user_id_'.$request->user->id)) {
            Redis::del('withdrawal_id_user_id_'.$request->user->id);

            Session::flash('error', 'Rút tiền thất bại');
            return view('withdrawal.fail');
        }else {

            return redirect()->route('withdrawal.create');
        }
    }
}
