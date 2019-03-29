<?php

namespace App\Http\Middleware;

use Closure;
use App\Libs\RequestAPI;
use Cookie;

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
            return redirect()->route('user.get.login');
        }
        // dd($access_token);

        $response = RequestAPI::request('GET', '/api/user/detail', ['headers' => ['Authorization' => 'Bearer '.$access_token]]);
        dd($response); 
        if($response) {
            return $next($request);
        }       
        return redirect()->route('user.get.login');
    }
}
