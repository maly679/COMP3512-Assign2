<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';

// checks if there is an existing array of favourites
if (!isset($_SESSION['favorites'])) {
    // initializes the array if the check is true
    $_SESSION['favorites'] = [];
}

// retrieves existing favourites
$fav = $_SESSION['favorites'];

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));

    $paintingGateway = new PaintingDB($conn);
    $paintings = $paintingGateway->getForID($fav);
    $conn = null;
}   catch (Exception $e) {
    die($e -> getmessage());
}

// outputs the lists of the logged-in user's favourited paintings
echo "<ul>";
foreach ($fav as $f) {
    echo "<li>";
    echo "<a href='single-painting.php?id=" . $f . "'>" . $_GET['Title'] . "</a>";
    echo "</li>";
}
echo "</ul>";



