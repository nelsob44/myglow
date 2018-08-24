<?php
require 'connection.php';

if(isset($_GET['email']) && isset($_GET['token'])) {
    
    $email = $_GET['email'];
    $token = $_GET['token'];
    
    $query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND token='$token'");
    
    if(mysql_num_rows($query) > 0){
        $str = "01234567abcdefghilmx";
        $str = str_shuffle($str);
        $str = substr($str, 0, 18);
        $password = md5($str);
        
        $update_query = mysqli_query($con, "UPDATE users SET password='$password', token='' WHERE email='$email'");
        
        echo "Your new password is: ".$str;
    } else {
        echo 'Please check your link';
    }
} else {
    header("Location: register.php");
    exit();
}


?>