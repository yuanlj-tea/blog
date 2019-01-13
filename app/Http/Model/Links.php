<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Model\Links
 *
 * @property int $link_id
 * @property string $link_name //名称
 * @property string $link_title //标题
 * @property string $link_url //链接
 * @property int $link_order //排序
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Links whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Links whereLinkName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Links whereLinkOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Links whereLinkTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Links whereLinkUrl($value)
 * @mixin \Eloquent
 */
class Links extends Model
{
    protected $table='links';
    protected $primaryKey='link_id';
    public $timestamps=false;
    protected $guarded=[];
}
