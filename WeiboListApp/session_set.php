<?php
include "RedisSession.php";

new RedisSession("127.0.0.1", 6379);
$_SESSION["username"] = "xk";
