<?php
    require_once("config/db.php");
    require_once("classes/Login.php");
    $login = new Login();
    if ($login->isUserLoggedIn() == true) {
        include("views/logged_in.php");
    
    } else {
        include("views/not_logged_in.php");
    }
?>
<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <div class="form-element">
            <label>Username:</label>
            <input type="text" name="Username" pattern="[a-zA-Z]+" required>
        </div>
        <div class="form-element">
            <label>Password:</label>
            <input type="password" required>
        </div>
        <button type="submit" name="login" value="Login"></button>
    </form>
    <a href="./register.php">register</a>

</body>

</html> -->