<?php
//Include DB configuration file


require '/bootstrap/app.php';

$app->run();

?>
<div class="center_wrap_search">
    <h5>Pay for something.....</h5>

    <form action="checkout.php" method="post">
        <label for="item">
            Product
            <input type="text" name="product">
        </label>    
        <label for="amount">
            Price
            <input type="text" name="price">
        </label> 
        <input type="submit" value="pay">
    
    </form>
    <p>You'll be taken to Paypal to complete your payment....</p>
    
</div>