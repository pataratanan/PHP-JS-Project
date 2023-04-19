<?php
require_once("nocache.php");
require_once("dbconn.php");


session_start();
if(!$_SESSION["who"]){
header("location: logoff.php");
}

$customer = $_SESSION["who"];

$sql = "select booking_datetime, checkedin,flight_number, to_airport, status, flight_datetime from booking ";
$sql = $sql . "INNER JOIN flight ";
$sql = $sql . "ON customer_id = $customer ";
$sql = $sql . "AND booking.flight_id = flight.id ";
$rs = $dbConn->query($sql)
or die ('Problem with query' . $dbConn->error);


$row = $rs->fetch_assoc();
$flight_datetime = $row['flight_datetime'];
$datetime = date('Y-m-d H:i:s', strtotime($flight_datetime . '-2 days'));
$rs->close();
$rs = $dbConn->query($sql)
or die ('Problem with query' . $dbConn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <script src="actions.js"></script>
    <link rel="stylesheet" href="styles.css"/>
    <style>
        h1{
            margin-left: 30px;
            color: #DC143C;
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
<h1>MyBooking</h1>
<nav> 
    <div class="navBar">
    <a href="index.php">Home</a>
    <a href="profile.php">MyProfile</a>
    <a href="newbooking.php">New Booking</a>
    <a href="bookings.php">Booking</a>
       
    <?php if($_SESSION['level'] == 1) {?>
    <a href="flights.php">Flights</a>
    <?php } ?>
    <?php if($datetime == true){ ?>
    <a href="checkin.php">Checkin</a>
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
<p style="color: #87CEEB;">Flight Number : <?php echo $row['flight_number']?></p>
<p style="color: #8FBC8F;">Flight Status : <?php echo $row['status']?></p>
<p style="color: #FF6347;">Destination Airport: <?php echo $row['to_airport']?></p>
<p style="color: #DDA0DD;">Date booked : <?php echo $row['booking_datetime']?></p>
<p style="color: #9ACD32;">Flight departure date and time : <?php echo $row['flight_datetime']?></p>
<p style="color: #4682B4;">Checked in status : <?php echo $row['checkedin']?></p>
<hr>
<?php } ?> 
<?php
$dbConn->close();
?>
</div>
    
</body>
</html>