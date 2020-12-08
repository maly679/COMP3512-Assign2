<!DOCTYPE html>
<html lang=en>

<head>
  <meta charset="UTF-8">
  <title>Galleries</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet" />
  <link rel="stylesheet" href="css/galleries.css" />
</head>
<div id="modalContainer">
  <img id="popupModal" />
</div>

<body>
  <main class="container">
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
    </div>
    <div id="map" class="box d"></div>

    <div id="header" class="box e">
      <section>
        <input type="button" value="Hide Galleries" id="toggleButton" />
      </section>
    </div>
  </main>

  <section id="largeImageView">
    <div id="header2" class="box f">
      <label>COMP 3512 Assignment 1</label>
      <span>Jordan Walker & Mariangel Ramirez & loading.io </span>
    </div>
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

  <script src="js/galleries.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBNBzMlgWl5UCwXNtoTztjLVICamMu_G0&callback=initMap" async defer></script>
</body>

</html>