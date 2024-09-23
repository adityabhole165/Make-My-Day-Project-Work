<?php
session_start(); // Ensure session is started

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
}
curl_close($ch3);

$res = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSON decode error: ' . json_last_error_msg();
}
$image=0;
foreach($res['result'] as $index => $result){


$imageUrls = [
    $image => $result['ImageUrl']
    // '' => 'http://52.66.71.147/mmd/Menu_imgs/cropped4513530702510682506.jpg',
    // Add more mappings as needed
];
$image++;
}
?>
