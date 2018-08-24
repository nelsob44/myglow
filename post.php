<?php
include("includes/header.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
else {
    $id = 0;
}
?>

    <div class="left_wrap">
            <div class='prof_pic'>
                <a href="<?php echo $userLoggedIn; ?>"><img id="prof_pic" src="<?php echo $user['profile_pic']; ?>"></a>
            </div>
            <br>
            <div class="user_details_left">
                <a href="<?php echo $userLoggedIn; ?>">
                    <?php echo $user['first_name']." ".$user['last_name']; ?>
                </a>
                <br>
                <?php echo "Posts: ".$user['num_posts']."<br>";
                echo "Likes: ".$user['num_likes'];
                ?>
                        
            </div>
        
        
        </div>
        
    <div class="center_wrap" id="center_wrap">
        <div class="posts_area">
            <?php
                $post = new Post($con, $userLoggedIn);
                $post->getSinglePost($id);
            ?>
        
        </div>
    
    </div>