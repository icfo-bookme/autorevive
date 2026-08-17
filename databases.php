<?php
$dbhost = "localhost";
$dbuser = "azizul";
$dbpass = "azizul";
$dbname = "wsdb";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()) {
die("Database connection failed".mysqli_connect_errno()."(".mysqli_connect_error().")");
}
?>