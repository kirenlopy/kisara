<?php 
//require_once(dirname(__FILE__).'/yiiframework/yii.php');
$dirpath = __DIR__;
$imagepath = $_GET['imgkey'];
$url_segments = parse_url($imagepath);
$url_segments['path'] =str_replace('/flyereats/', '/', $url_segments['path']);
$logo = $dirpath.$url_segments['path'];
$f = @mime_content_type($logo);
header("Content-type: $f");
echo @file_get_contents("$logo");
exit;

