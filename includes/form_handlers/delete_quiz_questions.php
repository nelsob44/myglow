<?php
require '../../connection.php';



if(isset($_POST['result'])) {
    if($_POST['result'] == 'true')
        $query_question = mysqli_query($con, "DELETE FROM questions");
        $query_choices = mysqli_query($con, "DELETE FROM choices");
        $query_records = mysqli_query($con, "DELETE FROM quiz_record ");
                
}

?>
