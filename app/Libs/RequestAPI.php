<?php 

namespace App\Libs;
use GuzzleHttp\Client;
use App\Exceptions\AppException;
use App\Libs\Config;
/**
 * 
 */
class RequestAPI 
{
	public static function register($method, $uri, $options = []){
		$client = new Client(['base_uri' => Config::SERVER_DOMAIN, 'timeout' => 20.0]);
		$rs = $client->request($method, $uri, $options);
		if($rs->getStatusCode() != 200){
			throw new AppException(AppException::ERR_SYSTEM);			
		}
		$body = json_decode($rs->getBody()->getContents());
		return $body;
	}

	public static function request($method, $uri, $options = []){

		$client = new Client(['base_uri' =>Config::SERVER_DOMAIN, 'timeout' => 20.0]);
		
		$rs = $client->request($method, $uri, $options);
		if($rs->getStatusCode() != 200){
			throw new AppExcetion(AppExcetion::ERR_SYSTEM);
		}
		$body = json_decode($rs->getBody()->getContents());
		dd($body->code);
		if(!isset($body->code) || $body->code != AppException::ERR_NONE) {
			$body->message = (array) $body->message;
			$msg = '';
			foreach($body->message as $message) {
				if(is_array($message)) {
					$msg .= implode(',', $message);
				}else {
					$msg .= $message;
				}
			}
			throw new AppException($body->code, $msg);
			
		}
		return $body;
	}
}