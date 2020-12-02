<?php
session_start();

if (isset($_SESSION['ID']) && isset($_SESSION['status']) ) {
    unset($_SESSION['ID']);
    unset($_SESSION['status']);
    header('location:index.php');
} 
?>
