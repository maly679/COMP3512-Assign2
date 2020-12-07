<?php
session_start();

require_once 'config.inc.php';
require_once 'db-classes.inc.php';

//Function is invoked below in markup; this occurs only if the user entered an incorrect username and password combination.
function checkIfError()
{
    if (isset($_GET['email']) && isset($_GET['pass']))
    {

        if (!empty($_GET['email']) && empty($_GET['pass']))
        {
            echo "<div class = 'error'> Please enter a password. </div>";

        }
        else
        {
            if (empty($_GET['email']) && !empty($_GET['pass']))
            {
                echo "<div class = 'error'> Please enter an email. </div>";
            }
            else
            {
                if (empty($_GET['email']) && empty($_GET['pass']))
                {

                    echo "<div class = 'error'> Please enter an email and password. </div>";

                }
            }
        }
        if (!empty($_GET['email']) && !empty($_GET['pass']))
        {
            establishConnection();

        }
    }

}

function establishConnection()
{
    try
    {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));
        $customerGate = new CustomerLogon($conn);
        $data = $customerGate->getByUserName($_GET['email']);
        checkData($_GET['email'], $_GET['pass'], $data);
        $conn = null;
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }
}

function checkMsgContent($msg)
{

    if (empty($msg))
    {
        echo "<div class = 'error'> Please enter a valid email and password combination. </div>";

    }
    else
    {
        echo $msg;
    }
}

// Checks if the data is retrieved form database, and if the password matches that of the database's.
function checkData($email, $pass, $data)
{
    $msg = '';
    if (isset($data) && count($data) > 0)
    {
        foreach ($data as $row)
        {

            if ($email == $row['UserName'])
            {
                $emailFound = true;
            }

            if ($emailFound && password_verify($pass, $row['Pass']))
            {
                $_SESSION['ID'] = $row['CustomerID'];
                $_SESSION['status'] = "loggedIn";
                header('location: home-logged-in.php');
            }

        }
        if (!$emailFound)
        {

            $msg = "<div class = 'error'> Please enter a valid email. </div>";

        }
        else
        {
            if ($emailFound)
            {
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
