<?php
session_start();

if (isset($_POST['imageUrl'])) {
    $imageUrl = $_POST['imageUrl'];

    // Fetch the image from the URL
    $ch = curl_init($imageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $imageData = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($imageData === false || $http_code != 200) {
        die('Error fetching the image.');
    }

    // Get the content type of the image
    $contentType = false;
    if (class_exists('finfo')) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $contentType = $finfo->buffer($imageData);
    }
    if (!$contentType && function_exists('mime_content_type')) {
        $contentType = mime_content_type($imageUrl);
    }
    if (!$contentType) {
        $contentType = 'application/octet-stream'; // Default to binary stream if content type cannot be determined
    }

    // Extract the filename from the URL
    $filename = basename(parse_url($imageUrl, PHP_URL_PATH));

    // Set headers to force download
    header("Content-Type: $contentType");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . strlen($imageData));

    // Output the image data
    echo $imageData;
    exit;
} else {
    die('No image URL specified.');
}
?>
