<?php
$a = array('ab','12');
$mc = new Memcache();
$mc->connect('127.0.0.1', 11211);
$mc->set('a','ss', 0, 10);
$val = $mc->get('a');
echo $val;