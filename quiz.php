<?php
include("includes/header.php");

//get the total number of questions
$query = mysqli_query($con, "SELECT * FROM questions");
$total = mysqli_num_rows($query);

define("admin", "abigail_oba");


if($userLoggedIn == admin) {
    $add_button = "<a href='add.php'><button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>A</button></a>";
}else {
    $add_button = "";
}

if($userLoggedIn == admin) {
    $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='delete_quiz'>D</button>";
}else {
    $delete_button = "";
}
                    


?>
<header class="container" style="margin-top:60px; text-align:center;">
    <div><h4>Quizzer</h4>
    </div>
</header>

<div class="center_wrap_search">
    <h5>Test Your Knowledge</h5>
    <p>This is a multiple choice quiz to test your knowledge</p>
    <ul>
        <li><strong>Number of Questions: </strong><?php echo $total; ?></li><br>
        <li><strong>Type: </strong>Multiple Choice</li><br>
        <li><strong>Estimated Time: </strong><?php echo $total * 0.5; ?> Minute(s)</li>
        
    </ul>
    <h5><a href="question.php?n=1" class="start">Start Quiz</a></h5><br>
    <h5><a href="quiz_result.php" class="start">View Quiz Results</a></h5>
    <h5><?php echo $add_button; ?>&nbsp;&nbsp;<?php echo $delete_button; ?></h5>
    
    <script>
    
        $(document).ready(function() {

            $('#delete_quiz').on('click', function(){
                bootbox.confirm("Are you sure you want to delete the last quiz record?", function(result) {
                    $.post("includes/form_handlers/delete_quiz_questions.php",
                        {result:result});
                    if(result)
                        location.reload();
              });
            });
        });
    
    </script>
    

</div>
</div>
</body>
</html>