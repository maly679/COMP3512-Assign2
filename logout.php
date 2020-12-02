<?php
session_start();

if (isset($_SESSION['ID']) && isset($_SESSION['status']) ) {

    //unset() functionality retreived from: https://www.php.net/manual/en/function.unset.php
    unset($_SESSION['ID']);
    unset($_SESSION['status']);
    unset($_SESSION['favorites']);
    //return to (not logged in) home page.
} 
header('location:index.php');
