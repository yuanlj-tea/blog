<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Model\Navs
 *
 * @property int $nav_id
 * @property string|null $nav_name //名称
 * @property string|null $nav_alias //别名
 * @property string|null $nav_url //url
 * @property int|null $nav_order //排序
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Navs whereNavAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Navs whereNavId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Navs whereNavName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Navs whereNavOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Navs whereNavUrl($value)
 * @mixin \Eloquent
 */
class Navs extends Model
{
    protected $table='navs';
    protected $primaryKey='nav_id';
    public $timestamps=false;
    protected $guarded=[];
}
