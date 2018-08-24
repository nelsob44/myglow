<?php
require 'connection.php';
require 'includes/classes/Csrf.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
require 'includes/form_handlers/forgot_password_handler.php';




$csrf = new csrf();
 
// Generate Token Id and Valid
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

?>


<html>
    <head>
        <title>Welcome to Glow</title>
        <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="assets/js/register.js"></script>
    </head>
    <body>
        <div class="wrapper"> 
            <div class='login_box'>
                <div id="errorMessages"><?php if($errorMessages != "") echo $errorMessages; ?></div>
                <div id="successMessages"><?php if($successMessages != "") echo $successMessages; ?></div>
                
                <div class="login_header">
                    <h1>Glow</h1>
                    Login or sign up below!
                
                
                </div>
                
                <div id="first">
                
                    <form action="register.php" method="post">
                    <input type="email" name="log_email" placeholder="Email Address" required>
                    <br>
                    <input type="password" name="log_password" placeholder="Password" required>
                    <br>
                    <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>">
                    <br>
                    <input type="submit" name="login_button" value="Login" class="buttons">
                    <br>
                    <a href="#" id="signup" class="signup">Need an Account? Register here!</a><br>
                    <a href="#" id="forgot_password" class="signup">Forgot Password? Click here!</a>
                       

                </form>
                
                </div>
                
                <div id="second">
                
                    <form action="register.php" method="post">
                    <input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])) {
                        echo $_SESSION['reg_fname'];
                    } ?>" required>
                    <br>

                    <input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])) {
                        echo $_SESSION['reg_lname'];
                    } ?>" required>
                    <br>
                    <input type="email" name="reg_email" placeholder="Email" value="<?php if(isset($_SESSION['reg_email'])) {
                        echo $_SESSION['reg_email'];
                    } ?>"required>
                    <br>
                    <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if(isset($_SESSION['reg_email2'])) {
                        echo $_SESSION['reg_email2'];
                    } ?>" required>
                    <br>
                    <input type="password" name="reg_password" placeholder="Password" required>
                    <br>
                    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
                    <br>
                    
                    <input type="text" name="country" placeholder="Your country" value="<?php if(isset($_SESSION['country'])) {
                        echo $_SESSION['country'];
                    } ?>" ><small><i>optional</i></small>
                    <br>
                    <input type="text" name="current_city" placeholder="City where you live" value="<?php if(isset($_SESSION['current_city'])) {
                        echo $_SESSION['current_city'];
                    } ?>" ><small><i>optional</i></small>
                    <br>
                    
                                        
                    Birthday:<input type="date" name="birthday" placeholder="Your birthday" value="<?php if(isset($_SESSION['birthday'])) {
                        echo $_SESSION['birthday'];
                    } ?>" ><small><i>optional</i></small><br>
                    
                    
                    <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>">
                    <input type="submit" name="register_button" value="Register" class="buttons">
                    <br>
                    <a href="#" id="signin" class="signin">Already have an Account? Sign in here!</a>

                </form>
                
                
                </div>
                
                <div>
                
                    <form action="" method="post" style="display:none;" id="third">
                    <div class="field-group">
                        <div><label for="username">Username</label></div>
                        <div><input type="text" name="user-login-name" id="user-login-name" class="input-field"> Or</div>
                    </div>

                    <div class="field-group">
                        <div><label for="email">Email</label></div>
                        <div><input type="text" name="user-email" id="user-email" class="input-field"></div>
                    </div>

                    <div class="field-group">
                        <div><input type="submit" name="forgot-password" id="forgot-password" value="Submit" class="buttons"></div>
                    </div>	
                       

                </form>
                        <script>
                            $('#forgot_password').click(function() {
                                $('#third').toggle();
                            });
                        
                        </script>
                

                </div>  
            </div>
        </div>
    </body>
</html>