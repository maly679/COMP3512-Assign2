<?php

$url = 'mysql://p6d3fldzumd697t8:un11bavbn0ccbnev@kavfu5f7pido12mr.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/tl1lklkcndfcb8di';

$dbparts = parse_url($url);
console_log($dbparts);

$hostname = $dbparts['host'];
console_log($hostname);

$username = $dbparts['user'];
console_log($username);

$password = $dbparts['pass'];
console_log($password);

$database = ltrim($dbparts['path'],'/');
console_log($database);

define('DBCONNSTRING', "mysql:host=" . $hostname . ";dbname=" . $database . ";charset=utf8mb4;");
define('DBUSER', $username);
define('DBPASS', $password);

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

// //define('DBHOST', 'localhost');
// //define('DBNAME', 'art');
// //define('DBUSER', 'root');
// //define('DBPASS', '');
// //define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

// $url = getenv('JAWSDB_URL');
// $dpparts = parse_url($url);

// $hostname = $dbparts['host'];
// $username = $dbparts['user'];
// $password = $dbparts['pass'];
// $database = ltrim($dbparts['path'], '/');

// define('DBUSER', $username);
// define('DBPASS', $password);
// define('DBCONNSTRING',"mysql:host=" . $hostname . ";dbname=" . $database);
?>
