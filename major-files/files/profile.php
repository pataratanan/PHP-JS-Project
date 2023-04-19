<?php 
require_once("nocache.php");
require_once("dbconn.php");
session_start();
if(!$_SESSION["who"]){
    header("location: logoff.php");
}
$unique = $_SESSION["who"];
$sql = "select fname,lname,email,address,suburb,state,postcode,phone from customer
where id = $unique";
   $rs = $dbConn->query($sql)
   or die ('Problem with query' . $dbConn->error);
 

   if(isset($_POST['submit'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $suburb = $_POST['suburb'];
    $state = $_POST['state'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];

    $sql = "update customer set fname = '$fname',
    lname = '$lname',
    email = '$email',
    password = '$password',
    address = '$address',
    suburb = '$suburb',
    state = '$state',
    postcode = '$postcode',
    phone = '$phone' where id = $unique";

     if (mysqli_query($dbConn,$sql) == TRUE) {
            echo "Record updated successfully";
    } else {
            echo "Error updating record: " . $dbConn->error;
    }

$dbConn->close(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="actions.js"></script>
    <link rel="stylesheet" href="styles.css"/>

    <style>
        h1{
            font-family: Monaco;
            margin-left: 30px;
            color: #FF6347;
        }
        nav{
            font-family: Monaco;
            margin-left: 30px;
            font-size: 20px;
        }
        body,a{
            font-family: Monaco; 
        }
        .login{
            float: right;
            margin-right: 50px;
        }
        .navBar{
            float: right;
        }
        .update,.detail{
            font-family: Monaco;
            font-size: 24px;
        }
    </style>

</head>

<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateFormProfile(this)">
    <h1>My profile:</h1>

<nav> 
<div class="navBar">
    <a href="index.php">Home</a>
    <a href="profile.php">MyProfile</a>
    <a href="newbooking.php">NewBooking</a>
    <a href="bookings.php">Booking</a>
       
    <?php if($_SESSION['level'] == 1) {?>
    <a href="flights.php">Flights</a>
    <?php } ?> 
</div>

<div class="login">
    <a href="login.php">Login</a>
    <a href="logoff.php">LogOff</a>
    <a href="register.php">Register</a>
</div>
</nav>

<br>
<br>
<h2 style="font-size: 28px;">Detail:</h2>

<div class="detail">
<?php while ($row = $rs->fetch_assoc()) { ?>
<p style="color: #8FBC8F;">FirstName : <?php echo $row['fname']?></p>
<p style="color: #E9967A;">LastName : <?php echo $row['lname']?></p>
<p style="color: #1E90FF;">Email : <?php echo $row['email']?></p>
<p style="color: #BA55D3;">Address : <?php echo $row['address']?></p>
<p style="color: #708090;">Suburb : <?php echo $row['suburb']?></p>
<p style="color: #CD5C5C;">State : <?php echo $row['state']?></p>
<p style="color: #ADD8E6;">Postcode : <?php echo $row['postcode']?></p>
<p style="color: #66CDAA;">Phone : <?php echo $row['phone']?></p>
<?php } ?>
</div>

<div class="update">
    <h2 style="font-size: 28px;">Update Detail:</h2>
      <p>
        <label style="color: #8FBC8F;" for="fname">FirstName:</label>
        <input type="text" name="fname" id="fname" maxlength="30">
      </p>
      <p>
        <label style="color: #E9967A;" for="lname">LastName :</label>
        <input type="text" name="lname" id="lname" maxlength="30">
      </p>
      <p>
        <label style="color: #1E90FF;" for="email">Email :</label>
        <input type="text" name="email" id="email" maxlength="30">
        <span class="error" id="email-error">** Invalid Email Address **</span>
      </p>
      <p>
        <label style="color: #D8BFD8;" for="password">New Password :</label>
        <input type="password" name="password" id="password" maxlength="30">
      </p>
      <p>
        <label style="color: #BA55D3;" for="address">Address :</label>
        <input type="text" name="address" id="address" maxlength="30">
      </p>
      <p>
        <label style="color: #708090;" for="suburb">Suburb :</label>
        <input type="text" name="suburb" id="suburb" maxlength="30">
      </p>
      <p>
        <label style="color: #CD5C5C;" for="state">State :</label>
        <input type="text" name="state" id="state" maxlength="30">
        <span class="error" id="state-error">** Must be 3 alphabet character or less**</span>
      </p>
      <p>
        <label style="color: #ADD8E6;" for="postcode">Postcode :</label>
        <input type="text" name="postcode" id="postcode" maxlength="30">
        <span class="error" id="postcode-error">** Only 4 digits required **</span>
      </p>
      <p>
        <label style="color: #66CDAA;" for="phone">Phone :</label>
        <input type="text" name="phone" id="phone" maxlength="30">
      </p>

      <span class="error" id="allField">** All fields are required **</span>

      <div class="input-box">
      <input style="font-family: Monaco;" id="submit" name="submit" type="submit">
      </div>

</div>

</form>
</body>
</html>