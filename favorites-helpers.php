<?php
// outputs the delete all button
function outputDeleteAll()
{
?>
    <form action="favorites.php" method="get">
        <button name="deleteAll" type="submit" value="all">Delete All</button>
    </form>
<?php
}

// outputs the lists of the logged-in user's favourited paintings
function outputFavorites($data)
{
    echo "<ul>";
    foreach ($data as $row) {
        echo "<form action ='favorites.php' method='get'>";
        outputList($row);
        echo "</form>";
    }
    echo "</ul>";
}

// outputs the li 
function outputList($row)
{
    echo "<li>";
    echo "<a href='single-painting.php?id=" . $row['PaintingID'] . "'><img src='images/paintings/square-medium/" . $row['ImageFileName'] . ".jpg'/><p>" . $row['Title'] . "</p></a>";
    echo "<button name='delete' type='submit' value='" . $row['PaintingID'] . "'>Delete</button>";
    echo "</li>";
}

?>