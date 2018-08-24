<?php
require '../../connection.php';

if(isset($_GET['image_id']))
    $image_id = $_GET['image_id'];

if(isset($_POST['result'])) {
    if($_POST['result'] == 'true')
        $query = mysqli_query($con, "DELETE FROM images WHERE id='$image_id'");
        $comment_query = mysqli_query($con, "DELETE FROM comments WHERE image_id='$image_id'");
}

?>