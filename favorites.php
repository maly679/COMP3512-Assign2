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
//print_r($_SESSION['favorites']);

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER,
        DBPASS
    ));
    $sql = "select title, imagefilename from paintings where paintingid = ?";
    $result = DatabaseHelper::runQuery($conn, $sql, array(
        $_SESSION['favorites']
    ));
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {
        //echo $row;
        echo "<ul>";
        //outputList($row);
        echo $row['title'];
        echo "</ul>";
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

// outputs the lists of the logged-in user's favourited paintings
function outputList($row)
{
    echo "<li>";
    echo "<a href='single-painting.php?id=" . $row . "'><img src=''/><p>" . $row . "</p></a>";
    echo "</li>";
}
