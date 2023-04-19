<?php
date_default_timezone_set("Australia/Sydney");

require_once("nocache.php");
require_once("dbconn.php");


session_start();
if(!$_SESSION["who"]){
header("location: logoff.php");
}

$customer = $_SESSION["who"];

$sql = "select booking.checkedin, booking.flight_id, flight.flight_number, plane.max_baggage_weight, plane.seating from booking ";
$sql = $sql . "JOIN flight ";
$sql = $sql . "ON booking.flight_id = flight.id ";
$sql = $sql . "JOIN plane ";
$sql = $sql . "ON plane.id = flight.plane ";
$sql = $sql . "where customer_id = $customer ";
$rs = $dbConn->query($sql)
or die ('Problem with query' . $dbConn->error);

$row = $rs->fetch_assoc();
$datetime = date('Y-m-d H:i:s');
$allowableBaggage = $row['max_baggage_weight'] / $row['seating'];
$rs->close();
$rs = $dbConn->query($sql);

if (ISSET($_POST['submit'])) {
    $sql1 = "UPDATE booking set checkedin = '1' , checkin_datetime = '$datetime', baggage = '$allowableBaggage' where customer_id = $customer ";
    $rs1 = $dbConn->query($sql1)
    or die ('Problem with query' . $dbConn->error);
    header("location: bookings.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkin</title>
    <script src="actions.js"></script>
    <link rel="stylesheet" href="styles.css"/>
    <style>
        h1{
            margin-left: 30px;
            color: #4682B4;
        }
        body{
            font-family: Monaco; 
        }
        .login{
            font-size: 18px;
            float: right;
            margin-right: 50px;
        }
        .navBar{
            font-size: 18px;
            float: right;
        }
        .main{
            font-size: 18px;
        }
    </style>
</head> 

<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h1>CheckinPage</h1>
    <nav> 
    <div class="navBar">
    <a href="index.php">Home</a>
    <a href="profile.php">MyProfile</a>
    <a href="newbooking.php">New Booking</a>
    <a href="bookings.php">Booking</a>
       
    <?php if($_SESSION['level'] == 1) {?>
    <a href="flights.php">Flights</a>
    <?php } ?>
    </div>

    <div class="login">
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    </div>
</nav>
<br>
<br>

<div class="main">
<?php while ($row = $rs->fetch_assoc()) { ?>

<h2 style="color: #CD5C5C;">Flight : <?php echo $row['flight_number']?></h2>
<p style="color: #778899;">Allowable baggage weight : <?php echo $row['max_baggage_weight'] / $row['seating'] ?></p>
<input style="font-family: Monaco;" type="submit" value="Checkin" name="submit" id="submit" >

<hr>
<?php } ?> 
</div>


<?php $dbConn->close(); ?>
</form>    
</body>
</html>