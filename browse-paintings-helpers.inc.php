<?php


function getGallerySQL()
{
    $sql = 'SELECT GalleryID, GalleryName, GalleryNativeName, GalleryCity, GalleryCountry, Latitude, Longitude, GalleryWebSite FROM Galleries';
    $sql .= " ORDER BY GalleryName";
    return $sql;
}

function getPaintingSQL()
{
    $sql = "SELECT PaintingID, Paintings.ArtistID AS ArtistID, FirstName, LastName, GalleryID, ImageFileName, Title, ShapeID, MuseumLink, AccessionNumber, CopyrightText, Description, Excerpt, YearOfWork, Width, Height, Medium, Cost, MSRP, GoogleLink, GoogleDescription, WikiLink, JsonAnnotations FROM Paintings INNER JOIN Artists ON Paintings.ArtistID = Artists.ArtistID ";
    return $sql;
}

function addSortAndLimit($sqlOld)
{
    $sqlNew = $sqlOld . " ORDER BY YearOfWork limit 20";
    return $sqlNew;
}


function makeArtistName($first, $last)
{
    return utf8_encode($first . ' ' . $last);
}


function getAllGalleries($connection)
{
    $sql = getGallerySQL();
    $result = $connection->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

// function getPaintings($pdo, $id)
// {
//    $sql = "SELECT PaintingID, Title, YearOfWork, ImageFileName
//    FROM Paintings WHERE GalleryID=?";
//    $statement = $pdo->prepare($sql);
//    $statement->bindValue(1, $id);
//    $statement->execute();
//    return $statement->fetchAll(PDO::FETCH_ASSOC);
// }


// https://www.php.net/manual/en/pdostatement.bindvalue.php
function getAllPaintings($connection)
{
    $sql = getPaintingSQL();
    //$sql .= "WHERE GALLERYID=?";

    $statement = $connection->prepare($sql);
    //$statement->bindValue(1, $id); // binding value is just to sanitize data
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getPaintingsByGallery($connection, $gallery)
{
    $sql = getPaintingSQL();
    $sql .= "WHERE GALLERYID= :galleryid";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':galleryid', $gallery);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function outputArtists($results)
{
    foreach ($results as $row) {
        outputSingleArtist($row);
    }
}

function outputSingleArtist($row)
{
    echo '<option value=' . $row['ArtistID'] . '>' . $row['FirstName'] . " " . $row['LastName'] . '</option>';
}

function outputGalleries($results)
{
    foreach ($results as $row) {
        outputSingleGallery($row);
    }
}

function outputSingleGallery($row)
{
    echo '<option value=' . $row['GalleryID'] . '>' . $row['GalleryName'] . '</option>';
}

/**
 * This function checks the querystring for any of the key fields that are needed and returns true
 * if any of them are found. It returns false if nothing is found. 
 * @return boolean
 */
function checkFormData()
{
    if (
        (isset($_GET['title']) && !empty($_GET['title'])) ||
        (isset($_GET['gallery']) && $_GET['gallery'] > 0) ||
        (isset($_GET['artist']) && $_GET['artist'] > 0) ||
        (isset($_GET['Before']) && !empty($_GET['Before'])) ||
        (isset($_GET['After']) && !empty($_GET['After'])) ||
        (isset($_GET['Between1']) && !empty($_GET['Between1'])) &&
        (isset($_GET['Between2']) && !empty($_GET['Between2']))
    ) {
        return true;
    } else {
        return false;
    }
}

function bindValues($connection, $sql, $parameters = array())
{
    if (!is_array($parameters)) {
        $parameters = array($parameters);
    }

    $statement = null;
    if (count($parameters) > 0) {
        // Use a prepared statement if parameters
        $statement = $connection->prepare($sql);
        foreach ($parameters as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->execute();
        $executedOk = $statement;
        if (!$executedOk) throw new PDOException;
    } else {
        // Execute a normal query
        $statement = $connection->query($sql);
        if (!$statement) throw new PDOException;
    }

    return $statement;
}

//POTENTIAL METHODS TO HELP WITH OUTPUTPAINTNGS
// header("Location: home-login.php");
// http_build_query()
// check if has key
//$_SERVER["QUERY_STRING"]
// . $_SESSION['sort'] = "artist" . '

/**
 * Prints out a table with paintings in them
 * @param $paintings assosiative array with paintings information
 * @param $loggedin boolean representing if a user is logged in.
 */
function outputPaintings($paintings, $loggedin)
{
    echo '<table>';
    echo '<tr>';
    echo '<th></th>';
    echo '<th id="tableArtist"><a href=browse-paintings.php?' . addSort("byArtist") . '> Artist </a> </th>'; //Needs to sort by artist Name
    echo '<th id="tableTitle"><a href=browse-paintings.php?' . addSort("byTitle") . '> Title </a></th>'; // Needs to sort by Title
    echo '<th id="tableYear"><a href=browse-paintings.php?' . addSort("byYear") . '> Year</a></th>'; // Needst to sort by YearOfWork
    echo '<th></th>';
    echo '<th></th>';
    echo '</tr>';
    foreach ($paintings as $row) {
        outputPainting($row, $loggedin);
    }
    echo '</table';
}

//I used this to search for the strpos and str_replace manuals https://www.php.net/manual/en/function.strpos.php.
// I used php.net for manuals.

/**
 * Changes the sort= in the querystring to match the string that is passed in by the user.
 * 
 * @param $addString String that determines what s
 * @return $queryString Returns a string 
 */
function addSort($addString)
{

    //check if there is a query string
    if (isset($_SERVER["QUERY_STRING"])) {

        $queryString = $_SERVER["QUERY_STRING"];

        if (strpos($queryString, '&sort=') === false) {
            $queryString .= "&sort=" . $addString;
        } else {
            if (strpos($queryString, 'sort=byArtist') !== false) {
                $queryString = str_replace("byArtist", $addString, $queryString);
            } elseif (strpos($queryString, 'sort=byTitle') !== false) {
                $queryString = str_replace("byTitle", $addString, $queryString);
            } elseif (strpos($queryString, 'sort=byYear') !== false) {
                $queryString = str_replace("byYear", $addString, $queryString);
            }
        }
        return $queryString;
    }
}


/**
 * Takes in painting information associative array and a boolean.
 * The associative array should contain paintings information. 
 * The $logged should be a boolean to determine if the favorite link should be output.
 * @param $row associative array
 * @param $loggedin boolean
 */
function outputPainting($row, $loggedin)
{
    echo '<tr>';
    echo '<td><img class="painting_image" src="images/paintings/square-medium/' . $row['ImageFileName'] . '.jpg" height="75" width="75"></td>';
    echo '<td>' . $row['FirstName'] . " " . $row['LastName'] . '</td>';
    echo '<td><a href=single-painting.php?id=' . $row['PaintingID'] . '>' . $row['Title'] . '</a></td>';
    echo '<td>' . $row['YearOfWork'] .  '</td>';
    if ($loggedin) {
        if (!findFavorite($row['PaintingID'])) {
            echo '<td><a class="style_link" href=add-favorites.php?id=' . $row['PaintingID'] . '>Favorite</a></td>';
        }
    }
    echo '<td><a class="style_link" href=single-painting.php?id=' . $row['PaintingID'] . '>View</a></td>';
    echo '</tr>';
}


/**
 * Takes in an $id that is then used to compare to the 
 * $_SESSIONS['favorites'][PaintingsID] then returns true
 * if it is equal or false if it is unequal.
 * @param $id 
 */
function findFavorite($id)
{
    $found = false;
    foreach ($_SESSION['favorites'] as $painting) {
        if ($painting['PaintingID'] == $id) {
            $found = true;
        }
    }
    return $found;
}


/** 
 * 
 * Takes in a connection to a database so a query can be run on it.
 * checks the query string and adds the field values to a parameters array. 
 * Uses $sql string and the parameters array to create pdo statment.
 * Uses pdo fetchall function to create a array of information.
 * @param $conn is a connection 
 * @return $paintings array (array with paintings array) 
 */
function buildQuery($conn)
{

    $addArray = [];
    $paramArray = [];

    $newsql = "SELECT PaintingID, FirstName, LastName, Title, YearOfWork, ImageFileName 
            FROM galleries INNER JOIN (artists INNER JOIN paintings ON artists.ArtistID = paintings.ArtistID) ON galleries.GalleryID = paintings.GalleryID";

    //This checks the query string has any feilds set (with checkFormData()), then it finds the feilds and builds a query string from them.
    if (checkFormData()) {
        $newsql .= " WHERE";

        if (isset($_GET['title']) && !empty($_GET['title'])) {

            $addsql = " Title LIKE :title";
            $addArray[] = $addsql;
            $paramArray[':title'] = '%' . $_GET['title'] . '%';
        }
        if (isset($_GET['gallery']) && $_GET['gallery'] != 0) {

            $addsql = " galleries.GalleryID = :gallery";
            $addArray[] = $addsql;
            $paramArray[':gallery'] = $_GET['gallery'];
        }
        if (isset($_GET['artist']) && $_GET['artist'] != 0) {

            $addsql = " artists.ArtistID = :artist";
            $addArray[] = $addsql;
            $paramArray[':artist'] = $_GET['artist'];
        }
        if (isset($_GET['Before']) && !empty($_GET['Before'])) {

            $addsql = " YearOfWork < :before";
            $addArray[] = $addsql;
            $paramArray[':before'] = $_GET['Before'];
        }
        if (isset($_GET['After']) && !empty($_GET['After'])) {

            $addsql = " YearOfWork > :after";
            $addArray[] = $addsql;
            $paramArray[':after'] = $_GET['After'];
        }
        if ((isset($_GET['Between1']) && !empty($_GET['Between1'])) && (isset($_GET['Between2']) && !empty($_GET['Between2']))) {
            $addsql = " YearOfWork BETWEEN :between1";
            $addArray[] = $addsql;
            $paramArray[':between1'] = $_GET['Between1'];
        }
        if ((isset($_GET['Between1']) && !empty($_GET['Between1'])) && (isset($_GET['Between2']) && !empty($_GET['Between2']))) {
            $addsql = " :between2";
            $addArray[] = $addsql;
            $paramArray[':between2'] = $_GET['Between2'];
        }

        //THIS ADDS THE ARRAY STRINGS TO THE SQL QUERY
        for ($i = 0; $i <= count($addArray) - 1; $i++) {
            if ($i == 0) {
                $newsql .= $addArray[$i];
            } else {
                $newsql .= " AND";
                $newsql .= $addArray[$i];
            }
        }
    }


    // Add the order by statment
    if (isset($_GET['sort'])) { // this is getting 
        if ($_GET['sort'] == "byTitle") {
            $newsql .= " ORDER BY Title";
        } elseif ($_GET['sort'] == "byArtist") {
            $newsql .=  " ORDER BY LastName";
        } elseif ($_GET['sort'] == "byYear") {
            $newsql .=  " ORDER BY YearOfWork";
        }
    } else {
        $newsql .= " ORDER BY YearOfWork";
    }

    //PRINT OUT PARAMS FOR TROUBLESHOOTING
    // foreach ($paramArray as $param) {
    //     echo " Param " . $param . "<br/>";
    // }
    // echo $newsql . "<br/>";


    //TEST PARAMETERS
    // $testSql = "SELECT Title , PaintingID FROM paintings WHERE PaintingID = :test";
    // $testParam = ['test' => "1"];


    //$statement = bindValues($conn, $testSql, $testParam);
    $statement = DatabaseHelper::runQuery($conn, $newsql, $paramArray);


    $paintings = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $paintings;
}


// REFERENCE CODE FROM LABS
// public static function runQuery($connection, $sql, $parameters = array())
// {
//     // Ensure parameters are in an array
//     if (!is_array($parameters)) {
//         $parameters = array($parameters);
//     }

//     $statement = null;
//     if (count($parameters) > 0) {
//         // Use a prepared statement if parameters
//         $statement = $connection->prepare($sql);
//         $executedOk = $statement->execute($parameters);
//         if (!$executedOk) throw new PDOException;
//     } else {
//         // Execute a normal query
//         $statement = $connection->query($sql);
//         if (!$statement) throw new PDOException;
//     }

//     return $statement;
// }
