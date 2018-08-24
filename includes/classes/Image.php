<?php
class Image {
  private $user_obj;
  private $con;

  public function __construct($con, $user) {
    $this->con = $con;
    $this->user_obj = new User($con, $user);
  }

  public function addImage($filepathname, $date_added) {
    if($filepathname != " ") {
      $userLoggedIn = $this->user_obj->getUsername();

      $add_photo_query = mysqli_query($this->con, "INSERT INTO images VALUES ('', '$userLoggedIn', '$filepathname', '$date_added', 'no', '')");

      $num_photos = $this->user_obj->getNumPhotos();
      $num_photos++;

      $update_num_photos = mysqli_query($this->con, "UPDATE users SET num_photos='$num_photos' WHERE username='$userLoggedIn'");
    }
  }

  public function loadImages($data, $limit) {

    $str = "";
    $page = $data['page'];

    $userLoggedIn = $this->user_obj->getUsername();


    if($page == 1)
        $start = 0;
    else {
      $start = ($page - 1) * $limit;
    }

    $data_query = mysqli_query($this->con, "SELECT * FROM images WHERE (deleted='no' AND username='$userLoggedIn') ORDER BY id DESC");

    if(mysqli_num_rows($data_query) > 0) {

        $num_iterations = 0;
        $count = 1;

        while($row = mysqli_fetch_array($data_query)) {
          $id = $row['id'];
          $photo = $row['photos'];
          $date_added = $row['date_added'];
          $added_by = $row['username'];

          if($num_iterations++ < $start)
              continue;

          if($count > $limit) {
              break;
          }
          else {
              $count++;
          }



          if($userLoggedIn == $added_by)
              $delete_button = "<button class='delete_button btn-danger' style='float: none; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='image$id'>x</button>";
          else
              $delete_button = "";


          $str .= "<div class='photostring' style='width:180px; height:150px; float:left; margin:10px; '>
                    <a href='images.php?id=$id' target='_blank'>
                      <img class='images' src='$photo' style='width:100%; height:100%; img-responsive;'>

                    </a>$delete_button
                  </div>";

            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#image<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this photo?", function(result) {
                                            $.post("includes/form_handlers/delete_photos.php?image_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                });



                            </script>



                            <?php
        }
        if($count > $limit)
            $str .= "<input type='hidden' class='nextPage' value='".($page + 1)."'>
                        <input type='hidden' class='noMorePhotos' value='false'>";
        else {
          $str .= "<input type='hidden' class='noMorePhotos' value='true'><p style='text-align: center;'>No more photos to show!</p>";
        }
    }
    echo $str;
  }


public function loadImagesProfile($data, $limit) {

    $str = "";
    $page = $data['page'];

    $userLoggedIn = $this->user_obj->getUsername();


    if($page == 1)
        $start = 0;
    else {
      $start = ($page - 1) * $limit;
    }

    $data_query = mysqli_query($this->con, "SELECT * FROM images WHERE (deleted='no' AND username='$userLoggedIn') ORDER BY id DESC");

    if(mysqli_num_rows($data_query) > 0) {

        $num_iterations = 0;
        $count = 1;

        while($row = mysqli_fetch_array($data_query)) {
          $id = $row['id'];
          $photo = $row['photos'];
          $date_added = $row['date_added'];
          $added_by = $row['username'];

          if($num_iterations++ < $start)
              continue;

          if($count > $limit) {
              break;
          }
          else {
              $count++;
          }




          $str .= "<div class='photostring' style='width:180px; height:150px; float:left; margin:0 auto; '>
                    <a href='images.php?id=$id' target='_blank'>
                      <img class='images' src='$photo' style='width:100%; height:100%; img-responsive;'>
                    </a>
                  </div>";

        }
        if($count > $limit)
            $str .= "<input type='hidden' class='nextPage' value='".($page + 1)."'>
                        <input type='hidden' class='noMorePhotos' value='false'>";
        else {
          $str .= "<input type='hidden' class='noMorePhotos' value='true'><p style='text-align: center;'>No more photos to show!</p>";
        }
    }
    echo $str;
  }


}



?>
