<?php
$url = "mysql://p6d3fldzumd697t8:un11bavbn0ccbnev@kavfu5f7pido12mr.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/tl1lklkcndfcb8di";
$dbparts = parse_url($url);
print_r($dbparts);
$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');
define('DBCONNECTION', "mysql:host=$hostname;dbname=$database");
define('DBUSER', $username);
define('DBPASS', $password);
?>




