<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\RequestJWT;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;
use Cookie;
use App\Libs\Config;

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

    	return redirect(Config::LEDGER_DOMAIN.'/api/recharge?jwt='.$jwt.'&data='.base64_encode(json_encode($data)))->with('access_token', $accessToken);
    }
}
