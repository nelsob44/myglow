<?php
include("includes/header.php");

$profile_id = $user['username'];

if (isset($_FILES["userfile"]) && !empty($_FILES["userfile"])) {
        $image = $_FILES['userfile']['tmp_name'];
        $imageName = $_FILES['userfile']['name'];
        $imageSize = $_FILES['userfile']['size'];
        $imageType = $_FILES['userfile']['type'];
        $imageCategory = $_POST['imageCategory'];
        $len = count($image);
        $path = "assets/images/mobile_uploads";
        for ($i = 0; $i < $len; $i++) {
             if (isset($imageName[$i]) && $imageName[$i] !== NULL) {
                 if(move_uploaded_file($image[$i], $path.$imageName[$i])) {
                    $add_photo_query = mysqli_query($con, "UPDATE users SET images=CONCAT(images, '$path.$imageName[$i]') WHERE username='$userLoggedIn'");
                 }
             }
        }
}

header("Location: ".$userLoggedIn);
?>

<div id="photouploadform">
<form action="file_upload.php" method="post" enctype="multipart/form-data">
    Select files to upload:
    <p><input type="file" name="userfile[]" multiple="multiple" style="width:200px; height:30px;"></p>
    <p>Category: <input type="text" name="imageCategory"></p>
    <input type="submit" value="Upload Image">
</form>
</div>
