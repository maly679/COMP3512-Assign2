<?php

$url = getenv('JAWSDB_URL');
$dpparts = parse_url($url);
console_log($dpparts);

$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'], '/');

define('DBUSER', $username);
define('DBPASS', $password);
define('DBCONNSTRING',"mysql:host=" . $hostname . ";dbname=" . $database);

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
?>
