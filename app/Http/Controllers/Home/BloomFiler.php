<?php

namespace App\Http\Controllers\Home;

use App\Libs\BloomFilter\BloomFilterHash;
use App\Libs\BloomFilter\FilteRepeatedComments;
use AjaxResponse;
use RedisPHP;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BloomFiler extends Controller
{
    private $bloom;

    public function __construct()
    {
        $this->bloom = new FilteRepeatedComments();
    }

    public function addValue()
    {
        $hash = new BloomFilterHash();
        $res = $hash->JSHash('test');
        pd($res);


        $range = range(1, 1000000);
        foreach ($range as $k => $v) {
            $this->bloom->add($v);
        }
        return AjaxResponse::success('ok');
    }

    public function exists(Request $request)
    {
        $str = $request->input('str', 1);
        $res = $this->bloom->exists($str);
        return AjaxResponse::success($res);
    }
}
