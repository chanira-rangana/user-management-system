<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php

    $errors = array();
    $first_name = '';
	$last_name = '';
	$email = '';
	$password = '';

    // checking submit button is pressed
    if(isset($_POST['submit'])){

        $first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

        //checking required fields
        $required_fields = array('first_name','last_name','email','password');
        /* 
            $errors = check_req_fields($required_fields);  

            check_req_fields($required_fields) -> return an array, $errors is an array 
            when we insert array into another array it will be added as array item
            therefore we must merge array 
        */
        $errors = array_merge($errors, check_req_fields($required_fields));

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

        // checking if email address already exists
        // sanitization -> mysqli_real_escape_string
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
            // check there was only one email address
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}

        if(empty($error)){
            $first_name = mysqli_real_escape_string($connection,$_POST['first_name']);
            $last_name = mysqli_real_escape_string($connection,$_POST['last_name']);
            $email = mysqli_real_escape_string($connection,$_POST['email']);
            $password = mysqli_real_escape_string($connection,$_POST['password']);
            $hashed_password = sha1($password);

            $query = "INSERT INTO user ( ";
			$query .= "first_name, last_name, email, password,last_login, is_deleted";
			$query .= ") VALUES (";
			$query .= "'{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', NOW(), 0";
			$query .= ")";

            $result = mysqli_query($connection, $query);

            if($result) {
                // query successfull.. redirecting to users page
                header('Location: users.php?user_added=true');
            } else {
				$errors[] = 'Failed to add the new record.';
			}
        }

        $_POST['password'] = '';

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

                display_errors($errors);
                
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