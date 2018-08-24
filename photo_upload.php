<?php
include("includes/header.php");

$image_obj = new Image($con, $userLoggedIn);


$photo_string = " ";
$photouploadsuccess = " ";
$profile_id = $user['username'];

if (isset($_FILES["userfile"]) && !empty($_FILES["userfile"])) {
        $image = $_FILES['userfile']['tmp_name'];
        $imageName = $_FILES['userfile']['name'];
        $imageSize = $_FILES['userfile']['size'];
        $imageType = $_FILES['userfile']['type'];


        $len = count($image);
        $path = "assets/images/mobile_uploads/";
        for ($i = 0; $i < $len; $i++) {
             if (isset($imageName[$i]) && $imageName[$i] !== NULL) {
                 if(move_uploaded_file($image[$i], $path.$imageName[$i])) {
                   $filepathname = $path.$imageName[$i];
                   $date_added = date("Y-m-d H:i:s");
                   $image_obj->addImage($filepathname, $date_added);

             }
        }
      } $photouploadsuccess .= "Your photo upload was successful";
}

?>


<div class="photos_container">
  <div class="addPhotos"><i class="fas fa-plus"></i>&nbsp;Add Photos</div>
    <div class="photouploadform">
    <form action="photo_upload.php" method="post" enctype="multipart/form-data">
        Select files to upload:
        <p><input type="file" name="userfile[]" multiple="multiple" style="width:200px; height:30px;"></p>
        <p>Album name: <input type="text" name="album_name"></p>
        <input type="submit" value="Upload Image">
    </form>
      <div><?php echo $photouploadsuccess; ?></div>
      
      <br>
      <hr>
  </div>
      <div class="photo_posts_area">

    </div>
    <img id="loading" src="assets/icons/loadingimage.gif">

<script>
$(document).ready(function() {

  $('.images').click(bigger)



  $('.addPhotos').click(function(){

  $(this).html() === 'Click to return' ? $(this).html('<i class="fas fa-plus"></i>&nbsp;Add Photos') : $(this).html('Click to return');
  $('.photouploadform').toggle();

  });

  function bigger() {
    $(this).animate({
      maxWidth: "600px",
      maxHeight: "500px",
      position: "relative",
      }, 2000);
}
});

var userLoggedIn = '<?php echo $userLoggedIn; ?>';
$(document).ready(function() {
  $('#loading').show();

  $.ajax({
    url: "includes/handlers/ajax_load_images.php",
    type: "POST",
    data: "page=1&userLoggedIn=" + userLoggedIn,
    cache: false,

    success: function(data) {
      $('#loading').hide();
      $('.photo_posts_area').html(data);
    }
  });

  $(window).scroll(function() {
    var height = $('.photo_posts_area').height();
    var scroll_top = $(this).scrollTop();
    var page = $('.photo_posts_area').find('.nextPage').val();
    var noMorePhotos = $('.photo_posts_area').find('.noMorePhotos').val();

    if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePhotos == 'false') {
      $('#loading').show();

      var ajaxReq = $.ajax({
        url: "includes/handlers/ajax_load_images.php",
        type: "POST",
        data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
        cache: false,

        success: function(response) {
          $('.photo_posts_area').find('.nextPage').remove();
          $('.photo_posts_area').find('.noMorePhotos').remove();

          $('#loading').hide();
          $('.photo_posts_area').append(response);
        }
      });

    }
    return false;
  });

});

</script>

</div>
