
<?php
session_start();
error_reporting(0);
// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999); // 6 digit OTP
}

// Dummy function to simulate sending SMS
function sendSMS($mobile,$otp) {
    // Ideally, you should integrate an SMS gateway here
    return "OTP successfully sent to $mobile $otp";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mobile']) && isset($_POST['hotel_id']) && isset($_POST['name'])) {
    $mobile = preg_replace('/[^0-9]/', '', $_POST['mobile']); // Sanitize input
    if (strlen($mobile) == 10) { // Check for valid mobile length
        $otp = generateOTP();
        $hotel_code=$_POST['hotel_id'];
        $name=$_POST['name'];
       $_SESSION['name']=$name;
        $_SESSION['otp'] = $otp;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['otp_time'] = time(); // Store time when OTP was generated
        $_SESSION['hotel_id'] = $hotel_code;

        $smsStatus = sendSMS($mobile, $otp);
        $_SESSION['message'] = $smsStatus;
        // key:359180AQrwQK5INrDt607e889fP1
// sender_id:RNSERP
// rout:4
// country_code:91
// message:
// Dear User, Welcome to the RUCHIRA RESTAURANT. Use below OTP No. 8073 to verify your mobile number - Vision by XPRESSHOTELERP
// template_id:1207169703350434137


$check_hotel_code="http://52.66.71.147/mmd/check_hotel_code.php?hotel_code=$hotel_code";
    
$ch4 = curl_init();
curl_setopt($ch4, CURLOPT_URL, $check_hotel_code);
curl_setopt($ch4, CURLOPT_POST, true);
curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false);

$response1 = curl_exec($ch4);
curl_close($ch4);
$result=json_decode($response1,true);
// print_r($result) ;

$check= $result['result'][0]['success'];
//echo $check;

// if($check==1){
//     header("Location: enter_otp.php");
// }
// else{
//     echo '<script>alert("Invalid Code");location.replace("send_otp.php");</script>';
// }

if($check==1){
    header("Location: enter_otp.php");
    

$Authkey='359180AQrwQK5INrDt607e889fP1';
$customer_phone='91'.$mobile;
 //$ebill_msg="Dear User, Welcome to the MMD(Make My Day). Use below OTP No. ".$_SESSION['otp']." to verify your mobile number - Vision by XPRESSHOTELERP";
$SenderId="RNSERP";
$route=4;
$country_code=91;
$TemplateId='1207169703350434137';

   $url_ebill = "https://otpsms.vision360solutions.in/api/sendhttp.php?authkey=" . $Authkey . "&mobiles=" . $customer_phone . "&message=" . urlencode($ebill_msg) . "&sender=" . $SenderId . "&route=" . $route . "&country=" . $country_code . "&DLT_TE_ID=" . $TemplateId;
        $ch2 = curl_init();
        curl_setopt( $ch2, CURLOPT_URL, $url_ebill );  
        curl_setopt( $ch2, CURLOPT_POST, true );
      //  curl_setopt( $ch2, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt( $ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch2);
        curl_close($ch2);
        // Redirect to the OTP entry page
        exit;
       
}
else{
    echo '<script>alert("Invalid Code");location.replace("send_otp.php");</script>';
}
} else {
        $_SESSION['error'] = "Invalid mobile number.";
    }

    $url_save_record = "http://52.66.71.147/mmd/save_cust_details_web.php?CustomerName=" . urlencode($CustomerName) . "&MobileNumber=" . urlencode($MobileNumber) . "&OTP=" . urlencode($OTP) ."&HotelCode=".urlencode($hotel_Code);

    $ch3 = curl_init();
    curl_setopt($ch3, CURLOPT_URL, $url_save_record);
    curl_setopt($ch3, CURLOPT_POST, true);
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch3);
   
    
    // if ($response === false) {
    //     echo 'cURL error: ' . curl_error($ch3);
    // } else {
    //     echo 'Response: ' . $response;
    // }
    
    curl_close($ch3);


    exit;
  }

    // Redirect to the OTP entry page

    
    // if($_SERVER['REQUEST_METHOD']=='POST'){
    // $CustomerName=$_POST['name'];

    // // $_SESSION['customer_name']=$CustomerName;
 
    // $MobileNumber=$mobile;

    // $_SESSION['mobile']=$MobileNumber;
    // $OTP=$otp;
    // $hotel_Code=$_POST['hotel_id'];
    // $_SESSION['customer_name']=$hotel_Code;

    // // echo $CustomerName;
    // // echo $$MobileNumber;
    // }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Send OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* body{
            overflow: hidden;
        } */
     @media screen and(max-width:476px){
        body{
            overflow: hidden;
        }
        .mob-down{
            display: block;
        }
       .mob{
        /* width: 18% !important; */
        width: 18% !important;
       }
        #mobile{
            width: 100%;
          /* margin-left:4% ; */
        }
     }
    </style>
</head>
<body class="py-5 bg-light">
    <div class="col-lg-12">
        <div class="row justify-content-center">
            <div class="col-lg-6">
            <!-- <div class="col-lg-12"> -->
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <div class="card shadow p-3 mb-5 bg-white rounded">
              
                    <div class="card-header">
                        <div class="img-container text-center">
                        <img src="../logo.png" alt="" height="100px">
                        </div>
                        <p style="font-size:x-large;font-weight:bold;text-align:center;">Welcome To MMD <span class="mob-down">(Make My Day)</span></p>
          
                     
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation"  novalidate>
                            <div class="mb-3">
                            <label for="mobile" class="form-label">Enter Your Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <label for="mobile" class="form-label my-2">Enter 10 Digit Mobile Number:</label>
                             
                            <div class="container" style="padding: 0;margin:0;">
                               <!-- <input type="number" class="form-control col-lg-4" id="mobile" name="mobile" placeholder="" maxlength=10 required > -->
                              
                               <input type="number" pattern="/^-?\d+\.?\d*$/" id="mobile" class="form-control" name="mobile" onKeyPress="if(this.value.length==10) return false;" />

                            </div>
                            <div class=" my-2">
                            <label for="hotel-id">Enter Hotel Code:</label>
                            
                            <input type="number" class="form-control " name="hotel_id" id="h_id" required>
                            </div>
                            <div class="text-center my-3">
                            <button type="submit" class="btn btn-primary" onclick="return validation()">Send OTP</button>
                            </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>

    

    <script>
        function validation(){
   let name=document.getElementById('name');
   let mobile=document.getElementById('mobile');
   let hotel_id=document.getElementById('h_id');
   if(name.value==''){
    alert("Name is Required..!");
    return false;
   }
   if(mobile.value==''){
    alert("Mobile number is Required..!");
    return false;
   }
   else if(mobile.value.length!=10){
    alert("Please enter correct number..!");
    return false;
   } 
   if(hotel_id.value==''){
    alert('Hotel Code is Required..!');
    return false;
   }
        }
    </script>
</body>
</html>
