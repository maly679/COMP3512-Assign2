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
// and then its adds the passed product id to the array
$fav[] = $_GET['id'];
// reserve modified array back to the session state
$_SESSION['favorites'] = $fav;

// outputs the lists of the logged-in user's favourited paintings
function outputList($fav)
{
    echo "<ul>";
    foreach ($fav as $f) {
        echo "<li>";
        echo "<a ></a>";
        echo "</li>";
    }
    echo "</ul>";
}
