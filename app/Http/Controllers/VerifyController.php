<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\AppException;
use App\Libs\RequestAPI;
use App\Http\Controllers\UserController;
use Cookie;

class VerifyController extends Controller
{	

	public function getVerifyCode(Request $request) {

        return view('user.verify_login');
	}

    public function verifyLogin(Request $request) {

    	$request->validate([
    		'verify_code' => 'required',
    	],[
    		'verify_code.required' => 'Bạn chưa nhập mã Google Authenticate',
    	]);
    	$redis = Redis::connection();
        $accessToken = $redis->get('access_token');
        // Redis::del('access_token');
        $response = RequestAPI::request('POST', '/api/user/login/verify-code', [

        	'headers' => [ 'Authorization' => 'Bearer '.$accessToken ],
        	'form_params' => [
        		'verify_code' => $request->verify_code,
        	],
        ]);
        if($response->code != AppException::ERR_NONE) {

        	throw new AppException(AppException::ERR_SYSTEM);
        	
        }
        
        Cookie::queue('access_token', $accessToken, UserController::TOKEN_EXPIRED);
        return redirect()->route('home')->with(['user' => $response->data]);
    }
}
