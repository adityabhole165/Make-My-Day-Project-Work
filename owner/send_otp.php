<?php
session_start();
error_reporting(0);
// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999); // 6 digit OTP
}

// Dummy function to simulate sending SMS
function sendSMS($mobile) {
    // Ideally, you should integrate an SMS gateway here
    return "OTP successfully sent to $mobile";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&  isset($_POST['hotel_id'])) {
   
        $hotel_code=$_POST['hotel_id'];
        
        $_SESSION['hotel_id'] = $hotel_code;

        

$Authkey='359180AQrwQK5INrDt607e889fP1';
$customer_phone='91'.$mobile;
$ebill_msg="Dear User, Welcome to the MMD(Make My Day). Use below OTP No. ".$_SESSION['otp']." to verify your mobile number - Vision by XPRESSHOTELERP";
$SenderId="RNSERP";
$route=4;
$country_code=91;
$TemplateId='1207169703350434137';




    $hotel_Code=$_POST['hotel_id'];
 


    $url_save_record = "http://52.66.71.147/mmd/save_cust_details_web.php?HotelCode=".urlencode($hotel_Code);

    $ch3 = curl_init();
    curl_setopt($ch3, CURLOPT_URL, $url_save_record);
    curl_setopt($ch3, CURLOPT_POST, true);
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch3);
   
    
 
    
    curl_close($ch3);


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
  
    if($check==1){
        header("Location: validate_otp2.php");
    }
    else{
        echo '<script>alert("Invalid Code");location.replace("send_otp.php");</script>';
    }
   
  

    // Redirect to the OTP entry page
    
    
 
   
}





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

                <div class="card">
              
                    <div class="card-header">
                        <div class="img-container text-center">
                        <img src="logo.png" alt="" height="100px">
                        </div>
                        <p style="font-size:x-large;font-weight:bold;text-align:center;">Welcome To MMD <span class="mob-down">(Make My Day)</span></p>
          
                     
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                          
                            <div class=" my-2">
                            <label for="hotel-id">Enter Hotel Code:</label>
                            
                            <input type="number" class="form-control " name="hotel_id" id="h_id" required>
                            </div>
                            <div class="text-center my-3">
                            <button type="submit" class="btn btn-primary" onclick="return validation()">Submit</button>
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
  
   let hotel_id=document.getElementById('h_id');

   if(hotel_id.value==''){
    alert('Hotel Code is Required..!');
    return false;
   }
   return true;
        }
    </script>
</body>
</html>
