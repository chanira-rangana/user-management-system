<?php
// Start the session
session_start();
?>
<?php require_once('inc/connection.php'); ?>
<?php
    //checking is a user is logged in
    if(!isset($_SESSION['user_id'])){
        //checking didn't logged in
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>User</title>
</head>
<body>
    <header>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> ! <a href="logout.php">Log out</a> </div>
    </header>
    <h1>Users</h1>
</body>
</html>

<?php mysqli_close($connection); ?>