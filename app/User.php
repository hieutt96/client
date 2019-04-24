<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cookie;
use App\Libs\RequestAPI;
use App\Exceptions\AppException;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUserInfo() {

        if(Cookie::get('access_token')) {
            $accessToken = Cookie::get('access_token');
            $rs = RequestAPI::request('GET', '/api/user/detail', [
                'headers' => ['Authorization' => 'Bearer '. $accessToken],
            ]);
            if($rs->code != AppException::ERR_NONE) {
                throw new AppException(AppException::ERR_SYSTEM);
                
            }
            $user = $rs->data;
            return $user;
        }
        return;
    }
}
