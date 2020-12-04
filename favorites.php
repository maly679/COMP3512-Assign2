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


//foreach ($_SESSION['faorites'] as $s) {}
//$fav = $_SESSION['favorites'];
//print_r($_SESSION['favorites']);
//print_r($fav);
try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER,
        DBPASS
    ));
    if (isset($_SESSION['favorites'])) {
        foreach ($_SESSION['favorites'] as $f) {
            tryQuery($f, $conn);
        }
    }
    function tryQuery($f, $conn)
    {
        $sql = "select title, imagefilename from paintings where PaintingID = ?";
        $result = DatabaseHelper::runQuery(
            $conn,
            $sql, //array($_SESSION['favorites']
            $f
            //)
        );
        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            echo $row['title'];
            echo $row['imagefilename'];
            //echo "<ul>";
            //outputList($row);
            echo "hello";
            //echo "</ul>";
        }
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

// outputs the lists of the logged-in user's favourited paintings
function outputList($row)
{
    echo "<li>";
    echo "<a href='single-painting.php?id=" . $row . "'><img src=''/><p>" . $row['title'] . "</p></a>";
    echo "</li>";
}
