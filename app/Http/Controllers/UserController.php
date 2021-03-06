<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Libs\RequestAPI;
use Carbon\Carbon;
use Cookie;
use Validator;
use App\Exceptions\AppException;
use Session;
use Illuminate\Support\Facades\Redis;
use Google2FA;
use App\Helpers\MyHelpers;

class UserController extends Controller
{

    const TOKEN_EXPIRED = 30;
    
    public function getLogin(Request $request){
        if(Redis::get('error_login')) {

            Redis::del('error_login');

            Session::flash('error', 'Hết phiên đăng nhập');
            
            return view('user.login');
        }
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

        $rs = RequestAPI::request('POST', '/api/user/login', ['form_params' => $form_params]);
        
        if($rs->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }

        $response = RequestAPI::request('GET', '/api/user/detail-google2fa', [

            'headers' => ['Authorization' => 'Bearer '.$rs->data->access_token],
        ]);
        if($response->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }

        if($response->data->status == '01') {
            $redis = Redis::connection();
            $redis->set('access_token', $rs->data->access_token);
            return redirect()->route('user.get.verify.code');
        }

        $user = $rs->data;
        Cookie::queue('access_token', $rs->data->access_token, self::TOKEN_EXPIRED);
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
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.same' => '2 mật khẩu không khớp nhau',
        ]);
    	$form_params = [
    		'name' => $request->username,
    		'email' => $request->email,
    		'password' => $request->password,
    	];
        
        $rs = RequestAPI::request('POST', '/api/user/register', ['form_params' => $form_params]);
        if($rs->code = AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        Session::flash('success', 'Bạn đã đăng ký thành công. Check Email to Active . Please!');
        return redirect()->route('user.get.login');
    }

    public function getListUser(Request $request) {

        $access_token = Cookie::get('access_token');
        // dd($access_token);
        $response = RequestAPI::request('GET', '/api/user/list', ['headers' => ['Authorization' => 'Bearer '.$access_token]]);
        dd($response);
    }

    public function logout(Request $request) {
        Cookie::queue(Cookie::forget('access_token'));
        return redirect()->route('user.get.login');
    }

    public function active(Request $request) {
        $user = json_decode(base64_decode($request->user));
        
        $response = RequestAPI::request('POST', '/api/user/active', [
            'form_params' => [
                'user_id' => $user->id,
            ],
        ]);
        $user = $response->data;
        Cookie::queue('access_token', $response->data->access_token, self::TOKEN_EXPIRED);
        Session::flash('success', 'Bạn đã kích hoạt tài khoản thành công. Tiếp tục sử dụng các dịch vụ của chúng tôi !');
        return redirect()->route('home')->with(['user' => $user]);
    }

    public function google2FAGenerate(Request $request) {

        $accessToken = Cookie::get('access_token');

        $response = RequestAPI::request('GET', '/api/user/detail-google2fa',[
            'headers' => ['Authorization' => 'Bearer '.$accessToken],
        ]);
        $data = $response->data;
        return view('user.detail', compact('data'));
    }

    public function edit(Request $request) {

        return view('user.edit');
    }

    public function postEdit(Request $request) {

        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'social_id' => 'required',
        ],[
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'social_id.required' => 'Bạn chưa nhập CMND/căn cước',
        ]);

        if(!MyHelpers::isValidPhoneNumber($request->phone)) {

            throw new AppException(AppException::ERR_PHONE_INVAILD);
            
        }
        $accessToken = Cookie::get('access_token');
        $response = RequestAPI::request('POST', '/api/user/edit', [
            'headers' => [ 'Authorization' => 'Bearer '.$accessToken ],
            'form_params' => [
                'address' => $request->address,
                'phone' => $request->phone,
                'social_id' => $request->social_id,
            ],
        ]);
        if($response->code != AppException::ERR_NONE) {

            throw new AppException(AppException::ERR_SYSTEM);
            
        }

        return redirect()->route('user.google2FA');
    }

    public function securyOn(Request $request) {

        return view('security.verify');
    }

    public function postSecuryOn(Request $request) {

        $request->validate([
            'password' => 'required',
        ],[
            'password.required' => 'Bạn chưa điền mật khẩu',
        ]);

        $accessToken = Cookie::get('access_token');
        $response = RequestAPI::request('POST', '/api/user/create-google2fa-secret',[
            'headers' => [ 'Authorization' => 'Bearer '.$accessToken],
            'form_params' => [
                'password' => $request->password,
            ],
        ]);
        if($response->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        $data = $response->data;
        Session::flash('success', 'Bật bảo mật bước 2 thành công');
        return view('security.complete', compact('data'));
    }

    public function securyVerifyOff(Request $request) {

        return view('security.verify_off');
    }

    public function postSecuryVerifyOff(Request $request) {

        $request->validate([
            'password' => 'required',
        ],[
            'password.required' => 'Bạn chưa điền mật khẩu',
        ]);

        $accessToken = Cookie::get('access_token');
        $response = RequestAPI::request('POST', '/api/user/off-google2fa',[
            'headers' => [ 'Authorization' => 'Bearer '.$accessToken],
            'form_params' => [
                'password' => $request->password,
            ],
        ]);

        if($response->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        Session::flash('success', 'Tắt bảo mật 2 lớp thành công');
        return redirect()->route('user.google2FA');
    }
}
