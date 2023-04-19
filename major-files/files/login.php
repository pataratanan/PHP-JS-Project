<?php 
date_default_timezone_set("Australia/Sydney");
require_once("nocache.php");

$errorMessage = '';

   // check that the form has been submitted
   if(isset($_POST['submit'])) {
    // check that username and password were entered
    if(empty($_POST['username']) || empty($_POST['password'])) {
       $errorMessage = "Both username and password are required";
    } else {
       // connect to the database
       require_once('dbconn.php');

       // parse username and password for special characters
       $username = $dbConn->escape_string($_POST['username']);
       $password = $dbConn->escape_string($_POST['password']);

       // hash the password so it can be compared with the db value
       $hashedPassword = hash('sha256', $password);

        $sql = "select id,admin from customer where email = '$username' and password = '$hashedPassword' ";
        $rs = $dbConn->query($sql);

        // check number of rows in record set.
        if($rs->num_rows) {
            // start a new session for the user
            session_start();

            // Store the user details in session variables
            $user = $rs->fetch_assoc();
            $_SESSION['who'] = $user['id'];
            $_SESSION['level'] = $user['admin'];
            // Redirect the user to the secure page
            header('Location: index.php');

        } else {
            $errorMessage = "Invalid Username or Password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"/>
    <script src="actions.js"></script>
    <style>
        h1{
            color: #4682B4;
        }
        .login{
            float: right;
            margin-right: 20px;
        }
        .realBody{
            margin-top: 30px;
        }
    </style>
</head>


<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div class="container">
<p style="color:red;"><?php echo $errorMessage;?></p>
<h1>Login Page:</h1>
<nav> 
    <div class="navBar">
    <a href="index.php">Home</a>
    <a href="profile.php">MyProfile</a>
    <a href="newbooking.php">NewBooking</a>
    <a href="bookings.php">Booking</a>
    </div>

    <div class="login">
    <a href="login.php">Login</a>  
    <a href="register.php">Register</a>
    </div>
    
</nav>

<div class="realBody">
    <label for="username"><strong>Username:</strong></label>
    <input id="username" type="text" placeholder="username@email.com" name="username">

    <label for="password"><strong>Password:</strong></label>
    <input id="password" type="password" placeholder="Enter Password" name="password">
    <br>
    <br>
    <div class="input-box">
         <input type="submit" value="Login" name="submit">
    </div>
</div>
</div>
</form>
</body>
</html>

