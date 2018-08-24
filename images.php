<?php
include("includes/header.php");

$image_obj = new Image($con, $userLoggedIn);
$str = "";
if(isset($_GET['id'])) {
  $image_id = $_GET['id'];
  $image_query = mysqli_query($con, "SELECT * FROM images WHERE id='$image_id'");
  $row = mysqli_fetch_array($image_query);

  $photo = $row['photos'];
  $date_Posted = $row['date_added'];
}

$profile_pic = $user['profile_pic'];
$firstname = $user['first_name'];
$lastname = $user['last_name'];

$comments_check = mysqli_query($con, "SELECT * FROM comments WHERE image_id='$image_id'");
$comments_check_num = mysqli_num_rows($comments_check);

?>

                    <script>

                        function toggle<?php echo $image_id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $image_id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            };

                            $(document).ready(function() {
                                       $('#formsubmit').click(function() {
                                          $.post('comment_frame.php?image_id=<?php echo $image_id; ?>',
                                                 {post_body: $('#post_body').val()},
                                                    function(data) {
                                                      console.log(data);
                                                    }
                                                );
                                       });
                                    });

                    </script>
<?php

$str .= "<div class='images_container' style='margin-top:5%;'>
            <div class='singleImage' style='float:left;'><div class='fb-share-button' data-href='http://localhost:1234/phpcourse' data-layout='button_count' data-size='small' data-mobile-iframe='true'><a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A1234%2Fphpcourse&amp;src=sdkpreparse' class='fb-xfbml-parse-ignore'>Share</a></div>
                <img src='$photo' class='center' style='img-responsive'>

            </div>
            <div class='image_info_top_wrap' onClick='javascript:toggle$image_id();'>
                  <div class='images_info'><a href='$userLoggedIn' target='_parent'><img src='$profile_pic' height='30'></a></div>
                  <div class='namedetails'><a href='$userLoggedIn' target='_parent'<b>$firstname  $lastname</b></a></div>
                  <div class='time_stamp'><small>$date_Posted</small></div>

                  <div class='photo_comments'>
                      <div class='newsfeedPostOptions'>
                                Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
                                <iframe src='like.php?image_id=$image_id' scrolling='no'></iframe>
                      </div>

                      <form action='' id='comment_form' name='postComment$image_id' method='post'>
                          <textarea name='post_body' id='post_body'></textarea>
                          <input type='submit' id='formsubmit' name='postComment$image_id' value='Post'>
                      </form>


                      <div class='image_comment' id='toggleComment$image_id' style='display:block;'>
                                <iframe src='comment_frame.php?image_id=".$image_id."' id='image_comment_iframe' frameborder='0'></iframe>
                      </div>
                      <hr style='background-color: #D3D3D3; padding: 5px;'>
                  </div>
            </div>
        </div>";


if($str != " ") {
  echo $str;
}
else {
  echo "<p>Sorry, No photos to show</p>";
}
?>
