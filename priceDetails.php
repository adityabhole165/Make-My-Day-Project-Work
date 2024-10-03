<?php
session_start();
// $con = mysqli_connect('localhost', 'root', '', 'mmd');
include('connection.php');
if (isset($_POST['add_cart']) || isset($_POST['update_cart'])) {
    $menuid = $_POST['menu_id'] ?? $_POST['menu_id1'];
    $hotelid = $_POST['hotel_id'] ?? $_POST['hotel_id1'];
    $sectionid = $_POST['section_id'] ?? $_POST['section_id1'];
    $menuname = $_POST['menu_name'] ?? $_POST['menu_name1'];
    $quantity = $_POST['quantity'] ?? $_POST['quantity1'];
    $rate = $_POST['rate'] ?? $_POST['rate1'];
    $menu_code = $_POST['menu_code'] ?? $_POST['menu_code1'];
    $discount = $_POST['discount'] ;
    $advance_amt = $_POST['advance_amt'] ?? $_POST['advance_amt1'];
    $MRP = $_POST['MRP'] ?? $_POST['MRP1'];
    $menu_sold = $_POST['menu_sold'] ?? $_POST['menu_sold1'];
    $active = $_POST['active'] ?? $_POST['active1'];
    $date = $_POST['date'];

    // $advance_amt = $advance_amt * $quantity;
    $subtotal = $quantity * $rate;
    $final_discount = $quantity * $discount;
    $total = $subtotal - $final_discount;


    // Fetch API for menu details
    $curr_date = isset($date) ? $date : date('d-m-Y');
    $fetch_api = 'http://52.66.71.147/mmd/get_item_details.php?menu_id=' . $menuid . '&hotel_id=' . $hotelid . '&section_id=' . $sectionid . '&check_date=' . $curr_date;
    $run_fetch_api = curl_init();
    curl_setopt($run_fetch_api, CURLOPT_URL, $fetch_api);
    curl_setopt($run_fetch_api, CURLOPT_POST, true);
    curl_setopt($run_fetch_api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($run_fetch_api, CURLOPT_SSL_VERIFYPEER, false);
    $fetch_res = curl_exec($run_fetch_api);
    $output = json_decode($fetch_res, true);
    $check_menu_sold = $output['result'][0]['menu_sold'] ?? 0;

    // Validate quantity
    if ($quantity <= 0) {
        echo '<script>alert("Please enter a valid quantity.");</script>';
        exit;
    }

    // Handle Insert or Update logic
    if (isset($_POST['add_cart'])) {
        $fetch_cart_list = "SELECT COUNT(*) as count FROM m_booking WHERE menu_id = '$menuid' AND mob='$_SESSION[mobile]'";
        $run_fetch_cart_list = mysqli_query($con, $fetch_cart_list);
        $row = mysqli_fetch_assoc($run_fetch_cart_list);

        if ($row['count'] > 0) {
            // Update the record if it exists
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
                    WHERE menu_id='$menuid' AND mob='$_SESSION[mobile]'";
        } else if ($check_menu_sold == 0) {
            // Insert new record
            $sql = "INSERT INTO m_booking(`menu_id`, `menu_code`, `menu_name`, `quantity`, `rate`, `discount`, `subtotal`, `final_discount`, `total`, `advance_amt`, `MRP`, `menu_sold`, `active`, `mob`, `booking_date`)
                    VALUES ('$menuid', '$menu_code', '$menuname', '$quantity', '$rate', '$discount', '$subtotal', '$final_discount', '$total', '$advance_amt', '$MRP', '$menu_sold', '$active', '$_SESSION[mobile]', '$date')";
        } else {
            echo '<script>alert("Menu already sold out.");</script>';
            exit;
        }

        $run_sql = mysqli_query($con, $sql);
        if ($run_sql) {
            echo "<script>alert('Booking processed successfully.');</script>";
        } else {
            echo "<script>alert('Failed to process booking.');</script>";
        }
    }

    // Update functionality for `update_cart`
    if (isset($_POST['update_cart']) && $check_menu_sold == 0) {
        $update_query = "UPDATE m_booking SET 
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
                        WHERE menu_id='$menuid' AND mob='$_SESSION[mobile]'";
        $update_query_run = mysqli_query($con, $update_query);
        if ($update_query_run) {
            echo "<script>alert('Booking updated successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update booking.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Product List</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
        }

        /* Modal styling */
        .modal-dialog {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .modal-content {
            width: 100%;
            max-width: 1000px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody td img {
            cursor: pointer;
        }

        tbody tr td:nth-child(2) {
            font-size: 16px;
            font-weight: bold;
        }

        /* Price Details Card */
        #calculation {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .card {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card p {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .card .text-success {
            color: green;
        }

        .card .text-danger {
            color: red;
        }

        .btn {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
            }

            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- <div class="col-lg-12 w-100">
        <div class="modal-dialog">
            <div class="modal-content">
             -->
                    <!-- Price Details -->
                    <div id="calculation">
                        <div class="card">
                        <!-- <h4 class="text-secondary text-center">Price Details</h4> -->
                            <p><span>Subtotal:</span><span>₹ <?php echo $subtotal_; ?></span></p>
                            <p><span>Discount:</span><span class="text-danger">₹ <?php 
                                // Calculate total discount based on quantity
                                $total_discount = 0;
                                $fetch_cart_list = "SELECT * FROM m_booking WHERE mob = '$_SESSION[mobile]'";
                                $run_fetch_cart_list = mysqli_query($con, $fetch_cart_list);
                                if (mysqli_num_rows($run_fetch_cart_list) > 0) {
                                    while ($row = mysqli_fetch_assoc($run_fetch_cart_list)) {
                                        // Assuming discount is per item and you want to multiply by quantity
                                        $subtotal_ += $row['subtotal'];
                                        $total_discount_sum += $row['final_discount'];
                                        $advance_amt_ += $row['advance_amt'];
                                        $grand_total =  $subtotal_ - $total_discount_sum - $advance_amt_;

                                        $total_discount += $row['final_discount'] * $row['quantity'];
                                    }
                                }
                                echo $total_discount; // Display total discount
                            ?></span></p>
                            <p><span>Bill:</span><span>₹ <?php echo $bill_amt_; ?></span></p>  
                            <p><span>Advance Amount:</span><span class="text-success">₹ <?php echo $advance_amt_; ?></span></p>
                            <hr>
                            <p><span>Total Bill:</span><span>₹ <?php echo $grand_total; ?></span></p>
                            <button class="btn">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
