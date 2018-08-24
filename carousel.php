
if(isset($_POST['post_id'])) {
    $id = $_POST['post_id'];

    function make_query($con) {

        $images = array();
        $query_carousel = mysqli_query($con, "SELECT image1, image2, image3, image4, image5, image6 FROM products WHERE id='$id'");
        $data_carousel = mysqli_fetch_assoc($query_carousel);

        array_push($images, $data_carousel['image1']);
        array_push($images, $data_carousel['image2']);
        array_push($images, $data_carousel['image3']);
        array_push($images, $data_carousel['image4']);
        array_push($images, $data_carousel['image5']);
        array_push($images, $data_carousel['image6']);

        return $images;

    }

    function make_slide_indicators($con){
        $images = array();
        $output = '';
        $count = 0;
        $result = make_query($con);

        $arrlength = count($images);
        for ($i = 0; $i < $arrlength; $i++) {
            if($count > $arrlength){
                $count =0;
            }
            if($count == 0){
                $output .='
                <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>
                ';
            }
            else {
                $output .='
                <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>
                ';
            }

            $count++;
        }
        return $output;
    }

    function make_slides($con){
        $output = '';
        $query_name = mysqli_query($con, "SELECT * FROM products WHERE id='$id'");
        while($query_name_result = mysqli_fetch_array($query_name)){
            $name = $query_name_result['name'];
            $brief_description = $query_name_result['brief_description'];
        }
        $images = array();
        $count =0;
        $result = make_query($con);

        $arrlength = count($images);
        for ($i = 0; $i < $arrlength; $i++) {
            if($count > $arrlength){
                $count =0;
            }
            if($count == 0){
                $output .= '<div class="item active">';
            }
            else {
                $output .= '<div class="item">';
            }
            $output .= '
                <img src="'.$images[$i].'">
                <div class="carousel-caption">
                    <h3>'.$name.'</h3>
                </div>
            </div>

            ';
            $count++;
        }
        return $output;

    }

}


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
                    url:"fetch.php",
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


$carousel .="<div>
                        <h4>$name</h4>
                        <div><img src='$image1' style='img-responsive;'></div>
                        <p>$description</p>
                    </div>;
        
                        <div id='dynamic_slide_show' class='carousel slide' data-ride='carousel'>
                            <ol class='carousel-indicators'>
                            <?php echo make_slide_indicators($con); ?>
                            </ol>
                            <div class='carousel-inner'>
                                <?php echo make_slides($con); ?>
                            </div>
                            <a class='left carousel-control' href='#dynamic_slide_show' data-slide='prev'>
                            <span class='glyphicon glyphicon-chevron-left'></span><span class='sr-only'>Previous</span>

                            </a>

                            <a class='right carousel-control' href='#dynamic_slide_show' data-slide='next'>
                            <span class='glyphicon glyphicon-chevron-right'></span><span class='sr-only'>Next</span>

                            </a>

                        </div>
        
        
