<!DOCTYPE html>
<html lang=en>

<head>
  <meta charset="UTF-8">
  <title>Galleries</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet" />
  <link rel="stylesheet" href="css/galleries.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<div id="modalContainer">
  <img id="popupModal" />
</div>

<body>
  <main class="container">
    <header class="e navContainer"> 
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

    <div class="box a">
      <section>
        <div id=loader1 class="lds-dual-ring"></div>
        <h3>Paintings</h3>
        <table id="paintingsList" width=100%>
          <tr>
            <th></th>
            <th id="tableArtist">artist</th>
            <th id="tableTitle">title</th>
            <th id="tableYear">year</th>
          </tr>
        </table>
      </section>
    </div>
    <div class="box b">
      <section>
        <div id=loader3 class="lds-dual-ring"></div>
        <h3>Galleries</h3>
        <ul id="galleryList"></ul>
      </section>
    </div>
    <div class="box c">
      <section>
        <div id=loader2 class="lds-dual-ring"></div>
        <h3>Gallery Information</h3>
        <label></label>
        <label>Gallery Name:</label>
        <span id="galleryName"></span>
        <label>Native Name:</label>
        <span id="galleryNative"></span>
        <label>City:</label>
        <span id="galleryCity"></span>
        <label>Address:</label>
        <span id="galleryAddress"></span>
        <label>Country:</label>
        <span id="galleryCountry"></span>
        <label>Website:</label>
        <span><a href="" id="galleryHome"></a></span>
      </section>
      <section>
        <input type="button" value="Hide Galleries" id="toggleButton" />
      </section>
    </div>
    <div id="map" class="box d"></div>
  </main>

  <section id="largeImageView">
    <div id=largePaintingsImage class="box h">
      <img id="largeImage" />
    </div>
    <div id="largePaintingDetails" class="box i">
      <section>
        <h2 id="paintingTitle"></h2>
        <span id="artistFirstName"></span>
        <span id="artistLastName"></span>,
        <span id="paintingYearOfWork"></span>
        <p id="paintingMedium"></p>
        <label>Size: </label><span id="paintingWidth"></span> x <span id="paintingHeight"></span>
        <br /> <br />
        <span id="paintingDescription"></span>
        <br /><br />
        <label>Gallery: </label>
        <span id="paintingGalleryName"></span>
        <br />
        <span>City: </span><span id="paintingGalleryCity"></span>
        <br />
        <span>Museum Link: </span><a href="" id="museumLink"></a>
        <br />
        <span>Copyright: </span><span id="copyright"></span>
        <br /><br />
        <figcaption id="colors"></figcaption>
        <button id="closeLargeImage">Close</button>
      </section>
    </div>
  </section>

  <div class="footer">
    <p>Photo by Paweł Czerwiński on <a href="https://unsplash.com/photos/bX9B9c-YasY">Unsplash</a></p>
  </div>
  
  <script src="js/galleries.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBNBzMlgWl5UCwXNtoTztjLVICamMu_G0&callback=initMap" async defer></script>
</body>

</html>