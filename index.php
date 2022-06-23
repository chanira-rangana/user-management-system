<?php require_once('inc/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Log In User management Sysytem</title>
</head>
<body>
    <div class="login">
        <form action="index.php" method="POST">
            <fieldset>
                <legend> <h1> Log In</h1></legend>
                <!-- <p class="error">Invalid Username or Password</p> -->
                <p>
                    <label for="uname" >Username:</label>
                    <input type="email" name="email" id="uname" placeholder="Email address">
                </p>
                <p>
                    <label for="psw" >Password:</label>
                    <input type="password" name="password" id="psw" placeholder="Password">
                </p>
                <button type="submit" name="submit">Login</button>
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php mysqli_close($connection); ?>