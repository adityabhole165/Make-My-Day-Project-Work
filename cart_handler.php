 <?php
    session_start();
    $_SESSION['imageUrls'] = $imageUrls;

if (isset($_POST['add_cart'])) {

    $menuid = $_POST['menu_id'];
    $hotelid=$_POST['hotel_id'];
    $sectionid=$_POST['section_id'];
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
    $date=$_POST['date'];


    // $curr_date = isset($date) ? $date : date('d-m-Y');
    // $fetch_api = 'http://52.66.71.147/mmd/get_item_details.php?menu_id=' . $menuid . '&hotel_id=' . $hotelid . '&section_id=' . $sectionid . '&check_date=' . $curr_date;
    //Fetch API
    $run_fetch_api = curl_init();
    curl_setopt($run_fetch_api, CURLOPT_URL, $fetch_api);
    curl_setopt($run_fetch_api, CURLOPT_POST, true);
    curl_setopt($run_fetch_api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($run_fetch_api, CURLOPT_SSL_VERIFYPEER, false);
    $fetch_res = curl_exec($run_fetch_api);
    $output = json_decode($fetch_res, true);

    $check_menu_sold = $output['result'][0]['menu_sold'];
    // Validate quantity
    if ($quantity <= 0) {
        echo '<script>alert("Please enter the correct quantity.");</script>';
        exit; // Stop further execution
    }
    

    // Check if the menu_id already exists in m_booking
    $fetch_cart_list = "SELECT COUNT(*) as count FROM m_booking WHERE menu_id = '$menuid' AND mob='$_SESSION[mobile]'";
    $run_fetch_cart_list = mysqli_query($con, $fetch_cart_list);
    $row = mysqli_fetch_assoc($run_fetch_cart_list);

    if ($row['count'] > 0) {
        // If menu_id already exists, show alert
        // echo "<script>alert('Menu ID $menuid has already been booked.');</script>";
$sql="UPDATE m_booking SET 
                        menu_id='$menuid',
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
                    WHERE menu_id=" .$menuid."";
$run_sql=mysqli_query($con,$sql);
// echo $sql;
if($run_sql){
echo '<script>alert("Record successfully added")</script>';
}


    } else if($check_menu_sold == 0) {
        // If menu_id does not exist, insert the new record
        $sql = "INSERT INTO m_booking(`menu_id`, `menu_code`, `menu_name`, `quantity`, `rate`, `discount`, `subtotal`, `final_discount`, `total`, `advance_amt`, `MRP`, `menu_sold`, `active`, `mob`, `booking_date`)
                VALUES ('$menuid','$menu_code', '$menuname', '$quantity', '$rate', '$discount', '$subtotal', '$final_discount', '$total', '$advance_amt', '$MRP', '$menu_sold', '$active', '$_SESSION[mobile]','$date')";

        $run_sql = mysqli_query($con, $sql);
 
        if ($run_sql) {
           //echo "<script>alert('Booking added successfully');</script>"; 
        } else {
            //echo "<script>alert('Failed to add booking.');</script>";
        }
    } else{
        echo '<script>alert("already sold out..");</script>';
    }
   
} elseif (isset($_POST['update_cart'])) {
    $menuid1 = $_POST['menu_id1'];
    $hotelid1 =$_POST['hotel_id1'];
    $sectionid1 =$_POST['section_id1'];
    $menuname1 = $_POST['menu_name1'];
    $quantity1 = $_POST['quantity1'];
    $rate1 = $_POST['rate1'];
    $menu_code1 = $_POST['menu_code1'];
    $discount1 = $_POST['discount1'];
    $subtotal1 = $quantity1 * $rate1;
    $final_discount1 = $quantity1 * $discount1;
    $total1 = $subtotal1 - $final_discount1;
    $advance_amt1 = $_POST['advance_amt1'];
    $MRP1 = $_POST['MRP1'];
    $menu_sold1 = $_POST['menu_sold1'];
    $active1 = $_POST['active1'];
    $date=$_POST['date'];


    $curr_date = isset($date) ? $date : date('d-m-Y');
    $fetch_api = 'http://52.66.71.147/mmd/get_item_details.php?menu_id=' . $menuid1 . '&hotel_id=' . $hotelid1 . '&section_id=' . $sectionid1 . '&check_date=' . $curr_date;
    //Fetch API
    $run_fetch_api = curl_init();
    curl_setopt($run_fetch_api, CURLOPT_URL, $fetch_api);
    curl_setopt($run_fetch_api, CURLOPT_POST, true);
    curl_setopt($run_fetch_api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($run_fetch_api, CURLOPT_SSL_VERIFYPEER, false);
    $fetch_res = curl_exec($run_fetch_api);
    $output = json_decode($fetch_res, true);

    $check_menu_sold = $output['result'][0]['menu_sold'];

    // Validate quantity
    if ($quantity1 <= 0) {
        echo '<script>alert("Please enter the quantity.");</script>';
        exit; // Stop further execution
    }

    if($check_menu_sold==0){
    // Update the existing record
    $update_query = "UPDATE m_booking SET 
                        menu_code='$menu_code1', 
                        menu_name='$menuname1', 
                        quantity='$quantity1', 
                        rate='$rate1', 
                        advance_amt='$advance_amt1', 
                        MRP='$MRP1', 
                        subtotal='$subtotal1', 
                        final_discount='$final_discount1', 
                        total='$total1', 
                        active='$active1', 
                        menu_sold='$menu_sold1',
                        booking_date='$date'
                        WHERE menu_id=".$_GET['c'];

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        echo "<script>alert('Booking Successfully Updated.');</script>";
        } else {
        echo "<script>alert('Booking Not Updated.');</script>";
    }
} else{
    echo "<script>alert('Already sold out..');</script>";
}
}
?>