<?php
class Advert {
    private $user_obj;
    private $con;

    public function __construct($con, $user) {
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }

    public function submitAdvert($item, $description, $price, $quantity, $location, $phone_number, $imagePath1, $imagePath2, $imagePath3, $imagePath4, $imagePath5, $imagePath6) {

        $item = strip_tags($_POST['forum_item']); //remove html tags
        $item = mysqli_real_escape_string($this->con, $item);

        $description = strip_tags($_POST['forum_item_description']); //remove html tags
        $description = mysqli_real_escape_string($this->con, $description);

        $price = strip_tags($_POST['forum_price']); //remove html tags
        $price = mysqli_real_escape_string($this->con, $price);

        $quantity = strip_tags($_POST['forum_quantity']); //remove html tags
        $quantity = mysqli_real_escape_string($this->con, $quantity);

        $location = strip_tags($_POST['forum_location']); //remove html tags
        $location = mysqli_real_escape_string($this->con, $location);

        $phone_number = strip_tags($_POST['forum_phone']); //remove html tags
        $phone_number = mysqli_real_escape_string($this->con, $phone_number);

        $date_posted = date("Y-m-d H:i:s");

        $posted_by = $this->user_obj->getUsername();

        $query = mysqli_query($this->con, "INSERT INTO products VALUES ('', '$item', '$description', '$imagePath1', '$imagePath2', '$imagePath3', '$imagePath4', '$imagePath5', '$imagePath6', '$price', '$location', '$phone_number', '', '$quantity', '', '$posted_by', '$date_posted')");

        $num_posts = $this->user_obj->getNumPosts();
        $num_posts++;
        $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$posted_by'");


    }

    public function loadAdverts() {
      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

        $email_query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $email_query_row = mysqli_fetch_array($email_query);
        $email = $email_query_row['email'];

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM products ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $name = $row['name'];
                $brief_description = $row['brief_description'];
                $image1 = $row['image1'];
                $image2 = $row['image2'];
                $image3 = $row['image3'];
                $image4 = $row['image4'];
                $image5 = $row['image5'];
                $image6 = $row['image6'];
                $price = $row['price'];
                $location = $row['location'];
                $phone_number = $row['phone_number'];
                $quantity = $row['quantity_in_stock'];
                $posted_by = $row['posted_by'];
                $date_time = $row['date_posted'];

                if(strlen($brief_description) > 25){

                    $description = mb_strimwidth($brief_description, 0, 27, '...');
                }else{
                  $description = $brief_description;
                }


                      if($userLoggedIn == $posted_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='advert$id'>x</button>";
                        else
                            $delete_button = "";

                      if($posted_by == admin){
                            $button_paypal = "<div id='paypal-button$id'></div>";
                      }else {
                          $button_paypal = " ";
                      }

                      if($quantity <= 9) {
                          $quantity_in_stock = "<div style='color:red; font-size:12px;'>$quantity&nbsp;<small style='font-size:10px;'>Low stock</small></div>";
                          $button_paypal = "<div id='paypal-button$id'></div>";
                      } else {
                          $quantity_in_stock = "<div style='color:blue; font-size:12px;'>$quantity</div>";
                          $button_paypal = "<div id='paypal-button$id'></div>";
                      }

                      if($quantity == 0) {
                          $quantity_in_stock = "<div style='color:red; font-size:12px;'>$quantity&nbsp;<small style='font-size:10px;'>Out of stock</small></div>";
                          $button_paypal = " ";
                      }




                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$posted_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];


                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval === 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    $str .="<div class='card-group border-secondary mb-3' style='float:left; margin:20px; max-width: 18rem;'>
                                  <div class='card'>
                                    <img class='card-img-top' src='$image1' style='width:200px; height:180px; img-responsive;' alt='Card image cap'>
                                    <div class='card-body'>
                                    <h5 class='card-title'><b>$name</b></h5>
                                    <div class='card-text'>£$price &nbsp;&nbsp;&nbsp;<small style='font-size:10px;'>Quantity in stock: $quantity_in_stock</small></div>
                                    <div class='card-text'><small style='font-size:10px;'>$description</small></div>
                                    <p style='font-size:10px;'>Seller's Location: $location&nbsp;&nbsp;Seller's Phone: $phone_number</p>
                                    <p class='card-text' style='font-size:10px;'><small class='text-muted'>Posted by:<a href='$posted_by'>$posted_by</a> &nbsp;&nbsp; Posted: $time_message&nbsp;&nbsp;<input type='submit' name='view' class='btn btn-info view' id='$id' style='font-size:10px; height:20px; padding-bottom:10px;' value='View' data-toggle='modal' data-target='#post_modal'>$delete_button</small></p>
                                    </div>
                                  </div>
                                  <div id='$id'>$button_paypal</div>

                            </div>";
                            ?>
                                <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                                <script>
                                paypal.Button.render({
                                  // Configure environment
                                  env: 'sandbox',
                                  client: {
                                    sandbox: 'Aa8--em8tJc6UltEYKjmF_lqI2TpfZTVwVVGUUfslXsHlOa_mtbKzJlk8lSj4frT0tGuZ-42HtWv6tFO',
                                    production: 'AVD5XzzBzPLUmSi0YIh60KRrXYNiazzUVLIIV8c73FpPzqc2W-8HKJJy1NRpC5LpDmNefm4GvNtzKDFx'
                                  },
                                  // Customize button (optional)
                                  locale: 'en_US',
                                  style: {
                                    size: 'small',
                                    color: 'gold',
                                    shape: 'pill',
                                  },
                                  // Set up a payment
                                  payment: function (data, actions) {
                                    return actions.payment.create({
                                      transactions: [{
                                        amount: {
                                          total: '<?php echo $price; ?>',
                                          currency: 'GBP'
                                        }
                                      }]
                                    });
                                  },
                                  // Execute the payment
                                  onAuthorize: function (data, actions) {
                                    return actions.payment.execute()
                                      .then(function () {

                                            $.ajax({
                                                type: "POST",
                                                url: "includes/form_handlers/sales_handler.php?product_name=<?php echo $name; ?>&price=<?php echo $price; ?>&quantity=<?php echo $quantity; ?>&product_id=<?php echo $id; ?>&email=<?php echo $email; ?>",
                                                success: function(msg) {
                                                    // Show a confirmation message to the buyer
                                                    window.alert('Thank you for your purchase!');
                                                },

                                            });


                                      });
                                  }
                                }, '#paypal-button<?php echo $id; ?>');
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {

                                        $('#advert<?php echo $id; ?>').on('click', function(){
                                            bootbox.confirm("Are you sure you want to delete this advert?", function(result) {
                                                $.post("includes/form_handlers/delete_advert.php?forum_post_id=<?php echo $id; ?>",
                                                    {result:result});
                                                if(result)
                                                    location.reload();

                                            });

                                        });

                                    });



                                </script>



                                <?php


              }
              echo $str;
          }
        }
    }

    public function makeQuery($id) {
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

          return $images;
        }
    }

    function makeSlideIndicators($id){
      if(isset($_POST['post_id'])) {
        $id = $_POST['post_id'];
        $images = array();
        $output = '';
        $count = 0;
        $advert = new Advert($con, $userLoggedIn);
        $result = $advert->makeQuery();

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
    }

    function makeSlides($id){
      if(isset($_POST['post_id'])) {
        $id = $_POST['post_id'];
        $output = '';
        $query_name = mysqli_query($con, "SELECT * FROM products WHERE id='$id'");
        while($query_name_result = mysqli_fetch_array($query_name)){
            $name = $query_name_result['name'];
            $brief_description = $query_name_result['brief_description'];
        }
        $images = array();
        $count =0;
        $advert = new Advert($con, $userLoggedIn);
        $result = $advert->makeQuery();

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

}

?>
