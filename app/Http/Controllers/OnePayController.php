<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Libs\RequestJWT;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;
use Cookie;
use App\Libs\Config;
use Session;
use Log;

class OnePayController extends Controller
{
    public function responseData(Request $request) {

  		// Thông tin thẻ test: 
		// Loại tài khoản: Visa
		// Số thẻ: 4000000000000002 or 5313581000123430 
		// Date Exp: 05/21 
		// CVV/CSC: 123 
		// Street: Tran Quang Khai 
		// City/Town: Hanoi 
		// State/Province: North 
		// Postcode(zip code): 1234 
		// Country: VietNam
		$data = $request->all();

		$rechargeId = Redis::get('recharge_id_user_id_'.$request->user->id);
		if(!$rechargeId) {
    		return redirect()->route('user.recharge');
    	}
    	$data['recharge_id'] = $rechargeId;
    	if($data['vpc_TxnResponseCode'] != '0') {
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
}
