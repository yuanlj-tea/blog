<?php
/**
 * 人事信息
 */

namespace App\Services\Common;

use App\Libs\Response;
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
     * @param array $data 要处理的数组
     * @param int $showNum 每页显示条数
     * @param int $page 显示页数
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

    /**
     * 根据分表字段获取库id
     * @param string|null $value
     * @return string
     */
    protected function getConnectionHashId(?string $value): string
    {
        $num = hexdec(md5($value)[0]);
        $r = $num < 8 ? ($num < 4 ? 0 : 1) : ($num < 12 ? 2 : 3);
        return $r;
    }

    /**
     * 根据分表字段获取表id
     * @param string|null $value
     * @return string
     */
    protected function getTableHashId(?string $value): string
    {
        return md5($value)[1];
    }

    /**
     * 根据分表字段获取表id
     * @param string $shardingKey
     * @return int
     */
    protected function getTableId(string $shardingKey): int
    {
        $crcData = sprintf("%u", crc32($shardingKey));
        return $crcData % 2;
    }

    /**
     * 获取分表的数据库连接名
     * @param $shareValue
     * @param string $connectionPrefix
     * @return string
     */
    public function getConnectionName($shareValue, $connectionPrefix = 'mysql')
    {
        // return sprintf("%s_%s",$connectionPrefix,$this->getConnectionHashId($shareValue));
        return $connectionPrefix;
    }

    /**
     * 获取分表的表名
     * @param $shareValue
     * @param $tablePrefix
     * @return string
     */
    public function getTableName($shareValue, $tablePrefix)
    {
        return sprintf("%s_%s", $tablePrefix, $this->getTableId($shareValue));
    }

    /**
     * 根据UID分表算法
     *
     * @param int $uid 用户ID
     * @param int $bit 表后缀保留几位
     * @param int $seed 向右移动位数
     */
    public function getTable($uid, $tablePrefix, $bit = 2, $seed = 20)
    {
        return $tablePrefix . '_' . sprintf("%0{$bit}d", ($uid >> $seed));
    }

    /**
     * 添加数据
     * @param $tablePrefix
     * @param $shareKey
     * @param $data
     * @param string $connectionPrefix
     * @return bool
     * @throws \Exception
     */
    public function sepAddData($tablePrefix, $shareKey, $data, $connectionPrefix = 'mysql')
    {
        $this->checkData($shareKey, $data, 'add');
        list($connectionName, $tableName) = $this->getSepConf($data[$shareKey], $connectionPrefix, $tablePrefix);

        $data = $this->sepFilterfields($connectionName, $tableName, $data);
        return DB::connection($connectionName)->table($tableName)->insert($data);
    }

    /**
     * 修改数据
     * @param $tablePrefix
     * @param $shareKey
     * @param $shareValue
     * @param $data
     * @param string $connectionPrefix
     * @return int
     * @throws \Exception
     */
    public function sepEditData($tablePrefix, $shareKey, $shareValue, $data, $connectionPrefix = 'mysql')
    {
        $this->checkData($shareKey, $data, 'edit');
        if (isset($data[$shareKey])) {
            unset($data[$shareKey]);
        }
        list($connectionName, $tableName) = $this->getSepConf($shareValue, $connectionPrefix, $tablePrefix);

        $data = $this->sepFilterfields($connectionName, $tableName, $data);
        return DB::connection($connectionName)->table($tableName)->where($shareKey, $shareValue)->update($data);

    }

    /**
     * 查找数据
     * @param $tablePrefix
     * @param $shareKey
     * @param $shareValue
     * @param string $connectionPrefix
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|mixed|object|null
     */
    public function sepSearchData($tablePrefix, $shareKey, $shareValue, $connectionPrefix = 'mysql')
    {
        list($connectionName, $tableName) = $this->getSepConf($shareValue, $connectionPrefix, $tablePrefix);
        $ret = DB::connection($connectionName)->table($tableName)->where($shareKey, $shareValue)->first();
        return $ret;
    }

    /**
     * 删除数据
     * @param $tablePrefix
     * @param $shareKey
     * @param $shareValue
     * @param string $connectionPrefix
     * @return int
     */
    public function sepDelData($tablePrefix, $shareKey, $shareValue, $connectionPrefix = 'mysql')
    {
        list($connectionName, $tableName) = $this->getSepConf($shareValue, $connectionPrefix, $tablePrefix);
        return DB::connection($connectionName)->table($tableName)->where($shareKey, $shareValue)->delete();
    }

    /**
     * 过滤分表要保存的数据
     * @param $connctionName
     * @param $tableName
     * @param $data
     */
    protected function sepFilterfields($connctionName, $tableName, $data)
    {
        $allowFields = [];
        $res = DB::connection($connctionName)->select("show full COLUMNS from `{$tableName}`;");
        if (empty($res)) {
            $tableName = strtolower($tableName);
            $res = DB::connection($connctionName)->select("show full COLUMNS from `{$tableName}`;");
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
     * 获取分表配置
     * @param $shareVlaue
     * @param $connectionPrefix
     * @param $tablePrefix
     * @return array
     */
    public function getSepConf($shareVlaue, $connectionPrefix, $tablePrefix)
    {
        $connectionName = $this->getConnectionName($shareVlaue, $connectionPrefix);
        $tableName = $this->getTableName($shareVlaue, $tablePrefix);
        return [$connectionName, $tableName];
    }

    public function checkData($shareKey, $data, $type)
    {
        if (!is_array($data)) {
            throw new \Exception('参数错误');
        }
        switch ($type) {
            case 'add':
                if (!isset($data[$shareKey]) || empty($data[$shareKey])) {
                    throw new \Exception('缺少shareKey对应值');
                }
                break;
            case 'edit':

                break;
        }
    }

}


