<?php
error_reporting(0);
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
    $userOtp = $_POST['otp'];
    $serverOtp = $_SESSION['otp'];
    $otpTime = $_SESSION['otp_time'];
    $_SESSION['stored_otp'] = $userOtp;

    if (time() - $otpTime > 300) { // OTP expires after 5 minutes
        $message = "OTP expired.";
    } elseif ($userOtp == $serverOtp) {
        $message = "OTP is valid.";
        // Clear OTP from session after validation to prevent replay attacks
        unset($_SESSION['otp'], $_SESSION['otp_time']);

        $url_validate_otp = "http://52.66.71.147/mmd/verify_mob.php?MobileNumber=" . $_SESSION['mobile'] . "&OTP=" . $serverOtp;
        
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, $url_validate_otp);
        curl_setopt($ch3, CURLOPT_POST, true);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch3);
        curl_close($ch3);

        echo '<script>window.location.href = "validate_otp2.php";</script>';
    } else {
        showInvalidOtpModal();
    }
} else {
    showOtpRequiredModal();
}

function showInvalidOtpModal() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Invalid OTP</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#myModal").modal('show');

                // Set a flag to determine if the click is inside the modal
                var isClickInsideModal = false;

                // When the modal is shown, add an event listener to track clicks inside the modal
                $('#myModal').on('mousedown', function() {
                    isClickInsideModal = true;
                });

                // When the modal is hidden, reset the flag
                $('#myModal').on('hidden.bs.modal', function() {
                    isClickInsideModal = false;
                });

                // Add a click event listener to the document
                $(document).mousedown(function(event) {
                    if (!$(event.target).closest('#myModal').length && !isClickInsideModal) {
                        // Redirect when clicking outside the modal
                        window.location.href = 'send_otp.php';
                    }
                });
            });

            function myfunc() {
                window.location.href = 'enter_otp.php';
            }
        </script>
    </head>
    <body>
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" onclick="myfunc()">&times;</button>
                    </div>
                    <div class="modal-body text-danger text-center">
                        <h4>Invalid OTP</h4>
                    </div>
                    <a href="enter_otp.php"><button class="btn btn-primary col-lg-12">Try again</button></a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}

function showOtpRequiredModal() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>OTP Required</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#myModal").modal('show');

                // Set a flag to determine if the click is inside the modal
                var isClickInsideModal = false;

                // When the modal is shown, add an event listener to track clicks inside the modal
                $('#myModal').on('mousedown', function() {
                    isClickInsideModal = true;
                });

                // When the modal is hidden, reset the flag
                $('#myModal').on('hidden.bs.modal', function() {
                    isClickInsideModal = false;
                });

                // Add a click event listener to the document
                $(document).mousedown(function(event) {
                    if (!$(event.target).closest('#myModal').length && !isClickInsideModal) {
                        // Redirect when clicking outside the modal
                        window.location.href = 'send_otp.php';
                    }
                });
            });

            function myfunc() {
                window.location.href = 'send_otp.php';
            }
        </script>
    </head>
    <body>
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" onclick="myfunc()">&times;</button>
                    </div>
                    <div class="modal-body text-danger text-center">
                        <h4>OTP is Required..!</h4>
                    </div>
                    <a href="send_otp.php"><button class="btn btn-primary col-lg-12">Try again</button></a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
