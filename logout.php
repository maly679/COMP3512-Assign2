<?php
session_start();

if (isset($_SESSION['ID']) && isset($_SESSION['status']) ) {
    unset($_SESSION['ID']);
    unset($_SESSION['status']);
    unset($_SESSION['favorites']);
    //return to (not logged in) home page.
    header('location:index.php');
} else {
    
    //catch error, where if user was not logged in, and redirect to login page.
    header('location:login.php');
}
