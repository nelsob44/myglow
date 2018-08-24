<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/imgareaselect-default.css" />
        <script src="assets/js/jquery.imgareaselect.min.js"></script>
        
        <script src="assets/js/jquery.imgareaselect.pack.js"></script>

    </head>
    <body>
<script>
//set image coordinates
function updateCoords(im,obj){
    $('#x').val(obj.x1);
    $('#y').val(obj.y1);
    $('#w').val(obj.width);
    $('#h').val(obj.height);
}

//check coordinates
function checkCoords(){
    if(parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
}

$(document).ready(function(){
    //prepare instant image preview
    var p = $("#filePreview");
    $("#fileInput").change(function(){
        //fadeOut or hide preview
        p.fadeOut();

        //prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("fileInput").files[0]);

        oFReader.onload = function (oFREvent) {
            p.attr('src', oFREvent.target.result).fadeIn();
        };
    });

    //implement imgAreaSelect plugin
    $('img#filePreview').imgAreaSelect({
        // set crop ratio (optional)
        //aspectRatio: '2:1',
        onSelectEnd: updateCoords
    });
});
</script>


<div class="center_wrap">
    <form action="upload.php" enctype="multipart/form-data" method="post" onsubmit="return checkCoords();">
        <p>Image: <input name="image" id="fileInput" type="file" /></p>
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />
        <input name="upload" type="submit" value="Upload" />
    </form>
    
    
    <p><img id="filePreview" style="display:none;"/></p>
</div>



<?php
include("includes/header.php");
$error = "";
        
$profile_id = $user['username'];
        
//if upload form is submitted
if(isset($_POST["upload"])){
    //get the file information
    $fileName = basename($_FILES["image"]["name"]);
    $fileTmp = $_FILES["image"]["tmp_name"];
    $fileType = $_FILES["image"]["type"];
    $fileSize = $_FILES["image"]["size"];
    $fileExt = substr($fileName, strrpos($fileName, ".") + 1);
    
    //specify image upload directory
    $largeImageLoc = $_SERVER['DOCUMENT_ROOT'].'/phpcourse/assets/images/profile_pics/'.$fileName;
    $thumbImageLoc = $_SERVER['DOCUMENT_ROOT'].'/phpcourse/assets/images/profile_pics/thumb/'.$fileName;
 
    //check file extension
    if((!empty($_FILES["image"])) && ($_FILES["image"]["error"] == 0)){
        if($fileExt != "jpg" && $fileExt != "jpeg" && $fileExt != "png"){
            $error = "Sorry, only JPG, JPEG & PNG files are allowed.";
        }
    }else{
        $error = "Select a JPG, JPEG & PNG image to upload";
    }
    
    //if everything is ok, try to upload file
    if(strlen($error) == 0 && !empty($fileName)){
        if(move_uploaded_file($fileTmp, $largeImageLoc)){
            //file permission
            chmod ($largeImageLoc, 0777);
            
            //get dimensions of the original image
            list($width_org, $height_org) = getimagesize($largeImageLoc);
            
            //get image coords
            $x = (int) $_POST['x'];
            $y = (int) $_POST['y'];
            $width = (int) $_POST['w'];
            $height = (int) $_POST['h'];

            //define the final size of the cropped image
            $width_new = $width;
            $height_new = $height;
            
            //crop and resize image
            $newImage = imagecreatetruecolor($width_new,$height_new);
            
            switch($fileType) {
                case "image/gif":
                    $source = imagecreatefromgif($largeImageLoc); 
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    $source = imagecreatefromjpeg($largeImageLoc); 
                    break;
                case "image/png":
                case "image/x-png":
                    $source = imagecreatefrompng($largeImageLoc); 
                    break;
            }
            
            imagecopyresampled($newImage,$source,0,0,$x,$y,$width_new,$height_new,$width,$height);

            switch($fileType) {
                case "image/gif":
                    imagegif($newImage,$thumbImageLoc); 
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    imagejpeg($newImage,$thumbImageLoc,90); 
                    break;
                case "image/png":
                case "image/x-png":
                    imagepng($newImage,$thumbImageLoc);  
                    break;
            }
            imagedestroy($newImage);
            
            //remove large image
            //unlink($imageUploadLoc);

            //display cropped image
            echo 'CROP IMAGE:<br><br><img src="'.$thumbImageLoc.'"/>';
            
            $result_path ="assets/images/profile_pics/thumb/".$fileName;
    
            $insert_pic_query = mysqli_query($con, "UPDATE users SET profile_pic='$result_path' WHERE username='$userLoggedIn'");
            header("Location: ".$userLoggedIn);
        }else{
            $error = "Sorry, there was an error uploading your file.";
        }
    }else{
        //display error
        echo $error;
    }
    
    
    
    

}
?>

</body>
</html>