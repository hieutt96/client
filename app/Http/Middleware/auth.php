<?php

namespace App\Http\Middleware;

use Closure;
use App\Libs\RequestAPI;
use Cookie;
use App\Exceptions\AppException;

class auth
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
        }else {
            return redirect()->route('user.get.login')->with('error', 'Bạn cần phải đăng nhập trước');
        }

        $response = RequestAPI::request('GET', '/api/user/detail', ['headers' => ['Authorization' => 'Bearer '.$access_token]]); 
        
        if($response->code != AppException::ERR_NONE) {
            return redirect()->route('user.get.login')->with('error', 'Phiên đăng nhập đã hết hạn');
        }
        if($response) {
            $request->user = $response->data;
            view()->share('user', $response->data);
            return $next($request);
        }       
        return redirect()->route('user.get.login')->with('error', 'Hết phiên đăng nhập');
    }
}
