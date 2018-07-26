<?php
/**
 * AJAX响应结果统一输出facades
 * @author     chenzhangwei
 */

namespace App\Services\Common\Facades;

use Illuminate\Support\Facades\Facade;

class AjaxResponse extends Facade
{


    /**
     * 获取Facade注册名称
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AjaxResponse';
    }

}
