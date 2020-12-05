<?php
session_start();

require_once 'config.inc.php';
require_once 'db-classes.inc.php';


?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Assignment 1</title>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet">
      <link rel="stylesheet" href="css/home-logged-in.css">
   </head>
   <body>
      <main class="container">
         <div class = "box h">
            <header>
               <h1>
                  COMP 3512 Assign1 
               </h1>
               <h2>
                  Mohamed Aly
               </h2>
            </header>
         </div>
         <!-- <div class="box galleryInformation">
            <section>
               <h2>Gallery Info</h2>
               <ul id="galleryInfo"></ul>
            </section>
         </div> -->
         <div class="box galleries">
            <section>
               <h2>Personal Information</h2>
               <ul id="PersonalInfoList">

               <?php

                if (isset($_SESSION['ID'])) {

                    try
                    {
                        $conn = DatabaseHelper::createConnection(array(
                            DBCONNSTRING,
                            DBUSER,
                            DBPASS
                        ));
                        $customerGate = new Customer($conn);
                        //Query For user info
                        $dataID = $customerGate->getByID( $_SESSION['ID']);
                        displayUserData($dataID);
                        //Query For paintings Info
                   
                    }
                    catch(PDOException $e)
                    {
                        die($e->getMessage());
                    }
                
                }


                function displayUserData($dataID) {
                    foreach ($dataID as $row) {
                        echo ("<li>" . $row['firstname'] . " " .  $row['lastname'] . "</li>");
                        echo ("<li>" . $row['city'] . "</li>");
                        echo ("<li>" . $row['country'] . "</li>");
                    
                    }
                }



                ?>


               </ul>
            </section>
         </div>
         <div class="box paintingsTop">
         <form action="home-logged-in.php" method="get">  
   
            <input type="text" name = "checkSearch" placeholder="Browse Paintings">
            <button type="Submit">Search</button>
            <input type="reset">
        </div>

        </div>   
    </form>     
         </div>
         <div class = "box paintingsBottom">
             <?php
                if (isset($_GET["checkSearch"])) {

                    try
                    {
                        $conn = DatabaseHelper::createConnection(array(
                            DBCONNSTRING,
                            DBUSER,
                            DBPASS
                        ));
                        $paingingTitleCheck = new PaintingDB($conn);
                        //Query For user info
                        $dataArtist = $paingingTitleCheck->getforTitle($_GET["checkSearch"]);
                        foreach($dataArtist as $r) {
                            echo " <img src='images/paintings/square-medium/" .  $r['ImageFileName'] . ".jpg'/>";
                            header("Refresh:25; url=home-logged-in.php");
                        }
                
                    }
                    catch(PDOException $e)
                    {
                        die($e->getMessage());
                    }
                
                
                    } else {

                    try
                {
                    $conn = DatabaseHelper::createConnection(array(
                        DBCONNSTRING,
                        DBUSER,
                        DBPASS
                    ));
                    for($i = 0; $i < count($_SESSION['favorites']); $i++) {
                        $artistGate = new PaintingDB($conn);
                        //Query For user info
                        $aid = $_SESSION['favorites'][$i]['ArtistID'];
                        $dataArtist = $artistGate->getAllForArtist($aid);
                        foreach($dataArtist as $d) {
                            echo " <img src='images/paintings/square-medium/" .  $d['ImageFileName'] . ".jpg'/>";
                            }                    }
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }

                // function queryForPaintings($conn) {
                //     for($i = 0; $i < count($_SESSION['favorites']); $i++) {
                //     $artistGate = new PaintingDB($conn);
                //     //Query For user info
                //     $aid = $_SESSION['favorites'][$i]['ArtistID'];
                //     $dataArtist = $artistGate->getAllForArtist($aid);
                //     displayPaintingData($dataArtist, $i);
    
                //     }
                // }

                // function displayPaintingData($dataArtist, $i) {
                //     foreach($dataArtist as $d) {
                //     echo " <img src='images/paintings/square-medium/" .  $d['ImageFileName'] . ".jpg'/>";
                //     }
                // }
            }
            ?>

        </div>
         <div class="box" id = "map">
             <?php
          
             echo "<ul>";
            
               for($i = 0; $i < count($_SESSION['favorites']); $i++) {
                
                echo "<img src='images/paintings/square-medium/" . $_SESSION['favorites'][$i]['ImageFileName'] . ".jpg'/>";
                echo "<div class = 'title'>" . $_SESSION['favorites'][$i]['Title'] . "</div>";
                echo "<div class = 'title'>" . $_SESSION['favorites'][$i]['ArtistID'] . "</div>";


                }
             echo "</ul>";
             
            
             ?>
         </div>
      </main>
      <script src="js/index.js"></script>
      <script
         src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWWSA9Vi0YY5CtBeMUZnkIX75OA4kzr4I&
         callback=initMap"  async defer></script> 
   </body>
</html>
