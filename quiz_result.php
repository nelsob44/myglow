<?php
include("includes/header.php");
$str = "";
$query_rank = mysqli_query($con, "SELECT MAX(quiz_score) as max_score FROM quiz_record");
$max_results = mysqli_fetch_array($query_rank);
$max_score = $max_results['max_score'];

$total_query = mysqli_query($con, "SELECT * FROM questions");
$total = mysqli_num_rows($total_query);

$percentage_score = ($max_score/$total) * 100;

$winner_query = mysqli_query($con, "SELECT * FROM quiz_record WHERE quiz_score='$max_score' ORDER BY date_added LIMIT 1");
$winner_result = mysqli_fetch_array($winner_query);
$top_winner = $winner_result['username'];

$users_results = mysqli_query($con, "SELECT * FROM quiz_record ORDER BY date_added ASC");
if(mysqli_num_rows($users_results) > 0) {
  $counter = 0;
  ?><div class="center_wrap_search" style="margin-top:80px; min-width:500px;">
    <div style="text-align:center;"><p>The maximum score on this quiz is currently:<b> <?php echo $percentage_score; ?>% </b></p>
      <p><b><a href='<?php echo $top_winner; ?>'><?php echo $top_winner; ?></a></b> is currently on the top spot for this quiz.....Let's see who can topple them!</p>
    </div>
    <table align="center">
      <thead>

          <th>Participants</th>
          <th>Quiz Submission Time</th>
          <th>Quiz Score</th>
          <th>Submission Ranking</th>
      </thead>
      <?php
  while($results = mysqli_fetch_array($users_results)) {
    ?> <tr> <?php
    $username = $results['username'];
    $date = $results['date_added'];
    $score = $results['quiz_score'];
    $counter++;


    ?><td><a href='<?php echo $username; ?>'><?php echo $username; ?></a></td>
      <td><?php echo $date; ?></td>
      <td><?php echo $score; ?></td>
      <td><?php echo $counter; ?></td>
    </tr> <?php

  }
  ?> </table></div> <?php
}else {
  echo "<div style='margin-top:100px;'><b><p>Sorry, there are no results to display at this time, please wait till the next quiz is uploaded.</p></b></div>";
}

?>
