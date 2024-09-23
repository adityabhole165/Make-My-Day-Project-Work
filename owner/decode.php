<?php
    $check_hotel_code="http://52.66.71.147/mmd/check_hotel_code.php?hotel_code=2255";
    
    $ch4 = curl_init();
    curl_setopt($ch4, CURLOPT_URL, $check_hotel_code);
    curl_setopt($ch4, CURLOPT_POST, true);
    curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false);
    
    $response1 = curl_exec($ch4);
    curl_close($ch4);

    $result=json_decode($response1, true); // Convert JSON string to associative array

    if(isset($result['result'])) {
        // foreach ($result['result'] as $index => $res){
        //     $subCat = $res["success"];
        //     echo $subCat;
            
        //     // Now $success will be true if "success" value is equal to 1
        //     if ($subCat == 1) {
        //         echo " Success is equal to 1.";
        //     } else {
        //         echo " Success is not equal to 1.";
        //     }
        // }
    } else {
        echo "No 'result' key found in the response.";
    }
?>
