<?php


	if(!empty($_POST["forgot-password"])){
		
		
		$condition = "";
		if(!empty($_POST["user-login-name"])) 
			$condition = " username = '" . $_POST["user-login-name"] . "'";
		if(!empty($_POST["user-email"])) {
			if(!empty($condition)) {
				$condition = " and ";
			}
			$condition = " email = '" . $_POST["user-email"] . "'";
		}
		
		if(!empty($condition)) {
			$condition = " where " . $condition;
		}

		$forgot_query = mysqli_query($con, "SELECT * FROM users " . $condition);
		
		$user_result = mysqli_fetch_array($forgot_query);
        $id = $user_result['id'];
        $firstname = $user_result['first_name'];
        $lastname = $user_result['last_name'];
        $username = $user_result['username'];
        $email = $user_result['email'];
        
        
		
		if(!empty($user_result)) {
			$str = "0123456789qwertyuiopdfgzcv";
            $str = str_shuffle($str);
            $str = substr($str, 0, 22);
            $url = "http://localhost:1234/phpcourse/resetPassword.php?token=$str&email=$email";
            
            mail($email, "Reset password", "To reset your password, please visit this: $url", "From: otheremail@domain.com\r\n" );
            
            $users_token_query = mysqli_query($con, "UPDATE users SET token='$str' WHERE email='$email'");
            echo 'Please check your email';
		} else {
			echo 'No User Found';
		}
	}
?>