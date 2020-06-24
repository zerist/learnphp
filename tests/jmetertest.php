<?php
require '../vendor/autoload.php';


$log = new \Monolog\Logger('name');
$log->pushHandler(new \Monolog\Handler\StreamHandler('app.log', MonoLog\Logger::WARNING));
$log->addRecord(\Monolog\Logger::WARNING, "test warning");