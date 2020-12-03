<?php

session_start();

require_once 'config.inc.php';
require_once 'db-classes.inc.php';


$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

if($pageWasRefreshed ) {
   header('location:login.php');
} else {
   //do nothing;
}


//Function invoked below in markup, and redirects to page that produces error; this occurs only if the user entered an incorrect username and password combination.
function checkIfError()
{
    if (isset($_GET['redirect']))
    {
        if ($_GET['redirect'] = 'error')
        {
            echo "<div class = 'error'> Incorrect username and password combination entered. Please try again. </div>";
        }
    }
}

// checks email and password generated upon login of user, and processes check with database to verify.
if (isset($_GET['email']) && isset($_GET['pass']))
{

    try
    {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));
        $sql = "select UserName, CustomerID, Pass FROM customerlogon WHERE UserName = ?";
        $result = DatabaseHelper::runQuery($conn, $sql, array(
            $_GET['email']
        ));
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        checkData($_GET['pass'], $data);
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }

}

// Checks if the data is retrieved form database, and if the password matches that of the database's.
function checkData($pass, $data)
{

    if (isset($data) && count($data) > 0)
    {
        foreach ($data as $row)
        {
            if (password_verify($pass, $row['Pass']))
            {
                $_SESSION['ID'] = $row['CustomerID'];
                $_SESSION['status'] = "loggedIn";
                header('location: single-painting.php');
            }
            else
            {

                //redirect to error page if incorrect user entry detected.
                header("location:login.php?redirect='error'");

            }
        }
    }
    else
    {
        //redirect to error page if incorrect user entry detected.
        header("location:login.php?redirect='error'");

    }
}
?>

<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Login Page </title>  
<link rel = "stylesheet" href = "css/login.css"> </style>
</head>    
<body>    
   <h1> Login to the Gallery </h1> 
    <form action="login.php" method="get">  
        <div class="container">   
        <div class="loginBox">
        <!-- if error occurs, based on query string value, output error here. -->
        <?=checkIfError(); ?>
            <label>
                <p>Email</p>
            </label for="email">
            <input type="text" placeholder="Enter Email" name="email" required>
            <label>
                <p>Password</p>
            </label for="pass">
            <input type="password" placeholder="Enter Password" name="pass" required>
            <button type="Submit">Login</button>
            <button type="button">Sign up</button>
        </div>

        </div>   
    </form>     
</body>     
</html>
