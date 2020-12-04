<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';
require_once 'favorites-helpers.php';

//NOTE: REMOVE DUPES

// if the get of delete is set then deletes the selected painting from favorites
if (isset($_GET['delete'])) {
    foreach ($_SESSION['favorites'] as $key => $rmv) {
        if ($rmv == $_GET['delete']) {
            unset($_SESSION['favorites'][$key]);
        }
    }
}

// if deleteAll is set then delete all from favorites
if (isset($_GET['deleteAll'])) {
    unset($_SESSION['favorites']);
}

outputDeleteAll();

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER,
        DBPASS
    ));
    if (isset($_SESSION['favorites'])) {
        foreach ($_SESSION['favorites'] as $key => $f) {
            $sql = "select PaintingID, Title, ImageFileName from paintings where PaintingID = ?";
            $result = DatabaseHelper::runQuery(
                $conn,
                $sql,
                $f
            );
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            outputFavorites($data);
        }
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

/*
// checks if there is an existing array of favourites
if (!isset($_SESSION['favorites'])) {
    // initializes the array if the check is true
    $_SESSION['favorites'] = [];
}
*/

/*
?>
<form action="favorites.php" method="get">
    <button name="deleteAll" type="submit" value="all">Delete All</button>
</form>
<?php
*/

/*             echo "<ul>";
            foreach ($data as $row) {
?><form action="favorites.php" method="get">
                    <?php echo "<li>";
                    echo "<a href='single-painting.php?id=" . $row['PaintingID'] . "'><img src='images/paintings/square-medium/" . $row['ImageFileName'] . ".jpg'/><p>" . $row['Title'] . "</p></a>";
                    echo "</li>"; ?>
                    <button name="delete" type="submit" value="<?= $row['PaintingID'] ?>">Delete</button>
                </form>
<?php  
            }
            echo "</ul>"; */