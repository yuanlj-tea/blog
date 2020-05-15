<?php

namespace App\Http\Controllers\Home;

use App\Libs\BloomFilter\FilteRepeatedComments;
use AjaxResponse;
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
        $range = range('a', 'z');
        foreach ($range as $k => $v) {
            $this->bloom->add($v);
        }
        return AjaxResponse::success('ok');
    }

    public function exists(Request $request)
    {
        $str = $request->input('str', 'z');
        $res = $this->bloom->exists($str);
        return AjaxResponse::success($res);
    }
}
