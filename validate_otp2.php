<?php
error_reporting(0);
ini_set('session.gc_maxlifetime', 300);
session_set_cookie_params(300);
include('include_db.php');
session_start();
if (!empty($_SESSION['stored_otp']) && !empty($_SESSION['hotel_id'])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OTP Validation</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.5/jspdf.plugin.autotable.min.js"></script>
        <script src="js/jsPDF/dist/jspdf.umd.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


        <style>
  .mobileTable{
display: none !important;

}


            /* Extra small devices (phones) */
            

            @media (max-width: 576px) {

               /* *{
                overflow-x:  hidden !important;
               } */
             .mobileTable{
                display: block !important;
               }

               #mytable{
                display: none !important;
               } 
                .modal-dialog {
                    max-width: 100%;
                }

                .mod-table {
                    font-size: 10px;
                    /* Further reduce font size for extra small screens */
                }

                .mod-table th,
                .mod-table td {
                    padding: 2px;
                    /* Further reduce padding for extra small screens */
                }

                .modal-body {
                    overflow-x: auto;
                    /* Add horizontal scroll if needed */
                   /* display: block !important; */
                }

                .card img {
                    height: 500px !important;
                }

                .phone-call {
                    position: fixed;
                    left: 75% !important;
                }

                #mainImg {
                    width: 150%;
                }

            
                .modal-content {
                    width: 100% !important;
                }

                #searchInput {
                    width: 125% !important;
                }

                .cardimg {
                    width: 125%;
                }

                .animation {
                    margin-left: -55% !important;
                     
                     /* display: none !important; */

                }

                .fields .mx-5 {
                    margin-left: 30px !important;
                    margin-right: 30px !important;
                }

                .mod {
                    max-width: 100% !important;
                }

                .mod-body {
                    max-width: 100% !important;

                }

                .container-btn {
                    /* height: 6vh !important; */
                    text-wrap: nowrap !important;

                }

                .table-responsive {
                    width: 100% !important;
                }

                /* .mobtd{
                    
                        display: none !important;
                   
                }
                .sr{
                    width: 50px !important;
                } */
         
            }

           
        
            @media (min-width: 576px) and (max-width: 767.98px) {
                /* CSS rules */

                /* .cardimg {
                    margin: 0 auto !important;
                } */

            }

            /* Medium devices (tablets) */
            @media (min-width: 768px) and (max-width: 991.98px) {

                /* CSS rules */
                .cardimg {
                    margin: 0 auto !important;
                }

                .modal-dialog {
                    max-width: 90%;
                }

                .mod-table {
                    font-size: 12px;
                    /* Reduce font size for smaller screens */
                }

                .mod-table th,
                .mod-table td {
                    padding: 4px;
                    /* Reduce padding for smaller screens */
                }

                .modal-body {
                    overflow-x: auto;
                    /* Add horizontal scroll if needed */
                }

                .animation {
                    margin-left: -35% !important;
                }
            }

            /* Large devices (desktops) */
            @media (min-width: 992px) and (max-width: 1199.98px) {

                .go_next .mobileTable{
                display: none !important;
                }

                /* CSS rules */
                .modal-dialog {
                    max-width: 90%;
                }

                .mod-table {
                    font-size: 12px;
                    /* Reduce font size for smaller screens */
                }

                .mod-table th,
                .mod-table td {
                    padding: 4px;
                    /* Reduce padding for smaller screens */
                }

                .modal-body {
                    overflow-x: auto;
                    /* Add horizontal scroll if needed */
                }

                .animation {
                    margin-left: -20% !important;

                }

                /* body{
    background-color: red !important;
} */

            }

            /* Extra large devices (large desktops) */
            @media (min-width: 1200px) {
                /* CSS rules */
                /* body{
        background-color: red !important;
    } */
    .go_next{
                display: flex !important;
            }
            }

            .phone-call {
                position: fixed;
                left: 94%;
                bottom: 5%;
            }

            .add-cart {
                position: fixed;
                left: 1%;
                bottom: 5%;
            }

            .custom-modal-width {
                max-width: 80%;
            }

            /* Default styles for larger screens */
            .mod-table {
                width: 100%;
                border-collapse: collapse;
            }

            .mod-table th,
            .mod-table td {
                padding: 8px;
                text-align: center;
            }

            .modal-confirm {
                color: #636363;
                width: 400px;
            }

            .modal-confirm .modal-content {
                padding: 20px;
                border-radius: 5px;
                border: none;
                text-align: center;
                font-size: 14px;
            }

            .modal-confirm .modal-header {
                border-bottom: none;
                position: relative;
            }

            .modal-confirm h4 {
                text-align: center;
                font-size: 26px;
                margin: 30px 0 -10px;
            }

            .modal-confirm .close {
                position: absolute;
                top: -5px;
                right: -2px;
            }

            .modal-confirm .modal-body {
                color: #999;
            }

            .modal-confirm .modal-footer {
                border: none;
                text-align: center;
                border-radius: 5px;
                font-size: 13px;
                padding: 10px 15px 25px;
            }

            .modal-confirm .modal-footer a {
                color: #999;
            }

            .modal-confirm .icon-box {
                width: 80px;
                height: 80px;
                margin: 0 auto;
                border-radius: 50%;
                z-index: 9;
                text-align: center;
                border: 3px solid #f15e5e;
            }

            .modal-confirm .icon-box i {
                color: #f15e5e;
                font-size: 46px;
                display: inline-block;
                margin-top: 13px;
            }

            .modal-confirm .btn,
            .modal-confirm .btn:active {
                color: #fff;
                border-radius: 4px;
                background: #60c7c1;
                text-decoration: none;
                transition: all 0.4s;
                line-height: normal;
                min-width: 120px;
                border: none;
                min-height: 40px;
                border-radius: 3px;
                margin: 0 5px;
            }

            .modal-confirm .btn-secondary {
                background: #c1c1c1;
            }

            .modal-confirm .btn-secondary:hover,
            .modal-confirm .btn-secondary:focus {
                background: #a8a8a8;
            }

            .modal-confirm .btn-danger {
                background: #f15e5e;
            }

            .modal-confirm .btn-danger:hover,
            .modal-confirm .btn-danger:focus {
                background: #ee3535;
            }

            .trigger-btn {
                display: inline-block;
                margin: 100px auto;
            }

            #delete {
                text-decoration: none;
            }

            .cardimg {
                position: relative;
                width: 100%;
                /* Adjust as needed */
                max-width: 500px;
                /* Adjust as needed */
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0px 15px 15px rgba(0, 0, 0, 0.8);
            }

            .cardimg img {
                width: 100%;
                border-radius: 10px;
            }

            .cardimg img:hover {
                background: #fff;
                box-shadow: 0px 25px 50fpx rgba(0, 0, 0, 0.50);
                -webkit-transition: all 0.2s ease-in;
                -moz-transition: all 0.2s ease-in;
                -ms-transition: all 0.2s ease-in;
                -o-transition: all 0.2s ease-in;
                transition: all 0.2s ease-in; 
                /* margin-top: 50px;*/
            }

         

             /* .cardimg{
    background: #FFFFFF;
 
  -webkit-transition: all 0.2s ease-in;
  -moz-transition: all 0.2s ease-in;
  -ms-transition: all 0.2s ease-in;
  -o-transition: all 0.2s ease-in;
  transition: all 0.2s ease-in;
  box-shadow: 0px 15px 26px rgba(0, 0, 0, 0.50);

} */

.cardimg img:hover{
    background: #FFFFFF;
  
  -webkit-transition: all 0.2s ease-in;
  -moz-transition: all 0.2s ease-in;
  -ms-transition: all 0.2s ease-in;
  -o-transition: all 0.2s ease-in;
  transition: all 0.2s ease-in;
  box-shadow: 0px 15px 26px rgba(0, 0, 0, 0.50);
}
 
        </style>
    </head>
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
           echo "<script>alert('Booking added successfully');</script>"; 
        } else {
            echo "<script>alert('Failed to add booking.');</script>";
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
        echo '<script>location.replace("validate_otp2.php");</script>';
    } else {
        echo "<script>alert('Booking Not Updated.');</script>";
    }
} else{
    echo "<script>alert('Already sold out..');</script>";
}
}
?>


    <div class="col-lg-12 w-100">
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog container mod" style="max-width: 85%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cart Product List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mod-body">
                        <?php
                        $fetch_product_list = "SELECT * FROM m_booking WHERE mob=$_SESSION[mobile]";
                        $run_query = mysqli_query($con, $fetch_product_list);
                        ?>

                        <!-- Add a wrapper div around the table -->
                        
                        <div class="go_next">
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;width:80%">
                                <table class="table table-responsive table-striped mod-table" id="mytable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="sr">Sr No.</th>
                                            <th>Menu Name</th>
                                            <th class="mobtd">Quantity</th>
                                            <th class="mobtd">Rate</th>
                                            <th class="mobtd">Discount</th>
                                            <th class="mobtd">Amount</th>
                                            <th class="mobtd">Advance Amount</th>
                                            <th class="mobtd">Booking Date</th>
                                            <th class="mobtd">Edit Menu</th>
                                            <th class="mobtd">Remove From Cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $subtotal_ = 0;
                                        $discount_ = 0;
                                        $bill_amt_ = 0;
                                        $advance_amt_ = 0;

                                        while ($exe_ = mysqli_fetch_assoc($run_query)) {
                                            $menu_name = $exe_['menu_name'];
                                            $code = $exe_['menu_code'];
                                            $menu_id = $exe_['menu_id'];
                                            $qty = $exe_['quantity'];
                                            $rate = $exe_['rate'];
                                            $discount = $exe_['discount'];
                                            $mrp = $exe_['total'];
                                            $original = $exe_['subtotal'];
                                            $advance = $exe_['advance_amt'];
                                            $booking_date= $exe_['booking_date'];
                                            $final_dis = $exe_['final_discount'];
                                            $total_advance_amt = $advance * $qty;
                                        ?>
                                            <tr class="">
                                                <td><?php echo $i; ?></td>
                                                <td style="width:40%"><?php echo $menu_name;
                                                echo '<p>' . $code .  ' <span> (₹' . $rate . ')</span>' . '</p>'; ?></td>
                                                <td class="text-center mobtd"><?php echo $qty; ?></td>
                                                <td class="text-center mobtd"><?php echo $rate; ?></td>
                                                <td class="text-center mobtd"><?php echo $final_dis; ?></td>
                                                <td class="text-center mobtd"><?php echo $mrp; ?></td>
                                                <td class="text-center mobtd"><?php echo $advance; ?></td>
                                                <td class="text-center mobtd"><?php echo date('d-m-Y', strtotime($booking_date)); ?></td>
                                                <td class="text-center mobtd"><a href="validate_otp2.php?c=<?php echo $menu_id; ?>"><img src="pen.png" alt="" height="40px"></a></td>
                                                <td class="text-center mobtd"><a href="#modalMy" data-bs-toggle="modal"><img src="delete.png" alt="" height="40px"></a></td>
                                            </tr>
                                            
                                       
                                        <?php
                                            $subtotal_ += $original;
                                            $discount_ += $final_dis;
                                            $bill_amt_ += $mrp;
                                            $advance_amt_ += $total_advance_amt;
                                            $i++;
                                        }
                                       
                                        mysqli_data_seek($run_query, 0);

                                        ?>
                                    </tbody>
                                </table>
                                
                            </div>
                           

                            
                        </div>
                  
                        <table class="table mobileTable">
                            <thead>
                                <tr>
                                   <th>
                                    Sr No.
                                    </th>
                                    <th>Menu Name</th>
                                </tr>
                            </thead>
                            <tbody>
                          
                           <?php
                           $i=1;
                           while($exe_ = mysqli_fetch_assoc($run_query)){

                            $menu_name = $exe_['menu_name'];
                          
                            $code = $exe_['menu_code'];
                            $menu_id = $exe_['menu_id'];
                            $qty = $exe_['quantity'];
                            $rate = $exe_['rate'];
                            $discount = $exe_['discount'];
                            $mrp = $exe_['total'];
                            $original = $exe_['subtotal'];
                            $advance = $exe_['advance_amt'];
                            $booking_date= $exe_['booking_date'];
                            $final_dis = $exe_['final_discount'];
                            $total_advance_amt = $advance * $qty;
                           ?>
                            
                                <tr>
                                <td>
                                   <?php echo $i; ?> 

                                </td>
                                <td><?php echo $menu_name; 
                                  echo '<p>' . $code .  ' <span> (₹' . $rate . ')</span>' . '</p>';
                                ?>
                            <div><b>Qty</b> <span><span class="mx-3">|</span><b class="mx-3">Rate</b></span><span><b></b></span></div>
                         
                            <div><?php echo $qty;?><span style="margin-left: 35%;"><?php echo $rate;?></span><span class="mx-2"><?php //echo $discount;?></span></div>
                            
                            <div><b>Amount</b> <span><b>|Booking Date</b></span></div>
                            <div><span class="mx-4"><?php echo $mrp;?></span><span class="mx-2"><?php echo $booking_date;?></span></div>

                            <div> <span><b>Edit</b></span><span class="mx-3">|</span><span><b class="mx-2">Delete</b></span></div>
                            <div><span class="">
                            <a href="validate_otp2.php?c=<?php echo $menu_id; ?>"><img src="pen.png" alt="" height="30px"></a>
                            <a href="#modalMy" data-bs-toggle="modal" style="margin-left: 25%;"><img src="delete.png" alt="" height="30px"></a>
                            </span></div>                           
                            </td>
                                        </tr>
<?php
     $i++;                     
                           }

                            ?>
                            </tbody>
                            </table>

                            <div id="calculation">
                                <div class="card p-3 mx-3 dis-next" style="width:95%">
                                    <h4 class="text-secondary text-center">Price Details</h4>
                                    <hr>
                                    <p class="" style="font-size:large;">Subtotal : <?php echo '<span class="">' . number_format($subtotal_) . '.00 </span>'; ?></p>
                                    <p class="text-success" style="font-size:large;">Discount : <?php echo '- ' . number_format($discount_) . '.00'; ?></p>
                                    <p class="" style="font-size:large;">Bill Amount : <?php echo number_format($bill_amt_) . '.00'; ?></p>
                                    <p class="" style="font-size:large;">Advance Amount : <?php echo number_format($advance_amt_) . '.00'; ?></p>
                                    <hr>
                                    <p class="text-danger" style="font-size:large;">Balance Amount : <?php echo number_format($bill_amt_ - $advance_amt_) . '.00'; ?></p>
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
                    <div class="modal-footer">
                        <!-- Optional footer buttons -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="modalMy" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="material-icons">&#xE5CD;</i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="delete.php?c=<?php echo $menu_id; ?>" class="text-white" id="delete"><button type="button" class="btn btn-danger">Delete</button></a>
                </div>
            </div>
        </div>
    </div>



    <?php
    $_SESSION['imageUrls'] = $imageUrls;
    $select_total_item = "SELECT COUNT(menu_id) as total FROM m_booking WHERE mob=$_SESSION[mobile]";
    $exe_total_item = mysqli_query($con, $select_total_item);
    $fetch = mysqli_fetch_array($exe_total_item);
    $count = $fetch['total'];
    include('navbar.php');

    $hotel_id = $_SESSION['hotel_id'];

    $url = "http://52.66.71.147/mmd/disp_items_web.php?hotel_code=$hotel_id";

    $ch3 = curl_init();
    curl_setopt($ch3, CURLOPT_URL, $url);
    curl_setopt($ch3, CURLOPT_POST, true);
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch3);

    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch3);
        exit;
    }
    curl_close($ch3);

    $res = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON decode error: ' . json_last_error_msg();
        exit;
    }

    $imageUrls = [];
    foreach ($res['result'] as $index => $result) {
        $imageUrls['image' . $index] = $result['ImageUrl'];
    }

    // Store the mapping in the session
    $_SESSION['imageUrls'] = $imageUrls;



    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Download Images</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>

    <body>

        <body>
            <?php
            foreach ($res['hotel_details'] as $h_detail) {
                $h_name = $h_detail['hotel_name'];
            }

            ?>
            <div class="container text-center my-5">
                <h2 class="title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1), 4px 4px 8px rgba(0, 0, 0, 0.1), 6px 6px 12px rgba(0, 0, 0, 0.1);">
                    Make My Day Tours and Travels
                </h2>
                <h5 class="subtitle"> As a trusted partner with your hotel <span style="background-color:darkorchid;color:#fff;"><?php echo $h_name; ?></span></h5>

                <!-- <img src="../images/verify_login_img.jpg" alt="" height="600px"> -->
                <h3 class="text-danger">For 24 * 7 Booking Call On : <a href="tel: +919834396919">9834396919</a> (MMD-Make My Day)</h3>
            </div>

            <div class="container my-5 col-lg-12">
                <!-- Search Bar -->
                <div class="row mb-3">

                    <!-- <div class="col col-lg-8 searchbar" style="margin: 0 auto;">
        <h5><label for="">Seach here:</label></h5>
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
        </div> -->
                </div>


                <div class="row">
                    <?php foreach($res['result'] as $index => $result):
                        $subCat = $result["SubCategory"];
                        if(trim($result['ImageUrl']) == "") {
                            continue;
                        }
                        $imageId = 'image' . $index; // Use the unique identifier
                        $curr_date = isset($date) ? $date : date('d-m-Y');
                        $fetch_api = 'http://52.66.71.147/mmd/get_item_details.php?menu_id=' . $result['MenuID'] . '&hotel_id=' . $result['hotel_id'] . '&section_id=' . $result['section_id'] . '&check_date=' . $curr_date;
                        //Fetch API
                // echo $fetch_api;
                        $run_fetch_api = curl_init();
                        curl_setopt($run_fetch_api, CURLOPT_URL, $fetch_api);
                        curl_setopt($run_fetch_api, CURLOPT_POST, true);
                        curl_setopt($run_fetch_api, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($run_fetch_api, CURLOPT_SSL_VERIFYPEER, false);
                        $fetch_res = curl_exec($run_fetch_api);
                        $output = json_decode($fetch_res, true);
                        curl_close($run_fetch_api);

                    ?>
                        <div class="col-lg-4 card-container-tablet"> <!-- Each card takes 3 columns in a single row -->
                            <div class="card my-3 cardimg shadow p-3 mb-10 bg-white rounded">
                                <h4 style="background-color: gray; text-align: center; color: #fff;"><?php echo $subCat ?></h4>
                                <h5 class="text-center" style="color:#76448A ;">Activity: <?php echo $result['MenuName'] ?></h5>
                                <h5 class="text-center text-danger">Code: <?php echo $result['MenuCode'] ?></h5>
                                <a data-bs-toggle="modal" href="#modal-<?php echo $index; ?>" class="text-center">
                                    <img src="<?php echo "proxy.php?id=$imageId"; ?>" alt="" class="img-fluid" style="max-height: 630px;" id="mainImg" onerror="this.src='img_not_found1.jpg'">
                                </a>
                                <div class="modal fade" id="modal-<?php echo $index; ?>" tabindex="-1">
                                    <div class="modal-dialog custom-modal-width">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo $subCat ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <img src="<?php echo "proxy.php?id=$imageId"; ?>" alt="" style="width: 100%;" id="modalImg">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container my-3 d-flex justify-content-center gap-3 container-btn">
                                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $index; ?>">
                                        Book Now
                                    </button>

                                    <a data-bs-toggle="modal" href="#modal-<?php echo $index; ?>" class="btn btn-primary">View</a>
                                    <form action="down.php" method="post">
                                        <input type="hidden" name="imageUrl" value="<?php echo $result['ImageUrl']; ?>">
                                        <button type="submit" class="btn btn-primary">Download Image</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Book Now -->
                        <div class="modal fade" id="exampleModal-<?php echo $index; ?>" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $index; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel-<?php echo $index; ?>"><?php echo $result['MenuName']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php foreach($output['result'] as $in => $data): ?>
                                                <?php if($data['active'] == 1 && $data['menu_sold'] == 0): ?>
                                                    <div class="d-flex fields">
                                                        <input type="hidden" name="menu_id" value="<?php echo $result['MenuID']; ?>">
                                                        <input type="hidden" name="menu_code" value="<?php echo $result['MenuCode']; ?>">
                                                        <input type="hidden" name="menu_name" value="<?php echo $result['MenuName']; ?>">
                                                        <input type="hidden" name="hotel_id" value="<?php echo $result['hotel_id']; ?>">
                                                        <input type="hidden" name="section_id" value="<?php echo $result['section_id']; ?>">
                                                        <input type="hidden" name="rate" value="<?php echo $data['rate']; ?>">
                                                        <input type="hidden" name="discount" value="<?php echo $data['rate'] - $data['MRP']; ?>">
                                                        <input type="hidden" name="advance_amt" value="<?php echo $data['AdvanceAmt']; ?>">
                                                        <input type="hidden" name="MRP" value="<?php echo $data['MRP']; ?>">
                                                        <input type="hidden" name="menu_sold" value="<?php echo $data['menu_sold']; ?>">
                                                        <input type="hidden" name="active" value="<?php echo $data['active']; ?>">
                                                   
                                                        <input type="number" id="quantity-<?php echo $index . '-' . $in; ?>" name="quantity" placeholder="Quantity" class="form-control col-lg-4">
                                                        <p class="mx-5 text-danger"><b style="font-size: large;">Rate: <?php echo $data["rate"]; ?></b></p>
                                                        <p class="text-success"><b style="font-size: large;">Discount: <span id="advanceAmt-<?php echo $index . '-' . $in; ?>"><?php echo $data['rate'] - $data['MRP'] . '.00'; ?></span></b></p>
                                                    </div>
                                                    <div class="date col-md-5">
                                                        <label for="">Select Date:</label>
                                                        <input type="date" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                    <div class="d-flex">
                                                    
                                                    <div>
                                                        <p class="my-3" style="font-size: larger;">Sub Total: <span id="mrp-<?php echo $index . '-' . $in; ?>"></span></p>
                                                        <p class="my-3" style="font-size: larger;color:green;">Discount: <span id="discount-<?php echo $index . '-' . $in; ?>"></span></p>
                                                        <p><b style="font-size: larger;">Total: <span id="total-<?php echo $index . '-' . $in; ?>"></span></b></p>
                                                    </div>
                                                    
                                                    </div>
                                                    <script>
                                                        document.getElementById('quantity-<?php echo $index . '-' . $in; ?>').addEventListener('input', function() {
                                                            var quantity = document.getElementById('quantity-<?php echo $index . '-' . $in; ?>').value;
                                                            var rate = <?php echo $data["rate"]; ?>;
                                                            var discount = <?php echo $data['rate'] - $data['MRP']; ?>;
                                                            var subdiscount = quantity * discount;
                                                            var subtotal = quantity * rate;
                                                            var total = subtotal - subdiscount;
                                                            document.getElementById('mrp-<?php echo $index . '-' . $in; ?>').innerText = subtotal;
                                                            document.getElementById('total-<?php echo $index . '-' . $in; ?>').innerText = total;
                                                            document.getElementById('discount-<?php echo $index . '-' . $in ?>').innerText = subdiscount;
                                                        });



                                                    // // document.getElementById('date').addEventListener('change', () => {
                                                    // //     // Pass PHP variables to JavaScript
                                                    // //     const isActive = <?php  //echo $data['active']; ?>;
                                                    // //     const menuSold = <?php  //echo $data['menu_sold']; ?>;
                                                    // //     console.log(menuSold);
                                                    // //     if (isActive === 1 && menuSold !== 0) {
                                                    // //         alert("Item is sold");
                                                    //        //location.replace("validate_otp2.php");
                                                    //     }
                                                    // });
                                                    
                                                </script>

                                
                                                <?php elseif($data['active'] == 1 && $data['menu_sold'] != 0): ?>
                                                    <div class="text-center">
                                                        <h4 class="text-danger">This item is sold out..!</h4>
                                                        <img src="sold_out.png" alt="">
                                                                   
                                                   
                                                    </div>
                                                    
                                                <?php else: ?>
                                                    <div>
                                                        <p class="text-danger">This item is not activated..!</p>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <?php 
                                         if($data['active'] == 1 && $data['menu_sold'] != 0){                                         
                                            ?>
                                            <?php
                                         } else{
                                            ?>                                    
                                            <button type="submit" class="btn btn-primary" name="add_cart">Add to cart</button>
                                            <?php
                                         }
                                            ?>
                                        </div>
                                    </form>       
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_GET['c'])) {
                            $fetch_ = "SELECT * FROM m_booking WHERE menu_id= ".$_GET['c']."  AND mob = $_SESSION[mobile] ";
                            $fetch_run = mysqli_query($con, $fetch_);
    
                            $fetch_row_ = mysqli_fetch_array($fetch_run);

                        ?>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $index; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel-<?php echo $index; ?>"><?php echo $fetch_row_['menu_name']; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.replace('validate_otp2.php')"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php foreach($output['result'] as $in => $data): ?>
                                                    
                                            <?php
                                               
                                                if($fetch_row_['active'] == 1 && $fetch_row_['menu_sold'] == 0): ?>
                                                        <div class="d-flex">
                                                            <input type="hidden" name="menu_id1" value="<?php echo $fetch_row_['menu_id']; ?>">
                                                            <input type="hidden" name="hotel_id1" value="<?php echo $result['hotel_id']; ?>">
                                                            <input type="hidden" name="section_id1" value="<?php echo $result['section_id']; ?>">
                                                            <input type="hidden" name="menu_code1" value="<?php echo $fetch_row_['menu_code']; ?>">
                                                            <input type="hidden" name="menu_name1" value="<?php echo $fetch_row_['menu_name']; ?>">
                                                            <input type="hidden" name="rate1" value="<?php echo $fetch_row_['rate']; ?>">
                                                            <input type="hidden" name="discount1" value="<?php echo $fetch_row_['rate'] -$fetch_row_['MRP']; ?>">
                                                            <input type="hidden" name="advance_amt1" value="<?php echo $fetch_row_['advance_amt']; ?>">
                                                            <input type="hidden" name="MRP1" value="<?php echo $fetch_row_['MRP']; ?>">
                                                            <input type="hidden" name="menu_sold1" value="<?php echo $fetch_row_['menu_sold']; ?>">
                                                            <input type="hidden" name="active1" value="<?php echo $fetch_row_['active']; ?>">

                                                            <p>Quantity:<input type="number" id="quantity1-<?php echo $index . '-' . $in; ?>" name="quantity1" placeholder="Quantity" class="form-control col-lg-8" value="<?php echo $fetch_row_['quantity'] ?>"></p>
                                                            <p class="mx-5 text-danger"><b style="font-size: large;">Rate: <?php echo $fetch_row_['rate']; ?></b></p>
                                                            <p class="text-success"><b style="font-size: large;">Discount: <span id="advanceAmt1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?></span></b></p>
                                                        </div>
                                                    <div class="date col-5">
                                                        <label for="">Select Date:</label>
                                                        <input type="date" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                        <div>
                                                            <p class="my-3" style="font-size: larger;">Sub Total: <span id="mrp1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['subtotal']; ?></span></p>
                                                            <p class="my-3" style="font-size: larger;color:green;">Discount: <span id="discount1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['final_discount']; ?></span></p>
                                                            <p><b style="font-size: larger;">Total: <span id="total1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['total']; ?></span></b></p>
                                                        </div>
                                                       
                                                        <script>
                                                            document.getElementById('quantity1-<?php echo $index . '-' . $in; ?>').addEventListener('input', function() {
                                                                var quantity = document.getElementById('quantity1-<?php echo $index . '-' . $in; ?>').value;
                                                                var rate = <?php echo $fetch_row_["rate"]; ?>;
                                                                var discount = <?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?>;
                                                                var subdiscount = quantity * discount;
                                                                var subtotal = quantity * rate;
                                                                var total = subtotal - subdiscount;
                                                                document.getElementById('mrp1-<?php echo $index . '-' . $in; ?>').innerText = subtotal;
                                                                document.getElementById('total1-<?php echo $index . '-' . $in; ?>').innerText = total;
                                                                document.getElementById('discount1-<?php echo $index . '-' . $in ?>').innerText = subdiscount;
                                                            });
                                                        </script>
                                                    <?php elseif($fetch_row_['active'] == 1 && $fetch_row_['menu_sold'] != 0): ?>
                                                        <div>
                                                            <p class="text-danger text-center">This item is sold out..!</p>
                                                        </div>
                                                    <?php else: ?>
                                                        <div>
                                                            <p class="text-danger">This item is not activated..!</p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" name="update_cart">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#exampleModal').modal('show');
                                });
                            </script>

                        <?php
                        }
                        ?>

                    <?php endforeach; ?>

                </div>

                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

                <script>
                    // JavaScript for filtering results based on search input
                    document.getElementById('searchInput').addEventListener('input', function() {
                        var searchQuery = this.value.trim().toLowerCase();
                        var cards = document.querySelectorAll('.card');
                        cards.forEach(function(card) {
                            var cardText = card.textContent.toLowerCase();
                            if (cardText.includes(searchQuery)) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                </script>

                <div class="add-cart">
                    <!-- <a href=""><img src="add-to-cart.png" alt="" height="80px"> <span style="font-size:xx-large;color:red;font-weight:bolder;"> <?php echo $count; ?></span>
</a> -->
                    <!-- <a data-bs-toggle="modal" href="#cartModal" class="text-center">
<img src="add-to-cart.png" alt="" height="80px">
<span style="font-size:xx-large;color:red;font-weight:bolder;"> <?php echo $count; ?></span>
</a> -->
                </div>
                
                <!-- -------------------------------------------------------------------------------------------------------------------- -->
                <div class="container phone-call">
                    <?php include('include_call.php'); ?>

                </div>

                <script>
                    if (window.history.replaceState) {
                        window.history.replaceState(null, null, window.location.href);
                    }
                </script>

            <?php
        } else {
            echo '<script>alert("Sorry, you are not logged in..!"); location.replace("send_otp.php");</script>';
        }
            ?>


        </body>

    </html>