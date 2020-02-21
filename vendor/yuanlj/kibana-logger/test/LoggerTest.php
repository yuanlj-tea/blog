<?php
require_once __DIR__.'/../vendor/autoload.php';

use KibanaLog\KibanaLogger;

$logger = new KibanaLogger();
$logger->setLogFileName("app.json")->setLevel("ERROR")->addRecord("test");
print_r(file_get_contents("/data/logs/oa-kingnet/app.json"));

KibanaLogger::writeLog("foo");
print_r(file_get_contents("/data/logs/oa-kingnet/laravel.log"));
