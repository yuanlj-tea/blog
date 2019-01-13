<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vaptcha\Vaptcha;
use App\Http\Requests;

class VaptchaController extends Controller
{
    private $vaptcha;

    public function __construct(){
        $this->vaptcha = new Vaptcha('5a391dc0a48611214c684bbc', '8ffca39bfc1840f3b32976be5e5df5d1'); // 这里替换成前面获取到的vid与key
    }

    public function response($status, $msg, $data){
        return response()->json([
            'status' =>  $status,
            'msg' => $msg,
            'data' => $data
        ], $status);
    }

    public function responseSuccess($data){
        return $this->response(200, 'success', $data);
    }

    public function getChallenge(Request $request){
        $data = json_decode($this->vaptcha->getChallenge($request->sceneid));
        return $this->responseSuccess($data);
    }

    public function getDownTime(Request $request) {
        $data = json_decode($this->vaptcha->downTime($request->data));
        return response()->json($data);
    }

    public function vaptchaView()
    {
        return view('vaptchaView');
    }
}
