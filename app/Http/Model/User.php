<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Model\User
 *
 * @property int $user_id
 * @property string|null $user_name //用户名
 * @property string|null $user_pass //密码
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\User whereUserPass($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

}
