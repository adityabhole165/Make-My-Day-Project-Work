<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'mmd');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve updated values from the form
$menu_id = $_POST['menu_id'];
$quantity = $_POST['quantity'];

// Update query
$update_query = "UPDATE m_booking SET quantity = '$quantity' WHERE menu_id = '$menu_id' AND mob = '$_SESSION[mobile]'";

if (mysqli_query($con, $update_query)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($con);
}

// Redirect back to the cart product list
header("Location: cart_product_list.php");
exit();
?>
