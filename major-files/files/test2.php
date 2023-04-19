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
$sql1 = "select id,flight_number,from_airport,to_airport,status,flight_datetime,distance_km,plane from flight";
$rs1 = $dbConn->query($sql1)
or die ('Problem with query' . $dbConn->error);
$row1 = $rs1->fetch_assoc();
$datetime = $row1['flight_datetime'];
$rs1->close();
$rs1 = $dbConn->query($sql1);

$sql2 = "select id,name,seating from plane";
$rs2 = $dbConn->query($sql2)
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
font-size: 26px;
}
.navBar{
font-size: 16px;
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
<?php while ($row2 = $rs2->fetch_assoc()) {?>
<?php while ($row1 = $rs1->fetch_assoc()) {?>
<h3 style="color: #F4A460; font-size: 16px;">Flight :<?php echo $row1["flight_number"]?></h3>
<p style="color: #708090; font-size: 16px;"><?php echo $row1["from_airport"]?>--><?php echo $row1["to_airport"]?> (<?php echo $row1["distance_km"]?>km) <?php echo $row2["name"]?></p>

<div class="time">
<span style="color: #5F9EA0; font-size: 16px;"><?=$row1['flight_datetime']?></span>

<?php if(strtotime($row1['flight_datetime']) < strtotime('now')){?>
<span style="color: #DC143C; font-size: 16px;"><img src="departed.svg" width="20px" height="20px" style="position:relative;top:1px;"><?php echo "Departed"?></span>
<?php }else{?>
<span style="color: #DC143C; font-size: 16px;"><img src="staged.svg" width="20px" height="20px" style="position:relative;top:2px;"><?php echo $row1["status"]?></span>
<a href="newBooking-form.php?flight_id=<?php echo $row1['id']?>"><-- Booking this flight</a>
<?php }?>

<br>
</div>
<hr>
<?php } ?>
<?php } ?>

<?php $dbConn->close(); ?>
</div>

</body>
</html>