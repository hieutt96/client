<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;
use App\Libs\RequestJWT;
use Cookie;
use App\Libs\StoreAPI;
use Illuminate\Support\Facades\Redis;
use App\Helpers\MyHelpers;

class ServiceController extends Controller
{
    const CARD_GAME = 1;
    const CARD_MOBILE = 2;
    const TOPUP_MOBILE = 3;
    public function listItem(Request $request) {

    	$services_id = $request->services_id;
    	if(!$services_id) {
    		return redirect()->route('home');
    	}
    	$jwt = RequestJWT::encodeJWT();
    	$serviceItems = RequestAPI::requestStore('POST', '/api/service-items', [
    		'query' => [
    			'jwt' => $jwt,
    		],
    		'form_params' => [
    			'services_id' => $services_id,
    		],
    	]);
    	if($serviceItems->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
    	$serviceItems = $serviceItems->data;
    	return view('services.create', compact('serviceItems', 'services_id'));
    }

    public function listAmount(Request $request) {

        $itemId = $request->item_id;
        if($itemId) {

            $jwt = RequestJWT::encodeJWT();
            $rs = RequestAPI::requestStore('GET', '/api/service-items/list-amount', [
                'query' => [
                    'jwt' => $jwt,
                    'item_id' => $itemId,
                ],
            ]);
            if($rs->code != 0) {
                return ;
            }
            return $rs->data;
        }
        return ;
    }

    public function postBuyItem(Request $request) {

        $request->validate([
            'service_id' => 'required',
            'item_id' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
        ]);
        $data = [
            'service_id' => (int) $request->service_id,
            'item_id' => (int) $request->item_id,
            'quantity' => (int) $request->quantity,
            'amount' => (int) $request->amount,
        ];
        // dd($request->service_id);
        if($request->service_id == self::TOPUP_MOBILE){
            Redis::set('service_id', $request->service_id);
        }
        
        Redis::set('service_data', json_encode($data));

        return redirect()->route('service.verify');
    }

    public function verifyTransaction() {

        $accessToken = Cookie::get('access_token');
        
        if($accessToken) {

            $response = StoreAPI::request('GET', '/api/user/detail',[
                'headers' => ['Authorization' => 'Bearer '.$accessToken],
            ]);

            if(isset($response->code) && $response->code == AppException::ERR_NONE) {

                $email = 0;
                return view('services.verify_transaction', compact('email'));
            } 
        }
        $email = 1;
        
        if(Redis::get('service_id')) {
            $phone = 1;
        }else {
            $phone = 0;
        }
        
        return view('services.verify_transaction', compact('email', 'phone'));
    }

    public function postVerifyTransaction(Request $request) {

        $request->validate([
            'password' => 'required',
        ],[
            'password.required' => 'Bạn chưa nhập password',
        ]);
        $serviceData = json_decode(Redis::get('service_data'), true);
        $serviceData['password'] = $request->password;

        if($request->has('phone')) {
            if(!MyHelpers::isValidPhoneNumber($request->phone)) {
                throw new AppException(AppException::ERR_PHONE_INVAILD);
                
            }
            $serviceData['phone'] = MyHelpers::pasrePhone($request->phone);
        }
        if($request->has('email')) {
            $serviceData['email'] = $request->email;
        }else {
            $serviceData['access_token'] = Cookie::get('access_token');
        }

        // Redis::del('service_data');
        $jwt = RequestJWT::encodeJWT();
        // dd([$serviceData, $jwt]);
        $response = StoreAPI::requestStore('POST', '/api/buy/service', [
            'query' => [
                'jwt' => $jwt,
            ],
            'form_params' => $serviceData,
        ]);
        if($response->code != AppException::ERR_NONE) {

            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        dd($response->data);
    }
}
