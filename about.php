<!DOCTYPE html>
<html lang=en>

<head>
  <title>About</title>
  <meta charset=utf-8>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/about.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div class="container">
    <!-- <div class="section header">
            <h2>About</h2>
        </div> -->
    <header class="section header navContainer">
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
    <div class="section body">
      <span class="sub-heading">Class Name: </span><span class="info">COMP 3512</span><br>
      <span class="sub-heading">University: </span><span class="info">Mount Royal University</span><br>
      <span class="sub-heading">Professor Name: </span><span class="info">Randy Connolly</span><br>
      <span class="sub-heading">Semester: </span><span class="info">Fall 2020</span><br>
      <span class="sub-heading">Technologies: </span><span class="info">Heroku API, Heroku CLI, Git, JAWSDB</span><br>
      <span class="sub-heading">Assignment Repository: </span><a href='https://github.com/maly679/COMP3512-Assign2'>COMP3512-Assign2</a><br>
      <span class="sub-heading">Group Members: </span>
      <ul>
        <li><a href='https://github.com/maly679'>Mohamed Aly</a></li>
        <li><a href='https://github.com/batuh836'>Brian Atuh</a></li>
        <li><a href='https://github.com/mbalu028'>Matthew Baluyot</a></li>
        <li><a href='https://github.com/mari-rmrz'>Mariangel Ramirez</a></li>
        <li><a href='https://github.com/Jwalker457'>Jordan Walker</a></li>
      </ul>
      <span class="sub-heading">External References: </span>
      <ul>
        <li><a href='https://www.javatpoint.com/html-login-form'>Login Form</a></li>
        <li><a href='https://developer.mozilla.org/en-US/docs/Web/API/URL/searchParams'>Search Parameters</a></li>
      </ul>
    </div>
  </div>
  <div class="footer">
    <p>Photo by Paweł Czerwiński on <a href="https://unsplash.com/photos/bX9B9c-YasY%22%3E">Unsplash</a></p>
  </div>
</body>

</html>