<?php
$m = new Memcached();
$m->addServer('localhost', 11211);

/* flush all items in 10 seconds */
$m->flush(10);
?>