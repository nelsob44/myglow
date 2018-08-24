<?php
//Include DB configuration file
include("includes/header.php");

//Set useful variables for paypal form
$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypalID = 'nelsob44-facilitator@gmail.com'; //Business Email

?>
<style type="text/css">
    .container{
        margin-top: 100px;
    }
    .list-group-item {
        padding: 5px; 
        border: 0px
    }
</style>

<div class="center_wrap_search">
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="price"><span class="currency">£</span>67</h5>
                </div>
                <div class="card-block">
                    <div class="card-title">
                        Glowstar Plugin

                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">Feature 1</li>
                        <li class="list-group-item">Feature 2</li>
                        <li class="list-group-item">Feature 3</li>
                        <li class="list-group-item">Feature 4</li>
                        <li class="list-group-item">Feature 5</li>

                    </ul>

                </div>

            </div>
        </div>
    </div>
</div>