<?php
// $redirect = $_POST['name'];
if (isset($_POST['name'])) {
   header("Location: login.php");
} else if (isset($_POST['search'])) {
   header("Location: browse-painting.php");
}
?>
<!DOCTYPE html>
<html lang=en>

<head>
   <meta charset="UTF-8">
   <title>Galleries Login</title>
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="css/index.css" />
</head>

<body class="container">
   <div class="main">
      <!-- <form name="login" method="GET" action="login.php"> -->
      <div class="btnContainer">
         <!-- <button class="button" type="submit" name="login">LOGIN</button> -->
         <button class="button" type="button" name="login" onClick="location.href='login.php'">LOGIN</button>
         <!-- Redirect to logged in page -->
      </div>
      <div class="btnContainer">
         <input class="button" type="button" value="JOIN">
         <!-- Does nothing, as instructed by Randy -->
      </div>
      <!-- </form> -->
   </div>
   <form name="search" method="GET" action="browse-paintings.php?">
      <div class="searchBar">
         <input class="searchBar" type="text" placeholder="Search painting or gallery.." name="search">
         <button id="buttonIcon"><i class="fa fa-search"></i></button>
         <!-- Result of this should filter -->
      </div>
   </form>
</body>

<footer>
   <p>Image from Unsplash by Darya Tryfanava</p>
</footer>

</html>