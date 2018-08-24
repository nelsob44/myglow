<?php
include("includes/header.php");

$item =" ";
$description = "";
$price ="";
$quantity = "";
$phone_number ="";
$location="";
$errorMessage="";
$imagePath1="";
$imagePath2="";
$imagePath3="";
$imagePath4="";
$imagePath5="";
$imagePath6="";
$uploadOk = 1;

if(isset($_POST['post'])) {

    
        $uploadOk = 1;
        $imageName1 = $_FILES['forum_file_1']['name'];


        if($imageName1 != "") {
            $targetDir1 = "assets/images/posts/";
            $imagePath1 = $targetDir1.$imageName1;
            $imageFileType1 = pathinfo($imageName1, PATHINFO_EXTENSION);

            if($_FILES['forum_file_1']['size'] > 5000000) {
                $errorMessage .= "<p>Sorry your file is too large</p><br>";
                $uploadOk = 0;
            }
            if(strtolower($imageFileType1) != "jpeg" && strtolower($imageFileType1) != "png" && strtolower($imageFileType1) != "jpg" ) {
                $errorMessage .= "<p>Sorry, only jpeg, jpg, and png files are allowed</p><br>";
                $uploadOk = 0;
            }
            if($uploadOk) {
                if(move_uploaded_file($_FILES['forum_file_1']['tmp_name'], $imagePath1)) {
                    //image uploaded okay
                }
                else {
                    //image did not upload
                    $uploadOk = 0;
                }
            }
        }
    
        $imageName2 = $_FILES['forum_file_2']['name'];


        if($imageName2 != "") {
            $targetDir2 = "assets/images/posts/";
            $imagePath2 = $targetDir2.$imageName2;
            $imageFileType2 = pathinfo($imageName2, PATHINFO_EXTENSION);

            if($_FILES['forum_file_2']['size'] > 5000000) {
                $errorMessage .= "<p>Sorry your file is too large</p><br>";
                $uploadOk = 0;
            }
            if(strtolower($imageFileType2) != "jpeg" && strtolower($imageFileType2) != "png" && strtolower($imageFileType2) != "jpg" ) {
                $errorMessage .= "<p>Sorry, only jpeg, jpg, and png files are allowed</p><br>";
                $uploadOk = 0;
            }
            if($uploadOk) {
                if(move_uploaded_file($_FILES['forum_file_2']['tmp_name'], $imagePath2)) {
                    //image uploaded okay
                }
                else {
                    //image did not upload
                    $uploadOk = 0;
                }
            }
        }
    
        $imageName3 = $_FILES['forum_file_3']['name'];


        if($imageName3 != "") {
            $targetDir3 = "assets/images/posts/";
            $imagePath3 = $targetDir3.$imageName3;
            $imageFileType3 = pathinfo($imageName3, PATHINFO_EXTENSION);

            if($_FILES['forum_file_3']['size'] > 5000000) {
                $errorMessage .= "<p>Sorry your file is too large</p><br>";
                $uploadOk = 0;
            }
            if(strtolower($imageFileType3) != "jpeg" && strtolower($imageFileType3) != "png" && strtolower($imageFileType3) != "jpg" ) {
                $errorMessage .= "<p>Sorry, only jpeg, jpg, and png files are allowed</p><br>";
                $uploadOk = 0;
            }
            if($uploadOk) {
                if(move_uploaded_file($_FILES['forum_file_3']['tmp_name'], $imagePath3)) {
                    //image uploaded okay
                }
                else {
                    //image did not upload
                    $uploadOk = 0;
                }
            }
        }
    
        $imageName4 = $_FILES['forum_file_4']['name'];


        if($imageName4 != "") {
            $targetDir4 = "assets/images/posts/";
            $imagePath4 = $targetDir4.$imageName4;
            $imageFileType4 = pathinfo($imageName4, PATHINFO_EXTENSION);

            if($_FILES['forum_file_4']['size'] > 5000000) {
                $errorMessage .= "<p>Sorry your file is too large</p><br>";
                $uploadOk = 0;
            }
            if(strtolower($imageFileType4) != "jpeg" && strtolower($imageFileType4) != "png" && strtolower($imageFileType4) != "jpg" ) {
                $errorMessage .= "<p>Sorry, only jpeg, jpg, and png files are allowed</p><br>";
                $uploadOk = 0;
            }
            if($uploadOk) {
                if(move_uploaded_file($_FILES['forum_file_4']['tmp_name'], $imagePath4)) {
                    //image uploaded okay
                }
                else {
                    //image did not upload
                    $uploadOk = 0;
                }
            }
        }
    
        $imageName5 = $_FILES['forum_file_5']['name'];


        if($imageName5 != "") {
            $targetDir5 = "assets/images/posts/";
            $imagePath5 = $targetDir5.$imageName5;
            $imageFileType5 = pathinfo($imageName5, PATHINFO_EXTENSION);

            if($_FILES['forum_file_5']['size'] > 5000000) {
                $errorMessage .= "<p>Sorry your file is too large</p><br>";
                $uploadOk = 0;
            }
            if(strtolower($imageFileType5) != "jpeg" && strtolower($imageFileType5) != "png" && strtolower($imageFileType5) != "jpg" ) {
                $errorMessage .= "<p>Sorry, only jpeg, jpg, and png files are allowed</p><br>";
                $uploadOk = 0;
            }
            if($uploadOk) {
                if(move_uploaded_file($_FILES['forum_file_5']['tmp_name'], $imagePath5)) {
                    //image uploaded okay
                }
                else {
                    //image did not upload
                    $uploadOk = 0;
                }
            }
        }
    
        $imageName6 = $_FILES['forum_file_6']['name'];


        if($imageName6 != "") {
            $targetDir6 = "assets/images/posts/";
            $imagePath6 = $targetDir6.$imageName6;
            $imageFileType6 = pathinfo($imageName6, PATHINFO_EXTENSION);

            if($_FILES['forum_file_6']['size'] > 5000000) {
                $errorMessage .= "<p>Sorry your file is too large</p><br>";
                $uploadOk = 0;
            }
            if(strtolower($imageFileType6) != "jpeg" && strtolower($imageFileType6) != "png" && strtolower($imageFileType6) != "jpg" ) {
                $errorMessage .= "<p>Sorry, only jpeg, jpg, and png files are allowed</p><br>";
                $uploadOk = 0;
            }
            if($uploadOk) {
                if(move_uploaded_file($_FILES['forum_file_6']['tmp_name'], $imagePath6)) {
                    //image uploaded okay
                }
                else {
                    //image did not upload
                    $uploadOk = 0;
                }
            }
        }

   
    if($uploadOk) {
        $advert = new Advert($con, $userLoggedIn);
        $advert->submitAdvert($_POST['forum_item'], $_POST['forum_item_description'], $_POST['forum_price'], $_POST['forum_quantity'], $_POST['forum_location'], $_POST['forum_phone'], $imagePath1, $imagePath2, $imagePath3, $imagePath4, $imagePath5, $imagePath6);
    }
    else {
        echo "<div style='text-align: center; margin-top:90px;' class='alert alert-danger'>
                $errorMessage
            </div>";
    }

    header("Location: market_place.php?page=1");
}






?>

<div class="center_wrap_search">
    <form class="form-control" action="advert_upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Item Name</label>
                <input type="text" class="form-control forum_title" name="forum_item" id="forum_item" placeholder="Name of Item or Service to advertise...">
            </div>
            <div class="form-group">
                <label for="post">Brief Description</label>
                <textarea class="form-control forum_post" name="forum_item_description" id="forum_item_description" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="title">Price</label>
                <input type="text" class="form-control forum_title" name="forum_price" id="forum_price" placeholder="Price...">
            </div>
            <div class="form-group">
                <label for="title">Quantity in stock</label>
                <input type="text" class="form-control forum_title" name="forum_quantity" id="forum_quantity" placeholder="Quantity in stock...">
            </div>
            <div class="form-group">
                <label for="title">Seller's Location</label>
                <input type="text" class="form-control forum_title" name="forum_location" id="forum_location" placeholder="Your Location...">
            </div>
            <div class="form-group">
                <label for="title">Seller's Phone</label>
                <input type="text" class="form-control forum_title" name="forum_phone" id="forum_phone" placeholder="Your Phone Number...">
            </div>
            
           <div class="form-group">
                <label for="file_attachment">Attach a file</label>
                <input type="file" class="form-control-file forum_file" name="forum_file_1" id="forum_file_1">
            </div>
            <div class="form-group">
                <label for="file_attachment">Attach a file</label>
                <input type="file" class="form-control-file forum_file" name="forum_file_2" id="forum_file_2">
            </div>
            <div class="form-group">
                <label for="file_attachment">Attach a file</label>
                <input type="file" class="form-control-file forum_file" name="forum_file_3" id="forum_file_3">
            </div>
            <div class="form-group">
                <label for="file_attachment">Attach a file</label>
                <input type="file" class="form-control-file forum_file" name="forum_file_4" id="forum_file_4">
            </div>
            <div class="form-group">
                <label for="file_attachment">Attach a file</label>
                <input type="file" class="form-control-file forum_file" name="forum_file_5" id="forum_file_5">
            </div>
            <div class="form-group">
                <label for="file_attachment">Attach a file</label>
                <input type="file" class="form-control-file forum_file" name="forum_file_6" id="forum_file_6">
            </div>
        
        

            <input type="submit" name="post" id="formsubmit" value="Post">
            <hr>


        </form>

</div>