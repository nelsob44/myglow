<?php 
include("includes/header.php");
?>


<?php


if($_POST) {
    $number = $_POST['number'];
    $selected_choice = $_POST['choice'];
    
    $next = $number+1;
    
    $total_query = mysqli_query($con, "SELECT * FROM questions");
    $total = mysqli_num_rows($total_query);
    
    $query = mysqli_query($con, "SELECT * FROM choices WHERE question_number=$number AND is_correct=1");
    $row = mysqli_fetch_array($query);
    
    $correct_choice = $row['id'];
    
    if($correct_choice == $selected_choice) {
        
        $score_query = mysqli_query($con, "SELECT * FROM quiz_record where username='$userLoggedIn'");
        $result = mysqli_fetch_array($score_query);
        $quiz_score = $result['quiz_score'];
        
        $quiz_score++;
        $date_added = date("Y-m-d H:i:s");
        $update = mysqli_query($con, "UPDATE quiz_record SET quiz_score='$quiz_score' WHERE username='$userLoggedIn'");
        $update_time = mysqli_query($con, "UPDATE quiz_record SET date_added='$date_added' WHERE username='$userLoggedIn'");
    
    }
    
    if($number == $total) {
        
        
        header("Location: final.php");
        exit();
    } else {
        header("Location: question.php?n=".$next);
    }
}

?>