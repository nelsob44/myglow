<?php
require '../../connection.php';

if(isset($_GET['move_forum_post_id']))
    $forum_post_id = $_GET['move_forum_post_id'];

if(isset($_POST['result'])) {
    if($_POST['result'] == 'true')
        
        $forum_query = mysqli_query($con, "SELECT * FROM forum_topics WHERE id='$forum_post_id'");
        $result = mysqli_fetch_array($forum_query);
        $title = $result['title'];
        $date_added = $result['date_posted'];
        $added_by = $result['posted_by'];
    
        $query = mysqli_query($con, "INSERT INTO forum_homepage (id, title, forum_post_id, date_added, added_by) VALUES('', '$title', '$forum_post_id', '$date_added', '$added_by')");
       
}

?>