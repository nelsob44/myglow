<?php
include("includes/header.php");

$score_query = mysqli_query($con, "SELECT * FROM quiz_record WHERE username='$userLoggedIn'");
$quiz_record = mysqli_fetch_array($score_query);
$score = $quiz_record['quiz_score'];
?>
<header class="container">
    <div><h4>Quizzer</h4>
    </div>
</header>

<div class="center_wrap">
    
    <h5>You're Done!</h5>
    <p>Congrats! You have completed the test</p>
    <p>Final Score: <?php echo $score; ?></p>
    <b><a href="question.php?n=1" class="start">Take Again</a></b><br><br>
    <b><a href="quiz_result.php" class="start">See First 200 Quiz Results</a></b>
    
</div>
</div>
</body>
</html>