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

//check if passed a painting id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // adds the passed painting id to the array
    $fav[] = $id;
    // reserve modified array back to the session state
    $_SESSION['favorites'] = $fav;
    header('Location: single-painting.php?id=' . $id);
} else {
    $singlePLink = "single-painting.php?id=" . $id;

    // outputs the lists of the logged-in user's favourited paintings
    echo "<ul>";
    foreach ($fav as $f) {
        echo "<li>";
        echo "<a href='single-painting.php?id=$f'>" . $f['Title'] . "</a>";
        echo "</li>";
    }
    echo "</ul>";
}
?>