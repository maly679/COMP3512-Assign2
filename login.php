<?php


session_start();

require_once 'config.inc.php';
require_once 'db-classes.inc.php';


function checkIfError() {
if (isset($_GET['redirect'])) {
    if ($_GET['redirect'] = 'error') {
        echo "<div class = 'error'> Incorrect username and password combination entered. Please try again. </div>";
        }
    }
}

if (isset($_GET['email']) && isset($_GET['pass'])) {

    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $sql = "select UserName, CustomerID, Pass FROM customerlogon WHERE UserName = ?";
        $result = DatabaseHelper::runQuery($conn, $sql, array($_GET['email']));
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        checkData( $_GET['pass'], $data);
    } catch (PDOException $e) {
        die ($e -> getMessage());
    }

}

function checkData($pass, $data) {

    if (isset($data) && count($data) > 0) {
        foreach($data as $row) {
            if(password_verify($pass, $row['Pass'])) {
                $_SESSION['ID'] = $row['CustomerID'];
                $_SESSION['status'] = "loggedIn";
                header('location: index.php');
            } else {
              
                header("location:login.php?redirect='error'");

            }
         }
    } else {

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
        <?=checkIfError();?>
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
