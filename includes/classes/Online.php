<?php
class Online {
    private $user_obj;
    private $con;

    public function __construct($con, $user) {
      $this->con = $con;
      $this->user_obj = new User($con, $user);
    }

    public function ShowOnlineUsers($con, $userLoggedIn) {

      $str = "";
      $online_query = mysqli_query($this->con, "SELECT * FROM users WHERE (user_online='yes' AND username!='$userLoggedIn') ORDER BY id DESC");
      if(mysqli_num_rows($online_query) > 0) {

        while ($row = mysqli_fetch_array($online_query)) {
          $id = $row['id'];
          $fname = $row['first_name'];
          $lname = $row['last_name'];
          $profile_pic = $row['profile_pic'];
          $username = $row['username'];

          $logged_in_user_obj = new User($con, $userLoggedIn);

          if($logged_in_user_obj->isFriend($username)) {



              $str .= "<div class='online_string'>
                          <div class='online_profile_pic' style='float:left;'>
                              <a href='$username'><img src='$profile_pic' width='35' height='35'></a>
                          </div>
                          <div class='online_user_name' style='float:left;'>
                              <a href='$username'><small>$fname $lname</small></a>
                          </div>
                      </div><hr>";

            }
          }
          echo $str;
        }

      }




}


?>
