<?php
if (isset($_POST['name'])) {
   header("Location: login.php");
} else if (isset($_POST['title'])) {
   header("Location: browse-painting.php");
}
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
         <input class="searchBar" type="text" placeholder="Search painting or gallery.." name="title">
         <!-- Result of this should filter -->
      </form>
   </div>

   <div class="footer">
      <p>Image from Unsplash by Darya Tryfanava</p>
   </div>

   <script src="js/index.js"></script>
</body>

</html>