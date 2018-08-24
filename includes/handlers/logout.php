<?php
require '../../connection.php';

if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
    
}



session_start();


session_destroy();
$online_status_query = mysqli_query($con, "UPDATE users SET user_online='no' WHERE username='$userLoggedIn'");

header("Location: ../../register.php");

?>