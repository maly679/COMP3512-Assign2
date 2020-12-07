<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';
include 'home-logged-in-helper.php';
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Assignment 1</title>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet">
      <link rel="stylesheet" href="css/homeLoggedIn.css" >
   </head>
   <body>
      <main class="container"> 
         <div class = "box h">
            <header>
               <h1>
                  COMP 3512 Assign 2
               </h1>
               <h2>
                  Group Member Names
               </h2>
            </header>
         </div>

         <div class="box WelcomeUser">
            <section>
            <?=displayUserInfo(); ?>
            </section>
         </div>
         <div class="box searchFavorite">
         <form action="home-logged-in.php" method="get">  
   
            <input type="text" name = "checkSearch" placeholder="Browse for a Favorite" class = 'searchFavoritesBox'>
            <button type="Submit">Search</button>
        </div>

        </div>   
    </form>     
         </div>
         <div class = "box Results">
             <?php
// Ensure session favorites are present, and retrieve required values to process for query.
if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
{
    //Begin processing for the Results section, which consists of either a searched result, or if nothing was searched, the recommended paintings.
    //Assign the Artist ID of the first favorite
    $ArtistID = $_SESSION['favorites'][0]['ArtistID'];
    //Obtain the threshhold pertaining to painting years, in order to process recommended paintings query
    $YoWStart = getThreshholdStart($_SESSION['favorites'][0]['YearOfWork']);
    $YoWEnd = getThreshholdEnd($_SESSION['favorites'][0]['YearOfWork']);

}

echo "<h2>Paintings You May Like</h2>";

// Verify session favorites is set and display the paintings user may like
if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
{

    displayDataPaintingsMayLike($ArtistID, $YoWStart, $YoWEnd, $dataFirst15);

}
else
{
    // Process displaying of first 15 paintings, if no favorites are set
    if (isset($dataFirst15))
    {

        processOutputtingFirst15($dataFirst15);
        echo "</div>";

    }
}
?>

        </div>
             <?php
// This is where the browser determines if the user has searched something; if they have, then the favorites are iterated through and displayed only if the full title is correct, otherwise it displays no result found.
if (isset($_GET["checkSearch"]))
{
    processCheckSearch($_GET["checkSearch"]);

}
else
{
    processRegFavorites();

}

?>
         </div>
      </main>
   </body>
</html>
