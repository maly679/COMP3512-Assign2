<?php

require_once 'config.inc.php';
require_once 'browse-paintings-helpers.inc.php';
require_once 'db-classes.inc.php';

$msg = "";
// 1. Connect to the database.
// 2. Handle connection errors.
// 3. Execute the SQL query.
// 4. Process the results.
// 5. Free resources and close connection.

// now retrieve galleries 

// SHOULD USE ONE CONNECTION TO GET ALL DATA ONCE THEN CLOSE??? When should i close connection?

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));


    //I think that this needs to be moved out of this try catch
    $galleryGateway = new GalleryDB($conn);
    $galleries = $galleryGateway->getAll();

    $artistGateway = new ArtistDB($conn);
    $artists = $artistGateway->getAll();
    $conn = null;
} catch (Exception $e) {
    die($e->getMessage());
}



if (isset($_GET['search'])) {
    try {
        // conn = pdo
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER, DBPASS
        ));

        $addArray = [];



        // $sql = "SELECT GalleryName, PaintingID, Paintings.ArtistID, FirstName, LastName, Paintings.GalleryID, ImageFileName, Title, YearOfWork, ImageFileName 
        //     FROM Galleries INNER JOIN (Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID) ON Galleries.GalleryID = Paintings.GalleryID";

        // //NEED LOGIC TO DETERMINE CORRECT QUERY
        // if (isset($_GET['title']) || isset($_GET['gallery']) || isset($_GET['artist'])) {
        //     $sql = self + " WHERE";
        //     if (isset($_GET['title'])) {
        //         $addsql = " LastName LIKE :title"; // add in wild cards
        //         $addArray[] = $addsql;
        //         $count++;
        //     }
        //     if (isset($_GET['gallery'])) {
        //         $addsql = "GalleryName = :gallery";
        //         $addArray[] = $addsql;
        //     }
        //     if (isset($_GET['artist'])) {
        //         $addsql = " LastName LIKE :artist";
        //     }


        //     $statement = DatabaseHelper::runQuery($conn, $sql, $paramArray);
        // } else {
        // }

        // for(i=0;i <;i++){
        //     if() {

        //     }
        //     //print addarray
        //     // and
        // }





        // $sql = "SELECT GalleryName, PaintingID, Paintings.ArtistID, FirstName, LastName, Paintings.GalleryID, ImageFileName, Title, YearOfWork, ImageFileName 
        //     FROM Galleries INNER JOIN (Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID) ON Galleries.GalleryID = Paintings.GalleryID
        //     WHERE LastName = 'Picasso'
        //     AND GalleryName = 'National Gallery of Art'
        //     AND Title = 'The Tragedy' ";



        //"SELECT PaintingID, Paintings.ArtistID, FirstName, LastName, Paintings.GalleryID, GalleryName, ImageFileName, Title, Excerpt, YearOfWork, ImageFileName FROM Galleries INNER JOIN (Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID) ON Galleries.GalleryID = Paintings.GalleryID ";


        // $sql = "SELECT FirstName, LastName, Paintings.Title, Paintings.YearOfWork 
        //         FROM Galleries, Artists INNER JOIN (Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID) ON Galleries.GalleryID = Paintings.GalleryID
        //         WHERE Artist.ArtistID = Paintings.ArtistID
        //         AND Title = :title
        //         AND Gallery.GalleryID = :gallery
        //         AND Artist.LastName = :artist";

        //SELECT GalleryName, PaintingID, Paintings.ArtistID, FirstName, LastName, Paintings.GalleryID, ImageFileName, Title, YearOfWork, ImageFileName 
        //FROM Galleries INNER JOIN (Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID) ON Galleries.GalleryID = Paintings.GalleryID 
        //WHERE Paintings.YearOfWork < 1600


        // if (isset($_GET['Before'])) {
        //     // use before
        //     $sql = self + " WHERE Paintings.YearOfWork < " . $_GET['Before'];
        // } else if (isset($_GET['After'])) {
        //     // use after
        // } else {
        //     // use Between1
        //     //     Between2
        // }


        // $paramArray = ['title' => "%" . $_GET['title'] . "%", 'gallery' => $_GET['gallery'], 'artist' => $_GET['artist']];

        // $statement = DatabaseHelper::runQuery($conn, $sql, $paramArray);



        // if (isset($_GET['YearOfWork'])) {
        //     //$year = $_GET['YearOfWork']; 
        //     $yearBefore = $_GET['Before'];
        //     $yearAfter = $_GET['After'];
        //     $yearBetween = $_GET['BetweenA'];
        //     $yearBetween = $_GET['BetweenB'];
        // }

        // $paintGateway = new PaintingDB($conn);
        // if (isset($_GET['museum'])) {
        //     $paintings = $paintGateway->getAllForGallery($_GET['museum']);
        // } else {
        //     $paintings = $paintGateway->getTop20();
        // }

        //   if (isset($_GET['id']) && $_GET['id'] > 0) { // change id to museium 
        //     $paintGateway = new PaintingDB($conn);
        //     $paintings = $paintGateway->getAllForArtist($_GET['id']);
        //   } else {
        //     $paintings = null;
        //   }

        $conn = null;
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    $msg = "Enter a search";
}
// take super globals $_GET
// create a sql query
// output paintings + info with html markup 

?>


<!DOCTYPE html>
<html lang=en>

<head>
    <title>browse-paintings.php</title>
    <meta charset=utf-8>
    <!-- <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'> -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/browse-paintings.css" />
</head>

<!-- note look at lab14a-ex09.php for help -->


<body>
    <!-- <main class="ui segment doubling stackable grid container"> -->
    <main class="container">


        <div class="box a">
            <label>COMP 3512 Assignment 2</label>
            <span>Jordan Walker & Mariangel Ramirez & </span>
        </div>

        <!-- <div class="box b">
            <section class="four wide column">
                <form class="ui form" method="post">
                    <h3 class="ui dividing header">Filters</h3>

                    <div class="field">
                        <label>Find painting: </label>
                        <input type="text" placeholder="enter search string" name="search" />
                    </div>
                    <button class="small ui orange button" type="submit">
                        <i class="filter icon"></i> Filter
                    </button>
                </form>
            </section>
        </div> -->
        <div class="box b">
            <section class="two wide column">
                <h3 class="ui dividing header">Painting Filters</h3>
                <form class="ui_form" method="get" action="browse-paintings.php" name="search">
                    <!-- <div class="ui_form_row">
                        <label>title</label>
                        <input class="inputtext" type="text" placeholder="enter search string" name="search" />
                    </div> -->


                    <!--  maintaining form state php or cookies?, how to clear the form -->
                    <!-- add checked to radiobutton to preselect  can use disabled-->
                    <!-- input type = reset ... check out reset buttons for HTML -->

                    <div id="row1"><label>Title </label></div>
                    <div id="row2"><label>Artist</label></div>
                    <div id="row3"><label>Gallery</label></div>
                    <div id="row4"><label>Year</lable>
                    </div>
                    <div id="row5"><input id="radioBefore" type="radio" id="Before" name="Year" value="Before" /><label for="Before"> Before </label></div>
                    <div id="row6"><input id="radioAfter" type="radio" id="After" name="Year" value="After" /><label for="After"> After </label></div>
                    <div id="row7"><input id="radioBetween" type="radio" id="Between" name="Year" value="Between" /><label for="Between"> Between </label></div>
                    <div id="boxrow1"><input class="inputtext" type="text" placeholder="enter search string" name="title" /></div>
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
                    <div id="boxrow4"><input id="inputBefore" class="inputtext" type="text" name="Before" /></div>
                    <div id="boxrow5"><input id="inputAfter" class="inputtext" type="text" name="After" /></div>
                    <div id="boxrow6"><input id="inputBetween1" class="inputtext" type="text" name="Between1" /></div>
                    <div id="boxrow7"><input id="inputBetween2" class="inputtext" type="text" name="Between2" /></div>

                    <!-- <label>Title </label>
                    <input type="text" placeholder="enter search string" name="search" />
                     -->

                    <!-- group radio buttons together radio group -->

                    <!-- <br />
                    <input type="radio" id="Before" name="Year" /><label for="Before"> Before </label> <input class="inputtext" type="text" for="Before" name="Before" /><br />
                    <input type="radio" id="After" name="Year" /><label for="After"> After </label> <input class="inputtext" type="text" for="After" name="After" /><br />
                    <input type="radio" id="Between" name="Year" /><label for="Between"> Between </label>
                    <input class="inputtext" type="text" for="Between" name="Between1" /> <br />
                    <input class="inputtext" type="text" for="Between" name="Between2" />
                    <br /> -->

                    <div id="row8">
                        <button class="small ui orange button" type="submit">
                            <i class="filter icon"></i> Filter
                        </button> <br />
                        <button class="resetbutton" type="reset">
                            <i class="filter icon"></i> Reset
                        </button>
                    </div>
                </form>
            </section>
        </div>
        <div class="box c">
            <section class="twelve wide column">
                <h2> Paintings </h2>
                <?php
                foreach ($_GET as $key => $data) {
                    echo $key . " " . $data . "<br />";
                }

                //outputPaintings($paintings);

                /* add your PHP code here */

                // if (isset($_GET['search'])) {
                //     if (count($paintings) > 0) {
                //         //outputPaintings($paintings);
                //     } else {
                //         echo "no paintings found with search term = " .
                //             $_GET['search'];
                //     }
                // } else {
                //     echo "Enter a search term and press Filter";
                // }

                ?>
                <div><?= $msg  ?></div>
            </section>
        </div>

    </main>
    <!-- <footer class="ui black inverted segment">
        <div class="ui container">&copy; 2021 Fundamentals of Web Development</div>
    </footer> -->

    <script src="js/browse-paintings.js"></script>
</body>

</html>

<!-- https://prod.liveshare.vsengsaas.visualstudio.com/join?E62D5585F3EDE88E0206EAD814466A7D249C -->