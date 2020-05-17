<?php


namespace App\Libs\Lock;


class LockTimeoutException extends \Exception
{
    public $message = '获取锁超时';
}