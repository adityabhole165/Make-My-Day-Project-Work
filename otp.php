<?php
if(isset($_POST['submit'])){

$Authkey='359180AQrwQK5INrDt607e889fP1';
$customer_phone='918605274923';
 $ebill_msg="Dear User, Welcome to the MMD(Make My Day). Use below OTP No. ".$_SESSION['otp']." to verify your mobile number - Vision by XPRESSHOTELERP";
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

        ?>

        <form action="" method="POST">
  <input type="number">
  <button type="submit" name="submit">send otp</button>
        </form>