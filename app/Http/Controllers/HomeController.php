<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;

class HomeController extends Controller
{
    public function home(Request $request) {
    	if($request->user) {
    		$user = $request->user;
    		return view('home', compact('user'));

    	}
    	if($request->cookie('access_token') !== null) {
    		$accessToken = $request->cookie('access_token');
    		$rs = RequestAPI::request('GET', '/api/user/detail', ['headers' => ['Authorization' => 'Bearer '.$accessToken]]);
            if($rs->code != AppException::ERR_NONE) {
                throw new AppException(AppException::INVALID_TOKEN);
                
            }
    		$user = $rs->data;
    		return view('home', compact('user'));
    	}
    	return view('home');
    }
}
