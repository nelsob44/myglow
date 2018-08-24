<?php
require '../../connection.php';

if(isset($_POST['post_id'])) {
    $id = $_POST['post_id'];
    $output = '';
    $carousel ='';
    
    $images = array();
    $query_carousel = mysqli_query($con, "SELECT * FROM products WHERE id='$id'");
    $data_carousel = mysqli_fetch_assoc($query_carousel);
    
    $name = $data_carousel['name'];
    $brief_description = $data_carousel['brief_description'];

    array_push($images, $data_carousel['image1']);
    array_push($images, $data_carousel['image2']);
    array_push($images, $data_carousel['image3']);
    array_push($images, $data_carousel['image4']);
    array_push($images, $data_carousel['image5']);
    array_push($images, $data_carousel['image6']);

    $arrlength = count($images);
    $count =0;
        
        for ($i = 0; $i < $arrlength; $i++) {
            if($count > $arrlength){
                $count =0;
            }
            if($count == 0){
                $output .= '<div class="item active" style="margin:20px;">';
            }
            else {
                $output .= '<div class="item" style="margin:20px;">';
            }
            $output .= '
                <img src="'.$images[$i].'" style="width:100%; height:auto;">
                <div class="carousel-caption">
                    <h3>'.$name.'</h3><br><div>'.$brief_description.'</div>
                </div>
                
            </div>

            ';
            $count++;
        }
        echo $output;

 
}

?>