<?php

require_once 'config.inc.php';
require_once 'browse-paintings-helpers.inc.php';
require_once 'db-classes.inc.php';

if (isset($_POST['name'])) {
   header("Location: login.php");
} 
else if (isset($_POST['title']) || isset($_POST['gallery'])) {
   header("Location: browse-painting.php");
}

// try {
//    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING,DBUSER, DBPASS));
//    $searchGateway = new TemporaryDB($conn);
//    $results = $searchGateway->getAllPaintingsAndGalleries($galleryID);

//    $paintingGateway = new PaintingDB($conn);
//   if (isset($_GET['museum'])) {
//     $paintings = $paintingGateway->getAllForGallery($_GET['museum']);
//   } else {
//     $paintings = $paintingGateway->Top20Paintings();
//   }

//    $conn = null;
// } catch (Exception $e) {
//    die($e->getMessage());
// }

?>
<!DOCTYPE html>
<html lang=en>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Galleries Login</title>
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet" />
   <link rel="stylesheet" href="css/index.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="container">
   <!-- For reference: https://www.w3schools.com/howto/howto_js_topnav_responsive.asp  -->
   <div class="navContainer">
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
   <div class="main">
      <div class="btnContainer">
         <button class="button" type="button" name="login" onClick="location.href='login.php'">LOGIN</button>
         <!-- Redirect to logged in page -->
      </div>
      <div class="btnContainer">
         <input class="button" type="button" value="JOIN">
         <!-- Does nothing, as instructed by Randy -->
      </div>
   </div>

   <div class="searchContainer">
      <form name="search" method="GET" action="browse-paintings.php?">
         <input class="searchBar" type="text" placeholder="Search painting or gallery.." name="search">
         <!-- Result of this should filter by painting (title) and gallery name -->
      </form>
   </div>

   <div class="footer">
      <p>Image from Unsplash by Darya Tryfanava</p>
   </div>

   <!-- <script src="js/index.js"></script> -->
</body>

</html>