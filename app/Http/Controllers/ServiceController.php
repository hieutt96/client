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
    	return view('services.create', compact('serviceItems'));
    }
}
