<?php
error_reporting(0);
session_start();

if (!empty($_SESSION['hotel_id'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Validation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.5/jspdf.plugin.autotable.min.js"></script>
<script src="js/jsPDF/dist/jspdf.umd.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>


    <style>
        @media screen and (max-width: 476px) {
            body{
                overflow-x:hidden ;
            }
            .card img {
                height: 500px !important;
            }
            .phone-call {
                position: fixed;
                left: 75% !important;
            }
           #mainImg{
          width: 150%;
           }
         /* #modalImg{
            width: 150% !important;
         } */


.modal-content{
    width: 145% !important;
}

            #searchInput{
  width: 125% !important;
     }
     .cardimg{
        width: 130%;
     }
        .title{

        }   
        .subtitle{

        }
        .animation{
            margin-left: -30% !important;
        }
   .vmobile{

   top:-450px !important;
   left:180px !important;
   }
   .code{
    top:-430px !important;
     left:40px !important;
   }

   .imageurl{
    max-width: 150%;
   }    
.ven_des{
    /* top:-400px !important; */
    left:150px !important;
    width: 60% !important;
} 
.pck_des{
    width: 60% !important;
    left:150px;
}

    }
        
      .phone-call {
            position: fixed;
            left: 94%;
            bottom: 5%;
        }
        .custom-modal-width {
            max-width: 80%; /* Adjust this value as needed */
        }
    body{
        overflow-x: hidden;
    }
    .pck_des{
   position: relative;
   left:135px;
   overflow: hidden;
   text-align: justify;
   }
   .ven_des{
    position: relative;
   left:130px;
   overflow: hidden;
    text-align: justify;
   }
   .cardimg {
    padding: 20px;
}

.no-gutters {
    margin-right: 0;
    margin-left: 0;
}

.no-gutters > .col,
.no-gutters > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
}

.text-center img {
    margin-bottom: 15px;
}

.card-body {
    padding: 10px;
}


    </style>  
</head>
<?php
session_start(); // Ensure session is started

$hotel_id = $_SESSION['hotel_id'];

$url = "http://52.66.71.147/mmd/disp_items_owner.php?hotel_code=$hotel_id";

$ch3 = curl_init();
curl_setopt($ch3, CURLOPT_URL, $url);
curl_setopt($ch3, CURLOPT_POST, true);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch3);
if ($response === false) {
    echo 'Curl error: ' . curl_error($ch3);
    exit;
}
curl_close($ch3);

$res = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSON decode error: ' . json_last_error_msg();
    exit;
}

$imageUrls = [];
foreach ($res['result'] as $index => $result) {
    $imageUrls['image' . $index] = $result['ImageUrl'];

}

// Store the mapping in the session
$_SESSION['imageUrls'] = $imageUrls;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Images</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Images</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php 
foreach($res['hotel_details'] as $h_detail){
$h_name=$h_detail['hotel_name'];
}

?>
<div class="container text-center my-5">
<h2 class="title">Make My Day tours and travels</h2>
<h5 class="subtitle"> As a trusted partner with your hotel <span style="background-color:darkorchid;color:#fff;"><?php echo $h_name; ?></span></h5>

    <!-- <img src="verify_login_img.jpg" alt="" height="600px"> -->
    <h3 class="text-danger">For 24 * 7 Booking Call On :      <a href="tel: +919834396919">9834396919</a> (MMD-Make My Day)</h3>

     
</div>

<div class="container my-5 col-lg-12">
    <!-- Search Bar -->
    <div class="row mb-3">
       
        <div class="col col-lg-8 searchbar" style="margin: 0 auto;">
        <h5><label for="">Search here:</label></h5>
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
        </div>
    </div>
    <div class="row">

        <?php foreach ($res['result'] as $index => $result): 
            $subCat = $result["SubCategory"];
            /*if(trim($result['ImageUrl'])==""){
             continue;

            }*/
            $imageId = 'image' . $index; // Use the unique identifier
        ?>
         <!-- Each card takes 3 columns in a single row -->
         <div class="col-lg-4">
    <div class="card my-3 cardimg">
        <div class="row no-gutters">
            <div class="col-md-6 text-center">
                <a data-bs-toggle="modal" href="#modal-<?php echo $index; ?>">
                    <img src="<?php echo "proxy.php?id=$imageId"; ?>" alt="" class="img-fluid" style="max-height: 300px;" id="mainImg" onerror="this.src='img_not_found1.jpg'">
                </a>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-title text-center" style="background-color: gray; color: #fff;"><?php echo $subCat ?></h4>
                    <h5 class="card-title text-center" style="color: #76448A;">Activity: <?php echo $result['MenuName'] ?></h5>
                    <hr>
                    <p><b>Vendor Name:</b> <?php echo $result['VendorName']; ?></p>
                    <p><b>Vendor Mobile:</b> <a href="tel:<?php echo $result['VendorContact'] ?>"><?php echo $result['VendorContact']; ?></a></p>
                    <h5 class="text-danger"><b>Code:</b> <?php echo $result['MenuCode'] ?></h5>
                    <p><b>Vendor Desc:</b> <?php echo $result['VendorDescription']; ?></p>
                    <p><b>Package Desc:</b> <?php echo $result['PackageDescription']; ?></p>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-<?php echo $index; ?>" tabindex="-1">
            <div class="modal-dialog custom-modal-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $subCat ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <img src="<?php echo "proxy.php?id=$imageId"; ?>" alt="" style="width: 100%;" id="modalImg">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container d-flex justify-content-center gap-3 mb-3">
            <a data-bs-toggle="modal" href="#modal-<?php echo $index; ?>" class="btn btn-primary">View</a>
            <form action="down.php" method="post">
                <input type="hidden" name="imageUrl" value="<?php echo $result['ImageUrl']; ?>">
                <button type="submit" class="btn btn-primary">Download Image</button>
            </form>
        </div>
    </div>
</div>


       
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    // JavaScript for filtering results based on search input
    document.getElementById('searchInput').addEventListener('input', function () {
        var searchQuery = this.value.trim().toLowerCase();
        var cards = document.querySelectorAll('.card');
        cards.forEach(function (card) {
            var cardText = card.textContent.toLowerCase();
            if (cardText.includes(searchQuery)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    // JavaScript for filtering results based on search input
    document.getElementById('searchInput').addEventListener('input', function () {
        var searchQuery = this.value.trim().toLowerCase();
        var cards = document.querySelectorAll('.card-container');
        cards.forEach(function (card) {
            var cardText = card.textContent.toLowerCase();
            if (cardText.includes(searchQuery)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>


<?php
// Store image URLs in session
$_SESSION['imageUrls'] = $imageUrls;
?>





<div class="container phone-call">
    <?php //include('include_call.php'); ?>
</div>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<?php
} else {
    echo '<script>alert("Sorry, you are not logged in..!"); location.replace("send_otp.php");</script>';
}
?>

</body>
</html>
