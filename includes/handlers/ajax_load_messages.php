<?php
include("../../connection.php");
include("../classes/User.php");
include("../classes/Message.php");

$limit = 10;

$message = new Message($con, $_REQUEST['userLoggedIn']);
echo $message->getConvosDropdown($_REQUEST, $limit);

?>