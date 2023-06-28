<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9V5NX2QTBN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-9V5NX2QTBN');
</script>
<?php

/*******************************************
@author : bastikikang 
@author email: bastikikang@gmail.com
@author website : http://bastisapp.com/kmrs/
 *******************************************/

/* ********************************************************
 *   Karenderia Multiple Restaurant 
 *   11 October 14 Version 1.0.0 initial release
 *   Last Update : 14 october 2014 Version 1.0.1
 *   Last Update : 12 november 2014 Version 1.0.2
 *   Last Update : 27 november 2014 Version 1.0.2a
 *   Last Update : 8 December 2014 Version 1.0.3
 *   Last Update : 26 December 2014 Version 1.0.4
 *   Last Update : 03 march 2015 Version 1.0.5 
 *   Last Update : 20 march 2015 Version 1.0.6 
 *   Last Update : 25 march 2015 Version 1.0.7
 *   Last Update : 05 May 2015 Version 1.0.8
 *   Last Update : 11 May 2015 Version 1.0.9
 *   Last Update : 29 May 2015 Version 2.0
 *   Last Update : 19 June 2015 Version 2.1
 *   Last Update : 25 July 2015 Version 2.2
 *   Last Update : 30 July 2015 Version 2.2.1
 *   Last Update : 17 Aug 2015 Version 2.3
 *   Last Update : 17 October 2015 Version 2.4
 *   Last Update : 24 October 2015 Version 2.5
 *   Last Update : 31 October 2015 Version 2.6
 *   Last Update : 19 March 2016 Version 3.0
 *   Last Update : 31 March 2016 Version 3.1
 *   Last Update : 30 May 2016 Version 3.2
 *   Last Update : 07 Nov 2016 Version 3.3
 *   Last Update : 17 Nov 2016 Version 3.4
 *   Last Update : 23 May 2017 Version 4.0
 *   Last Update : 29 May 2017 Version 4.1
 *   Last Update : 15 June 2017 Version 4.2
 *   Last Update : 28 August 2017 Version 4.3
 *   Last Update : 30 August 2017 Version 4.4
 *   Last Update : 01 May 2018 Version 4.5
 *   Last Update : 15 August 2018 Version 4.6
 *   Last Update : 31 August 2018 Version 4.7
 *   Last Update : 23 November 2018 Version 4.8
 ***********************************************************/

define('YII_ENABLE_ERROR_HANDLER', true);
define('YII_ENABLE_EXCEPTION_HANDLER', true);
if (isme()) {
    define('YII_DEBUG', false);
}

require_once(dirname(__FILE__) . '/vendor/autoload.php');
require_once(dirname(__FILE__) . '/protected/config/env.php');

// include Yii bootstrap file
// require_once(dirname(__FILE__) . '/yiiframework/yii.php');

$config = dirname(__FILE__) . '/protected/config/main.php';

function mem_me()
{
    if (isme()) {
        echo  round(memory_get_peak_usage() / 1024 / 1024) . ' MB';
    }
}

function logme(...$data)
{
    $direname = Yii::app()->runtimePath . DIRECTORY_SEPARATOR . "logs";
    $filepath = $direname . DIRECTORY_SEPARATOR . 'dump.log';

    if (is_dir($direname) == false) {
        mkdir($direname);
    }

    $separator = '----------------------------------------' . "\n";
    file_put_contents($filepath, $separator . $_SERVER["REQUEST_URI"] . "\n\n" . print_r($data, true), FILE_APPEND);
}

function logmestr($str)
{
    $direname = Yii::app()->runtimePath . DIRECTORY_SEPARATOR . "logs";
    $filepath = $direname . DIRECTORY_SEPARATOR . 'dump.log';

    if (is_dir($direname) == false) {
        mkdir($direname);
    }

    file_put_contents($filepath, $_SERVER["REQUEST_URI"] . "\n" . $str . "\n", FILE_APPEND);
}

function logmerequest()
{
    $countPost = count($_POST);
    $index = 0;
    $postStr = "[";
    foreach ($_POST as $key => $val) {
        $last = ($index == $countPost - 1) ? true : false;
        $postStr .= "\n\t\"" . $key . "\" => \"" . $val . "\"";
        if (!$last) {
            $postStr .= ",";
        }
        $index += 1;
    }
    $postStr .= "\n\t]";

    /*
    $countGet = count($_GET);
    $index = 0;
    $getStr = "[";
    foreach ($_GET as $key => $val) {
        $last = ($index == $countGet-1) ? true : false; 
        $getStr .= "\n\t" . $key . " => \"" . $value . "\"";
        if (!$last) {
            $getStr .= ",";
        }
        $index += 1;
    }
    $getStr .= "\n\t]";
    */
    /*
    $requestDataStr = "\n\n\$requests[] = array(
    'url' => \"" . $_SERVER['REQUEST_URI'] . "\",
    'method' => \"" . $_SERVER['REQUEST_METHOD'] . "\",
    'post' => " . $postStr . "
);";
*/
    $requestData = array(
        'url' => $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . '?' . http_build_query($_GET),
        'post' => $postStr
    );

    logme($requestData);
}

function dumpme($data)
{
    if (isme()) {
        var_dump($data);
    }
}

function ddumpme($data)
{
    if (isme()) {
        var_dump($data);
        exit;
    }
}


function isme()
{
    $ips = array("103.25.44.42" => true, "130.204.14.92" => true);

    $ip = $_SERVER['REMOTE_ADDR'];

    return (isset($ips[$ip]) && $ips[$ip]);
}

if (isme()) {
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set("display_errors", "On");
}

$start_time = microtime_float();

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function log_time($key, $start_time, $end_time)
{
    if (isme()) {
        $execution_time = round($end_time - $start_time) . ' sec';

        $log = '/var/sentora/hostdata/zadmin/public_html/flyereats_in/time.log';

        file_put_contents($log, $_SERVER['REQUEST_URI'] . '    ' . $key . '    ' . $execution_time . "\n", FILE_APPEND);
    }
}

function log_memory_usage()
{
    global $start_time;

    $end_time = microtime_float();

    // Calculate script execution time
    $execution_time = round($end_time - $start_time) . ' sec';

    /* Currently used memory */
    $mem_usage = round(memory_get_usage() / 1024 / 1024) . ' MB';

    /* Peak memory usage */
    $mem_peak = round(memory_get_peak_usage() / 1024 / 1024);

    //    if ($mem_peak < 16) {
    //       return;
    //  }

    $mem_peak .= ' MB';

    $separator = "\t";

    $log = '/var/sentora/hostdata/zadmin/public_html/flyereats_in/memusage.log';

    $uri = $_SERVER['REQUEST_URI'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uri .= '?' . http_build_query($_POST);
    }

    file_put_contents($log, $_SERVER['REQUEST_METHOD'] . ' ' . $uri . $separator . $mem_peak . $separator . $mem_usage . $separator . $execution_time . "\n", FILE_APPEND);
}

$cache_file = '';
$cache_active = false;

function cache_get_base_dir()
{
    return realpath('./protected/runtime/polling-cache/');
}


function cache_get_todays_order_file_name($mid)
{
    $uri = 'merchantapp_get_todays_order_' . $mid;
    $cache_file = cache_get_base_dir() . '/' . $uri;
    return $cache_file;
}

function cache_get_new_order_file_name($mid)
{
    $uri = 'merchantapp_get_new_order_' . $mid;

    $cache_file = cache_get_base_dir() . '/' . $uri;
    return $cache_file;
}

function cache_clientapp_homepage_key($token)
{
    return 'clientapp_api_homepage_' . $token;
}

function cache_clientapp_getactiveorder_key($token)
{
    return 'clientapp_api_getactiveorder_' . $token;
}

function cache_merchantapp_neworder_key($token)
{
    return 'merchantapp_get_new_order_' . $token;
}

function cache_merchantapp_gettodaysorder_key($token)
{
    return 'merchantapp_get_todays_order_' . $token;
}

function cache_invalidate($cache_key)
{
    cache_invalidate_memcached($cache_key);
}

function cache_check($cache_file, $stale_time)
{
    global $cache_active;

    if (!file_exists($cache_file)) {
        $cache_active = true;
    } else {
        if (time() - filemtime($cache_file) > $stale_time) {
            unlink($cache_file);
            $cache_active = true;
        } else {
            sleep(2);
            echo file_get_contents($cache_file);
            exit;
        }
    }
}


function cache_check_memcached($cache_key, $stale_time)
{
    global $cache_active;

    return;

    $cacheComponent = Yii::app()->cache;

    $value = $cacheComponent->get_value($cache_key);

    if ($value === false) {
        $cache_active = true;
    } else {
        if (time() - $value['time'] > $stale_time) {
            $cacheComponent->delete_value($cache_key);
        } else {
            if (isset($value['headers']) && count($value['headers'])) {
                foreach ($value['headers'] as $header_str) {
                    list($header_name, $header_value) = explode(':', $header_str);
                    if ($header_name != 'Content-type') {
                        continue;
                    }

                    header($header_str);
                }
            }

            echo $value['output'];
            Yii::app()->end();
        }
    }
}

function cache_invalidate_memcached($cache_key)
{
    $cacheComponent = Yii::app()->cache;
    $cacheComponent->delete_value($cache_key);
}

function cache_set_memcached($cache_key, $output, $headers)
{
    $value = [
        'time' => time(),
        'output' => $output
    ];

    if (count($headers)) {
        $value['headers'] = $headers;
    }

    $cacheComponent = Yii::app()->cache;
    $cacheComponent->set_value($cache_key, $value);
}

function cache_set_file($cache_key, $output)
{
    file_put_contents($cache_key, $output);
}

//logmestr($_SERVER['REQUEST_URI']);

$logrequest = false;

/*
if (isset($_GET['debug_key']) && $_GET['debug_key'] == 'flyereats2021') {    
    $logrequest = true;
}
*/

$configuredApplication = Yii::createWebApplication($config);

if (strpos($_SERVER['REQUEST_URI'], '/merchantapp/api/get-todays-order') !== false) {
    if (isset($_REQUEST['mtid'])) {
        $token = $_REQUEST['mtid'];
        $stale_time = 1 * 60;
        $cache_key = cache_merchantapp_gettodaysorder_key($token);
        cache_check_memcached($cache_key, $stale_time);
    }
} elseif (strpos($_SERVER['REQUEST_URI'], '/merchantapp/api/new-order') !== false) {
    if (isset($_REQUEST['mtid'])) {
        $token = $_REQUEST['mtid'];
        $stale_time = 1 * 60;
        $cache_key = cache_merchantapp_neworder_key($token);
        cache_check_memcached($cache_key, $stale_time);
    }
} elseif (strpos($_SERVER['REQUEST_URI'], '/mobileapp/apiRestV2/homePage') !== false) {
    if (isset($_REQUEST['client_token'])) {
        $token = $_REQUEST['client_token'];

        $functionsComponent = Yii::app()->functions;
        $clientId = $functionsComponent->getClientIdByToken($token);

        $stale_time = 1 * 60;

        $cache_key = cache_clientapp_homepage_key($clientId);

        cache_check_memcached($cache_key, $stale_time);
    }
} elseif (strpos($_SERVER['REQUEST_URI'], '/mobileapp/apiRest/getActiveOrder') !== false) {
    /*
    if (isset($_REQUEST['client_token'])) {
        $token = $_REQUEST['client_token'];

        $stale_time = 1*600;
        $cache_key = cache_clientapp_getactiveorder_key($token);   
        cache_check_memcached($cache_key, $stale_time);
    }
*/
}

if (strpos($_SERVER['REQUEST_URI'], '/merchantapp') !== false) {
    //$logrequest = true;
}

if (isset($_REQUEST['client_token']) && $_REQUEST['client_token'] == '9hjsvn4ce83x8osbe4c915d76668a4d994b981f37ec9edf') {
    $logrequest = true;
}

if ($cache_active || $logrequest) {
    ob_start();
    if ($logrequest) {
        logmerequest();
    }
}

$configuredApplication->run();

if ($cache_active || $logrequest) {
    $output = ob_get_clean();
    if ($logrequest) {
        logmestr($output);
    }
    if ($cache_active) {
        cache_set_memcached($cache_key, $output, headers_list());
    }

    echo $output;
    exit;
}
