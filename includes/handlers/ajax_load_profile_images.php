<?php
require '../../connection.php';
include("../classes/User.php");
include("../classes/Post.php");
include("../classes/Image.php");

$limit = 4; //Number of images to be loaded per call

$images = new Image($con, $_REQUEST['profileUsername']);
$images->loadImagesProfile($_REQUEST, $limit);

?>
