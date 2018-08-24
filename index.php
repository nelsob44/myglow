<?php

include("includes/header.php");

//session_destroy();

if(isset($_POST['post'])) {

    $uploadOk = 1;
    $imageName = $_FILES['fileToUpload']['name'];
    $errorMessage = "";

    if($imageName != "") {
        $targetDir = "assets/images/posts/";
        $imageName = $targetDir . uniqid() . basename($imageName);
        $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

        if($_FILES['fileToUpload']['size'] > 5000000) {
            $errorMessage = "Sorry your file is too large";
            $uploadOk = 0;
        }
        if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg" ) {
            $errorMessage = "Sorry, only jpeg, jpg, and png files are allowed";
            $uploadOk = 0;
        }
        if($uploadOk) {
            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
                //image uploaded okay
            }
            else {
                //image did not upload
                $uploadOk = 0;
            }
        }
    }
    if($uploadOk) {
        $post = new Post($con, $userLoggedIn);
        $post->submitPost($_POST['post_text'], 'none', $imageName);
    }
    else {
        echo "<div style='text-align: center;' class='alert alert-danger'>
                $errorMessage
            </div>";
    }



}

?>

        <div class="left_wrap">
                <div class='prof_pic'>
                    <a href="<?php echo $userLoggedIn; ?>"><img id="prof_pic" src="<?php echo $user['profile_pic']; ?>"></a>
                </div>
                <br>
                <div class="user_details_left">
                    <p><a href="<?php echo $userLoggedIn; ?>">
                        <?php echo $user['first_name']." ".$user['last_name']; ?>
                    </a>
                    </p>
                    <?php echo "Total Posts: ".$user['num_posts']."<br>";
                    echo "Total Likes: ".$user['num_likes'];
                    ?>
                    <p><a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')"><i class="fas fa-envelope"></i>
                    <?php
                    if($num_messages > 0)
                        echo '<span class="notification_badge" id="unread_message">'. $num_messages. '</span>';
                    ?>
                </a></p>
                    
                    <p><a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')"><i class="fas fa-bell"></i>
                    <?php
                    if($num_notifications > 0)
                        echo '<span class="notification_badge" id="unread_notification">'. $num_notifications. '</span>';
                    ?>
                </a></p>
                    <p><a href="requests.php"><i class="fas fa-users"></i>
                            <?php
                            if($num_requests > 0)
                                echo '<span class="notification_badge" id="unread_requests">'. $num_requests. '</span>';
                            ?>
                </a></p>

                    <div class="dropdown_data_window" style="height: 0px; border:none;"></div>
                        <input type="hidden" id="dropdown_data_type" value="">
                <div class="">
                <p></p>
                <h5>Trending now....</h5>
                <div class="trends">
                    <?php
                    $query = mysqli_query($con, "SELECT * FROM trends ORDER by hits DESC LIMIT 6");

                foreach($query as $row) {
                    $word = $row['title'];
                    $word_dot = strlen($word) >= 14 ? "..." : "";

                    $trimmed_word = str_split($word, 14);
                    $trimmed_word = $trimmed_word[0];

                    echo "<div style'padding: 1px'>";
                    echo $trimmed_word . $word_dot;
                    echo "<br></div>";
                }
                ?>
                    </div><br>
                    <h5><a href="quiz.php" target="_parent"><strong>Fun Quiz</strong></a></h5>

                </div>

                </div>
        </div>


        <div class="center_wrap">


        <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" multiple="multiple">
            <textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>



            <input type="submit" name="post" class="message_submit" value="Post">
            <hr>


        </form>
            

        <div class="posts_area"></div>
        <img id="loading" src="assets/icons/loadingimage.gif">

    </div>



    </div>

    <script>
        var userLoggedIn = '<?php echo $userLoggedIn; ?>';
        $(document).ready(function() {
                          $('#loading').show();


            $.ajax({
                url: "includes/handlers/ajax_load_posts.php",
                type: "POST",
                data: "page=1&userLoggedIn=" + userLoggedIn,
                cache: false,

                success: function(data) {
                    $('#loading').hide();
                    $('.posts_area').html(data);
                }
            });

            $(window).scroll(function() {
                var height = $('.posts_area').height();
                var scroll_top = $(this).scrollTop;
                var page = $('.posts_area').find('.nextPage').val();
                var noMorePosts = $('.posts_area').find('.noMorePosts').val();

                if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
                    $('#loading').show();

                    var ajaxReq = $.ajax({
                        url: "includes/handlers/ajax_load_posts.php",
                        type: "POST",
                        data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                        cache: false,

                        success: function(response) {
                            $('.posts_area').find('.nextPage').remove();
                            $('.posts_area').find('.noMorePosts').remove();
                            $('#loading').hide();
                            $('.posts_area').append(response);
                        }
                    })

                }
                return false;
            })

            $('.textarea').wysihtml5();

         });

    </script>

    <div class="right_wrap">
        <div class="slideshow">
            <div>
             <img src="assets/images/adverts/barclaycard_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
           <div>
             <img src="assets/images/adverts/jobs_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
            <div>
             <img src="assets/images/adverts/kodak_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
           <div>
             <img src="assets/images/adverts/lexus_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
            <div>
             <img src="assets/images/adverts/truck_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
            <div>
             <img src="assets/images/adverts/tv_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>


        </div>

        <div class="online_users">
            <div style="text-align:centre;"><a href="forum.php" target="_parent"><small style="font-size:11;">Active users: <?php echo $active_users; ?></small></a>&nbsp;&nbsp;
            <a href="forum.php" target="_parent"><small style="font-size:11;">Users online: <?php echo $users_online; ?></small></a>&nbsp;&nbsp;</div>
            <b><h6 id='online_heading' style="text-align:center;">Friends Online</h6></b><hr>
           <?php
                $online_obj = new Online($con, $userLoggedIn);
                $online_obj->ShowOnlineUsers($con, $userLoggedIn);
            ?>
        </div>
        <div class="rss_newsfeed">
            <!-- start feedwind code --> <script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" data-fw-param="83144/"></script> <!-- end feedwind code -->

        </div>


    </div>

        <script>
                $(".slideshow > div:gt(0)").hide();

                    setInterval(function() {
                      $('.slideshow > div:first')
                        .fadeOut(1000)
                        .next()
                        .fadeIn(1000)
                        .end()
                        .appendTo('.slideshow');
                    }, 5000);

            </script>
    </div>

    </body>
<?php 
include("includes/footer.php");
?>
</html>
