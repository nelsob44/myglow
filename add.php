<?php
include("includes/header.php");

define("admin", "abigail_oba");

if($userLoggedIn !== admin) {
    header("Location: quiz.php");
    exit();
}


if(isset($_POST['submit'])) {
    $question_number = $_POST['question_number'];
    $question_text = $_POST['question_text'];
    $correct_choice = $_POST['correct_choice'];
    $date_added = date("Y-m-d");
    
    $choices = array();
    $choices[1] = $_POST['choice1'];
    $choices[2] = $_POST['choice2'];
    $choices[3] = $_POST['choice3'];
    $choices[4] = $_POST['choice4'];
    $choices[5] = $_POST['choice5'];
    
    $query = mysqli_query($con, "INSERT INTO questions (question_number, text, date_added) VALUES('$question_number', '$question_text', '$date_added')");
    
    //validate insert
    if($query) {
        foreach($choices as $choice => $value) {
            if($value != '') {
                if($correct_choice == $choice) {
                    $is_correct = 1;
                }else {
                    $is_correct = 0;
                }
                //choice query
                $choice_query = mysqli_query($con, "INSERT INTO choices (question_number, is_correct, text) VALUES ('$question_number', '$is_correct', '$value')");

                if($choice_query) {
                    continue;
                }else {
                    die('Error : ('.$mysqli->errno .')'.$mysqli->error);
                }
            }
        }

        $msg = 'Question has been added';
    }
}

$total_query = mysqli_query($con, "SELECT * FROM questions");
$total = mysqli_num_rows($total_query);
$next = $total+1;

?>


<div class="center_wrap_search container-fluid">
    <h5>Add A Question</h5>
    <?php if(isset($msg)) {
        echo '<p><b>'.$msg.'</b></p>';
    }
    ?>
    <div class="quiz_form">
    <form method="post" action="add.php">
        <p>
            <label>Question Number: </label>
            <input type="number" name="question_number" value="<?php echo $next; ?>">
        </p>
        <p>
            <label>Question Text: </label>
            <input type="text" name="question_text">
        </p>
        <p>
            <label>Choice #1: </label>
            <input type="text" name="choice1">
        </p>
        <p>
            <label>Choice #2: </label>
            <input type="text" name="choice2">
        </p>
        <p>
            <label>Choice #3: </label>
            <input type="text" name="choice3">
        </p>
        <p>
            <label>Choice #4: </label>
            <input type="text" name="choice4">
        </p>
        <p>
            <label>Choice #5: </label>
            <input type="text" name="choice5">
        </p>
        <p>
            <label>Correct Choice Number: </label>
            <input type="number" name="correct_choice">
        </p>
        <p>
            <input type="submit" name="submit" value="Submit">
        </p>
    
    </form>
    </div>

</div>
</div>
</body>
</html>