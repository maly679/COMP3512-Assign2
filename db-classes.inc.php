<?php
class DatabaseHelper
{
    /*  Returns a connection object to a database  */
    public static function createConnection($values = array())
    {
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }

    /*
      Runs the specified SQL query using the passed connection and
      the passed array of parameters (null if none)
    */
    public static function runQuery($connection, $sql, $parameters = array())
    {
        // Ensure parameters are in an array
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }

        $statement = null;
        if (count($parameters) > 0) {
            // Use a prepared statement if parameters
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
            if (!$executedOk) throw new PDOException;
        } else {
            // Execute a normal query
            $statement = $connection->query($sql);
            if (!$statement) throw new PDOException;
        }

        return $statement;
    }
}

class ArtistDB
{
    private static $baseSQL = "SELECT * FROM artists ORDER BY LastName";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}

class PaintingDB
{
    private static $baseSQL = "SELECT PaintingID, Paintings.ArtistID, FirstName, LastName, Paintings.GalleryID, GalleryName, ImageFileName, Title, Excerpt, YearOfWork, ImageFileName, Description, Width, Height, Medium, CopyrightText, WikiLink, MuseumLink, JsonAnnotations FROM galleries INNER JOIN (artists INNER JOIN paintings ON artists.ArtistID = paintings.ArtistID) ON galleries.GalleryID = paintings.GalleryID ";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getForID($paintingID)
    {
        $sql = self::$baseSQL . " WHERE paintings.PaintingID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($paintingID));
        return $statement->fetchAll();
    }

    public function getAllForArtist($artistID)
    {
        $sql = self::$baseSQL . " WHERE paintings.ArtistID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($artistID));
        return $statement->fetchAll();
    }

    public function getAllForGallery($galleryID)
    {
        $sql = self::$baseSQL . " WHERE paintings.GalleryID=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($galleryID));
        return $statement->fetchAll();
    }

    public function getTop20()
    {
        $sql = self::$baseSQL . " ORDER BY YearOfWork LIMIT 20";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}

class GalleryDB
{
    private static $baseSQL = "SELECT GalleryID, GalleryName, GalleryNativeName, GalleryCity, GalleryAddress, GalleryCountry, Latitude, Longitude, GalleryWebSite FROM galleries ";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL . " ORDER BY GalleryName";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getForID($galleryID)
    {
        $sql = self::$baseSQL . " WHERE GalleryID=?"; 
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, array($galleryID));
        return $statement->fetchAll();
    }
}
