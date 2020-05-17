<?php

namespace App\Http\Controllers\Home;

use App\Libs\Lock\DistributedLock;
use AjaxResponse;
use App\Libs\Lock\LockTimeoutException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LockTest extends Controller
{
    public function lock()
    {
        $lock = DistributedLock::getInstance();

        $key = 'test_a';
        $random = gen_uid();
        $getLock = $lock->getLock($key, $random, 60);

        if ($getLock) {
            //do sth

            //释放锁
            $lock->release($key, $random);
            return AjaxResponse::success('获取到锁');
        } else {
            return AjaxResponse::fail('没有获取到锁');
        }
    }

    public function testLockCallback()
    {
        $lock = DistributedLock::getInstance();

        $key = 'test_b';
        $callback = function ($param) {
            return $param;
        };

        $lock->getLockCallBack($key, $callback, ['foo', 'bar']);
        return AjaxResponse::success('执行成功');
    }

    public function testBlock()
    {
        $lock = DistributedLock::getInstance();

        $key = 'test_c';
        $random = gen_uid();
        try {
            $lock->block($key, $random, 60, 10);

            //do sth
            sleep(5);

            //释放锁
            $lock->release($key, $random);
            return AjaxResponse::success('获取到锁，执行逻辑');
        } catch (LockTimeoutException $e) {
            return AjaxResponse::fail($e->getMessage());
        } catch (\Exception $e) {
            return AjaxResponse::fail('程序运行期错误');
        }
    }
}
