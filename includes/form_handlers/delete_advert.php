<?php
require '../../connection.php';

if(isset($_GET['forum_post_id']))
    $forum_post_id = $_GET['forum_post_id'];

if(isset($_POST['result'])) {
    if($_POST['result'] == 'true')
        $query = mysqli_query($con, "DELETE FROM products WHERE id='$forum_post_id'");
       
}

?>