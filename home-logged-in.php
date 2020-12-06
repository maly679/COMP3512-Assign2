<?php
session_start();

require_once 'config.inc.php';
require_once 'db-classes.inc.php';

//function definitions

//output paintings in a formatted manner
function outputFormattedPainting($data) {

for ($i = 0;$i < count($data);$i++)
    {
        if ($i == 0)
        {
            echo "<div class = 'middle'> <img src='images/paintings/square-medium/" . $data[$i]['ImageFileName'] . ".jpg'/> 
                        " . "<br>" . $data[$i]['Title'] . "</div>";
        }
        if ($i % 2 && $i != 0)
        {

            echo "<div class = 'odd'> <img src='images/paintings/square-medium/" . $data[$i]['ImageFileName'] . ".jpg'/> 
                        " . "<br>" . $data[$i]['Title'] . "</div>";
        }
        else
        {
            if ($i != 0)
            {
                echo "<div class = 'even'> <img src='images/paintings/square-medium/" . $data[$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $data[$i]['Title'] . "</div>";
            }
        }
    }
 }

//outputting first 15 values when no favorites are present.
function processOutputtingFirst15($dataFirst15)
{
    echo "<div class='box' id = 'Favorites'>";
    echo "<h2> Sample Panintings </h2>";
    echo "<div class = 'showPaintings'>";

    outputFormattedPainting($dataFirst15);
}

//obtain the threshhold of start date
function getThreshholdStart($yow)
{

    if ($yow < 1400)
    {
        return 0;
    }
    else
    {
        if ($yow > 1400 && $yow < 1550)
        {
            return 1400;
        }
        else
        {
            if ($yow > 1550 && $yow < 1700)
            {

                return 1550;
            }
            else
            {
                if ($yow > 1700 && $yow < 1875)
                {
                    return 1700;

                }
                else
                {
                    if ($yow > 1875 && $yow < 1945)
                    {
                        return 1875;
                    }
                    else
                    {
                        return 1945;
                    }
                }
            }
        }
    }
}

//obtain the threshhold of end date

function getThreshholdEnd($yow)
{

    if ($yow < 1400)
    {
        return 1400;
    }
    else
    {
        if ($yow > 1400 && $yow < 1550)
        {
            return 1550;
        }
        else
        {
            if ($yow > 1550 && $yow < 1700)
            {

                return 1700;
            }
            else
            {
                if ($yow > 1700 && $yow < 1875)
                {
                    return 1875;

                }
                else
                {
                    if ($yow > 1875 && $yow < 1945)
                    {
                        return 1945;
                    }
                    else
                    {
                        return 2020;
                    }
                }
            }
        }
    }
}

//process user info
function displayUserData($dataID)
{
    if (isset($dataID))
    {
        echo "<h2> Welcome " . $dataID[0]['firstname'] . "!";
        echo ("<p> <strong> <i>" . $dataID[0]['firstname'] . " " . $dataID[0]['lastname'] . " </p>" . "<p>" . $dataID[0]['city'] . ", </p>" . "<p>" . $dataID[0]['country'] . "</p> </i> </strong> </h2>");
    }
}
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

               <?php
//verify user logged in
if (isset($_SESSION['ID']))
{

    try
    {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));
        $customerGate = new Customer($conn);
        //Query For user info to process welcome user section
        $dataID = $customerGate->getByID($_SESSION['ID']);
        displayUserData($dataID);
        $conn = null;
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }

}

?>
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

// ensure session favorites are present, and retrieve required values to process for query.
if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
{
    //begin processing for the Results section, which consists of either a searched result, or if nothing was searched, the recommended paintings.
    //Assign the Artist ID of the first favorite
    $ArtistID = $_SESSION['favorites'][0]['ArtistID'];
    //obtain the threshhold pertaining to painting years, in order to process recommended paintings query
    $YoWStart = getThreshholdStart($_SESSION['favorites'][0]['YearOfWork']);
    $YoWEnd = getThreshholdEnd($_SESSION['favorites'][0]['YearOfWork']);

} else {

//proceed with obtaining the first 15 paintings to display in lieu of the favorites
try
{
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER,
        DBPASS
    ));

    $paintingGate = new PaintingDB($conn);

    $dataFirst15 = $paintingGate->getTop15();
    $conn = null;
}
catch(PDOException $e)
{
    die($e->getMessage());
}
}


//Verify session favorites is set and display the paintings user may like
if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
{

    echo "<h2>Paintings You May Like</h2>";

    //obtain the paintings that user may like, based on first favorite Artist ID and threshhold identified above.
    try
    {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));
        echo "<div class = 'showPaintings'>";

        $paintingGate = new PaintingDB($conn);
//obtain necessary paintings user may like, based on above set values obtained from favorite
        $dataPaintingsMayLike = $paintingGate->getAllForArtistandEraMayLike($ArtistID, $YoWStart, $YoWEnd);
        $conn = null;
//Process the display pattern (odd even, or 0) pertaining to the paintings in order to display the first painting in the middle, $i = odd number paintings on the right column of the showPaintings grid
//and $i = even number paintings on the left, for formatting purposes
        outputFormattedPainting($dataPaintingsMayLike);

        echo "</div>";
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }
}
?>

        </div>
             <?php
// This is where the browser determines if the user has searched something; if they have, then the favorites are iterated through and displayed only if the full title is correct, otherwise it displays no result found.
if (isset($_GET["checkSearch"]))
{
    if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
    {
        echo "<div class='box' id ='Favorites'>";

        foreach ($_SESSION['favorites'] as $key => $value)
        {

            if ($value['Title'] == $_GET['checkSearch'])
            {
                echo "<h2> " . $value['Title'] . "</h2>";
                echo " <img src='images/paintings/square/" . $value['ImageFileName'] . ".jpg'/ height='700' width='710'>";
                $imageFound = true;
                break;
            }
            else
            {
                $imageFound = false;
            }
        }
        if (!$imageFound)
        {
            echo "<h2>No Result Found<h2> <i> Please Try searching for a Title again! </i></h2>";

        }
    }
    else
    {
        echo "<div class='box' id ='Favorites'>";
        echo "<h2> <i> You have no favorites <br>  Please Add to Favorites to use this feature! </i> </h2>";
    }

    
}
else
{
//If no search entered, display favorites if present

    if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
    {

        echo "<div class='box' id ='Favorites'>";
        echo "<h2>Your Favorites</h2>";
        echo "<div class = 'showPaintings'>";

        outputFormattedPainting($_SESSION['favorites']);
    }
    else
    {
        //Process displaying of first 15 paintings, if no favorites are set
        if (isset($dataFirst15))
        {
            processOutputtingFirst15($dataFirst15);
        }
    }

    echo "</div>";
    echo "</div>";
}

?>
         </div>
      </main>
   </body>
</html>
