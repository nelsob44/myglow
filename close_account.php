<?php
include("includes/header.php");

if(isset($_POST['cancel'])) {
    header("Location: settings.php");
}

if(isset($_POST['close_account'])) {
    $close_query = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");
    session_destroy();
    header("Location: register.php");
}
?>

<div class="center_wrap">
    <h3>Close Account</h3>
    
    Are you sure you wan to close your account?<br><br>
    
    <form action="close_account.php" method="post">
        <input type="submit" name="close_account" id="close_account" value="Yes! Close it" class="danger settings_submit">
        <input type="submit" name="cancel" id="update_details" value="No!" class="info settings_submit">
    
    </form>


</div>