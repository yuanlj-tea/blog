<?php
/**
 * Created by PhpStorm.
 * User: allen
 * Date: 2019/2/27
 * Time: 10:40 PM
 */

namespace App\Libs;

use RedisPHP;

class Common
{
    /**
     * 根据不同的驱动，清除session
     * @param $driver
     * @param $session_id
     */
    public static function clearSession($driver, $session_id)
    {

        switch ($driver) {
            case 'files':

                $savePath = ini_get('session.save_path');
                $sess_id = 'sess_'.$session_id;

                //检测到session保存路径存在该session_id，则删除
                $files = self::getFiles($savePath,1);
                foreach($files as $v){
                    if(strpos($v,$sess_id) !== false){
                        unlink($v);
                    }
                }
                break;
            case 'redis':
                $sess_id = 'PHPREDIS_SESSION:'.$session_id;

                RedisPHP::del($sess_id);

                break;
            default:
                break;
        }
    }

    /*
     * 递归遍历文件夹下的所有内容,返回所有非文件夹的文件
     * $foldername  要遍历的文件夹名
     */
    public static function getFiles($folderpath, $isClear = 0)
    {
        static $arr = array();
        if ($isClear) {
            $arr = array();   //创建一个空数组,用来存放当前打开的文件夹里的文件夹名
        }
        $folder = opendir($folderpath);     //打开文件夹
        while ($f = readdir($folder)) {         //读取打开的文件夹
            if ($f == '.' || $f == '..') {
                continue;
            }
            if (!is_dir($folderpath . '/' . $f)) {
                //$arr[] = $f;
                $arr[] = $folderpath . '/' . $f;
            }
            if (is_dir($folderpath . '/' . $f)) {
                self::getFiles($folderpath . '/' . $f);
            }
        }
        closedir($folder);
        return $arr;
    }
}