<?php
session_start();

require_once 'config.inc.php';
require_once 'db-classes.inc.php';

//Function is invoked below in markup; this occurs only if the user entered an incorrect username and password combination.
function checkIfError()
{
    if (isset($_GET['email']) && isset($_GET['pass'])) {

        if (!empty($_GET['email']) && empty($_GET['pass'])) {
            echo "<div class = 'error'> Please enter a password. </div>";
        } else {
            if (empty($_GET['email']) && !empty($_GET['pass'])) {
                echo "<div class = 'error'> Please enter an email. </div>";
            } else {
                if (empty($_GET['email']) && empty($_GET['pass'])) {

                    echo "<div class = 'error'> Please enter an email and password. </div>";
                }
            }
        }
        if (!empty($_GET['email']) && !empty($_GET['pass'])) {
            establishConnection();
        }
    }
}

function establishConnection()
{
    try {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));
        $customerGate = new CustomerLogon($conn);
        $data = $customerGate->getByUserName($_GET['email']);
        checkData($_GET['email'], $_GET['pass'], $data);
        $conn = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function checkMsgContent($msg)
{

    if (empty($msg)) {
        echo "<div class = 'error'> Please enter a valid email. </div>";
    } else {
        echo $msg;
    }
}

// Checks if the data is retrieved form database, and if the password matches that of the database's.
function checkData($email, $pass, $data)
{
    $msg = '';
    if (isset($data) && count($data) > 0) {
        foreach ($data as $row) {

            if ($email == $row['UserName']) {
                $emailFound = true;
            }

            if ($emailFound && password_verify($pass, $row['Pass'])) {
                $_SESSION['ID'] = $row['CustomerID'];
                $_SESSION['status'] = "loggedIn";
                header('location: home-logged-in.php');
            }
        }
        if (!$emailFound) {

            $msg = "<div class = 'error'> Please enter a valid email. </div>";
        } else {
            if ($emailFound) {
                $msg = "<div class = 'error'> Please enter a valid password. </div>";
            }
        }
    }

    checkMsgContent($msg);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login Page </title>
    <link rel="stylesheet" href="css/login.css">
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- <h1> Login to the Gallery </h1>  -->
    <header class="navContainer">
        <input type="checkbox" class="toggler">
        <button id="menuIcon"><i class="fa fa-bars"></i></button>
        <a href="about.php"><img id="logo" src="images/login-page/logo.png"></a>
        <div class="navItems">
            <div>
                <div>
                    <ul>
                        <!-- 
                            Makes sure that if the user is logged in then it will take them back to
                            home (logged in). Otherwise it will take the user back to the landing page 
                        -->
                        <?php
                        if (isset($_SESSION['status']) && isset($_SESSION['ID'])) {
                            echo '<li><a class="navBtn" href="home-logged-in.php">Home</a></li>';
                        } else {
                            echo '<li><a class="navBtn" href="index.php">Home</a></li>';
                        }
                        ?>
                        <li><a class="navBtn" href="about.php">About</a></li>
                        <li><a class="navBtn" href="galleries.php">Galleries</a></li>
                        <li><a class="navBtn" href="browse-paintings.php">Browse</a></li>
                        <li><a class="navBtn" href="favorites.php">Favorites</a></li>
                        <!-- 
                            Makes sure that if user is already logged in, then the button changes to
                            allow them to logout. Otherwise, if the user is not logged in, it will 
                            prompt them to login
                        -->
                        <?php
                        if (isset($_SESSION['status']) && isset($_SESSION['ID'])) {
                            echo '<li><a class="navBtn" href="logout.php">Logout</a></li>';
                        } else {
                            echo '<li><a class="navBtn" href="login.php">Login</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <form action="login.php" method="get">
        <div class="container">

            <div class="loginBox">
                <!-- if error occurs, based on query string value, output error here. -->
                <?= checkIfError(); ?>
                <label>
                    <p>Email</p>
                </label for="email">
                <input type="text" placeholder="Enter Email" name="email">
                <label>
                    <p>Password</p>
                </label for="pass">
                <input type="password" placeholder="Enter Password" name="pass">
                <button type="Submit">Login</button>
                <button type="button">Sign up</button>
            </div>

        </div>
    </form>
</body>

</html>