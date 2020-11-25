<?php

/* these three will need to be moved to lab14a-db-classes.inc.php */

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

// use this function for getTop20
function addSortAndLimit($sqlOld)
{
    $sqlNew = $sqlOld . " ORDER BY YearOfWork limit 20";
    return $sqlNew;
}


function makeArtistName($first, $last)
{
    return utf8_encode($first . ' ' . $last);
}


/*
  You will likely need to implement functions such as these ...
*/

// function getGalleries($pdo)
// {
//    $sql = "SELECT GalleryID, GalleryName FROM Galleries
//    ORDER BY GalleryName";
//    $result = $pdo->query($sql);
//    return $result->fetchAll(PDO::FETCH_ASSOC);
// }

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

// TALK TO JP ABOUT THE BIND VALUE
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
    $statement->bindValue(':galleryid', $gallery); // 1
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
    echo '<option value=' . $row['PaintingID'] . '>' . $row['FirstName'] . $row['LastName'] . '</option>';
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

function outputPaintings($paintings)
{
    foreach ($paintings as $row) {
        outputSinglePainting($row);
    }
}

function outputSinglePainting($row)
{

    echo  '<li class="item">';
    echo  '<a class="ui small image" href="single-painting.php?id=' . $row['PaintingID'] . '"><img src="images/paintings/square-medium/' . $row['ImageFileName'] . '.jpg"></a>';
    echo  '<div class="content">';
    echo  '<a class="header" href="single-painting.php?id=' . $row['PaintingID'] . ' ">' . $row['Title'] . '</a>';
    echo  '<div class="meta"><span class="cinema">' . $row['FirstName'] . " " . $row['LastName'] . '</span></div>';
    echo  '<div class="description">';
    echo  '<p>' . $row['Excerpt'] . '</p>';
    echo  '</div>';
    echo  '<div class="meta">';
    echo  '<strong>' . $row['YearOfWork'] . '</strong>';
    echo  '</div>';
    echo  '</div>';
    echo  '</li>';


    // Ask about this method
    // <li class="item">
    //     <a class="ui small image" href="single-painting.php?id=<?php $row['PaintingID'] need ? here>"><img src="images/art/works/square-medium/001150.jpg"></a>
    //     <div class="content">
    //         <a class="header" href="single-painting.php?id=id here">
    //             <php? $row[Title] </a> <div class="meta"><span class="cinema">Artist name here</span></div>
    //     <div class="description">
    //         <p>Excerpt here</p>
    //     </div>
    //     <div class="meta">
    //         <strong>YearOfWork here</strong>
    //     </div>
    //     </div>
    // </li>


}
