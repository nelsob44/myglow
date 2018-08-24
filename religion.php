<?php
include("includes/header.php");


?>

<div class="container-fluid forum_container">
        <div class="forum_body_container_topics">


            <div class="new_posts"><a href="forum.php" target="_parent"><small style="font-size:11;">Active users: <?php echo $active_users; ?></small></a>&nbsp;&nbsp;
              <a href="forum.php" target="_parent"><small style="font-size:11;">Users online: <?php echo $users_online; ?></small></a>&nbsp;&nbsp;<a href='religion_new.php'><small>Create a new post /</small></a></div>
           <div class="politics_area">
             <?php
             $topic = new Topic($con, $userLoggedIn);
             $topic->loadTopicReligion();
             ?>
           </div>
            
            <div class="pagination_div">

               <ul class='pagination pagination-lg'>

             <?php

             $page = $_GET['page'];
            $data_query = mysqli_query($con, "SELECT * FROM forum_topics WHERE category='religion'");
             $count = mysqli_num_rows($data_query);
             $pages = $count/20;
             $pages = ceil($pages);
             $link = " ";
             $limit = 4;
                 if ($pages >=1 && $page <= $pages) {
                     $counter = 1;
                     $link = "";
                     if ($page >= ($limit/2)) {
                       $link .="<a href=religion.php?page=1>1</a>...&nbsp;";
                     }
                     for ($i=$page; $i<=$pages; $i++) {
                       if($counter < $limit) {
                         $link .="<a href=religion.php?page=".$i.">".$i."</a>&nbsp;";
                       }
                       $counter++;

                     }
                     if ($page < $pages - ($limit/2)) {
                       $link .="..."."<a href=religion.php?page=".$pages.">".$pages."</a>&nbsp;";
                     }

                     echo $link;
                   }
               ?>

             </ul>


           </div>


       </div>

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
</div>
