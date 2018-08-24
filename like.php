<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    

</head>
<body>
    <style type="text/css">
        *{
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background-color: #fff;
        }
        form {
            position: absolute;
            top: 0;
        }
    
    </style>

    <?php
    require 'connection.php';
    include("includes/classes/User.php");
    include("includes/classes/Post.php");
    include("includes/classes/Notification.php");
    include("includes/classes/Topic.php");

    if(isset($_SESSION['username'])) {
        $userLoggedIn = $_SESSION['username'];
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $user = mysqli_fetch_array($user_details_query);

    }
    else {
        header("Location: register.php");
    }

if(isset($_GET['forum_post_id'])) {
     $forum_post_id = $_GET['forum_post_id'];
    
    
    $get_likes = mysqli_query($con, "SELECT * FROM forum_topics WHERE id='$forum_post_id'");
    $row = mysqli_fetch_array($get_likes);
    $total_likes = $row['likes'];
    $user_liked = $row['posted_by'];
    
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
    $row = mysqli_fetch_array($user_details_query);
    $total_user_likes = $row['num_likes'];
    
    if(isset($_POST['like_button'])) {
        $total_likes++;
        $query = mysqli_query($con, "UPDATE forum_topics SET likes='$total_likes' WHERE id='$forum_post_id'");
        $total_user_likes++;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "INSERT INTO likes VALUES ('', '$userLoggedIn', '', '', '$forum_post_id', '')");
        
        //Insert Notification
        if($user_liked != $userLoggedIn) {
            $notification = new Notification($con, $userLoggedIn);
            $notification->insertForumNotification($forum_post_id, $user_liked, "like");
        }
    }
    
    //Unlike button
    if(isset($_POST['unlike_button'])) {
        $total_likes--;
        $query = mysqli_query($con, "UPDATE forum_topics SET likes='$total_likes' WHERE id='$forum_post_id'");
        $total_user_likes--;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND forum_post_id='$forum_post_id'");
        
    }
    //Check for previous likes
    $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND forum_post_id='$forum_post_id'");
    $num_rows = mysqli_num_rows($check_query);
    
    if($num_rows > 0) {
        echo '<form action="like.php?forum_post_id='.$forum_post_id.'" method="POST">
                <input type="submit" class="comment_like" name="unlike_button" value="Unlike">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
    else {
        echo '<form action="like.php?forum_post_id='.$forum_post_id.'" method="POST">
                <input type="submit" class="comment_like" name="like_button" value="Like">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
}

    
    
    
if(isset($_GET['forum_comment_id'])) {
     $forum_comment_id = $_GET['forum_comment_id'];
    
    
    $get_likes = mysqli_query($con, "SELECT * FROM comments WHERE id='$forum_comment_id'");
    $row = mysqli_fetch_array($get_likes);
    $total_likes = $row['likes'];
    $user_liked = $row['posted_by'];
    
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
    $row = mysqli_fetch_array($user_details_query);
    $total_user_likes = $row['num_likes'];
    
    if(isset($_POST['like_button'])) {
        $total_likes++;
        $query = mysqli_query($con, "UPDATE comments SET likes='$total_likes' WHERE id='$forum_comment_id'");
        $total_user_likes++;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "INSERT INTO likes VALUES ('', '$userLoggedIn', '', '', '', '$forum_comment_id')");
        
        //Insert Notification
        if($user_liked != $userLoggedIn) {
            $notification = new Notification($con, $userLoggedIn);
            $notification->insertForumNotification($forum_comment_id, $user_liked, "like");
        }
    }
    
    //Unlike button
    if(isset($_POST['unlike_button'])) {
        $total_likes--;
        $query = mysqli_query($con, "UPDATE comments SET likes='$total_likes' WHERE id='$forum_comment_id'");
        $total_user_likes--;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND forum_comment_id='$forum_comment_id'");
        
    }
    //Check for previous likes
    $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND forum_comment_id='$forum_comment_id'");
    $num_rows = mysqli_num_rows($check_query);
    
    if($num_rows > 0) {
        echo '<form action="like.php?forum_comment_id='.$forum_comment_id.'" method="POST">
                <input type="submit" class="comment_like" name="unlike_button" value="Unlike">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
    else {
        echo '<form action="like.php?forum_comment_id='.$forum_comment_id.'" method="POST">
                <input type="submit" class="comment_like" name="like_button" value="Like">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
}    
    


    
    //Get id of post
if(isset($_GET['post_id'])) {
     $post_id = $_GET['post_id'];
    
    
    $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($get_likes);
    $total_likes = $row['likes'];
    $user_liked = $row['added_by'];
    
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
    $row = mysqli_fetch_array($user_details_query);
    $total_user_likes = $row['num_likes'];
    
    //Like button
    if(isset($_POST['like_button'])) {
        $total_likes++;
        $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
        $total_user_likes++;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "INSERT INTO likes VALUES ('', '$userLoggedIn', '$post_id', '', '', '')");
        
        //Insert Notification
        if($user_liked != $userLoggedIn) {
            $notification = new Notification($con, $userLoggedIn);
            $notification->insertNotification($post_id, $user_liked, "like");
        }
    }
    
    //Unlike button
    if(isset($_POST['unlike_button'])) {
        $total_likes--;
        $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
        $total_user_likes--;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
        
    }
    //Check for previous likes
    $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
    $num_rows = mysqli_num_rows($check_query);
   
    
    if($num_rows > 0) {
        echo '<form action="like.php?post_id='.$post_id.'" method="POST">
                <input type="submit" class="comment_like" name="unlike_button" value="Unlike">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
    else {
        echo '<form action="like.php?post_id='.$post_id.'" method="POST">
                <input type="submit" class="comment_like" name="like_button" value="Like">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
} else {
    if(isset($_GET['image_id'])) {
     $image_id = $_GET['image_id'];
    
    
    $get_likes = mysqli_query($con, "SELECT likes, username FROM images WHERE id='$image_id'");
    $row = mysqli_fetch_array($get_likes);
    $total_likes = $row['likes'];
    $user_liked = $row['added_by'];
    
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
    $row = mysqli_fetch_array($user_details_query);
    $total_user_likes = $row['num_likes'];
    
    if(isset($_POST['like_button'])) {
        $total_likes++;
        $query = mysqli_query($con, "UPDATE images SET likes='$total_likes' WHERE id='$image_id'");
        $total_user_likes++;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "INSERT INTO likes VALUES ('', '$userLoggedIn', '', '$image_id', '', '')");
        
        //Insert Notification
        if($user_liked != $userLoggedIn) {
            $notification = new Notification($con, $userLoggedIn);
            $notification->insertNotification($image_id, $user_liked, "like");
        }
    }
    
    //Unlike button
    if(isset($_POST['unlike_button'])) {
        $total_likes--;
        $query = mysqli_query($con, "UPDATE images SET likes='$total_likes' WHERE id='$image_id'");
        $total_user_likes--;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND image_id='$image_id'");
        
    }
    //Check for previous likes
    $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND image_id='$image_id'");
    $num_rows = mysqli_num_rows($check_query);
    
    if($num_rows > 0) {
        echo '<form action="like.php?image_id='.$image_id.'" method="POST">
                <input type="submit" class="comment_like" name="unlike_button" value="Unlike">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
    else {
        echo '<form action="like.php?image_id='.$image_id.'" method="POST">
                <input type="submit" class="comment_like" name="like_button" value="Like">
                <div class="like_value">
                    '.$total_likes.' Like(s)
                </div>
            </form>
            ';
    }
        
}
}
    ?>
    
</body>
</html>