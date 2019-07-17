<?php
/**
 * 人事信息
 */

namespace App\Services\Common;

use DB;

class Common
{


    /**
     * 过滤要保存的字段
     * @param $data 要保存的数据
     * @param $tableName 表名
     */
    public function filterFields($data, $tableName)
    {
        $allowFields = [];
        $res = DB::select("show full COLUMNS from `{$tableName}`;");
        if (empty($res)) {
            $tableName = strtolower($tableName);
            $res = DB::select("show full COLUMNS from `{$tableName}`;");
        }
        foreach ($res as $k => $v) {
            $allowFields[] = $v->Field;
        }
        foreach ($data as $k => $v) {
            if (!in_array($k, $allowFields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }


    /**
     * 新建/编辑数据
     * @param $data
     * @param $tableName 表名
     * @param $primaryKey 主键字段名
     * @return mixed
     */
    public function saveData($data, $tableName, $primaryKey)
    {
        $data = $this->filterFields($data, $tableName);
        if (isset($data[$primaryKey]) && !empty($data[$primaryKey])) {
            $id = $data[$primaryKey];
            unset($data[$primaryKey]);
            $res = DB::table($tableName)->where($primaryKey, $id)->update($data);
        } else {
            $res = DB::table($tableName)->insertGetId($data);
        }
        return $res;
    }


    /**
     * 将数据分页处理
     * @param type $data 要处理的数组
     * @param type $showNum 每页显示条数
     * @param type $page 显示页数
     * @return type
     */
    public function getPage($data = [], $showNum = 10, $page = 1)
    {
        $pageData['total'] = count($data);
        $pageData['per_page'] = $showNum;
        $pageData['current_page'] = $page;
        $pageData['last_page'] = ceil(count($data) / $showNum);
        $pageData['data'] = array_slice($data, ($page - 1) * $showNum, $showNum);

        return $pageData;
    }


    /*
     * 递归遍历文件夹下的所有内容,返回所有非文件夹的文件
     * $foldername  要遍历的文件夹名
     */
    public function getFiles($folderpath, $isClear = 0)
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
                $this->getFiles($folderpath . '/' . $f);
            }
        }
        return $arr;
    }


    /**
     * 获取指定日期区间内每一天的日期
     */
    public function getDateFromRange($startdate, $enddate)
    {
        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = ($etimestamp - $stimestamp) / 86400 + 1;

        // 保存每天日期
        $date = [];
        for ($i = 0; $i < $days; $i++) {
            $date[] = date('Y-m-d', $stimestamp + (86400 * $i));
        }
        return $date;
    }

    /**
     * 根据日期区间获取区间内的月份数组
     * @param $startDate
     * @param $endDate
     * @param string $format
     * @return array
     */
    public function getMonthArrFromRange($startDate, $endDate, $format = 'Y-m-01')
    {
        $s = date($format, strtotime($startDate));
        $e = date($format, strtotime($endDate));
        $data = [];

        if ($s == $e) {
            $data[] = $s;
            return $data;
        }
        if (strtotime($startDate) > strtotime($endDate)) {
            return $data;
        }
        while ($s != $e) {
            $data[] = $s;
            $s = date($format, strtotime("+1 month", strtotime($s)));
        }
        $data[] = $e;
        return $data;
    }


    /**
     * 获取最近6个月的日期
     * @param string $date
     */
    public function getRecentMonth($date = '')
    {
        if (!empty($date)) {
            $date = date('Y-m', strtotime($date));
            for ($i = 0; $i <= 5; $i++) {
                $dateArr[] = date('Y-m', strtotime("- {$i}month", strtotime($date)));
            }
            foreach ($dateArr as $dk => $dv) {
                $recentDate[date('m', strtotime($dv))] = $this->getDate($dv);
            }
            return $recentDate;
        }
    }

    /**
     * 获取所选月份的月初和月末日期
     * @param $date
     * @return array
     */
    public function getDate($date)
    {
        $timestamp = strtotime($date);
        $s = date('Y-m-d 00:00:00', $timestamp);
        $e = date('Y-m-t 23:59:59', $timestamp);
        return ['s' => $s, 'e' => $e];
    }

    /**
     * 将二维数组按照某个字段进行降序排列
     * @param $arr
     * @param $row
     * @return mixed
     */
    public static function array_sort($arr, $row)
    {
        $arr_tmp = [];
        foreach ($arr as $k => $v) {
            $arr_tmp[] = $v[$row];
        }
        array_multisort($arr_tmp, SORT_DESC, $arr);
        return $arr;
    }


}


