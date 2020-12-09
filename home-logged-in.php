<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';
include 'home-logged-in-helpers.php';
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8" />
   <title>Assignment 1</title>
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet">
   <link rel="stylesheet" href="css/home-logged-in.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
   <main class="container">
      <div class="h navContainer">
         <input type="checkbox" class="toggler">
         <button id="menuIcon"><i class="fa fa-bars"></i></button>
         <a href="about.php"><img id="logo" src="images/login-page/logo.png"></a>
         <div class="navItems">
            <div>
               <div>
                  <ul>
                     <li><a class="navBtn" href="index.php">Home</a></li>
                     <li><a class="navBtn" href="about.php">About</a></li>
                     <li><a class="navBtn" href="galleries.php">Galleries</a></li>
                     <li><a class="navBtn" href="browse-paintings.php">Browse</a></li>
                     <li><a class="navBtn" href="favorites.php">Favorites</a></li>
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
      <div class="box b WelcomeUser">
         <section>
            <?= displayUserInfo(); ?>
         </section>
      </div>
      <div class="box searchFavorite">
         <form action="home-logged-in.php" method="get">

            <input type="text" name="checkSearch" placeholder="Browse for a Favorite" class='searchFavoritesBox'>
            <button type="Submit">Search</button>
      </div>

      </div>
      </form>
      </div>
      <div class="box Results">
         <?php
         // Ensure session favorites are present, and retrieve required values to process for query.
         if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites'])) {

            //Assign the Artist ID of the first favorite in list
            $ArtistID = $_SESSION['favorites'][0]['ArtistID'];
            //Obtain the threshhold pertaining to the painting years, in order to process recommended paintings query
            $YoWStart = getThreshholdStart($_SESSION['favorites'][0]['YearOfWork']);
            $YoWEnd = getThreshholdEnd($_SESSION['favorites'][0]['YearOfWork']);
         }

         echo "<h2>Paintings You May Like</h2>";

         // Verify session favorites is set and display the paintings user may like
         if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites'])) {

            displayDataPaintingsMayLike($ArtistID, $YoWStart, $YoWEnd, $dataFirst15);
         } else {
            // Process displaying of first 15 paintings, if no favorites are set
            if (isset($dataFirst15)) {

               outputFormattedPainting($dataFirst15);
               echo "</div>";
            }
         }
         ?>

      </div>
      <?php
      // This is where the browser determines if the user has searched something; if they have, then the favorites are iterated through and displayed only if the full title is correct, otherwise it displays no result found.
      if (isset($_GET["checkSearch"])) {
         processCheckSearch($_GET["checkSearch"]);
      } else {
         processRegFavorites();
      }

      ?>
      </div>
   </main>
</body>

</html>