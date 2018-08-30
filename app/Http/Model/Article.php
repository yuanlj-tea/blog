<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Model\Article
 *
 * @property int $art_id
 * @property string|null $art_title //文章标题
 * @property string|null $art_tag //关键词
 * @property string|null $art_description //描述
 * @property string|null $art_thumb //缩略图
 * @property string|null $art_content //内容
 * @property int|null $art_time //发布时间
 * @property string|null $art_editor //作者
 * @property int|null $art_view //查看次数
 * @property int|null $cate_id //分类id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereArtView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Article whereCateId($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $table='article';
    protected $primaryKey='art_id';
    public $timestamps=false;
    protected $guarded=[];
}
