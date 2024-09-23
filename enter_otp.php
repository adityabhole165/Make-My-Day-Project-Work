<?php session_start();
///session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Enter OTP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Function to start the countdown
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            var end = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = seconds;

                if (--timer < 0) {
                    clearInterval(end);
                    document.getElementById("resendBtn").disabled = false; // Enable the resend button
                    display.textContent = ""; // Clear the countdown text
                }
            }, 1000);
        }

        // Start the countdown when the page loads
        window.onload = function () {
            var sixtySeconds = 59, // Start the countdown at 59 seconds
                display = document.querySelector('#time');
            startTimer(sixtySeconds, display);
        };
    </script>
</head>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
    $userOtp = $_POST['otp'];
    $serverOtp = $_SESSION['otp'];
    $otpTime = $_SESSION['otp_time'];

    if (time() - $otpTime > 300) { // OTP expires after 5 minutes
        $message = "OTP expired.";
    } elseif ($userOtp == $serverOtp) {
        $message = "OTP is valid.";
        // Clear OTP from session after validation to prevent replay attacks
        unset($_SESSION['otp'], $_SESSION['otp_time']);

        $url_validate_otp = "http://52.66.71.147/mmd/verify_mob.php?MobileNumber=" .$_SESSION['mobile'] . "&OTP=" . $serverOtp;
//echo $url_validate_otp;
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, $url_validate_otp);
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


    } else {
        $message = "Invalid OTP.";
    }
} else {
    $message = "OTP is required.";
}


?>


<body class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <?php if (!empty($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>

                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-header">
                        Enter OTP
                    </div>
                    <div class="card-body">
                        <form action="validate_otp.php" method="post" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP:</label>
                                <input type="number" pattern="/^-?\d+\.?\d*$/" class="form-control" id="otp" name="otp"  onKeyPress="if(this.value.length==6) return false;" required>
                            </div>
                            <button type="submit" class="btn btn-primary" onclick="return validation()">Verify OTP</button>
                            <button id="resendBtn" type="button" class="btn btn-link" disabled onclick="window.location='send_otp.php'">
                                Resend OTP (<span id="time">60</span>s)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function validation(){
        let checkOTP=document.getElementById('otp');
        if(checkOTP.value==""){
            alert("Please enter OTP..!");
            return false;
        }
    }
</script>
</body>
</html>
