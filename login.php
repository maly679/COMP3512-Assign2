<?php

?>
<!DOCTYPE html>
<html lang=en>
<title>Login Page</title>
<meta charset=utf-8>

<head>

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
</head>

</html>