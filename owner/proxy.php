<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the image URLs from the session
    $imageUrls = $_SESSION['imageUrls'];

    // Validate the ID
    if (!isset($imageUrls[$id])) {
        die('Invalid ID');
    }

    // Get the actual URL from the mapping
    $url = $imageUrls[$id];

    // Fetch the image from the URL
    $ch = curl_init($url);
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
        $contentType = mime_content_type($url);
    }
    if (!$contentType) {
        $contentType = 'application/octet-stream'; // Default to binary stream if content type cannot be determined
    }

    // Set the appropriate header to display the image
    header("Content-Type: $contentType");
    header("Content-Length: " . strlen($imageData));

    // Output the image data
    echo $imageData;
    exit;
} else {
    die('No ID specified.');
}
?>
