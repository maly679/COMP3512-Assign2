<?php
require_once 'config.inc.php';
require_once 'db-classes.inc.php';

//function definitions


//retrieve the count of object data
function getCountofObject($data)
{
    $count = 0;
    foreach ($data as $key => $value)
    {
        $count++;
    }
    return $count;
}

//retrieve the list of paintings that contains 15, if there aren't 15 recommended paintings generated
function consolidateDataPaintingsMayLike($dataFirst15, $dataPaintingsMayLike)
{

    if (isset($dataPaintingsMayLike) && isset($dataFirst15))
    {
        $dataPaintingsCount = getCountofObject($dataPaintingsMayLike);
        $countPaintings = $dataPaintingsCount;
        $regCount = 0;
        while ($countPaintings < 15)
        {

            $dataPaintingsMayLike[] = $dataFirst15[$regCount];
            $countPaintings++;
            $regCount++;
        }
        return $dataPaintingsMayLike;

    }
}

// Get the first 15 paintings from the table to use for various scenarios
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

//Output paintings in a formatted manner
function outputFormattedPainting($data)
{
    echo "<ul>";
    for ($i = 0;$i < count($data);$i++)
    {

        echo "<li> <img src='images/paintings/square-medium/" . $data[$i]['ImageFileName'] . ".jpg'/> 
                        " . "<br>" . $data[$i]['Title'] . "</li>";

    }
    echo "</ul>";
}

// Outputting first 15 values when no favorites are present.
function processOutputtingFirst15($dataFirst15)
{
    outputFormattedPainting($dataFirst15);
}

// Obtain the threshhold of start date
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

// Obtain the threshhold of end date
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

// Process user info
function displayUserData($dataID)
{
    if (isset($dataID))
    {
        echo "<h2> Welcome " . $dataID[0]['firstname'] . "!";
        echo ("<p> <strong> <i>" . $dataID[0]['firstname'] . " " . $dataID[0]['lastname'] . " </p>" . "<p>" . $dataID[0]['city'] . ", </p>" . "<p>" . $dataID[0]['country'] . "</p> </i> </strong> </h2>");
    }
}

function displayUserInfo()
{ // Verify user logged in
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
            //displayDataForUser
            displayUserData($dataID);
            $conn = null;
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }

    }
}

function displayDataPaintingsMayLike($ArtistID, $YoWStart, $YoWEnd, $dataFirst15)
{
    // Obtain the paintings that user may like, based on first favorite Artist ID and threshhold identified above.
    try
    {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));

        $paintingGate = new PaintingDB($conn);
        // Obtain necessary paintings user may like, based on above set values obtained from favorite
        $dataPaintingsMayLike = $paintingGate->getAllForArtistandEraMayLike($ArtistID, $YoWStart, $YoWEnd);
        $countPaintings = getCountofObject($dataPaintingsMayLike);
        // If the paintings count is less than 10, process the outputting to retrieve values from the first 15 in table, to make it meet the threshhol.
        if (isset($dataPaintingsMayLike) && $countPaintings < 10)
        {
            $dataPaintingsMayLike = consolidateDataPaintingsMayLike($dataFirst15, $dataPaintingsMayLike);
        }
        $conn = null;
        // Process the display pattern (odd even, or 0) pertaining to the paintings in order to display the first painting in the middle, $i = odd number paintings on the right column of the showPaintings grid
        //and $i = even number paintings on the left, for formatting purposes
        outputFormattedPainting($dataPaintingsMayLike);

    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }
}

function processCheckSearch($getSearch)
{
    if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
    {
        echo "<div class='box' id ='Favorites'>";

        foreach ($_SESSION['favorites'] as $key => $value)
        {

            if ($value['Title'] == $getSearch)
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
}

function processRegFavorites()
{
    // If no search entered, display favorites if present
    echo "<div class='box' id ='Favorites'>";
    echo "<h2>Your Favorites</h2>";
    if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
    {
        outputFormattedPainting($_SESSION['favorites']);

    }

    echo "</div>";
    echo "</div>";
}

?>
