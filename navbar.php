
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    img{
  background-attachment: fixed;
    }
    @media screen and (max-width:576px){
      .navbar{
      width: 120% !important;
    }

    }
    .navbar{
      background-color: #00478D;
      color:#fff;
    }
    .navbar ul li a{
      color:#fff;
  
    }
   
.power:hover {
    /* Hover effect */
    transform: scale(1.2); /* Scale the element */
}

@media (min-width: 992px) and (max-width: 1199.98px) { 
  /* .power-btn{
   font-size: xx-large !important;
 } */
  .profile{
    margin-left: -50% !important;
  }

}
  </style>
   <script>
    // JavaScript function to redirect to the cart page
    function goToCart() {
      window.location.href = 'cart_product_list.php';
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Add click event listeners to the cart elements
      document.getElementById('cartHeader').addEventListener('click', goToCart);
      document.getElementById('cartImage').addEventListener('click', goToCart);
    });
  </script>
</head>
<body>
  <?php
function animation() {
  echo '
  <style>
    @keyframes animate {
     
    }
    .animated-img {
      animation: animate 1s linear infinite;
    }
      .animated-img:hover{
    transform: scale(1.2); /* Scale the element */
      
      }
  </style>
<h6 style="color:#fff;display:inline; href="cart_product_list.php" id="cartHeader">Cart</h6>
  <img src="add-to-cart.png" id="cartImage" height="33vh" class="animated-img" style="filter:invert(500);font-size:larger;">
 ';
}


?>
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid" style="height:5%;">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
         <a class="" href="cart_product_list.php"><img src="images/logo.png" alt="" height="60"></a>
        </li>
        <li class="nav-item my-2">
          <!-- <a class="nav-link active text-white" aria-current="page" href="send_otp.php">Home</a> -->
        </li>
        <!-- <li class="nav-item my-2">
          <a class="nav-link text-white" href="#">Link</a>
        </li>
        <li class="nav-item dropdown my-2">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a> -->
          <ul class="dropdown-menu my-2" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item text-white"  href="#">Action</a></li>
            <li><a class="dropdown-item text-white" href="#">Another action</a></li>
            <li><hr class="dropdown-divider text-white"></li>
            <li><a class="dropdown-item text-white" href="#">Something else here</a></li>
          </ul>
        </li>
        <!-- <li class="nav-item my-2">
          <a class="nav-link disabled text-white" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li> -->
        <form class="d-flex col-12 my-2">
        <input class="form-control me-2" type="search" id="searchInput" placeholder="Search here" aria-label="Search" style="height: 6vh;">
        <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
      </form>
    
      </ul>        
     <div class="d-flex mx-5 align-items-center profile">
      <div>
      <a data-bs-toggle="modal" href="#cartModal">
      <?php
//  session_start();
// Store image URLs in session

?>
   <!-- <i class="fa-solid fa-cart-shopping mx-5" style="font-size:x-large;"> -->
   <?php animation() ?><span class="text-white" style="font-size: larger;" id="cart"> <?php echo '<span class="">'.$count.'</span>'; ?></span></i>
      </a>
      </div>
      <!-- <p style="font-size: larger;">Cart</p> -->
      <span class="mx-5"> <?php echo isset($_SESSION['name']) ?' <img src="images/profile.png" height="33vh" class="mx-2">' . $_SESSION['name'] : '<i class="fa-solid fa-circle-user"  style="font-size:x-large;"></i>' .'Log in'; ?></span>
     <a href="send_otp.php" class="power-btn"><img src="images/power.png" alt="" class="mx-3 power" height="35vh"></a> 
      </div>
    </div>
  </div>
</nav>

</body>
</html>