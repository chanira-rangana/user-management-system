<?php require_once('inc/connection.php'); ?>
<?php
    // check for user form submission 
    if(isset($_POST['submit'])){

        $errors = array();

        // check if the username password has been entered
        if(!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
            $errors[] = 'Username is Missing or Invalid';
        }
        if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ) {
            $errors[] = 'Password is Missing or Invalid';
        }
        // check if there any errors in the form
        if(empty($errors)){
            // save username and password into variables
            $email = mysqli_real_escape_string($connection,$_POST['email']); 
                //mysqli_real_escape_string is used for avoid sql query injection
            $password = mysqli_real_escape_string($connection,$_POST['password']); 
            $hashed_password = sha1($password);
            
            
            // prepare database query
            $query = "SELECT * FROM user 
                        WHERE email='{$email}' 
                        AND password='{$hashed_password}'
                        LIMIT 1";

            $result_set = mysqli_query($connection,$query);            
            
            // check if the user is valid  
            if($result_set){
                //query successfull

                if(mysqli_num_rows($result_set) == 1){
                    //valid user found
                    // redirect to the user.php page
                    header('Location: users.php');

                }else {
                    $errors[] = 'Invalid Username or Password';
                }
            }else {
                $errors[] = 'Database query failed';
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
    <link rel="stylesheet" href="css/style.css">
    <title>Log In User management Sysytem</title>
</head>
<body>
    <div class="login">
        <form action="index.php" method="POST">
            <fieldset>
                <legend> <h1> Log In</h1></legend>
                
                <?php
                    if(isset($errors) && !empty($errors)){
                        echo '<p class="error">Invalid Username or Password</p>';
                    }
                ?>
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