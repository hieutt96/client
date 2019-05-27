<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;

class TxnController extends Controller
{
    
    public function listNotification(Request $request) {

    	$accessToken = Cookie::get('access_token');
    	$response = RequestAPI::request('GET', '/api/txn-list-notification', [
    		'headers' => [ 'Authorization' => 'Bearer '.$accessToken ],
    	]);
    	if($response->code = AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
    	$notifications = $response->data;
    	dd($notifications);
    	return view('txn.list', compact('notifications'));
    }
}
