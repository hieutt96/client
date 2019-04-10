<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\Libs\RequestAPI;

class HomeController extends Controller
{
    public function home(Request $request) {
    	if($request->cookie('access_token') !== null) {
    		$accessToken = $request->cookie('access_token');
    		$user = RequestAPI::request('GET', '/api/user/detail', ['headers' => ['Authorization' => 'Bearer '.$accessToken]]);
    		return view('home', compact('user'));
    	}
    	return view('home');
    }
}
