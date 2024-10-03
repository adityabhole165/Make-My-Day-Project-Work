<?php
include('connection.php');
$sql="DELETE FROM m_booking WHERE menu_id=".$_GET['c'];
$run_sql=mysqli_query($con,$sql);
// echo $sql;
if($run_sql){
    echo '<script>alert("Menu Item Successfully Removed..")</script>';
    echo '<script>location.replace("cart_product_list.php");</script>';
} else{
    echo '<script>alert("An Error Occurred..");</script>';
}


?>