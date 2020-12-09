<?php
session_start();
require_once 'config.inc.php';
require_once 'browse-paintings-helpers.inc.php';
require_once 'db-classes.inc.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('diplay_startup_errors', 1);

$msg = "";

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));

    $galleryGateway = new GalleryDB($conn);
    $galleries = $galleryGateway->getAll();

    $artistGateway = new ArtistDB($conn);
    $artists = $artistGateway->getAll();
    $conn = null;
} catch (Exception $e) {
    die($e->getMessage());
}


//if (checkFormData()) {
try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));

    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }

    //$_SESSION['favorites'] = [];

    //$_SESSION['status'] = true;


    $paintings = buildQuery($conn);

    //THIS IS FOR TESTING/DEBUGGING
    // if (count($paintings) > 0) {
    //     echo "contains objects";
    // } else {
    //     echo "no objects";
    // }

    //TEST QUERY STING
    // $newsql = "SELECT GalleryName, PaintingID, Paintings.ArtistID, FirstName, LastName, Paintings.GalleryID, ImageFileName, Title, YearOfWork, ImageFileName 
    //     FROM Galleries INNER JOIN (Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID) ON Galleries.GalleryID = Paintings.GalleryID
    //     WHERE LastName = 'Picasso'
    //     AND GalleryName = 'National Gallery of Art'
    //     AND Title = 'The Tragedy' ";

    $conn = null;
} catch (Exception $e) {
    die($e->getMessage());
}
// } else {
//     $msg = "Enter a search";
// }
?>


<!DOCTYPE html>
<html lang=en>

<head>
    <title>Browse Paintings</title>
    <meta charset=utf-8>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'> -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/browse-paintings.css" />
    <script src="js/browse-paintings.js"></script>
</head>


<body>
    <main class="container">
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
                            <li><a class="navBtn" href="index.php">Home</a></li>
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

        <div class="box b">
            <section class="two wide column">
                <h3 class="ui dividing header">Painting Filters</h3>
                <form class="ui_form" method="get" action="browse-paintings.php" name="search">
                    <div id="row1"><label>Title </label></div>
                    <div id="row2"><label>Artist</label></div>
                    <div id="row3"><label>Gallery</label></div>
                    <div id="row4"><label>Year</lable>
                    </div>
                    <div id="row5"><input id="radioBefore" type="radio" id="Before" name="Year" value="Before" /><label for="Before"> Before </label></div>
                    <div id="row6"><input id="radioAfter" type="radio" id="After" name="Year" value="After" /><label for="After"> After </label></div>
                    <div id="row7"><input id="radioBetween" type="radio" id="Between" name="Year" value="Between" /><label for="Between"> Between </label></div>
                    <div id="boxrow1"><input class="inputtext" type="text" placeholder="Enter Painting Title" name="title" /></div>
                    <div id="boxrow2"><select class="ui fluid dropdown" name="artist">
                            <option value='0'>Select Artist</option>
                            <?php
                            outputArtists($artists);
                            ?>
                        </select></div>
                    <div id="boxrow3"><select class="ui fluid dropdown" name="gallery">
                            <option value='0'>Select Gallery</option>
                            <?php
                            outputGalleries($galleries);
                            ?>
                        </select></div>
                    <div id="boxrow4"><input id="inputBefore" class="inputtext" type="text" name="Before" disabled placeholder="Enter Before Date" /></div>
                    <div id="boxrow5"><input id="inputAfter" class="inputtext" type="text" name="After" disabled placeholder="Enter After Date" /></div>
                    <div id="boxrow6"><input id="inputBetween1" class="inputtext" type="text" name="Between1" disabled placeholder="Enter First Date" /></div>
                    <div id="boxrow7"><input id="inputBetween2" class="inputtext" type="text" name="Between2" disabled placeholder="Enter Second Date" /></div>

                    <div id="row8">
                        <button class="filterButton" type="submit">
                            <i class="filter icon"></i> Filter
                        </button>
                        <button class="resetButton" type="reset">
                            <i class="filter icon"></i> Reset
                        </button>
                    </div>
                </form>
            </section>
        </div>
        <div class="box c">
            <section>
                <h2> Paintings </h2>
                <?php
                //if (checkFormData()) {

                // foreach ($_GET as $key => $value) {   // note this is for testing delete later
                //     echo $key . " " . $value . "<br />";
                // }

                if (count($paintings) > 0) {
                    $loggedin = false;
                    if (isset($_SESSION['status']) && isset($_SESSION['ID'])) {
                        $loggedin = true;
                    } else {
                        $loggedin = false;
                    }
                    outputPaintings($paintings, $loggedin);
                } else {
                    $msg = "No Paintings Found";
                }
                //}

                ?>
                <div><?= $msg ?></div>
            </section>
        </div>
    </main>
    <div class="footer">
        <p>Photo by Paweł Czerwiński on Unsplash</p>
    </div>
</body>

</html>

<!-- https://prod.liveshare.vsengsaas.visualstudio.com/join?E62D5585F3EDE88E0206EAD814466A7D249C -->