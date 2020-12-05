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

if (isset($_GET["id"])) {
    //retrieve and add painting to favorites
    $painting = getPainting($_GET["id"]);
    $fav[] = $painting;
    
    //update session favorites 
    $_SESSION['favorites'] = $fav;
    header('Location: favorites.php');
}

function getPainting($id) {
    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $paintingGateway = new PaintingDB($conn);
        $response = $paintingGateway->getForID($_GET["id"]);
        return $response[0];
    }
    catch (Exception $e) {
        die($e->getMessage());
    }
}
?>
