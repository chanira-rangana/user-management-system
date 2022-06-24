<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php
    $errors = array();

    if(isset($_POST['submit'])){
        //checking required fields

        $required_fields = array('first_name','last_name','email','password');

        foreach($required_fields as $field){
            if(empty(trim($_POST[$field]))){
                $errors[] = $field .' is required';
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
    <title>Add New User</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
      <div class="appname">User Management System</div>
      <div class="loggedin">
        Welcome
        <?php echo $_SESSION['first_name']; ?>
        ! <a href="logout.php">Log out</a>
      </div>
    </header>

    <main>
        <h1>
            Add New User <span><a href="users.php"> < Back to user list </a></span>
        </h1>
        <?php 
            if(!empty($errors)){
                echo '
                    <div class="errmsg">
                        <b>There Was error(s) in your form</b>';

                    foreach($errors as $error){
                        echo '<p>'.$error.'</p>';
                    }

                echo '</div>';
            }
        ?>
        <form action="add-user.php" method="POST" class="userform">
            <p>
                <label for="fname">First Name:</label>
                <input type="text" name="first_name" id="fname">
            </p>
            <p>
                <label for="lname">Last Name:</label>
                <input type="text" name="last_name" id="lname">
            </p>
            <p>
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email">
            </p>
            <p>
                <label for="password">New Password:</label>
                <input type="password" name="password" id="password">
            </p>
            <p>
                <label for="confirmed_password">Confirm Password:</label>
                <input type="password" name="confirmed_password" id="confirmed_password">
            </p>

            <p>
                <label for="save">&nbsp;</label>
                <button type="submit" name="submit" id="save">Save</button>
            </p>
        </form> 
    </main>
</body>
</html>