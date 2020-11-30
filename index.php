<?php
// if (isset($_POST['submit'])) {
//    header("Location: single-painting.php");
// }
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
      <form method='POST' action="login.php">
         <div class="loginBtn">
            <input type="submit" value="LOGIN">
            <!-- Redirect to logged in page -->
         </div>
         <div class="joinBtn">
            <input type="button" value="JOIN">
            <!-- Ask Randy what the join button does. Create new user page ??? -->
         </div>
      </form>
   </div>
   <div class="searchBar">
      <input type="text" placeholder="Search painting or gallery..">
      <button><i class="fa fa-search"></i></button>
      <!-- Result of this should filter -->
   </div>
</body>

<footer>
   <p>Image from Unsplash by Darya Tryfanava</p>
</footer>

</html>