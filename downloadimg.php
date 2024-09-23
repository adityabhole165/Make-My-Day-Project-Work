<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Images</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container text-center my-5">
    <img src="../images/verify_login_img.jpg" alt="" height="600px">
</div>

<div class="container my-5 col-lg-12">
    <div class="row">
        <?php if (isset($res['result'])): ?>
            <?php foreach ($res['result'] as $index => $result): 
                $subCat = $result["SubCategory"];
                $imageId = 'image' . ($index + 1);  // Use a unique identifier
            ?>
            <div class="col">
                <div class="card my-3">
                    <h4 style="background-color: gray; text-align: center; color: #fff;"><?php echo $subCat ?></h4>
                    <h5 class="text-center" style="color:#76448A ;">Activity: <?php echo $result['MenuName'] ?></h5>
                    <h5 class="text-center text-danger">Code: <?php echo $result['MenuCode'] ?></h5>
                </div>
                <div class="card" style="margin-top: -5%;" id="convert_pdf">
                    <a data-bs-toggle="modal" href="#modal-<?php echo $index; ?>" class="text-center">
                        <img src="proxy.php?id=<?php echo $imageId ?>" alt="" height="550px" id="main_img" onerror="this.src = 'img_not_found1.jpg';">
                    </a>
                    <div class="modal fade" id="modal-<?php echo $index; ?>" tabindex="-1">
                        <div class="modal-dialog custom-modal-width">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo $subCat ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <img src="proxy.php?id=<?php echo $imageId ?>" alt="" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container mx-3 my-3  d-flex justify-content-center gap-3">
                        <a href="proxy.php?id=<?php echo $imageId ?>" class="btn btn-primary">View</a>
                        <form action="down.php" method="post">
                            <input type="hidden" name="imageUrl" value="<?php echo $result['ImageUrl']; ?>">
                            <button type="submit" class="btn btn-primary">Download Image</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col">
                <div class="alert alert-danger">No results found or an error occurred.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
