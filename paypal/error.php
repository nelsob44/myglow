<?php
include('../connection.php');

?>

<div class="center_wrap_search">
    <?php
    
    $images = array();
    
    $query_1 = mysqli_query($con, "SELECT image1 image2, image3, image4, image5, image6 FROM products WHERE id=12");
    $data_1 = mysqli_fetch_assoc($query_1);
    
    array_push($images, $data_1['image1']);
    array_push($images, $data_1['image2']);
    array_push($images, $data_1['image3']);
    array_push($images, $data_1['image4']);
    array_push($images, $data_1['image5']);
    array_push($images, $data_1['image6']);
    
    $arrlength = count($images);
    $count =0;
    for ($i = 0; $i < $arrlength; $i++) {
        echo $images[$i];
        echo '<br>';
        $count++;
    } 
    ?>

</div>