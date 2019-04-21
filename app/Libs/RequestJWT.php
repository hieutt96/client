<?php

namespace App\Libs;
use Firebase\JWT\JWT;

class RequestJWT {

	const ENCODE_ALG = 'HS256';
	const TOKEN_EXPIRE = 900;

	public static function encodeJWT() {
		$secret = env('WEB_API_SECRET', 'auQszsTMdamHJK8GUAsg');

		$issuedAt   = time();
		$notBefore  = $issuedAt;
		$expire     = $notBefore + self::TOKEN_EXPIRE;
		$iss = env('WEB_API_KEY', 'DVsWpVaKiL46hcLxZWa4');
		$data = [
			'iat' => $issuedAt,
			'nbf' => $notBefore,
			'exp' => $expire,
			'iss' => $iss,
		];

		return JWT::encode($data, $secret, self::ENCODE_ALG);
	}
}