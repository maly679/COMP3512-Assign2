<?php
session_start();

if (isset($_SESSION['ID']) && isset($_SESSION['status']))
{

    //unset() functionality retreived from: https://www.php.net/manual/en/function.unset.php
    //re-intialize the Session variables pertianing to logged on user's values.
    unset($_SESSION['ID']);
    unset($_SESSION['status']);
    unset($_SESSION['favorites']);
    //redirect user to home page when logout is clicked
    header('location:index.php');
}

