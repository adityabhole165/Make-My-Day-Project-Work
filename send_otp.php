<?php
session_start();
error_reporting(0);

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999); // 6 digit OTP
}

// Function to send SMS via the Vision360 API
function sendSMS($mobile, $otp) {
    // API credentials and configuration
    $Authkey = '359180AQrwQK5INrDt607e889fP1';
    $customer_phone = '91' . $mobile; // Assuming mobile is a 10-digit number
    $SenderId = "RNSERP";
    $route = 4; // Ensure this is a valid route
    $country_code = 91;
    $TemplateId = '1207169703350434137'; // Ensure this is a valid Template ID

    // OTP message - Make sure the message is exactly as per the DLT template
    $ebill_msg = "Dear User, Welcome to the MMD(Make My Day). Use below OTP No. $otp to verify your mobile number - Vision by XPRESSHOTELERP";

    // Ensure the message length is within limits
    if (strlen($ebill_msg) > 160) {
        return ['success' => false, 'error' => "Message exceeds the maximum length allowed by the API."];
    }

    // API URL for sending the OTP SMS
    $url_ebill = "https://otpsms.vision360solutions.in/api/sendhttp.php?authkey=" . $Authkey 
                . "&mobiles=" . $customer_phone 
                . "&message=" . urlencode($ebill_msg) 
                . "&sender=" . $SenderId 
                . "&route=" . $route 
                . "&country=" . $country_code 
                . "&DLT_TE_ID=" . $TemplateId;

    // Initialize cURL
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $url_ebill);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

    // Execute cURL request
    $sms_response = curl_exec($ch2);

    // Check if there were any cURL errors
    if ($sms_response === false) {
        $error_message = curl_error($ch2);
        curl_close($ch2);
        return ['success' => false, 'error' => "cURL Error: $error_message"];
    }

    // Close cURL
    curl_close($ch2);

    // Log the raw response for debugging
    error_log("Raw SMS API Response: " . htmlspecialchars($sms_response));

    // Check the raw response for common error indications
    if (strpos($sms_response, 'success') !== false) {
        return ['success' => true, 'message' => "OTP successfully sent to $mobile"];
    } else {
        // Return the error message from the API response if available
        return ['success' => false, 'error' => "SMS API Error: " . htmlspecialchars($sms_response)];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mobile']) && isset($_POST['hotel_id']) && isset($_POST['name'])) {
    $mobile = preg_replace('/[^0-9]/', '', $_POST['mobile']); // Sanitize input
    if (strlen($mobile) == 10) { // Check for valid mobile length
        $otp = generateOTP();
        $hotel_code = $_POST['hotel_id'];
        $name = $_POST['name'];
        $_SESSION['name'] = $name;
        $_SESSION['otp'] = $otp;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['otp_time'] = time(); // Store time when OTP was generated
        $_SESSION['hotel_id'] = $hotel_code;

        // Send the OTP via SMS
        $smsStatus = sendSMS($mobile, $otp);
        $_SESSION['message'] = $smsStatus['message'];

        // Check hotel code via API
        $check_hotel_code = "http://52.66.71.147/mmd/check_hotel_code.php?hotel_code=$hotel_code";
        
        $ch4 = curl_init();
        curl_setopt($ch4, CURLOPT_URL, $check_hotel_code);
        curl_setopt($ch4, CURLOPT_POST, true);
        curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false);

        $response1 = curl_exec($ch4);
        curl_close($ch4);
        $result = json_decode($response1, true);
        
        $check = $result['result'][0]['success'];

        if ($check == 1) {
            header("Location: enter_otp.php");
            exit;
        } else {
            echo '<script>alert("Invalid Code");location.replace("send_otp.php");</script>';
        }
    } else {
        $_SESSION['error'] = "Invalid mobile number.";
    }

    // Exit after handling request
    exit;
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
        @media screen and (max-width: 476px) {
            body {
                overflow: hidden;
            }
            .mob-down {
                display: block;
            }
            .mob {
                width: 18% !important;
            }
            #mobile {
                width: 100%;
            }
        }
    </style>
</head>
<body class="py-5 bg-light">
    <div class="col-lg-12">
        <div class="row justify-content-center">
            <div class="col-lg-6">
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
                        <form method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label">Enter Your Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <label for="mobile" class="form-label my-2">Enter 10 Digit Mobile Number:</label>
                                <input type="number" pattern="/^-?\d+\.?\d*$/" id="mobile" class="form-control" name="mobile" onKeyPress="if(this.value.length==10) return false;" required>
                            </div>
                            <div class="my-2">
                                <label for="hotel-id">Enter Hotel Code:</label>
                                <input type="number" class="form-control" name="hotel_id" id="h_id" required>
                            </div>
                            <div class="text-center my-3">
                                <button type="submit" class="btn btn-primary" onclick="return validation()">Send OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validation() {
            let name = document.getElementById('name');
            let mobile = document.getElementById('mobile');
            let hotel_id = document.getElementById('h_id');
            if (name.value == '') {
                alert("Name is Required..!");
                return false;
            }
            if (mobile.value == '') {
                alert("Mobile number is Required..!");
                return false;
            } else if (mobile.value.length != 10) {
                alert("Please enter correct number..!");
                return false;
            }
            if (hotel_id.value == '') {
                alert('Hotel Code is Required..!');
                return false;
            }
        }
    </script>
</body>
</html>
