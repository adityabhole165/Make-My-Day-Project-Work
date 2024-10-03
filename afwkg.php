
<!-- version 3 -->
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
    $discount = $_POST['discount'];
    $advance_amt = $_POST['advance_amt'] ?? $_POST['advance_amt1'];
    $MRP = $_POST['MRP'] ?? $_POST['MRP1'];
    $menu_sold = $_POST['menu_sold'] ?? $_POST['menu_sold1'];
    $active = $_POST['active'] ?? $_POST['active1'];
    $date = $_POST['date'] ?? date('d-m-Y');

    // Calculate pricing
    $subtotal = $quantity * $rate;
    $final_discount = $quantity * $discount;
    $total = $subtotal - $final_discount;

    // Fetch menu details from API
    $fetch_api = 'http://52.66.71.147/mmd/get_item_details.php?menu_id=' . $menuid . '&hotel_id=' . $hotelid . '&section_id=' . $sectionid . '&check_date=' . $date;
    $run_fetch_api = curl_init();
    curl_setopt($run_fetch_api, CURLOPT_URL, $fetch_api);
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

    // Insert or update logic
    if (isset($_POST['add_cart'])) {
        $fetch_cart_list = "SELECT COUNT(*) as count FROM m_booking WHERE menu_id = '$menuid' AND mob='$_SESSION[mobile]'";
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
        /* table */  
        .table-responsive {
    overflow-x: auto;
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
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
    height: 30px; /* Set a default height for the images */
    width: 30px; /* Set a default width for the images */
}

tbody tr td:nth-child(1) { /* Adjusted from 2nd to 1st (0-based) */
    font-size: 16px;
    font-weight: bold;
}

/* Laptop and larger view */
@media (min-width: 769px) {
    .table td,
    .table th {
        text-align: center;
        vertical-align: middle;
    }

    /* Set specific widths for each column */
    .table td:nth-child(1), /* Sr. No. */
    .table th:nth-child(1) {
        width: 5%; /* Small width for Sr. No. */
    }

    .table td:nth-child(2), /* Menu Name */
    .table th:nth-child(2) {
        width: 20%;
    }

    .table td:nth-child(3), /* Quantity */
    .table th:nth-child(3) {
        width: 10%;
    }

    .table td:nth-child(4), /* Rate */
    .table th:nth-child(4) {
        width: 10%;
    }

    .table td:nth-child(5), /* Discount */
    .table th:nth-child(5) {
        width: 10%;
    }

    .table td:nth-child(6), /* Amount */
    .table th:nth-child(6) {
        width: 10%;
    }

    .table td:nth-child(7), /* Advance Amount */
    .table th:nth-child(7) {
        width: 10%;
    }

    .table td:nth-child(8), /* Booking Date */
    .table th:nth-child(8) {
        width: 10%;
    }

    .table td:nth-child(9), /* Edit Menu */
    .table th:nth-child(9) {
        width: 10%;
    }

    .table td:nth-child(10), /* Remove From Cart */
    .table th:nth-child(10) {
        width: 5%;
    }

    /* Set a minimum height for table rows */
    tbody tr {
        min-height: 50px;
    }

    /* Combined Quantity and Rate Column */
    .table td.combined {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
}

/* Mobile View */
@media (max-width: 768px) {
    /* Hide thead for mobile */
    .table thead {
        display: none;
    }

    /* Set tr to block for mobile */
    .table tr {
        display: block;
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
    }

    /* Create grid for mobile view */
    .table td {
        display: inline-block;
        width: 50%;
        text-align: left;
        font-size: 13px;
        border: none;
        padding: 10px;
        position: relative;
        min-height: 60px;
        box-sizing: border-box;
    }

    /* Show label for each td for mobile view */
    .table td:before {
        content: attr(data-label);
        font-weight: bold;
        text-align: left;
        margin-right: 10px;
        float: left;
    }

    /* Adjust padding for buttons (edit and delete) */
    .table td img {
        height: 59px;
        width: 59px;
    }

    .table td img[src*="pen.png"] {
        height: auto;
        width: 55px;
    }

    .table td img[src*="delete.png"] {
        height: 55px;
        width: 55px;
    }

    /* Position the Menu Name at the top and span both columns */
    .table td.menu-name {
        width: 100%;
        font-weight: bold;
        font-size: 16px;
        text-align: center;
        display: block;
        margin-bottom: 10px;
    }

    /* Hide specific headers for mobile */
    .table th:nth-child(1), /* Sr. No. */
    .table th:nth-child(6), /* Edit Menu */
    .table th:nth-child(7)  /* Remove From Cart */ {
        display: none;
    }

    /* Hide Sr. No. for mobile view */
    .table td.sr-no {
        display: none;
    }

    /* Adjust layout to stack Quantity above Rate */
    .table td:nth-child(2) {
        width: 100%;
        position: relative;
        display: flex;
        justify-content: space-between;
    }

    /* Hide header for edit and delete buttons for mobile view */
    .table td:nth-child(6),
    .table td:nth-child(7) {
        width: 50%;
        text-align: center;
    }

    /* Adjust the layout for mobile view */
    .table td:nth-child(odd) {
        padding-right: 5px;
    }

    .table td:nth-child(even) {
        padding-left: 5px;
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="col-lg-12 w-100">
        <div class="modal-dialog">
        <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
        <h5 class="modal-title">Cart Product List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalBtn"></button>
    </div>

    <!-- Modal Body -->
    <div class="modal-body">
        <?php
        $fetch_product_list = "SELECT * FROM m_booking WHERE mob=$_SESSION[mobile]";
        $run_query = mysqli_query($con, $fetch_product_list);

        // Initialize variables for calculation
        $subtotal_ = 0;
        $discount_ = 0;
        $bill_amt_ = 0;
        $advance_amt_ = 0;
        ?>

      <!-- Table -->
<div class="table-responsive">
    <table class="table table-striped table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>Sr. No.</th>
                <th>Menu Name</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Discount</th>
                <th>Amount</th>
                <th>Advance Amount</th>
                <th>Booking Date</th>
                <th>Edit Menu</th>
                <th>Remove From</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $mob = $_SESSION['mobile'];
            $query = "SELECT * FROM m_booking WHERE mob='$mob'";
            $result = mysqli_query($con, $query);
            $count = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                $menu_name = $row['menu_name'];
                $menu_id = $row['menu_id'];
                $qty = $row['quantity'];
                $rate = $row['rate'];
                $discount = $row['discount'];
                $mrp = $row['total'];
                $advance = $row['advance_amt'];
                $booking_date = $row['booking_date'];
                $final_dis = $row['final_discount'];
                $total_advance_amt = $advance * $qty;

                // Add to calculations
                $subtotal_ += $row['subtotal'];
                $discount_ += $final_dis;
                $bill_amt_ += $mrp;
                $advance_amt_ += $total_advance_amt;

                // Display rows with data-label attributes for mobile view
                echo "<tr>";
                echo "<td class='sr-no' data-label='Sr. No.'>{$count}</td>";
                echo "<td data-label='Menu Name'>{$menu_name}</td>";
                echo "<td data-label='Quantity'>{$qty}</td>";
                echo "<td data-label='Rate'>{$rate}</td>";
                echo "<td data-label='Discount'>{$discount}</td>";
                echo "<td data-label='Amount'>{$mrp}</td>";
                echo "<td data-label='Advance Amount'>{$advance}</td>";
                echo "<td data-label='Booking Date'>" . date('d-m-Y', strtotime($booking_date)) . "</td>";

                // Edit and delete buttons
                echo "<td data-label='Edit Menu'>
                        <a href='Update.php?menu_id={$menu_id}'>
                            <img src='pen.png' alt='Edit' height='30px' margin-top='10px'>
                        </a>
                      </td>";
                echo "<td data-label='Remove From Cart'>
                        <a href='#modalMy' data-bs-toggle='modal' class='open-delete-modal' data-menu-id='{$menu_id}'>
                            <img src='delete.png' alt='Delete' height='30px' id='del'>
                        </a>
                      </td>";
                echo "</tr>";

                $count++;
            }
            ?>
        </tbody>
    </table>
</div>

        <!-- Calculation Card -->
        <div id="calculation">
    <div class="card p-3 mx-3 dis-next" style="width:95%">
        <h3 class="text-secondary text-center">Price Details</h3>
        <hr>
        <p class="d-flex justify-content-between" style="font-size:large;">
            <span>Subtotal :</span>
            <span><?php echo number_format($subtotal_) . '.00'; ?></span>
        </p>
        <p class="d-flex justify-content-between text-success" style="font-size:large;">
            <span>Discount :</span>
            <span><?php echo  number_format($discount_) . '.00'; ?></span>
        </p>
        <p class="d-flex justify-content-between" style="font-size:large;">
            <span>Bill Amount :</span>
            <span><?php echo number_format($bill_amt_) . '.00'; ?></span>
        </p>
        <p class="d-flex justify-content-between" style="font-size:large;">
            <span>Advance Amount :</span>
            <span><?php echo number_format($advance_amt_) . '.00'; ?></span>
        </p>
        <hr>
        <p class="d-flex justify-content-between text-danger" style="font-size:large;">
            <span>Balance Amount :</span>
            <span><?php echo number_format($bill_amt_ - $advance_amt_) . '.00'; ?></span>
        </p>
        <hr>
        <div class="text-center">
            <button class="btn btn-primary">Proceed to Pay</button>
        </div>
    </div>
</div>


        <?php
        if (mysqli_num_rows($run_query) == 0) {
            echo '<script>document.getElementById("mytable").style.display="none";</script>';
            echo '<script>document.getElementById("calculation").style.display="none";</script>';
            echo '<div class="text-center">';
            echo '<img src="shopping.png" height="300"></img>';
            echo '</div>';
            echo '<h3 class="text-center text-danger">Your cart is empty</h3>';
        }
        ?>
    </div>
</div>

<!-- Modal for confirming deletion -->
</div><div id="modalMy" class="modal fade">
    <div class="modal-dialog modal-confirm">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title w-100">Are you sure?</h4>
        <!-- Close button in the top right corner -->
        <a href="cart_product_list.php">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </a>
    </div>
    <div class="modal-body">
        <p>Do you really want to delete these records? This process cannot be undone.</p>
    </div>
    <div class="modal-footer justify-content-center">
        <!-- Cancel button -->
         <a href="cart_product_list.php">
         <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Cancel</button>
         </a>
        <!-- Delete button with the same size -->
        <!-- <button type="button" class="btn btn-danger btn-lg " id="deleteLink">Delete</button> -->
        <!-- <a href="delete.php?c=<?php //echo $menu_id; ?>" class="btn btn-secondary btn-lg"  id="delete"><button type="button" class="btn btn-danger">Delete</button></a> -->
        <!-- <a href="delete.php?c=<?php //echo $menu_id; ?>" class="btn btn-secondary btn-danger btn-lg" id="deleteLink">Delete</a> -->
        <a href="delete.php?c=<?php echo $menu_id; ?>" class="btn btn-danger btn-lg" id="deleteLink" style="width: 100px;">Delete</a>

    </div>
</div>

    </div>
</div>

<script>
    // JavaScript to handle passing menu_id to delete.php
    /* Hide delete div */
document.getElementById('modalMy').style.display = 'none';
function showCalculation() {
    let calculationDiv = document.getElementById('modalMy');
    calculationDiv.style.display = 'block';  // Show the calculation div
}
</script>
   <script>
    function hideCartModal() {
        // Bootstrap handles modal visibility, we don't need to set display: none manually
        let modalMy = new bootstrap.Modal(document.getElementById('modalMy'));
        modalMy.hide();
    }

    document.addEventListener('DOMContentLoaded', function() {
        let del = document.querySelectorAll('.open-delete-modal');

        if (del) {
            del.forEach(item => {
                item.addEventListener('click', function() {
                    let menuId = this.getAttribute('data-menu-id');
                    let deleteLink = document.getElementById('deleteLink');
                    deleteLink.setAttribute('href', 'delete.php?c=' + menuId);
                    
                    // Show the modal
                    let modalMy = new bootstrap.Modal(document.getElementById('modalMy'));
                    modalMy.show();
                });
            });
        }
    });
</script>


<!-- hide Delete div -->
<script>
/* Hide delete div */
// document.getElementById('modalMy').style.display = 'none';
// function showCalculation() {
//     let calculationDiv = document.getElementById('modalMy');
//     calculationDiv.style.display = 'block';  // Show the calculation div
// }

// function hideCartModal() {
//     let modalDialog = document.querySelector('.modal-dialog');
//     if (modalDialog) {
//         modalDialog.style.display = 'none';
//     }
// }
</script>

    <script>
        // Calculate price details
        function calculateTotal() {
            let subtotal = 0;
            let discount = 0;
            let total = 0;

            const rows = document.querySelectorAll("tbody tr");
            rows.forEach(row => {
                const quantity = parseInt(row.cells[2].textContent);
                const rate = parseFloat(row.cells[3].textContent);
                const discountValue = parseFloat(row.cells[4].textContent);

                subtotal += (quantity * rate);
                discount += (quantity * discountValue);
            });

            total = subtotal - discount;

            document.getElementById("subtotal").textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById("discount").textContent = `$${discount.toFixed(2)}`;
            document.getElementById("total").textContent = `$${total.toFixed(2)}`;
        }

        window.onload = calculateTotal;
    </script>
     

</body>

<script>
    // Use querySelector to select the button by its ID
    document.querySelector('#closeModalBtn').addEventListener('click', function() {
        // Redirect to the validate_otp2.php page
        window.location.href = 'validate_otp2.php';
    });
</script>

<script>
  

</script>
</html>