<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;

class store
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Cookie::get('access_token')) {
            $access_token = Cookie::get('access_token');  

            $response = RequestAPI::request('GET', '/api/user/detail', ['headers' => ['Authorization' => 'Bearer '.$access_token]]); 

            if($response) {
                $request->user = $response->data;
                view()->share('user', $response->data);
            }   
        }
        return $next($request);
    }
}
