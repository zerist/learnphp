<?php
include 'FlexiHash.php';

$hserver = new FlexiHash();
$hserver->addServer('192.168.1.1');
$hserver->addServer('192.168.1.2');
$hserver->addServer('192.168.1.3');
$hserver->addServer('192.168.1.4');
$hserver->addServer('192.168.1.5');
echo "\nserverList: ";
print_r($hserver->serverList);
echo count($hserver->serverList);

echo "\nsave key1 in server:", $hserver->lookup('key1');
echo "\nsave key2 in server:", $hserver->lookup('key2');
echo "\n1--------------------------------------------------";

$hserver->removeServer('192.168.1.4');
echo "\nsave key1 in server:", $hserver->lookup('key1');
echo "\nsave key2 in server:", $hserver->lookup('key2');
echo "\n2---------------------------------------------------";

$hserver->addServer('192.168.1.6');
echo "\nsave key1 in server:", $hserver->lookup('key1');
echo "\nsave key2 in server:", $hserver->lookup('key2');
