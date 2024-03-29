<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';
require_once 'favorites-helpers.php';

$msg = "";


// if the get of delete is set then deletes the selected painting from favorites
if (isset($_GET['delete'])) {
    foreach ($_SESSION['favorites'] as $key => $value) {
        if ($value['PaintingID'] == $_GET['delete']) {
            unset($_SESSION['favorites'][$key]);
        }
    }
}

// if deleteAll is set then delete all from favorites
if (isset($_GET['deleteAll'])) {
    unset($_SESSION['favorites']);
}

// checks if the sesson is set then outputs the favorites
// if (isset($_SESSION['favorites'])) {
//     outputFavorites($_SESSION['favorites']);
// }
?>

<!DOCTYPE html>
<html lang=en>

<head>
    <title>Favorites</title>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'> -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css%22%3E">
    <link rel=" stylesheet" href="css/favorites.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>



<body>
    <main class="container">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <div class="navContainer">
            <input type="checkbox" class="toggler">
            <button id="menuIcon"><i class="fa fa-bars"></i></button>
            <a href="about.php"><img id="logo" src="images/login-page/logo.png"></a>
            <div class="navItems">
                <div>
                    <div>
                        <ul>
                            <!-- 
                                Makes sure that if the user is logged in then it will take them back to
                                home (logged in). Otherwise it will take the user back to the landing page 
                            -->
                            <?php
                            if (isset($_SESSION['status']) && isset($_SESSION['ID'])) {
                                echo '<li><a class="navBtn" href="home-logged-in.php">Home</a></li>';
                            } else {
                                echo '<li><a class="navBtn" href="index.php">Home</a></li>';
                            }
                            ?>
                            <li><a class="navBtn" href="about.php">About</a></li>
                            <li><a class="navBtn" href="galleries.php">Galleries</a></li>
                            <li><a class="navBtn" href="browse-paintings.php">Browse</a></li>
                            <li><a class="navBtn" href="favorites.php">Favorites</a></li>
                            <!-- 
                                Makes sure that if user is already logged in, then the button changes to
                                allow them to logout. Otherwise, if the user is not logged in, it will 
                                prompt them to login
                            -->
                            <?php
                            if (isset($_SESSION['status']) && isset($_SESSION['ID'])) {
                                echo '<li><a class="navBtn" href="logout.php">Logout</a></li>';
                            } else {
                                echo '<li><a class="navBtn" href="login.php">Login</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentContainer box">
            <h3>Favorite Paintings</h3>
            <?php
            outputDeleteAll();

            if (isset($_SESSION['status']) && isset($_SESSION['ID'])) {
                if (isset($_SESSION['favorites'])) {
                    outputFavorites($_SESSION['favorites']);
                } else {
                    $msg = "There are no Favorites";
                }
            } else {
                $msg = "You are not logged in";
            }
            ?>
            <div id="output_message">
                <?= $msg  ?>
            </div>
        </div>
    </main>
    <div class="footer">
        <p>Photo by Paweł Czerwiński on <a href="https://unsplash.com/photos/bX9B9c-YasY">Unsplash</a></p>
    </div>
</body>

</html>