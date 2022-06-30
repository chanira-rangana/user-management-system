<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>

<?php

    $errors = array();  
    $user_id = $_GET['user_id'];
    // if set submit
    if(isset($_POST['submit'])){
        // if new password and confirmed password are same
        $password = $_POST['password'];
        $confirmed_password = $_POST['confirmed_password'];
        if($password == $confirmed_password){
            // generate hashed password
            $hashed_password = sha1($password);

            // check new password has been already exsisted
            $sql = "SELECT * FROM user WHERE password = '{$hashed_password}' LIMIT 1";
            $result_set = mysqli_query($connection, $sql);
            if ($result_set) {
                // check there was only one password address
                if (mysqli_num_rows($result_set) == 1) {
                    $errors[] = 'Password already exists use another password';
                }
                // save password
            }

            
        }else {
            $errors[] = "Password doesn't same";
        }
        if(empty($error)){
            $sql = "UPDATE user SET password='{$hashed_password}' WHERE id = '{$user_id}' LIMIT 1 ";
            $result_set = mysqli_query($connection, $sql);
            if($result_set){
                header('Location: modify-user.php?user_password_modify=true');
            }else {
                $errors = "Faild to change Password";
            }
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Change Password</title>
</head>
<body>
        <?php 
            if(!empty($errors)){

                display_errors($errors);
                
            }
        ?>
        <form action="change_password.php" method="POST" class="userform">
            <p>
                <label for="password">New Password:</label>
                <input type="password" name="password" id="password" >
            </p>
            <p>
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" name="confirmed_password" id="confirm-password" >
            </p>
            <p>
                <label for="save">&nbsp;</label>
                <button type="submit" name="submit" id="save">Change password</button>
            </p>
        </form> 
</body>
</html>

<?php mysqli_close($connection); ?>
