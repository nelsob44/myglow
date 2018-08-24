<?php

include("includes/header.php");

//session_destroy();
$message_obj = new Message($con, $userLoggedIn);



if(isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $user_array = mysqli_fetch_array($user_details_query);
    
    
    $num_friends = (substr_count($user_array['friend_array'], ",")) - 1;
}

if(isset($_POST['remove_friend'])) {
    $user = new User($con, $userLoggedIn);
    $user->removeFriend($username);
}
if(isset($_POST['add_friend'])) {
    $user = new User($con, $userLoggedIn);
    $user->sendRequest($username);
}
if(isset($_POST['respond_request'])) {
    header("Location: request.php");
}

if(isset($_POST['post_message'])) {
    if(isset($_POST['message_body'])) {
        $body = mysqli_real_escape_string($con, $_POST['message_body']);
        $date = date("Y-m-d H:i:s");
        $message_obj->sendMessage($username, $body, $date);
    }
    
    $link = '#profileTabs a[href="#messages_div"]';
    echo "<script> 
          $(function() {
              $('" . $link ."').tab('show');
          });
        </script>";
}

?>

<style type="text/css">
    .wrapper {
        margin-left: 0px;
        padding-left: 0px;
    }

</style>

<div class="profile_left">
    <img src="<?php echo $user_array['profile_pic']; ?>">
                <div class="profile_info">
                    <p><?php echo "Posts: ".$user_array['num_posts']; ?></p>
                    <p><?php echo "Likes: ".$user_array['num_likes']; ?></p>
                    <p><?php echo "Friends: ".$num_friends; ?></p>
                            <div class="profile_left_form">
                                <form action="<?php echo $username; ?>" method="post">
                                   <?php
                                    $profile_user_obj = new User($con, $username); 
                                    if($profile_user_obj->isClosed()) {
                                        header("Location: user_closed.php");
                                    }

                                    $logged_in_user_obj = new User($con, $userLoggedIn);

                                    if($userLoggedIn != $username) {
                                        if($logged_in_user_obj->isFriend($username)) {
                                            echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>';
                                        }
                                        else if($logged_in_user_obj->didReceiveRequest($username)) {
                                            echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"><br>';
                                        }
                                        else if($logged_in_user_obj->didSendRequest($username)) {
                                            echo '<input type="submit" name="" class="default" value="Request Sent"><br>';
                                        }
                                        else 
                                            echo '<input type="submit" name="add_friend" class="success" value="Add Friend"><br>';
                                    }

                                    ?>
                                    

                                </form>
                                
                                <input type="submit" id="postSomething" data-toggle="modal" data-target="#post_form" value="Post Something">
                                
                                <?php
                                if($userLoggedIn != $username) {
                                    echo '<div class="profile_info_bottom">';
                                        echo $logged_in_user_obj->getMutualFriends($username) . " Mutual friends";
                                        echo '</div>';
                                }
                                
                                ?>
                                
                            </div>

                </div>
  
    
</div>

<div id="profilepage">
    <div class="profile_nav">
        <ul class="nav nav-tabs flex-column flex-sm-row" role="tablist" id="nav-tab">
            <li class="active"><a data-toggle="tab" id="nav-newsfeed-tab" href="#nav-newsfeed_div">Newsfeed</a></li>
            <li><a data-toggle="tab" id="nav-about-tab" href="#nav-about_div">About</a></li>
            <li><a data-toggle="tab" id="nav-messages-tab" href="#nav-messages_div">Messages</a></li>
        </ul>
    </div>
    <hr>
    
    <div class="tab-content" id="nav-tabContent"> 
        <div class="tab-pane fade in active" id="nav-newsfeed_div">
            <div class="posts_area"></div>
            <img id="loading" src="assets/icons/loadingimage.gif">
        
        </div>
        
        <div class="tab-pane fade" id="nav-about_div">
            <div class="user_info">
                <?php
                $user_obj = new User($con, $username);
                
                    echo "<p>Country: ".$user_obj->getCountry($con, $username). "</p><br>";
                    echo "<p>City: ".$user_obj->getCity($con, $username). "</p><hr>";
                    
                ?>
            </div>
            <div class="about_area">
                
            </div>
            <img id="loading_photo" src="assets/icons/loadingimage.gif">
            
           
        </div>
        
        <div class="tab-pane fade" id="nav-messages_div">
            <?php
            $message_obj = new Message($con, $userLoggedIn);
                echo "<h4>You and <a href='".$username."'>".$profile_user_obj->getFirstAndLastName() . "</a></h4><hr><br>";
                echo "<div class='loaded_messages' id='scroll_messages'>";
                    echo $message_obj->getMessages($username);
                echo "</div>";
            
            ?>
            <div class="message_post">
                <form action="" method="POST">
                                        
                    <textarea name='message_body' class='message_textarea' placeholder='Write your message....'></textarea>
                    <input type='submit' name='post_message' class='message_submit' value='Send'>
                    

                  

                </form>
                
                
            </div>
            <script>
                var div = document.getElementById("scroll_messages");
                div.scrollTop = div.scrollHeight;

            </script>

        </div>
    
    </div>

        
        
    
    


<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Post something!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        
      <div class="modal-body">
        <p>This will appear on the user's profile page and also their newsfeed for your friends to see</p>
          
          <form class="profile_post" action="profile.php" method="post">
            <div class="form-group">
                <textarea class="form-control" name="post_body"></textarea>
                <input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
                <input type="hidden" name="user_to" value="<?php echo $username; ?>">
                
            </div>
          
          </form>
      </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
      </div>
    </div>
  </div>
</div>
    

        
</div>
<script>
        var userLoggedIn = '<?php echo $userLoggedIn; ?>';
        var profileUsername = '<?php echo $username; ?>';
        $(document).ready(function() {
                          //$('#loading').show();
                         
            
            $.ajax({
                url: "includes/handlers/ajax_load_profile_posts.php",
                type: "POST",
                data: "page=1&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
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
                    //$('#loading').show();
                    
                    var ajaxReq = $.ajax({
                        url: "includes/handlers/ajax_load_profile_posts.php",
                        type: "POST",
                        data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
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
         });

    </script>

<script>
        
        var profileUsername = '<?php echo $username; ?>';
        $(document).ready(function() {
                          $('#loading_photo').show();
                         
            
            $.ajax({
                url: "includes/handlers/ajax_load_profile_images.php",
                type: "POST",
                data: "page=1&profileUsername=" + profileUsername,
                cache: false,
                
                success: function(data) {
                    $('#loading_photo').hide();
                    $('.about_area').html(data);
                }
            });
            
            $(window).scroll(function() {
                var height = $('.about_area').height();
                var scroll_top = $(this).scrollTop;
                var page = $('.about_area').find('.nextPage').val();
                var noMorePhotos = $('.about_area').find('.noMorePhotos').val();
                
                if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePhotos == 'false') {
                    $('#loading_photo').show();
                    
                    var ajaxReq = $.ajax({
                        url: "includes/handlers/ajax_load_profile_images.php",
                        type: "POST",
                        data: "page=" + page + "&profileUsername=" + profileUsername,
                        cache: false,
                        
                        success: function(response) {
                           
                            $('.about_area').find('.nextPage').remove();
                            $('.about_area').find('.noMorePhotos').remove();
                            $('#loading_photo').hide();
                            $('.about_area').append(response);
                        }
                    })
                    
                }
                return false;
            })
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

</div
        
</body>
</html>