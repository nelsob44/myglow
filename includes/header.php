<?php
require 'connection.php';
include("includes/classes/Csrf.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");
include("includes/classes/Image.php");
include("includes/classes/Online.php");
include("includes/classes/Topic.php");
include("includes/classes/Advert.php");

$csrf = new csrf();
//Generate Token Id and Valid
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);


$t = time();

if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);

     //total active users
                    $user_obj = new User($con, $userLoggedIn);
                    $active_users = $user_obj->getTotalUsers();

                    //total users online
                    $user_obj = new User($con, $userLoggedIn);
                    $users_online = $user_obj->getUsersOnline();

    if (isset($_SESSION['logged']) && ($t - $_SESSION['logged'] > 60)) {

    $online_status_query = mysqli_query($con, "UPDATE users SET user_online='no' WHERE username='$userLoggedIn'");
    header('location: register.php');
    session_destroy();
    session_unset();
    
    }else {
        $_SESSION['logged'] = time();
    }



}
else {
    header("Location: register.php");
}



                    //unread messages
                    $messages = new Message($con, $userLoggedIn);
                    $num_messages = $messages->getUnreadNumber();

                    //unread notifications
                    $notifications = new Notification($con, $userLoggedIn);
                    $num_notifications = $notifications->getUnreadNumber();
                    //unread friend requests
                    $user_obj = new User($con, $userLoggedIn);
                    $num_requests = $user_obj->getNumberofFriendRequests();





?>
<html>
    <head>
        <title>Welcome to Glow</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
        <script src="assets/js/bootbox.min.js"></script>
        <script src="assets/js/demo.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/imgareaselect-default.css" />
        <script src="assets/js/jquery.imgareaselect.min.js"></script>

        <script src="assets/js/jquery.imgareaselect.pack.js"></script>



        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/jquery.Jcrop.css">
    </head>
    <body>
        
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.1';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>


        
    <--!<div class="navbar navbar-inverse navbar-fixed-top top_bar">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand logo" href="index.php"><img src="assets/icons/glow_logo.jpg" style="width:35px; height:30px;"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="index.php"><i class="fas fa-home"></i></a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><strong>Forum</strong><span class="caret"></span></a>
              <ul class="dropdown-menu">

                <li><a href="forum.php?page=1" target="_parent"><strong>Home</strong></a>&nbsp;&nbsp;</li>
                <li><a href="politics.php?page=1">Politics</a></li>
                <li><a href="business.php?page=1">Business</a></li>
                <li><a href="careers.php?page=1">Careers</a></li>
                <li><a href="international.php?page=1">International News</a></li>
                <li><a href="religion.php?page=1">Religion</a></li>
                <li><a href="entertainment.php?page=1">Entertainment</a></li>
                <li><a href="education.php?page=1">Education</a></li>
                <li><a href="science_and_technology.php?page=1">Science/Technology</a></li>
                <li><a href="arts_and_literature.php?page=1">Arts/Literature </a></li>
                <li><a href="romance_and_relationships.php?page=1">Relationships/Romance</a></li>
                <li><a href="sports.php?page=1">Sports</a></li>
                <li><a href="jokes.php?page=1">Jokes</a></li>
                <li><a href="market_place.php?page=1">Market Place</a></li>
              </ul>
            </li>
            <li><a href="<?php echo $userLoggedIn; ?>"><img id="prof_pic" style="width:35px; height:25px;" src="<?php echo $user['profile_pic']; ?>">&nbsp;<?php echo $user['first_name']; ?></a></li>
            <li><a href="video.php" target="_blank"><i class="fas fa-video"></i>&nbsp;Video Call</a>&nbsp;&nbsp;</li>
            <li><a href="photo_upload.php"><i class="far fa-images"></i></a></li>
            <li><a href="settings.php"><i class="fas fa-cog"></i></a></li>
            <li><a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')"><i class="fas fa-envelope"></i>
                    <?php
                    if($num_messages > 0)
                        echo '<span class="notification_badge" id="unread_message">'. $num_messages. '</span>';
                    ?>
                </a></li>
            <li><a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')"><i class="fas fa-bell"></i>
                    <?php
                    if($num_notifications > 0)
                        echo '<span class="notification_badge" id="unread_notification">'. $num_notifications. '</span>';
                    ?>
                </a></li>
            <li><a href="requests.php"><i class="fas fa-users"></i>
                    <?php
                    if($num_requests > 0)
                        echo '<span class="notification_badge" id="unread_requests">'. $num_requests. '</span>';
                    ?>
                </a></li>


            <li><div class="search">
                <form class="form-inline" action="search.php" method="get" name="search_form">
                    <div class="form-group mx-sm-3">
                    <input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search Friends..." autocomplete="on" id="search_text_input">
                    </div>
                    <button type="submit" class="button_holder mx-sm-3">
                        <img src="assets/icons/magnifying_glass.png">
                    </button>
                </form>
                <div class="search_results"></div>
                <div class="search_results_footer_empty"></div>
            </div></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">

            <li><a href="quiz.php"><strong>Quiz</strong></a></li>
            <li><a href="includes/handlers/logout.php"><i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </div>
    </div>

        



        <!--    <div class='logo'>
                <img src="assets/icons/binary2.jpg" class="">
                <a href="index.php">Glow!</a>


            </div>
            <div class="search">
                <form action="search.php" method="get" name="search_form">
                    <input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">
                    <div class="button_holder">
                        <img src="assets/icons/magnifying_glass.png">
                    </div>
                </form>
                <div class="search_results"></div>
                <div class="search_results_footer_empty"></div>
            </div>

            <nav>
                <?php
                    //unread messages
                    $messages = new Message($con, $userLoggedIn);
                    $num_messages = $messages->getUnreadNumber();

                    //unread notifications
                    $notifications = new Notification($con, $userLoggedIn);
                    $num_notifications = $notifications->getUnreadNumber();
                    //unread friend requests
                    $user_obj = new User($con, $userLoggedIn);
                    $num_requests = $user_obj->getNumberofFriendRequests();



                ?>
                <a href="forum.php?page=1" target="_parent"><strong>Forum</strong></a>&nbsp;&nbsp;

                <a href="video.php" target="_blank"><i class="fas fa-video"></i>&nbsp;Video Call</a>&nbsp;&nbsp;
                <a href="<?php echo $userLoggedIn; ?>"><img id="prof_pic" style="width:35px; height:25px;" src="<?php echo $user['profile_pic']; ?>">&nbsp;<?php echo $user['first_name']; ?></a>
                <a href="index.php"><i class="fas fa-home"></i></a>
                <a href="photo_upload.php"><i class="far fa-images"></i></a>
                <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')"><i class="fas fa-envelope"></i>
                    <?php
                    if($num_messages > 0)
                        echo '<span class="notification_badge" id="unread_message">'. $num_messages. '</span>';
                    ?>
                </a>
                <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')"><i class="fas fa-bell"></i>
                    <?php
                    if($num_notifications > 0)
                        echo '<span class="notification_badge" id="unread_notification">'. $num_notifications. '</span>';
                    ?>
                </a>
                <a href="requests.php"><i class="fas fa-users"></i>
                    <?php
                    if($num_requests > 0)
                        echo '<span class="notification_badge" id="unread_requests">'. $num_requests. '</span>';
                    ?>
                </a>
                <a href="settings.php"><i class="fas fa-cog"></i></a>
                <a href="includes/handlers/logout.php"><i class="fas fa-sign-out-alt"></i></a>



            </nav>
            <div class="dropdown_data_window" style="height: 0px; border:none;"></div>
            <input type="hidden" id="dropdown_data_type" value=""> -->



            <script>
        var userLoggedIn = '<?php echo $userLoggedIn; ?>';
        $(document).ready(function() {

            $('.dropdown_data_window').scroll(function() {
                var inner_height = $('.dropdown_data_window').innerHeight(); //div containing data
                var scroll_top = $('.dropdown_data_window').scrollTop;
                var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
                var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

                if((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

                    var pageName; //holds name of page to send ajax request to
                    var type = $('#dropdown_data_type').val();

                    if(type == 'notification')
                        pageName = "ajax_load_notifications.php";
                    else if(type = 'message')
                        pageName = "ajax_load_messages.php"

                    var ajaxReq = $.ajax({
                        url: "includes/handlers/" + pageName,
                        type: "POST",
                        data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                        cache: false,

                        success: function(response) {
                            $('.dropdown_data_window').find('.nextPageDropdownData').remove();
                            $('.dropdown_data_window').find('.noMoreDropdownData').remove();
                            $('#loading').hide();
                            $('.dropdown_data_window').append(response);
                        }
                    })

                }
                return false;
            })
         });

    </script>

        <div class="main_wrap col-md-6 col-md-offset-3">
