<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Libs\RequestAPI;
use Carbon\Carbon;
use Cookie;
use Validator;

class UserController extends Controller
{

	const SERVER_DOMAIN = 'http://localhost:1001';

    public function getLogin(Request $request){
        // if($request->cookie('access_token')) {
        //     Cookie::queue(
        //         Cookie::forget('access_token')
        //     );
        // }
    	return view('user.login');
    }

    public function postLogin(Request $request){
        $email = $request->email;
        $password = $request->password;
        $form_params = [
            'email' => $email,
            'password' => $password,
        ];
        // dd($form_params);
        $rs = RequestAPI::request('POST', '/api/user/login', ['form_params' => $form_params]);
        // dd($rs);
        // dd(3);
        return response()->view('user.login')->withCookie(cookie('access_token', $rs->access_token, 10));
    }

    public function getRegister(Request $request){
    	return view('user.register');
    }

    public function postRegister(Request $request){

        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:confirm_password',
        ],[
            'username.required' => 'Bạn chưa nhập tên.',
            'password.same' => '2 mật khẩu không khớp nhau',
        ]);
    	$form_params = [
    		'name' => $request->username,
    		'email' => $request->email,
    		'password' => $request->password,
    	];
        
        $rs = RequestAPI::request('POST', '/api/user/register', ['form_params' => $form_params]);
        dd($rs);
    }

    public function getListUser(Request $request) {

        $access_token = Cookie::get('access_token');
        // dd($access_token);
        $response = RequestAPI::request('GET', '/api/user/list', ['headers' => ['Authorization' => 'Bearer '.$access_token]]);
        dd($response);
    }
}
