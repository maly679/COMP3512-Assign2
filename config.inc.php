<?php


// define('DBCONNECTION', "mysql:host='kavfu5f7pido12mr.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';dbame='tl1lklkcndfcb8di'");
// define('DBUSER', 'p6d3fldzumd697t8');
// define('DBPASS', 'un11bavbn0ccbnev');


$url = "mysql://p6d3fldzumd697t8:un11bavbn0ccbnev@kavfu5f7pido12mr.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/tl1lklkcndfcb8di";
$dpparts = parse_url($url);
define('DBUSER', $dbparts['user']);
define('DBPASS', $dbparts['pass']);
define('DBCONNSTRING', "mysql:host=" . $dbparts['host'] . ";dbname=" . ltrim($dbparts['path'],'/') . ";charset=utf8mb4;");


?> 
