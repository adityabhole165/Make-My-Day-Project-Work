
<?php
$CustomerName = "Satish Dhawale";
$MobileNumber = '9565658569';
$OTP = '147858';

$url_save_record = "http://52.66.71.147/mmd/save_cust_details_web.php?CustomerName=" . urlencode($CustomerName) . "&MobileNumber=" . urlencode($MobileNumber) . "&OTP=" . urlencode($OTP);

$ch3 = curl_init();
curl_setopt($ch3, CURLOPT_URL, $url_save_record);
curl_setopt($ch3, CURLOPT_POST, true);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch3);

if ($response === false) {
    echo 'cURL error: ' . curl_error($ch3);
} else {
    echo 'Response: ' . $response;
}

curl_close($ch3);




    $Authkey='359180AQrwQK5INrDt607e889fP1';
$customer_phone='918605274923';
$ebill_msg="Dear User, Welcome to the MMD(Make My Day). Use below OTP No. 7548 to verify your mobile number - Vision by XPRESSHOTELERP";
$SenderId="RNSERP";
$route=4;
$country_code=91;
$TemplateId='1207169703350434137';

 //$url_ebill = "https://otpsms.vision360solutions.in/api/sendhttp.php?authkey=".$Authkey."&mobiles=".$customer_phone."&message=".urlencode($ebill_msg)."&sender=".$SenderId."&route=".$route."&country=".$country_code."&DLT_TE_ID=".$TemplateId;
        $ch2 = curl_init();
        curl_setopt( $ch2, CURLOPT_URL, $url_ebill );  
        curl_setopt( $ch2, CURLOPT_POST, true );
      //  curl_setopt( $ch2, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt( $ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch2);
        curl_close($ch2);
        // Redirect to the OTP entry page
       
    ?>