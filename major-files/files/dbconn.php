<?php
$dbConn = new mysqli('localhost', 'twa013', 'twa013cO', 'cooper_flights013');
if($dbConn->connect_error) {
    die("failed to connect to the database: " . $dbConn->connect_error);
}
?>
