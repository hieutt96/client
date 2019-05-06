<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;
use App\Libs\RequestJWT;

class ServiceController extends Controller
{
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

        dd([$request->all(), RequestJWT::encodeJWT()]);
    }
}
