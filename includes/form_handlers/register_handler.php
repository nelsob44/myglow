<?php
/*require '../classes/Csrf.php';

$csrf = new csrf();

// Generate Token Id and Valid
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
if($csrf->check_valid('post')) {
	var_dump($_POST[$token_id]);
} else {
	echo 'Not Valid';
}*/

//declaring variables to prevent errors
$fname=""; //First name
$lname=""; //Last name
$em=""; //email
$em2=""; //email 2
$password=""; //password
$password2=""; //password 2
$country ="";
$current_city="";
$birthday="";
$date=""; //Sign up date
$errorMessages=""; //Error messages
$successMessages="";

if(isset($_POST['register_button'])) {
    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ', '',$fname);
    $fname =ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname;

    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '',$lname);
    $lname =ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;

    $em = strip_tags($_POST['reg_email']);
    $em = str_replace(' ', '',$em);
    $em =ucfirst(strtolower($em));
    $_SESSION['reg_email'] = $em;

    $em2 = strip_tags($_POST['reg_email2']);
    $em2 = str_replace(' ', '',$em2);
    $em2 =ucfirst(strtolower($em2));
    $_SESSION['reg_email2'] = $em2;

    $country = strip_tags($_POST['country']);
    $country =ucfirst(strtolower($country));
    $_SESSION['country'] = $country;

    $current_city = strip_tags($_POST['current_city']);
    $current_city =ucfirst(strtolower($current_city));
    $_SESSION['current_city'] = $current_city;

    $birthday = strip_tags($_POST['birthday']);
    $birthday =ucfirst(strtolower($birthday));
    $_SESSION['birthday'] = $birthday;

    $password = strip_tags($_POST['reg_password']);

    $password2 = strip_tags($_POST['reg_password2']);

    $date = date("Y-m-d");

    if($em == $em2) {
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);
            //check if email exists
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email = '$em'");
            //count number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                $errorMessages.= "Email already in use.<br>";
            }

        } else {
            $errorMessages.= "Invalid format.<br>";
        }

    } else {
        $errorMessages.= "Emails don't match.<br>";
    }

  if (strlen($fname) > 25 || strlen($fname) < 2) {
      $errorMessages.= "Your first name must be between 2 and 25 characters.<br>";
  }

    if (strlen($lname) > 25 || strlen($lname) < 2) {
      $errorMessages.= "Your last name must be between 2 and 25 characters. <br>";
  }

    if ($password != $password2) {
        $errorMessages.= "Your passwords do not match. <br>";
    } else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            $errorMessages.= "Your password can only contain English characters or numbers. <br>";
        }
    }

    if(strlen($password > 30 || strlen($password) < 5)) {
        $errorMessages.= "Your password must be between 5 and 30 characters. <br>";
    }
    if(empty($errorMessages)) {

        $password = md5($password); //Encrypt password before sending to database

        //Generate username by concatenating first name and last name
        $username = strtolower($fname."_".$lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");

        $i = 0;
        //if username exists, add number to username
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $username."_".$i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");

        }
        //profile picture assignment
        $rand = rand(1,5); //Random number between 1 and 5

        if($rand == 1) {
            $profile_pic = "assets/images/profile_pics/defaults/auto-tires.jpg";
        } else if ($rand == 2) {
            $profile_pic = "assets/images/profile_pics/defaults/binary.jpg";

        } else if ($rand == 3) {
            $profile_pic = "assets/images/profile_pics/defaults/queen.jpg";
        } else if ($rand == 4) {
            $profile_pic = "assets/images/profile_pics/defaults/woman.jpg";
        } else if ($rand == 5) {
            $profile_pic = "assets/images/profile_pics/defaults/social-media.jpg";
        }

        $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0','0', 'no', ',', '', '$country', '$current_city', '0', '0', '$birthday', 'no', '', '')");
        $successMessages.= "<span style='color: #14C800;'>You're all set! You can now login!</span><br>";
        //clear session variables
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }
}

?>
