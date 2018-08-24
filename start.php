<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

include("includes/header.php");

$_SESSION['user_id'] = 1;

$user_id = $_SESSION['user_id'];

require 'vendor/autoload.php';

//API
$api = new APIContext(
    new OAuthTokenCredential(
        'Aa8--em8tJc6UltEYKjmF_lqI2TpfZTVwVVGUUfslXsHlOa_mtbKzJlk8lSj4frT0tGuZ-42HtWv6tFO',
        'EIIz0x_5wLN4jmsCDzHUFyL5y23kL2nGLLyskdxbo2L2M9eaAexxE7oBrHl9Rvi_JTfriUDAy_ly0IiA'
        )
);

$api->setConfig([
    'mode' => 'sandbox',
    'http.ConnectionTimeOut' => 30,
    'log.LogEnabled' => true,
    'log.FileName' => '',
    'log.LogLevel' => 'FINE',
    'validation.level' => 'log'
    
]);
?>