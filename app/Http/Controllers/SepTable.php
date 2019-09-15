<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Common;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SepTable extends Controller
{
    public function index()
    {
        //插入数据
        $data = [
            'user_id' => gen_uid(),
            'user_name' => 'foo'
        ];
        $ret = Common::sepAddData('test', 'user_id', $data);
        pd($ret);

        //修改数据
        $data = [
            'user_id' => '1602058175d3022a08a3c34089090418',
            'user_name' => 'bar'
        ];
        $ret = Common::sepEditData('test', 'user_id', '1602058175d3022a08a3c34089090418', $data);
        pd($ret);

        //删除数据
        $ret = Common::sepDelData('test', 'user_id', '5260425825d301419ec5b40095378400');
        pd($ret);

        //查询数据
        $ret = Common::sepSearchData('test', 'user_id', '6454361825d301414d4e743083746623');
        pd($ret);

    }
}
