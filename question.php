<?php
include("includes/header.php");



//get question number
$number = (int)$_GET['n'];
$user_record = mysqli_query($con, "SELECT * FROM quiz_record WHERE username='$userLoggedIn'");
if(mysqli_num_rows($user_record) < 1) {
    $insert_record = mysqli_query($con, "INSERT INTO quiz_record(id, username, quiz_score, date_added) VALUES('', '$userLoggedIn', '', '$date_added')");
}
if($number == 1) {
    $update_score_query = mysqli_query($con, "UPDATE quiz_record SET quiz_score='0' WHERE username='$userLoggedIn'");
}



$total_query = mysqli_query($con, "SELECT * FROM questions");
$total = mysqli_num_rows($total_query);

$quiz_query = mysqli_query($con, "SELECT * FROM questions WHERE question_number='$number'");
$question = mysqli_fetch_array($quiz_query);

//get choices

$quiz_query_choice = mysqli_query($con, "SELECT * FROM choices WHERE question_number='$number'");




?>
<header class="container" style="margin-top:70px;">
    <div><h4>Quizzer</h4>
    </div>
</header>

<div class="center_wrap">
    
    <div class="current">Question<?php echo $question['question_number']; ?> of <?php echo $total; ?></div>
    <p class="question">
        <?php echo $question['text']; ?>
    </p>
    <form method="post" action="process.php">
        <ul class="choices">
            <?php while($choice = $quiz_query_choice->fetch_assoc()) : ?>
                <li><input name="choice" type="radio" value="<?php echo $choice['id']; ?>"><?php echo $choice['text']; ?></li>
            <?php endwhile; ?>
            
            
        </ul>
        <input type="hidden" name="number" value="<?php echo $number; ?>">
        <input type="submit" value="submit">
    </form>

</div>
</div>
</body>
</html>