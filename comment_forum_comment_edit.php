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



    if(isset($_GET['forum_comment_id']) && isset($_GET['forum_post_id'])) {
        $forum_comment_id = $_GET['forum_comment_id'];
        $forum_post_id = $_GET['forum_post_id'];

        $user_query = mysqli_query($con, "SELECT * FROM comments WHERE id='$forum_comment_id'");
        $row = mysqli_fetch_array($user_query);

        $comment_to_edit = $row['post_body'];
        $posted_to = $row['posted_to'];

        if(isset($_POST['postComment' . $forum_comment_id])) {
              $post_body = $_POST['post_body'];

              $post_body = mysqli_real_escape_string($con, $post_body);

              $date_time_now = date("Y-m-d H:i:s");
              $insert_post = mysqli_query($con, "UPDATE comments SET post_body='$post_body' WHERE id='$forum_comment_id'");


              header("Location: post_details.php?forum_comment_id=forum_post_id=$forum_post_id&page=1");
          }

    }

    ?>

    <form action=" " style="position: relative; top:50px;" class="form-control" id="forum_comment_form" name="postComment<?php echo $forum_post_id; ?>" method="POST">
            <textarea class="form-control" name="post_body"><?php echo $comment_to_edit; ?></textarea>
            <input type="submit" style="width:60px; height:25px; border-radius:9px;" name="postComment<?php echo $forum_comment_id; ?>" value="Post">


        </form>
</body>
</html>
