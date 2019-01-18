<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Model\Category
 *
 * @property int $cate_id
 * @property string|null $cate_name //分类名称
 * @property string|null $cate_title //分类说明
 * @property string|null $cate_keywords //关键词
 * @property string|null $cate_description //描述
 * @property int|null $cate_view //查看次数
 * @property int|null $cate_order //排序
 * @property int|null $cate_pid //父级id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCateDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCateKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCateOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCatePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCateTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Model\Category whereCateView($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $table='category';
    protected $primaryKey='cate_id';
    public $timestamps=false;
    protected $guarded=[];

    public function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $this->getTree($categorys,'cate_name','cate_id','cate_pid');
    }

//    public static function tree()
//    {
//        $categorys = Category::all();
//        return (new Category)->getTree($categorys,'cate_name','cate_id','cate_pid');
//    }

    public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {
        $arr = array();
        foreach ($data as $k=>$v){
            if($v->$field_pid==$pid){
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m=>$n){
                    if($n->$field_pid == $v->$field_id){
                        $data[$m]["_".$field_name] = '├─ '.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
