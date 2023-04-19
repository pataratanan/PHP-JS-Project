<?php
// ensure the page is not cached
require_once("nocache.php");
require_once("dbconn.php");
// get access to the session variables
session_start();
if(!$_SESSION["who"]){
header("location: logoff.php");
}

$customerID = $_SESSION["who"];

$sql = "select flight.id as flightID, flight.flight_number, flight.from_airport, flight.to_airport, flight.status, flight.flight_datetime as datetime, flight.distance_km,
plane.id as planeID, plane.seating as seating, plane.name as name from flight ";
$sql = $sql . "LEFT OUTER JOIN plane ";
$sql = $sql . "ON plane.id = flight.plane ";
$rs = $dbConn->query($sql)
or die ('Problem with query' . $dbConn->error);


?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="styles.css">
<script src="actions.js"></script>
<title>New Booking</title>
<style>
.time{
font-size: 16px;
color: #FF6347;
}
body{
font-family: Monaco;;
color: #008080;
font-size: 16px;
}
h1{
margin-left: 30px;
color: #DB7093;
}
nav{
margin-left: 30px;
}
.login{
float: right;
font-size: 24px;
}
.navBar{
font-size: 20px;
}
.row{
font-size: 16px;
color: #D2B48C;
}
</style>
</head>
<body>
<h1>NewBooking</h1>
<br>
<nav>
<div class = "navBar">
<a href="index.php">Home</a>
<a href="profile.php">MyProfile</a>
<a href="newbooking.php">NewBooking</a>
<a href="bookings.php">Booking</a>
<?php if($_SESSION['level'] == 1) {?>
<a href="flights.php">Flights</a>
<?php } ?>
<a href="checkin.php">Checkin</a>
</div>

<div class="login">
<a href="login.php">Login</a>
<a href="register.php">Register</a>
</div>
</nav>

<br>

<div class="rows">

<?php while ($row = $rs->fetch_assoc()) {?>
<?php 
$sql2 = "select id as bookingID from booking where flight_id  = ". $row['flightID'] ." ";
$rs2 = $dbConn->query($sql2)
or die ('Problem with query' . $dbConn->error);

$seatingCapacity = $row['seating'];
$bookingFlightID = $rs2->num_rows; //booking.flight_id;
$seated = $row['seating'] - $bookingFlightID; //number of booked


?>
<br>
<h3 style="color: #F4A460; font-size: 16px;">Flight :<?php echo $row["flight_number"]?></h3>
<p style="color: #708090; font-size: 16px;"><?php echo $row["from_airport"]?>--><?php echo $row["to_airport"]?> (<?php echo $row["distance_km"]?>km) <?php echo $row['name'] ?></p>

<div class="time">
<span style="color: #5F9EA0; font-size: 16px;"><?php echo $row['datetime']?></span>

<?php if(strtotime($row['datetime']) < strtotime('now')){?>
<span style="color: #DC143C; font-size: 16px;"><img src="departed.svg" width="20px" height="20px" style="position:relative;top:1px;"><?php echo "Departed"?></span>
<?php } else if(strtotime($row['datetime']) > strtotime('tomorrow')){?>
    <span style="color: #DC143C; font-size: 16px;"><img src="staged.svg" width="20px" height="20px" style="position:relative;top:2px;"><?php echo "Staged"?></span>
    <?php if($seated <= 0){?>
    <span style="color: #DC143C; font-size: 16px;">FULL</span> 
    <?php } else{?>
        <span><?php echo $seated?> seats left</span> <a href="newBooking-form.php?flight_id=<?php echo $row['flightID']?>"><- Booking this flight</a> 
        <?php } ?>
<?php }?>

<br>
<hr>
</div>

<?php } ?>

<?php $dbConn->close(); ?>
</div>

</body>
</html>