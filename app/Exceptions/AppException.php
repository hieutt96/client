<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AppException extends Exception
{

	const ERR_NONE = 0;
	const ERR_ACCOUNT_NOT_FOUND = 1;
	const ERR_SYSTEM = 3;

    protected $code;
    protected $message;

    public function __construct($code , $message = null, $data = []) {

    	if(!$code) {
    		$code = Response::HTTP_NOT_FOUND;
    	}

    	if(!$message) {
    		$message = trans('exception.' .$code, $data);
    	}

    	$this->code = $code;
    	$this->message = $message;

    	parent::__construct($code, $message);
    }

    public function render(Request $request) {

    	$json = [

    		'code' => $this->code,
    		'message' => $this->message,
    		'data' => 'null',
    	];

    	return new JsonResponse($json);
    }
}
