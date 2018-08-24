<?php
include("includes/header.php");

?>

    <div class="forum_container">
        
    
        <form class="form-control" action="market_place_new.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control forum_title" name="forum_title" id="forum_title" placeholder="your title, max of 200 characters">
            </div>
            <div class="form-group">
                <label for="post">Post</label>
                <textarea class="form-control forum_post" name="forum_post" id="forum_post" rows="10"></textarea>
            </div>
           <div class="form-group">
                <label for="file_attachment">Attach a file</label>
                <input type="file" class="form-control-file forum_file" name="forum_file" id="forum_file">
            </div>


            <input type="submit" name="post" id="post_button" value="Post">
            <hr>
        
        
        </form>
                
    </div>
    
<?php
$title =" ";
$post = "";
$errorMessages="";
$imageName="";

    
if(isset($_POST['post'])) {

    $uploadOk = 1;
    $imageName = $_FILES['forum_file']['name'];
    $errorMessage = "";

    if($imageName != "") {
        $targetDir = "assets/images/posts/";
        $imagePath = $targetDir.$imageName;
        $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

        if($_FILES['forum_file']['size'] > 5000000) {
            $errorMessage = "Sorry your file is too large";
            $uploadOk = 0;
        }
        if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg" ) {
            $errorMessage = "Sorry, only jpeg, jpg, and png files are allowed";
            $uploadOk = 0;
        }
        if($uploadOk) {
            if(move_uploaded_file($_FILES['forum_file']['tmp_name'], $imagePath)) {
                //image uploaded okay
            }
            else {
                //image did not upload
                $uploadOk = 0;
            }
        }
    }
    if($uploadOk) {
        $topic = new Topic($con, $userLoggedIn);
        $topic->submitTopicMarketPlace($title, $post, $imagePath);
    }
    else {
        echo "<div style='text-align: center;' class='alert alert-danger'>
                $errorMessage
            </div>";
    }
    
    header("Location: market_place.php?page=1");



}


?>