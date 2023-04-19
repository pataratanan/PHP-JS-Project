<!-- Pataratanan Visitserngtrakul 20310367 Practical Class time Tuesday and Thursday 14:00 - 16:00 -->
<?php

   // ensure the page is not cached
   require_once("nocache.php");  
   // get access to the session variables
   session_start();
   if(!$_SESSION["who"]){
       header("location: logoff.php");
   }

   require_once("dbconn.php");

   $sql = "select flight.flight_number,flight.from_airport,flight.to_airport,flight.status,flight.flight_datetime,flight.distance_km,flight.plane,plane.name,plane.seating from flight ";
   $sql = $sql . "LEFT JOIN plane ";
   $sql = $sql . "ON flight.plane = plane.id ";
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
    <title>Home page</title>

    <style>
        .time{
            font-size: 16px;
            color: #FF6347;
        }
        body{
            font-family: Monaco;
            color: #008080;
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
            font-size: 16px;
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

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <body>

    <h1>HomePage</h1>
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
    </div>

    <div class="login">
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    </div>

    </nav>
    <br>
        
    <div class="rows">

    <?php while ($row = $rs->fetch_assoc()) {?>
    
        <h3 style="color: #F4A460; font-size: 16px;">Flight: <?php echo $row["flight_number"]?></h3> 
        <p style="color: #708090; font-size: 16px;"><?php echo $row["from_airport"]?>--><?php echo $row["to_airport"]?> (<?php echo $row["distance_km"]?>km) <?php echo $row["name"]?></p>

        <div class="time">
        <span style="color: #5F9EA0; font-size: 16px;"><?php echo $row["flight_datetime"]?></span>

        <?php if(strtotime($row['flight_datetime']) < strtotime('now')){?>   
        <span style="color: #DC143C; font-size: 16px;"><img src="departed.svg" width="20px" height="20px" style="position:relative;top:1px;"><?php echo "Departed"?></span>
        <?php }else{?>
        <span style="color: #DC143C; font-size: 16px;"><img src="staged.svg" width="20px" height="20px" style="position:relative;top:2px;"><?php echo "Staged"?></span>
               <?php if($row['status'] != 'Cancelled') { ?>
                <span style="color: #DC143C; font-size: 16px;"><img src="open.svg" width="20px" height="20px" style="position:relative;top:2px;"><?php echo "Open" ?></span>
             <?php  } else{ ?>
                <span style="color: #DC143C; font-size: 16px;"><img src="cancelled.svg" width="20px" height="20px" style="position:relative;top:2px;"><?php echo "Cancelled" ?></span>
            <?php   } ?>
        </div>
    <?php } ?>
    <hr>
 <?php } ?>
    </div>
<?php $dbConn->close(); ?>
  </body>
</form>
</html>