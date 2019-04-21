<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\RequestJWT;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;

class RechargeController extends Controller
{
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

    	return view('recharge.create');
    }
}
