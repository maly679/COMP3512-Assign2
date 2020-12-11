<?php

$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);
$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');
define('DBUSER', $username);
define('DBPASS', $password);
define('DBCONNSTRING', "mysql:host=$hostname;dbname=$database");


?>
