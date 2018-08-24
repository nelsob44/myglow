<?php
include("../../connection.php");
include("../classes/User.php");
include("../classes/Notification.php");

$limit = 10;

$notification = new Notification($con, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>