<?php

require_once(dirname(__FILE__) . '/vendor/autoload.php');
require_once(dirname(__FILE__) . '/protected/config/env.php');
// require_once(dirname(__FILE__) . '/yiiframework/yii.php');
require_once(dirname(__FILE__) . '/protected/config/memcached.php');

function dumpme($data) {
    var_dump($data);
}

memchd_connect();

if (memchd_write_key("3ae3f053e745d875e421ba497ad274c0 ", "Asia/Kolkata")) {
    echo "Key 'test_key' written successful.\n";
} else {
    echo "Could not write key.\n";
}

$value = memchd_read_key("3ae3f053e745d875e421ba497ad274c0 ");

echo $value . "\n";

memchd_close();
