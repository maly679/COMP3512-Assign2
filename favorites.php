<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';

/*
// checks if there is an existing array of favourites
if (!isset($_SESSION['favorites'])) {
    // initializes the array if the check is true
    $_SESSION['favorites'] = [];
}
*/

// retrieves existing favourites
$fav = $_SESSION['favorites'];
print_r($_SESSION['favorites']);

try
{
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER,
        DBPASS
    ));
    $sql = "select title, imagefilename from paintings where paintingid =" . $fav;
    $result = DatabaseHelper::runQuery($conn, $sql, 5);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
  
    foreach($data as $row) {
        echo "hello";
    }
}
catch(PDOException $e)
{
    die($e->getMessage());
}

// outputs the lists of the logged-in user's favourited paintings

//echo "<ul>";
foreach ($fav as $f) {
    /*
    echo "<li>";
    echo "<a href='single-painting.php?id=" . $f . "'><img src=''/><p>" . $f . "</p></a>";
    echo "</li>"; 
    */
    echo $f;
}
//echo "</ul>"; 



