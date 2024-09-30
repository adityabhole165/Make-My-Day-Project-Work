<?php
// process_booking.php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'mmd');

if (isset($_POST['add_cart'])) {
    $menuid = $_POST['menu_id'];
    $hotelid = $_POST['hotel_id'];
    $sectionid = $_POST['section_id'];
    $menuname = $_POST['menu_name'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $menu_code = $_POST['menu_code'];
    $discount = $_POST['discount'];
    $subtotal = $quantity * $rate;
    $final_discount = $quantity * $discount;
    $total = $subtotal - $final_discount;
    $advance_amt = $_POST['advance_amt'];
    $MRP = $_POST['MRP'];
    $menu_sold = $_POST['menu_sold'];
    $active = $_POST['active'];
    $date = $_POST['date'];

    // Validate quantity
    if ($quantity <= 0) {
        echo '<script>alert("Please enter the correct quantity."); window.history.back();</script>';
        exit;
    }

    // Check if menu_id already exists in m_booking
    $fetch_cart_list = "SELECT COUNT(*) as count FROM m_booking WHERE menu_id = '$menuid' AND mob = '$_SESSION[mobile]'";
    $run_fetch_cart_list = mysqli_query($con, $fetch_cart_list);
    $row = mysqli_fetch_assoc($run_fetch_cart_list);

    if ($row['count'] > 0) {
        // Update existing record
        $sql = "UPDATE m_booking SET 
                    menu_code='$menu_code', 
                    menu_name='$menuname', 
                    quantity='$quantity', 
                    rate='$rate', 
                    advance_amt='$advance_amt', 
                    MRP='$MRP', 
                    subtotal='$subtotal', 
                    final_discount='$final_discount', 
                    total='$total', 
                    active='$active', 
                    menu_sold='$menu_sold',
                    booking_date='$date'
                WHERE menu_id = '$menuid' AND mob = '$_SESSION[mobile]'";
    } else {
        // Insert new record
        $sql = "INSERT INTO m_booking (menu_id, menu_code, menu_name, quantity, rate, discount, subtotal, final_discount, total, advance_amt, MRP, menu_sold, active, mob, booking_date) 
                VALUES ('$menuid', '$menu_code', '$menuname', '$quantity', '$rate', '$discount', '$subtotal', '$final_discount', '$total', '$advance_amt', '$MRP', '$menu_sold', '$active', '$_SESSION[mobile]', '$date')";
    }

    if (mysqli_query($con, $sql)) {
        echo '<script>alert("Booking processed successfully."); window.location.href = "menu.php";</script>';
    } else {
        echo '<script>alert("Failed to process booking."); window.history.back();</script>';
    }
}
?>
