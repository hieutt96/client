<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\AppException;
use App\Libs\RequestAPI;
class PaymentController extends Controller
{
    public function payment(Request $request) {

    	if(!$request->has('order_id') || !$request->has('checksum')) {

    		return redirect()->back();
    	}
    	$rs = RequestAPI::requestLedger('GET', '/api/order/detail', [

    		'query' => [
    			'order_id' => $request->order_id,
    		],
    	]);
    	if($rs->code != AppException::ERR_NONE) {

    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}

    	$this->verifyChecksum($request->order_id, $rs->data->secret, $request->checksum);
    	$orderId = $rs->data->id;
    	$amount = $rs->data->amount;
    	$request->session()->put('order_id', $orderId);
    	return view('payment.index', compact('orderId', 'amount'));
    }

    public function verifyChecksum($orderId, $secret, $checksum) {

    	$veridyCheckSum = hash_hmac('SHA1', $orderId, $secret);
    	if($veridyCheckSum != $checksum) {

    		throw new AppException(AppException::ERR_CHECKSUM_INVALID);
    		
    	}
    }

    public function postPayment(Request $request) {

    	$orderId = $request->session()->get('order_id');
    	if(!$orderId) {
    		throw new AppException(AppException::ERR_ORDER_NOT_FOUND);
    		
    	}else {
    		// $request->session()->forget('order_id');
    	}

    	$request->validate([
    		'email' => 'required',
    		'password' => 'required',
    	], [
    		'email.required' => 'Bạn chưa nhập email',
    		'password.required' => 'Bạn chưa nhập password',
    	]);
    	// dd($orderId);
    	
    	$rs = RequestAPI::requestLedger('POST', '/api/order/payment', [

    		'form_params' => [
    			'email' => $request->email,
    			'password' => $request->password,
    			'order_id' => $orderId,
    		],
    	]);
    	// dd(1);
    	if($rs->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::ERR_SYSTEM);
    		
    	}
    	// dd($rs);
    	$url = $rs->data->url_success.'?order_id='.$rs->data->order_id.'&amount='.$rs->data->amount.'&balance='.$rs->data->balance;
    	return redirect($url);
    }
}
