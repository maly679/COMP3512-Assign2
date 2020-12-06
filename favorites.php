<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';
require_once 'favorites-helpers.php';

//NOTE: REMOVE DUPES

// if the get of delete is set then deletes the selected painting from favorites
if (isset($_GET['delete'])) {
    foreach ($_SESSION['favorites'] as $key => $rmv) {
        if ($rmv == $_GET['delete']) {
            unset($_SESSION['favorites'][$key]);
        }
    }
}

// if deleteAll is set then delete all from favorites
if (isset($_GET['deleteAll'])) {
    unset($_SESSION['favorites']);
}

outputDeleteAll();

// checks if the sesson is set then outputs the favorites
if (isset($_SESSION['favorites'])) {
        outputFavorites($_SESSION['favorites']);
}
