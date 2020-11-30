<?php
//define('DBHOST', 'localhost');
//define('DBNAME', 'art');
//define('DBUSER', 'root');
//define('DBPASS', '');
//define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

$url = getenv('JAWSDB_URL');
$dpparts = parse_url($url);

$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'], '/');

define('DBUSER', $username);
define('DBPASS', $password);
define('DBCONNSTRING',"mysql:host=" . $hostname . ";dbname=" . $database);
?>