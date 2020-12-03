<?php

// $user = "p6d3fldzumd697t8";
// $pass = "un11bavbn0ccbnev";
// $host = "kavfu5f7pido12mr.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
// $dbname = "tl1lklkcndfcb8di";
// $charSetTrail = ";charset=utf8mb4;";
// define('DBUSER', $user);
// define('DBPASS', $pass);
// define('DBCONNSTRING', "mysql:host=" . $host . ";dbname=" . $dbname . $charSetTrail);

$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);
$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');
define('DBCONNECTION', "mysql:host=$hostname;dbname=$database");
define('DBUSER', $username);
define('DBPASS', $password);

?>
