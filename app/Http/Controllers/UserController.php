<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Libs\RequestAPI;
use Carbon\Carbon;
use Cookie;
use Validator;
use App\Exceptions\AppException;

class UserController extends Controller
{

	const SERVER_DOMAIN = 'http://localhost:1001';

    public function getLogin(Request $request){
        if($request->cookie('access_token')) {
            $accessToken = $request->cookie('access_token');

            $rs = RequestAPI::request('GET', '/api/user/detail', [
                'headers' => ['Authorization' => 'Bearer '.$accessToken],
            ]);
            if($rs->code != AppException::ERR_NONE) {
                throw new AppException(AppException::ERR_SYSTEM);
                
            }
            $user = $rs->data;
            return redirect()->route('home')->with(['user' => $user]);
        }
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
        if($rs->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        $user = $rs->data;
        Cookie::queue('access_token', $rs->data->access_token, 10);
        return redirect()->route('home')->with(['user' => $user]);
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
