<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;
use Cookie;

class TransferController extends Controller
{
    public function create(Request $request) {
    	return view('transfer.create');
    }

    public function postCreate(Request $request) {

    	$request->validate([
    		'email' => 'required|email',
    		'amount' => 'required|numeric',
    		'description' => 'required',
    	],[
    		'email.required' => 'Bạn chưa nhập email',
    		'email.email' => 'Email không đúng định dạng',
    		'amount.required' => 'Bạn chưa nhập số tiền',
    		'amount.numeric' => 'Số tiền phải là số',
    		'description.required' => 'Bạn chưa nhập mô tả',
    	]);
    	$accessToken = $request->cookie('access_token');
    	$data = [
    		'email' => $request->email,
    	];
    	$rs = RequestAPI::request('POST', '/api/check-user-exists', [
    		'headers' => ['Authorization' => 'Bearer '.$accessToken],
    		'form_params' => $data,
    	]);
    	if($rs->code != AppException::ERR_NONE) {
    		throw new AppException(AppException::USER_NOT_EXISTS);
    		
    	}
    	$dataTransfer = [
    		'email' => $request->email,
    		'amount' => $request->amount,
    		'description' => $request->description,
    	];
    	$request->session()->put('data_transfer', $dataTransfer);
    	return redirect()->route('transfer.verify');
    }

    public function verify(Request $request) {

    	if(!$request->session()->has('data_transfer')) {
    		return redirect()->route('transfer.create');
    	}
        $accessToken = Cookie::get('access_token');
        $dataTransfer = $request->session()->get('data_transfer');
        $rs = RequestAPI::requestSetting('POST', '/api/txn/caculate-fee', [
            'headers' => ['Authorization'=> 'Bearer '.$accessToken],
            'form_params' => [
                'amount' => $dataTransfer['amount'],
            ],
        ]);
        if($rs->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        $request->session()->push('data_transfer.fee', $rs->data->fee);
        $dataTransfer['fee'] = $rs->data->fee;
        return view('transfer.verify', compact('dataTransfer'));
    }

    public function postVerify(Request $request) {
        if(!$request->session()->has('data_transfer')) {
            return redirect()->route('transfer.create');
        }
        $request->validate([
            'password' => 'required',
        ], [
            'password.required' => 'Bạn chưa nhập Password',
        ]);
        $dataTransfer = $request->session()->get('data_transfer');
        $accessToken = Cookie::get('access_token');
        dd($accessToken);
        $rs = RequestAPI::requestLedger('POST', '/api/transfer/create', [
            'headers' => ['Authorization' => 'Bearer '.$accessToken],
            'form_params' => [
                'email' => $dataTransfer['email'],
                'amount' => $dataTransfer['amount'],
                'description' => $dataTransfer['description'],
                'password' => $request->password,
            ],
        ]);
        if($rs->code != AppException::ERR_NONE) {
            throw new AppException(AppException::ERR_SYSTEM);
            
        }
        dd($rs);
    }
}
