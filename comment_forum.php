<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">


</head>
<body>
    <style type="text/css">
        *{
            font-size: 12px;
            font-family: Arial, Helvetica, Sans-serif;
        }

    </style>

    <?php
    include("includes/header.php");



    if(isset($_GET['forum_post_id'])) {
        $forum_post_id = $_GET['forum_post_id'];

        $user_query = mysqli_query($con, "SELECT * FROM forum_topics WHERE id='$forum_post_id'");
        $row = mysqli_fetch_array($user_query);

        $posted_to = $row['posted_by'];

        if(isset($_POST['postComment' . $forum_post_id])) {
              $post_body = $_POST['post_body'];

              $post_body = mysqli_real_escape_string($con, $post_body);
              $date_time_now = date("Y-m-d H:i:s");
              $insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '', '', '$forum_post_id', '')");

              if($posted_to != $userLoggedIn) {
                  $notification = new Notification($con, $userLoggedIn);
                  $notification->insertForumNotification($forum_post_id, $posted_to, "comment");
              }


              $get_commenters = mysqli_query($con, "SELECT * FROM comments WHERE forum_post_id='$forum_post_id'");
              $notified_users = array();
              while($row = mysqli_fetch_array($get_commenters)) {

                  if($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to && $row['posted_by'] != $userLoggedIn
                    && !in_array($row['posted_by'], $notified_users)) {

                      $notification = new Notification($con, $userLoggedIn);
                      $notification->insertForumNotification($forum_post_id, $row['posted_by'], "comment_non_owner");

                      array_push($notified_users, $row['posted_by']);
                  }
              }
              echo "<p>Comment Posted!</p>";
              header("Location: post_details.php?forum_post_id=$forum_post_id&page=1");
          }

    }

    ?>

    <form action="comment_forum.php?forum_post_id=<?php echo $forum_post_id; ?>" style="position: relative; top:50px;" class="form-control" id="forum_comment_form" name="postComment<?php echo $forum_post_id; ?>" method="POST">
            <textarea class="form-control" name="post_body" placeholder="Type your reply here...."></textarea>
            <input type="submit" style="width:60px; height:25px; border-radius:9px;" name="postComment<?php echo $forum_post_id; ?>" value="Post">


        </form>
    
</body>
</html>
