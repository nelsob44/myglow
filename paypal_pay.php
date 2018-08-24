<?php
//Include db configuration file
include ('includes/header.php');

?>
<div class="center_wrap_search">
    <div class="container">
<?php
    $advert = new Advert($con, $userLoggedIn);
    $advert->loadAdverts();
?>




        <div id="post_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;
                        </button>
                        <h4 class="modal-title">Details</h4>

                    </div>
                    <div class="modal-body" id="post_detail">
                      
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>

                </div>

            </div>

        </div>

        <script>
        $(document).ready(function(){
            function fetch_post_data(post_id) {
                
                $.ajax({
                    url:"includes/handlers/fetch.php",
                    method:"POST",
                    data:{post_id:post_id},
                    success:function(data) {
                        $('#post_modal').modal('show');
                        $('#post_detail').html(data);
                    }
                });
            }
            
            $(document).on('click', '.view', function(){
               var post_id = $(this).attr('id');
                fetch_post_data(post_id);
            });
        });
        </script>


    </div>
</div>
<footer>
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
                       $link .="<li class='page-item'><a href='paypal_pay.php?page=1'>1</a>...&nbsp;</li>";
                     }
                     for ($i=$page; $i<=$pages; $i++) {
                       if($counter < $limit) {
                         $link .="<li class='page-item'><a href='paypal_pay.php?page=$i'>$i</a>&nbsp;</li>";
                       }
                       $counter++;

                     }
                     if ($page < $pages - ($limit/2)) {
                       $link .="..."."<li class='page-item'><a href='paypal_pay.php?page=$pages'>$pages</a>&nbsp;</li>";
                                ?> </ul>
                   </nav> <?php
                     }

                     echo $link;
                   }
               ?>

             </ul>


           </div>



    </footer>
