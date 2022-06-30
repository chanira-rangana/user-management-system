<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/function.php'); ?>
<?php

    $errors = array();

    $user_id = '';
    $first_name = '';
	$last_name = '';
	$email = '';
	$password = '';

    if(isset($_GET['user_id'])){
        //getting uer information
        $user_id = mysqli_real_escape_string($connection,$_GET['user_id']);
        $query = "SELECT * FROM user WHERE id= {$user_id}  LIMIT 1";
        $result_set = mysqli_query($connection,$query);
        if($result_set){
            if(mysqli_num_rows($result_set) == 1){
                // user found
                $result = mysqli_fetch_assoc($result_set);
                $first_name = $result['first_name'];
                $last_name = $result['last_name'];
                $email = $result['email'];
            }else {
                // user not found
                // if user not found redirect to the user.php 
                header('Location: users.php?err=user_not_found');
                
            }
        }else {
            // queryy failed
            header('Location: users.php?err=query_failed');
        }
    }

    // checking submit button is pressed
    if(isset($_POST['submit'])){

        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];

        //checking required fields
        $required_fields = array('user_id','first_name','last_name','email');
        /* 
            $errors = check_req_fields($required_fields);  

            check_req_fields($required_fields) -> return an array, $errors is an array 
            when we insert array into another array it will be added as array item
            therefore we must merge array 
        */
        $errors = array_merge($errors, check_req_fields($required_fields));

        // checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100);

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
		$query = "SELECT * FROM user WHERE email = '{$email}' AND id != {$user_id} LIMIT 1";

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

            $query = "
                UPDATE user SET first_name='{$first_name}',last_name='{$last_name}', email='{$email}' WHERE id = '{$user_id}' LIMIT 1  
            ";

            $result = mysqli_query($connection, $query);

            if($result) {
                // query successfull.. redirecting to users page
                header('Location: users.php?user_modified=true');
            } else {
				$errors[] = 'Failed to modify the record.';
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
    <title>Modify User</title>
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
        <form action="modify-user.php" method="POST" class="userform">
        <input type="hidden" name="user_id" id="user_id" <?php echo 'value="' . $user_id . '"'?> >
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
                <label for="password">Password:</label>
                <span>****</span> | <a <?php echo 'href="change_password.php?user_id=' . $user_id . '"'?> >Change Password</a>
            </p>
            <p>
                <label for="save">&nbsp;</label>
                <button type="submit" name="submit" id="save">Save</button>
            </p>
        </form> 
    </main>
</body>
</html>