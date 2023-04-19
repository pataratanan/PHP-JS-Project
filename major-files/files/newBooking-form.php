<?php
require_once("nocache.php");
require_once("dbconn.php");


session_start();
if(!$_SESSION["who"]){
header("location: logoff.php");
}
$customerID = $_SESSION["who"];
$code = $dbConn->escape_string($_GET["flight_id"]);

$sql = "select id,flight_number,flight_datetime,plane from flight where id = '$code' ";
$rs = $dbConn->query($sql)
or die ('Problem with query' . $dbConn->error);

$row = $rs->fetch_assoc();
$datetime = date('Y-m-d H:i:s');
$rs->close();
$rs = $dbConn->query($sql);

$redirect = "";
if (ISSET($_POST['flight_id'])) {
    $flightid = $_POST['flight_id'];
    $sql3 = "insert into booking (flight_id,customer_id,booking_datetime)
    values ('$flightid','$customerID','$datetime')";
    $rs3 = $dbConn->query($sql3)
    or die ('Problem with query' . $dbConn->error);
    $redirect = "<meta http-equiv=refresh content=0;URL=newBooking-form.php?flight_id=".$row['id'].">";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?=$redirect?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="actions.js"></script>
    <title>NewBooking-form</title>
    <style>
        h1{
            font-size: 28px;
            margin-left: 20px;
            color: #556B2F;
        }
        nav{
            margin-left: 30px;
            font-size: 14px;
        }
        body{
            font-size: 14px;
        }
        .login{
            font-size: 20px;
            float: right;
            margin-right: 50px;
        }
        .navBar{
            font-size: 20px;
            float: right;
        }
        .main{
            font-size: 18px;
        }
    </style>
</head>
<body>
<nav> 
    <div class="navBar">
    <a href="index.php">Home</a>
    <a href="profile.php">MyProfile</a>
    <a href="newbooking.php">New Booking</a>
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

<h1>Flight : <?php echo $row['flight_number']?></h1>

<div class="main"> 
<fieldset>
        <legend>Payment Details</legend><br>   
        <span>Amount of a standard fee - $455.00</span>    
        <form method="post" action="newBooking-form.php?flight_id=<?=$row['id']?>" onsubmit="return validateFormBooking(this)">  
        <div>
            <label>Card Number:</label>
            <input type="text" id="cardNumber" name="cardNumber" placeholder="#############"><br>
        </div>
        <div>
            <label>Name on Card</label>
            <input type="text" id="cardName" name="cardName" placeholder="John Doe">
        </div>
        <div>
            <label for="cardExpiry">Expiry Date</label>
            <input type="text" id="cardExpiry" name="cardExpiry" placeholder="##/##">
        </div>
        <div>
        <span class="error" id="allField">** All fields are required **</span>
        </div>
        <div>
            <input type="hidden" name="flight_id" value="<?=$row['id']?>" />
            <input type="submit" value="Submit" name="submit" >
        </div>
        </form>
</fieldset>
</div>
<?php $dbConn->close(); ?>

</body>
</html>