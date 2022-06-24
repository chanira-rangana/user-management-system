<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php

    $errors = array();
    $first_name = '';
	$last_name = '';
	$email = '';
	$password = '';


    if(isset($_POST['submit'])){

        $first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

        //checking required fields
        $required_fields = array('first_name','last_name','email','password');

        foreach($required_fields as $field){
            if(empty(trim($_POST[$field]))){
                $errors[] = $field .' is required';
            }
        }


        // checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100, 'password' => 40);

		foreach ($max_len_fields as $field => $max_len) {
			if (strlen(trim($_POST[$field])) > $max_len) {
				$errors[] = $field . ' must be less than ' . $max_len . ' characters';
			}
		}

        // checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
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
                <input type="text" name="first_name" id="fname" <?php echo 'value="' . $first_name . '"'?> >
            </p>
            <p>
                <label for="lname">Last Name:</label>
                <input type="text" name="last_name" id="lname" <?php echo 'value="' . $last_name . '"'?>>
            </p>
            <p>
                <label for="email">Email Address:</label>
                <input type="text" name="email" id="email" <?php echo 'value="' . $email . '"'?>>
            </p>
            <p>
                <label for="password">New Password:</label>
                <input type="password" name="password" id="password" <?php echo 'value="' . $password . '"'?>>
            </p>
            <p>
                <label for="save">&nbsp;</label>
                <button type="submit" name="submit" id="save">Save</button>
            </p>
        </form> 
    </main>
</body>
</html>