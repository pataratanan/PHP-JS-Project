<?php
   // ensure the page is not cached
   require_once("nocache.php");  
   require_once("dbconn.php");
   // get access to the session variables
   session_start();
   // check if the user is logged in
   if (!$_SESSION["who"]){
     header("location: logoff.php");
   }

   $sql = "select flight.id as flightID,flight.flight_number,flight.from_airport,flight.to_airport,flight.status as status,flight.flight_datetime,flight.distance_km,flight.plane,plane.name,plane.seating from flight ";
   $sql = $sql . "LEFT JOIN plane ";
   $sql = $sql . "ON flight.plane = plane.id ";
   $sql = $sql . "where MONTH((flight_datetime))= MONTH(CURDATE()) ";
   $rs = $dbConn->query($sql)
   or die ('Problem with query' . $dbConn->error);

   if (ISSET($_POST['submit'])) {   
    $flightid = $_POST['flight_id'];    
    $sql3 = "UPDATE flight set status = 'Cancelled' where id = $flightid ";
    $rs3 = $dbConn->query($sql3)
    or die ('Problem with query' . $dbConn->error);  
    header("location: index.php");
}
    
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles.css">
    <script src="actions.js"></script>
    <title>Filght</title>

    <style>
        h1{
            color: #4682B4;
        }
        body{
          font-family: Monaco;
        }
        .login{
            float: right;
            margin-right: 20px;
            font-size: 20px;
        }
        .navBar{
            font-size: 20px;
        }
    </style>

  </head>
 
  <body>
  
<h1>Flights</h1>

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
    <a href="register.php">Register</a>
    </div>
</nav>
<br>

<div class="rows">
<?php while ($row = $rs->fetch_assoc()) {?>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h3 style="color: #F4A460; font-size: 16px;">Flight: <?php echo $row["flight_number"]?></h3> 
    <p style="color: #708090; font-size: 16px;"><?php echo $row["from_airport"]?>--><?php echo $row["to_airport"]?> (<?php echo $row["distance_km"]?>km) <?php echo $row["name"]?></p>
    <span style="color: #5F9EA0; font-size: 16px;"><?php echo $row["flight_datetime"]?></span>
    <span style="color: #DC143C; font-size: 16px;"><?php echo $row["status"]?></span>
    
    <div>   
    <input type="hidden" name="flight_id" id="flight_id" value="<?=$row['flightID']?>" /> 
    <input type="submit" value="Cancel" name="submit" id="submit" >  
    </div>
    
    <hr>
    </form>
<?php } ?>
</div>
<?php $dbConn->close(); ?>
  </body>
  
</html>
