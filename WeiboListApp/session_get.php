<?php
include "RedisSession.php";

$reids = new RedisSession("127.0.0.1", 6379);
print_r($reids->redis->keys("*"));