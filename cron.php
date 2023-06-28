<?php

date_default_timezone_set("Asia/Kolkata");

require_once(dirname(__FILE__) . '/vendor/autoload.php');
require_once(dirname(__FILE__) . '/protected/config/env.php');

// include Yii bootstrap file
// require_once(dirname(__FILE__).'/yiiframework/yii.php');

defined('YII_DEBUG') or define('YII_DEBUG', true);

function dumpme($data)
{
    var_dump($data);
}

// we'll use a separate config file
$configFile = 'protected/config/cron.php';

// creating and running console application
Yii::createConsoleApplication($configFile)->run();
