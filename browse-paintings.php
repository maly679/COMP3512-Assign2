<?php

require_once 'config.inc.php';
//require_once 'lab14a-test03-helpers.inc.php';
require_once 'db-classes.inc.php';

// 1. Connect to the database.
// 2. Handle connection errors.
// 3. Execute the SQL query.
// 4. Process the results.
// 5. Free resources and close connection.

// now retrieve galleries 

// SHOULD USE ONE CONNECTION TO GET ALL DATA ONCE THEN CLOSE???

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));
    $galleryGateway = new GalleryDB($conn);
    $galleries = $galleryGateway->getAll();

    $artistGateway = new ArtistDB($conn);
    $artists = $artistGateway->getAll();
    // close connection?

    $paintGateway = new PaintingDB($conn);
    if (isset($_GET['museum'])) {
        $paintings = $paintGateway->getAllForGallery($_GET['museum']);
    } else {
        $paintings = $paintGateway->getTop20();
    }

    //   if (isset($_GET['id']) && $_GET['id'] > 0) { // change id to museium 
    //     $paintGateway = new PaintingDB($conn);
    //     $paintings = $paintGateway->getAllForArtist($_GET['id']);
    //   } else {
    //     $paintings = null;
    //   }
} catch (Exception $e) {
    die($e->getMessage());
}

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
                <form class="ui_form" method="get">
                    <!-- <div class="ui_form_row">
                        <label>title</label>
                        <input class="inputtext" type="text" placeholder="enter search string" name="search" />
                    </div> -->

                    <div id="row1"><label>Title </label></div>
                    <div id="row2"><label>Artist</label></div>
                    <div id="row3"><label> Gallery</label></div>
                    <div id="row4"><input type="radio" id="Before" name="Year" value="Before" /><label for="Before"> Before </label></div>
                    <div id="row5"><input type="radio" id="After" name="Year" value="After" /><label for="After"> After </label></div>
                    <div id="row6"><input type="radio" id="Between" name="Year" value="Between" /><label for="Between"> Between </label></div>
                    <div id="boxrow1"><input class="inputtext" type="text" placeholder="enter search string" name="search" /></div>
                    <div id="boxrow2"><select class="ui fluid dropdown" name="artist">
                            <option value='0'>Select Artist</option>
                            <?php

                            // foreach ($data as $row) {
                            //     echo '<option value=' . $row['GalleryID'] . ">" . $row['GalleryName'] . "</option>";
                            // }
                            ?>
                        </select></div>
                    <div id="boxrow3"><select class="ui fluid dropdown" name="gallery">
                            <option value='0'>Select Gallery</option>
                            <?php
                            foreach ($galleries as $row) {
                            }
                            ?>
                        </select></div>
                    <div id="boxrow4"><input class="inputtext" type="text" name="Before" /></div>
                    <div id="boxrow5"><input class="inputtext" type="text" name="After" /></div>
                    <div id="boxrow6"><input class="inputtext" type="text" name="Between1" /></div>
                    <div id="boxrow7"><input class="inputtext" type="text" name="Between2" /></div>

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

                    <div id="row7">
                        <button class="small ui orange button" type="submit">
                            <i class="filter icon"></i> Filter
                        </button>
                    </div>
                </form>
            </section>
        </div>
        <div class="box c">
            <section class="twelve wide column">
                <h2> Paintings </h2>
                <?php
                /* add your PHP code here */
                if (isset($_POST['search'])) {
                    if (count($paintings) > 0) {
                        //outputPaintings($paintings);
                    } else {
                        echo "no paintings found with search term = " .
                            $_POST['search'];
                    }
                } else {
                    echo "Enter a search term and press Filter";
                }

                ?>
            </section>
        </div>

    </main>
    <!-- <footer class="ui black inverted segment">
        <div class="ui container">&copy; 2021 Fundamentals of Web Development</div>
    </footer> -->
</body>

</html>

<!-- https://prod.liveshare.vsengsaas.visualstudio.com/join?4732950F765E6F2D53A07D9D56BF94BA1F0D -->