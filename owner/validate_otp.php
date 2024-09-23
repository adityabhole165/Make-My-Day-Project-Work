<?php
error_reporting(0);
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
    $userOtp = $_POST['otp'];
    $serverOtp = $_SESSION['otp'];
    $otpTime = $_SESSION['otp_time'];
$_SESSION['stored_otp']=$userOtp;
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

       



?>

<?php
echo '<script>location.replace("validate_otp2.php");</script>';
}else {
    

    ?>
  <!-- Trigger the modal with a button -->

  <!-- Modal -->
  <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
    function myfunc(){
        location.replace('enter_otp.php');
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
</div>
</body>
</html>
  
  
<?php
//  echo '<script>location.replace("send_otp.php");</script>';
}
} 

else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#myModal").modal('show');
        });
        function myfunc(){
            location.replace('send_otp.php');
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
              
                <a href="send_otp.php"><button class="btn btn-primary col-lg-12" id="replace">Try again</button></a>
         

            </div>
            </div>
        </div>
    </div>
    </body>
    </html>
     <?php 
}
   
?>

<script>
//   const onBackButtonEvent = (e) => {

// e.preventDefault();
// var currentLocation = window.location.pathname;

// history.push(`${currentLocation}/send_otp.php`)};

// useEffect(() => {window.addEventListener('popstate', onBackButtonEvent);return () => {window.removeEventListener('popstate', onBackButtonEvent);

// };}, [])


</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</div>
</body>
</html>
