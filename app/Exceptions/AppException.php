<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AppException extends Exception
{

	const ERR_NONE = 0;
	const ERR_ACCOUNT_NOT_FOUND = 1;
	const ERR_SYSTEM = 3;
    const INVALID_TOKEN = 4;

    protected $code;
    protected $message;

    public function __construct($code , $message = "", $data = []) {

    	if(!$code) {
    		$code = Response::HTTP_NOT_FOUND;
    	}

    	if(!$message) {
    		$message = trans('exception.' .$code, $data);
    	}

    	$this->code = $code;
    	$this->message = $message;

    	parent::__construct($message, $code);
    }

    public function render(Request $request) {

    	if($this->code == self::INVALID_TOKEN){
            $access_token = $request->cookie('access_token');
            if(!empty($access_token)){
                return redirect()->route('user.get.login', ['return_url'=>base64_encode($request->getRequestUri())])->with('error', $this->message);
            }
            else
                return redirect()->route('user.get.login', ['return_url'=>base64_encode($request->getRequestUri())]);
        }
        return redirect()->back()->with('error', $this->message)->withInput();
    }
}
