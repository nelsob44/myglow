<?php
require '../../connection.php';

if(isset($_GET['product_name']))
    $product_name = $_GET['product_name'];

if(isset($_GET['product_id']))
    $product_id = $_GET['product_id'];

if(isset($_GET['price']))
    $price = $_GET['price'];

if(isset($_GET['email']))
    $email = $_GET['email'];


if(isset($_GET['quantity'])) {
    $quantity = $_GET['quantity'];
    $quantity--;
}

$date = date("Y-m-d H:i:s");


$query = mysqli_query($con, "UPDATE products SET quantity_in_stock='$quantity' WHERE id='$product_id'");
$query2 = mysqli_query($con, "UPDATE products SET last_txn_date='$date' WHERE id='$product_id'");
$query3 = mysqli_query($con, "INSERT INTO payments VALUES ('', '$product_id', '$price', '', 'confirmed', '$email', '$date', '$product_name')");


?>
