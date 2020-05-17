<?php

namespace KibanaLog;

use KibanaLog\Exception\InvalidSuffixException;
use KibanaLog\Exception\NotEmptyFileNmaeException;

class KibanaLogger
{
    private static $instance = null;

    /**
     * 日志文件存储路径
     */
    private $logPath = '/data/logs/oa-kingnet';

    /**
     * 默认日志文件名
     */
    private $logFileName = '';

    private $allowLevel = ['INFO', 'ERROR', 'FATAL', 'WARN', 'DEBUG'];

    private $level;

    public function __construct($logFileName = 'laravel.log', $level = 'ERROR')
    {
        $logFileName = $this->parseFileName($logFileName);
        $this->logFileName = $logFileName;

        if (!in_array($level, $this->allowLevel)) {
            throw new \Exception('无效的错误级别');
        }
        $this->level = $level;
    }

    /**
     * 设置日志文件名
     * @param string $fileName
     * @return $this
     * @throws InvalidSuffixException
     * @throws NotEmptyFileNmaeException
     */
    public function setLogFileName($fileName = 'laravel.log')
    {
        $logFileName = $this->parseFileName($fileName);
        $this->logFileName = $logFileName;
        return $this;
    }

    /**
     * 设置日志级别
     * @param string $level
     * @return $this
     * @throws \Exception
     */
    public function setLevel($level = 'ERROR')
    {
        if (!in_array($level, $this->allowLevel)) {
            throw new \Exception('无效的错误级别');
        }
        $this->level = $level;
        return $this;
    }

    public function addRecord($logContent)
    {
        $this->writeLog($logContent);
    }

    protected function writeLog($logContent)
    {
        if (!file_exists($this->logPath)) {
            $oldumask = umask(0);
            mkdir($this->logPath, 0777, true);
            @chmod($this->logPath, 0777);
            umask($oldumask);
        }

        $path = sprintf("%s/%s", rtrim("$this->logPath", '/'), trim($this->logFileName, '/'));
        if (!file_exists($path)) {
            touch($path);
            @chmod($path, 0777);
        }

        $formatLog = sprintf("[%s] %s: %s", date('c'), $this->level, $logContent);
        file_put_contents($path, $formatLog . PHP_EOL, FILE_APPEND);
    }

    private function parseFileName($fileName)
    {
        if (empty($fileName)) {
            throw new NotEmptyFileNmaeException('日志文件不能为空');
        }
        $fileName = pathinfo($fileName, PATHINFO_BASENAME);
        $arr = explode('.', $fileName);
        if (!isset($arr[1]) || !in_array($arr[1], ['log', 'json'])) {
            throw new InvalidSuffixException('无效的日志文件名后缀');
        }
        return $fileName;
    }

    public static function __callStatic($method, $arguments)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        call_user_func_array([self::$instance, $method], $arguments);
    }
}