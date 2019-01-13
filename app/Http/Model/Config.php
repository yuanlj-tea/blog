<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Model\Config
 *
 * @property int $conf_id
 * @property string|null $conf_title //标题
 * @property string|null $conf_name //变量名
 * @property string|null $conf_content //变量值
 * @property int|null $conf_order //排序
 * @property string|null $conf_tips //描述
 * @property string|null $field_type //字段类型
 * @property string|null $field_value //类型值
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereConfContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereConfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereConfName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereConfOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereConfTips($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereConfTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Config whereFieldValue($value)
 * @mixin \Eloquent
 */
class Config extends Model
{
    protected $table='config';
    protected $primaryKey='conf_id';
    public $timestamps=false;
    protected $guarded=[];
}
