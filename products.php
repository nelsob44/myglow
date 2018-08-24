<?php
//Include db configuration file
include ('includes/header.php');


?>
<div class="center_wrap_search">
<?php
    $advert = new Advert($con, $userLoggedIn);
    $advert->loadAdverts();
?>
    
    <div class="pagination_div">

               <ul class='pagination pagination-sm'>

             <?php

             $page = $_GET['page'];
             $data_query = mysqli_query($con, "SELECT * FROM products");
             $count_adverts = mysqli_num_rows($data_query);
             $pages = $count_adverts/30;
             $pages = ceil($pages);
             $link = " ";
             $limit = 4;
                 if ($pages >=1 && $page <= $pages) {
                     $counter = 1;
                     $link = "";
                     if ($page >= ($limit/2)) {
                        ?><nav aria-label="Page navigation example">
                            <ul class="pagination"> <?php
                       $link .="<li class='page-item'><a href='products.php?page=1'>1</a>...&nbsp;</li>";
                     }
                     for ($i=$page; $i<=$pages; $i++) {
                       if($counter < $limit) {
                         $link .="<li class='page-item'><a href='products.php?page=$i'>$i</a>&nbsp;</li>";
                       }
                       $counter++;

                     }
                     if ($page < $pages - ($limit/2)) {
                       $link .="..."."<li class='page-item'><a href='products.php?page=$pages'>$pages</a>&nbsp;</li>";
                                ?> </ul>
                   </nav> <?php
                     }

                     echo $link;
                   }
               ?>

             </ul>


           </div>

   
</div>