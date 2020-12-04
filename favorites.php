<?php
session_start();
require_once 'config.inc.php';
require_once 'db-classes.inc.php';

//NOTE: REMOVE DUPES

/*
// checks if there is an existing array of favourites
if (!isset($_SESSION['favorites'])) {
    // initializes the array if the check is true
    $_SESSION['favorites'] = [];
}
*/


//foreach ($_SESSION['faorites'] as $s) {}
//$fav = $_SESSION['favorites'];
//print_r($_SESSION['favorites']);
//print_r($fav);
if (isset($_GET['delete'])) {
    //echo "yes";
    if ($_GET['delete'] != 'all') {


        foreach ($_SESSION['favorites'] as $key => $rmv) {
            //echo $rmv;
            if ($rmv == $_GET['delete']) {
                //echo $rmv;
                //echo "yes";
                //echo $_GET['delete'];
                unset($_SESSION['favorites'][$key]);
            }
        }
    }
} else {
    unset($_SESSION['favorites']);
}
?>
<form action="favorites.php" method="get">
    <button name="delete" type="submit" value="all">Delete All</button>
</form>
<?php
try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER,
        DBPASS
    ));
    if (isset($_SESSION['favorites'])) {
        foreach ($_SESSION['favorites'] as $key => $f) {
            //tryQuery($f, $conn);
            //echo $f;
            $sql = "select PaintingID, Title, ImageFileName from paintings where PaintingID = ?";
            $result = DatabaseHelper::runQuery(
                $conn,
                $sql, //array($_SESSION['favorites']
                $f
                //)
            );
            $data = $result->fetchAll(PDO::FETCH_ASSOC);

            echo "<ul>";
            foreach ($data as $row) {
                // echo $row['title'];
                // echo $row['imagefilename'];
?><form action="favorites.php" method="get">
                    <?php echo "<li>";
                    echo "<a href='single-painting.php?id=" . $row['PaintingID'] . "'><img src='images/paintings/square-medium/" . $row['ImageFileName'] . ".jpg'/><p>" . $row['Title'] . "</p></a>";
                    echo "</li>"; ?>
                    <button name="delete" type="submit" value="<?= $row['PaintingID'] ?>">Delete</button>
                </form>
<?php    //outputList($row);

                // echo "hello";
            }
            echo "</ul>";
        }

        // function tryQuery($f, $conn)
        // {

        //     //echo "</ul>";
        // }
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

// outputs the lists of the logged-in user's favourited paintings
function outputList($row)
{
}
