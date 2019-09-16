<?php

namespace App;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\User
 *
 * @property int $user_id
 * @property string|null $user_name //用户名
 * @property string|null $user_pass //密码
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserPass($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    protected $table = 'user';

    protected $primaryKey = 'user_id';

    protected $hidden = ['user_pass'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['user_id', 'user_name'];
    }
}