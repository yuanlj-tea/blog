<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class grpctest extends Controller
{
    public function getClient(){
        //用于连接 服务端
        $client = new \Xuexitest\XuexitestClient('127.0.0.1:50052', [
            'credentials' => Grpc\ChannelCredentials::createInsecure()
        ]);

        //实例化 TestRequest 请求类
        $request = new \Xuexitest\TestRequest();
        $request->setTypeid(1);

        //调用远程服务
        $get = $client->SayTest($request)->wait();

        //返回数组
        //$reply 是 TestReply 对象
        //$status 是数组
        list($reply, $status) = $get;

        //数组
        $getdata = $reply->getGetdataarr();

        foreach ($getdata as $k=>$v){
            echo $v->getId(),'=>',$v->getName(),"\n\r";
        }
    }
}
