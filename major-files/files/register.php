<?php 
require_once("nocache.php");
require_once("dbconn.php");

if(isset($_POST['submit'])){
$password = $_POST['password'];
$hashedPassword = hash('sha256', $password);
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$address = $_POST['address'];
$suburb = $_POST['suburb'];
$state = $_POST['state'];
$postcode = $_POST['postcode'];
$phone = $_POST['phone'];
$admin = $_POST['admin'];
$sql = "insert into customer (fname,lname,email,password,address,suburb,state,postcode,phone,admin)
values ('$fname','$lname','$email','$hashedPassword','$address','$suburb','$state','$postcode','$phone','$admin')";

if (mysqli_query($dbConn,$sql)) {
    session_start();
    echo "Successfully Registration";
    header('Location: index.php');
  } else {
    echo "Failed to register: " . $dbConn->error;
  }
  
  $dbConn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="actions.js"></script>
    <link rel="stylesheet" href="styles.css"/>
    <style>
        h1{
            margin-left: 30px;
            color: #FF6347;
        }
        nav{
            margin-left: 30px;
            font-size: 24px;
        }
        a{
            font-variant: small-caps; 
        }
        body{
            font-size: 18px;
        }
        .login{
            float: right;
            margin-right: 50px;
        }
        .navBar{
            float: right;
        }
        .main{
            font-size: 26px;
        }
    </style>
</head>

<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>"  onsubmit="return validateForm(this)">

<h1>Registration Page:</h1>
<h2>Please fill in the details to create an account with us.</h2>
<nav> 
    <div class="navBar">
    <a href="index.php">Home</a>
    <a href="profile.php">MyProfile</a>
    <a href="newbooking.php">New Booking</a>
    <a href="bookings.php">Booking</a>
    </div>

    <div class="login">
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    </div>
</nav>

    
<div>
<label for="fname"><b>FirstName</b></label>
<input type="text" placeholder="John" name="fname" id="fname">
<span class="error" id="fname-error">** Please start with capital letter **</span>
</div>

<div>
<label for="lname"><b>LastName</b></label>
<input type="text" placeholder="Smith" name="lname" id="lname">
<span class="error" id="lname-error">** Please start with capital letter **</span>
</div>

<div>
<label for="email"><b>Enter Email</b></label>
<input type="text" placeholder="johnSmith@email.com" name="email" id="email">
<span class="error" id="email-error">** Invalid Email Address **</span>
</div>

<div>
<label for="password"><b>Password</b></label>
<input type="password" placeholder="########" name="password" id="password">
<span class="error" id="password-error">** Password must be 8 characters long and must include at least 1 number **</span>
</div>

<div>
<label for="address"><b>Address</b></label>
<input type="text" placeholder="Unit XX, XXXX St." name="address" id="address">
</div>

<div>
<label for="suburb"><b>Suburb</b></label>
<input type="text" placeholder="Suburb" name="suburb" id="suburb">
</div>

<div>
<label for="state"><b>State</b></label>
<input type="text" placeholder="State" name="state" id="state">
<span class="error" id="state-error">** Must be 3 alphabet character or less**</span>
</div>

<div>
<label for="postcode"><b>PostCode</b></label>
<input type="text" placeholder="XXXX" name="postcode" id="postcode">
<span class="error" id="postcode-error">** Only 4 digits required **</span>
</div>

<div>
<label for="phone"><b>Phone</b></label>
<input type="text" placeholder="+66-XXX-XXX-XXX" name="phone" id="phone">
</div>

<div>
<label for="admin"><b>Admin</b></label>
<input type="text" placeholder="0(user) or 1(admin)" name="admin" id="admin">
</div>

<br>
<div class="input-box">
         <input type="submit" value="Register" name="submit">
</div>

<br>
<span class="error" id="allField">** All fields are required **</span>

<div >
<p>Already have an account? <a href="login.php">Sign in</a>.</p>
</div>
    

</form>
</body>

</html>