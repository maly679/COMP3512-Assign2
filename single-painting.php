<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';

function getfavoritesButton()
{
    if (isset($_SESSION['ID']) && isset($_SESSION['status'])) {
        // checks if there is an existing array of favorites
        if (!isset($_SESSION['favorites'])) {
            // initializes the array if the check is true
            $_SESSION['favorites'] = [];
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $fav = $_SESSION['favorites']; // retrieves existing favorites
            $favoritesLink = "add-favorites.php?id=" . $id;
            $isfavorite = getIsFavorite($id, $fav);

            if (!$isfavorite) {
                echo "<a href='" . $favoritesLink . "'><button id='add-to-favorites'>Add To Favorites</button></a>";
            } else {
                echo "Added To Favorites";
            }
        }
    }
}

function getIsFavorite($id, $favorites)
{
    $found = false;
    foreach ($favorites as $painting) {
        if ($painting['PaintingID'] == $id) {
            $found = true;
        }
    }

    return $found;
}
?>

<!DOCTYPE html>
<html lang=en>

<head>
    <title>Single Painting</title>
    <meta charset=utf-8>
    <script src="js/single-painting.js"></script>
    <link rel="stylesheet" href="css/single-painting.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="header">
        <header class="navContainer">
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
        </header>
    </div>
    <div class="container">
        <div class="section" id="painting-section">
            <img id="image" src="" />
        </div>
        <div class="section data-container">
            <div class="data-section">
                <p class="heading" id="title"></p>
                <p class="sub-heading" id="artist"></p>
                <p class="sub-heading" id="gallery-year"></p>
                <br />
                <?= getfavoritesButton() ?>
            </div>
            <div class="data-section">
                <div id="tab-button-bar">
                    <button class="tab-button open" title="description">Description</button>
                    <button class="tab-button" title="details">Details</button>
                    <button class="tab-button" title="colors">Colors</button>
                </div>
                <div class="tab visible" id="description-tab">
                    <p id="description"></p>
                </div>
                <div class="tab" id="details-tab">
                    <strong>Medium: </strong><span id="medium"></span><br />
                    <strong>Width: </strong><span id="width"></span><br />
                    <strong>Height: </strong><span id="height"></span><br />
                    <strong>Copyright: </strong><span id="copyright"></span><br />
                    <strong>WikiLink: </strong><a id="wiki-link" href=""></a><br />
                    <strong>Museum Link: </strong><a id="museum-link" href=""></a><br />
                </div>
                <div class="tab" id="colors-tab"></div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Photo by Paweł Czerwiński on <a href="https://unsplash.com/photos/bX9B9c-YasY%22%3E">Unsplash</a></p>
    </div>
</body>

</html>