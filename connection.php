<?php

ob_start(); //Turn on output buffering
session_start();

$timezone = date_default_timezone_set("Europe/London");

$con = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno()) {
    echo "Failed to connect: ".mysqli_connect_errno();
}

?>