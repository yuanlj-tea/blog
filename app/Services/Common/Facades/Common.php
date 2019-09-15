<?php
/**
 * 通用服务
 */

namespace App\Services\Common\Facades;

use Illuminate\Support\Facades\Facade;

class Common  extends Facade {


    /**
     * 获取Facade注册名称
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Common';
    }

}
