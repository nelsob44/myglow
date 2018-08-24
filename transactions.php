<?php

require 'start.php';

?>
<!DOCTYPE html>
<div class="center_wrap_search">
    <?php if($user['member'] == "1"): ?>
    <p>You are a member</p>
    <?php else: ?>
    <p>You are not a member. <a href="member/payment.php">Become a member</a></p>
    <?php endif; ?>
</div>
