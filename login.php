<?php
require_once 'config.inc.php';
require_once 'db-classes.inc.php';

$digest = password_hash( $_POST['pass'], PASSWORD_BCRYPT, ['cost' => 12] );
$userName = $_SESSION[""];
$pass = "SELECT Password_sha256 from customerlogon";

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));

    $result = DatabaseHelper::runQuery($conn, $pass, null);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "hello";
} catch (Exception $e) {
    die($e->getMessage());
}

if ($digest == $password_field_from_database_table //&& emails also match
) {
 // we have a match, log the user in
 session_start(); // starts the session
 // check for favorites
 if (isset($_SESSION["favorites"])) {
     $_SESSION["favorites"];
 }
 header(location: index.php); // redirect the logged in user to the homepage 
}

?>
<!DOCTYPE html>
<html lang=en>

<head>
    <title>Login Page</title>
    <meta charset=utf-8>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <!--Retrieved November, 27, 2020. from: https://www.w3schools.com/howto/howto_css_login_form.asp-->
    <form action="/login.php" method="post">
        <div class="loginBox">
            <label>
                <p>Email</p>
            </label for="email">
            <input type="text" placeholder="Enter Email" name="email" required>
            <label>
                <p>Password</p>
            </label for="pass">
            <input type="text" placeholder="Enter Password" name="pass" required>
            <button type="Submit">Login</button>
            <button type="Submit">Sign up</button>
        </div>
    </form>
</body>

</html>