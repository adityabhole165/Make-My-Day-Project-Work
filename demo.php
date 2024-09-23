<?php

$con=mysqli_connect('localhost','root','','mmd');

if(isset($_POST['add'])){
$menu_id=$_POST['menuId'];
$menu_name=$_POST['menuName'];
$menu_des=$_POST['desc'];
$menu_rate=$_POST['rate'];
$menu_img=$_POST['img'];
$menu_discount=$_POST['discount'];


$sql="INSERT INTO m_menuitems(MenuId,MenuSubCategoryName,MenuName,MenuImageUrl,Description,Rate,MenuTypeId,Discount)
VALUES('$menu_id','','$menu_name','$menu_img','$menu_des','$menu_rate','','$menu_discount')";
$run=mysqli_query($con,$sql);
// echo $sql;
if($sql){
    echo '<script>alert("Product successfully added in Cart")</script>';
} else{
    echo '<script>alert("Error Occurred")</script>';

}
} 

if(isset($_POST['remove'])){
    $id=$_POST['menuId'];
    $sql="DELETE FROM m_menuitems WHERE MenuId='$id' LIMIT 1";
    $run=mysqli_query($con,$sql);

    if($run){
        echo '<script>alert("Product successfully removed from Cart")</script>';
    } else{
        echo '<script>alert("Error Occurred")</script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



    <title>Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        .category {
            margin: 20px 0;
        }

        .category h2 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            font-size: 16px;
        }

        .menu-item {
            background: #fff;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .menu-item .details {
            flex: 1;
        }

        .menu-item .details h3 {
            margin: 0;
            font-size: 16px;
            margin-left:16%;
            margin-top:-10%;
        }

        .menu-item .details p {
            margin: 5px 0;
            color: #666;
            /* overflow: hidden; */
            font-size: 13px;
            
        }

        .menu-item .details .description {
            /* overflow: hidden; */
            text-overflow: ellipsis;
            max-height: 1.2em; /* to fit one line */
            
        }

        .menu-item .details .view-more, .menu-item .details .view-less {
            color: #9fa2a1;
            cursor: pointer;
            text-decoration: underline;
            display: inline-block;
            margin-top: 5px;
            font-size: 10px;
        }

        .menu-item .details .view-less {
            display: none;
        }

        .menu-item .details .price {
            font-size: 15px;
            font-weight: bold;
        }

        .menu-item .image-add {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .menu-item .image-add img {
            width: 100px;
            height: 100px;
            display: flex;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .menu-item .image-add button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .menu-item .image-add button:hover {
            background-color: #0056b3;
        }
        .veg-switch {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .veg-switch span {
            margin-right: 10px;
            font-weight: bold;
            font-size:10px
        }

        .food-type {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .food-icon {
            width: 15px;
            height: 15px;
            margin-right: 5px;
        }

        .switch {
            margin-left: 10px;
        }

        /* Additional styling for existing elements */
        .veg-switch span {
            margin-right: 10px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 14px;
            background-color: #ccc;
            border-radius: 34px;
            cursor: pointer;
        }

        .slider:before {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            left: -3px;
            bottom: -3px;
            background-color: white;
            border-radius: 50%;
            transition: 0.4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .title-icons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .title-icons .veg-icon {
            width: 20px;
            height: 20px;
            margin: 0 5px;
            border-radius: 50%;
        }
        /* Footer Bar */
.footer-bar {
    position: fixed;
    bottom: 0;
    width: 80%;
    height:3.5%;
    background-color: #2196F3;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 15px 0;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1;
}

.footer-link {
    color: white;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    margin: 0 5px;
    flex-direction: column;
    align-items: center;
    width: 33.33%;
}

.footer-icon {
    width: 24px;
    height: 24px;
    margin-bottom: 5px;
}


.quantity-controls {
    display: flex;
    align-items: center;
    margin-top: 10px;
}


.quantity-section button {
    width: 30px;
    height: 30px;
    margin: 0 10px;
    font-size: 18px;
    border-radius: 5px;
}

.quantity-section .quantity {
    margin: 0 15px;
    font-size: 16px;
    font-weight: bold;
}


.quantity-controls button {
    width: 20px;
    height: 20px;
    background-color: #007bff;
    color: #fff;
    border: 2px;
    cursor: pointer;
    border-radius: 5px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    margin-top: 5px;
}

/* .quantity-controls button {
    width: 30px;
    height: 30px;
    margin: 0 5px;
    border-radius: 5px;
} */

.quantity-section {
    display: flex;
    justify-content: center; /* Centers the content horizontally */
    align-items: center; /* Centers the content vertically */
    height: 50px; /* Adjust the height to your needs */
}

.quantity-section button {
    width: 30px;
    height: 30px;
    margin: 0 10px;
    font-size: 18px;
    border-radius: 5px;
}

.quantity-section .quantity {
    margin: 0 15px;
    font-size: 16px;
    font-weight: bold;
}



#cart {
    background: #fff;
    margin-top: 20px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
} 



/* #cart {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    position:fixed;
    top: 0;
    right: calc(100%-500px);
    width: 200px;
    height:50vh;
    transition:0.5s;
    background-color:#fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
} */

#cart-items li {
    margin-bottom: 10px;
}

#total-bill {
    font-weight: bold;
    font-size: 16px;
}
/* vegicon */
.veg-switch {
    background-color: #f8f8f8; /* Light background color for the card */
    border-radius: 10px; /* Rounded corners for the card */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    padding: 20px; /* Padding inside the card */
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 400px; /* Optional: Set a max-width for the card */
    margin: 0 auto; /* Optional: Center the card horizontally */
}

.food-type {
    display: flex;
    align-items: center;
    margin-right: 20px; /* Space between food types */
}

.food-icon {
    width: 20px; /* Size of the food icons */
    height: 20px;
    margin-right: 10px; /* Space between the icon and text */
}
.veg-switch span {
    font-weight: bold;
}
@media screen and (max-width:576px){
   .description.full{
    /* text-wrap:wrap !important;
    height: 8vh !important; */
    text-align: justify !important;
   }
}
    </style>
</head>

<body>
    <div class="container">
        <!-- <div class="title-icons">
            <img src="image/veggicon.png" alt="Vegetarian" class="veg-icon">
            <img src="image/nvicon.png" alt="Non-Vegetarian" class="veg-icon">
        </div> -->
        <h1>Menu</h1>
        <div class="veg-switch">
            <div class="food-type">
                <img src="image/vegicon.png" alt="Veg Icon" class="food-icon">
                <span>Veg</span>
            </div>
            <div class="food-type">
                <img src="image/nonvegicon.png" alt="Non-Veg Icon" class="food-icon">
                <span>Non-Veg</span>
            </div>
            <span>Only Veg</span>
            <label class="switch">
                <input type="checkbox" id="vegSwitch">
                <span class="slider"></span>
            </label>
        </div>
        <?php
        $json = '{
            "result": [
                {"MenuId": "19482", "MenuSubCategoryName": "BEVERAGES", "MenuName": "Tea", "MenuImageUrl": "image/pexels-thought-catalog-317580-904616.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "15.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "19483", "MenuSubCategoryName": "BEVERAGES", "MenuName": "Coffee", "MenuImageUrl": "image/pexels-spotwizardlee-35777904-7362647.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "20.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "19484", "MenuSubCategoryName": "BEVERAGES", "MenuName": "Cold Coffee", "MenuImageUrl": "image/pexels-markus-winkler-1430818-11100423.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "25.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "18214", "MenuSubCategoryName": "VEG SOUP", "MenuName": "Tomato Soup", "MenuImageUrl": "https://www.vegrecipesofindia.com/wp-content/uploads/2020/11/tomato-soup-recipe-4.jpg", "Description": "Tomato soup also gives you a good amount of fiber, potassium and vitamins A, C and K. Copper and selenium are two important nutrients in tomato soup that have a range of tomato health benefits", "Rate": "130.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "18215", "MenuSubCategoryName": "VEG SOUP", "MenuName": "Sweet Corn Soup", "MenuImageUrl": "https://5.imimg.com/data5/EM/QO/MY-764091/sweet-corn-soup-500x500.png", "Description": "", "Rate": "120.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "18216", "MenuSubCategoryName": "VEG SOUP", "MenuName": "Veg Clear Soup", "MenuImageUrl": "image/pexels-jentstyle-photo-3559899.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "140.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "18217", "MenuSubCategoryName": "VEG SOUP", "MenuName": "Veg Manchow Soup", "MenuImageUrl": "image/pexels-valeriya-724667.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "150.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "18231", "MenuSubCategoryName": "ROTI", "MenuName": "Butter Roti", "MenuImageUrl": "image/pexels-dhiraj-jain-207743066-12737800.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "15.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "18233", "MenuSubCategoryName": "ROTI", "MenuName": "Naan", "MenuImageUrl": "image/pexels-dhiraj-jain-207743066-12737664.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "30.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "26050", "MenuSubCategoryName": "ROTI", "MenuName": "Bhakari", "MenuImageUrl": "image/bhakri.png", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "10.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "873780", "MenuSubCategoryName": "ROTI", "MenuName": "Butter Naan", "MenuImageUrl": "image/butteroti.png", "Description": "Naan", "Rate": "35.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "878776", "MenuSubCategoryName": "ROTI", "MenuName": "Chapati", "MenuImageUrl": "image/pexels-towfiqu-barbhuiya-3440682-9797029.jpg", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "30.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "20220", "MenuSubCategoryName": "RICE", "MenuName": "Veg Biryani", "MenuImageUrl": "image/vb.png", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "140.00", "MenuTypeId": "1", "Discount": "0.00"},
                {"MenuId": "33553", "MenuSubCategoryName": "RICE", "MenuName": "Veg Schezwan Rice", "MenuImageUrl": "image/sr.png", "Description": "Manchow soup is a soup popular in Indian Chinese cuisine due to its easy preparation and hot spicy taste.", "Rate": "150.00", "MenuTypeId": "1", "Discount": "0.00"}
            ]
        }';
        
        $menuData = json_decode($json, true);
        $currentCategory = "";
        
        foreach ($menuData['result'] as $menuItem) {
            if ($currentCategory != $menuItem['MenuSubCategoryName']) {
                if ($currentCategory != "") {
                    echo "</div>";
                }
                $currentCategory = $menuItem['MenuSubCategoryName'];
                echo "<div class='category'><h2>" . $currentCategory . "</h2>";
            }
        
            echo "<div class='menu-item'>";
            echo "<div class='details'>";
        
            // Add veg/non-veg icon based on MenuTypeId
            $iconUrl = $menuItem['MenuTypeId'] == 1 ? "image/vegicon.png" : "image/nonvegicon.png";
            echo "<div class='food-type'>";
            echo "<img src='" . $iconUrl . "' alt='Food Type Icon' class='food-icon'>";
            echo "</div>";
        
            echo "<h3>" . $menuItem['MenuName'] . "</h3>";
            $descriptionWords = explode(' ', $menuItem['Description']);
            $shortDescription = implode(' ', array_slice($descriptionWords, 0, 5));
            $fullDescription = $menuItem['Description'];
            echo "<p class='description short'>" . $shortDescription . (count($descriptionWords) > 5 ? "..." : "") . "</p>";
            echo "<p class='description full' style='display: none;'>" . $fullDescription . "</p>";
            if (count($descriptionWords) > 5) {
                echo "<span class='view-more' id='more'>View More</span>";
                echo "<span class='view-less'>View Less</span>";

            }
            
            echo "<p class='price'>₹" . $menuItem['Rate'] . "</p>";
            echo "</div>";
        
            echo "<div class='image-add'>";
            echo "<img src='" . $menuItem['MenuImageUrl'] . "' alt='" . $menuItem['MenuName'] . "'>";
            echo "<button class='add-to-cart'>Add</button>";
            echo "<div class='quantity-section' style='display: none;'>"?>
                  <form id='myForm' method="POST">
    <input type='hidden' name='menuId' value="<?php echo $menuItem['MenuId'] ?>">
    <input type='hidden' name='menuName' value="<?php echo $menuItem['MenuName'] ?>">
    <input type='hidden' name='rate' value="<?php echo $menuItem['Rate'] ?>">
    <input type='hidden' name='desc' value="<?php echo $menuItem['Description'] ?>">
    <input type='hidden' name='img' value="<?php echo $menuItem['MenuImageUrl'] ?>">
    <input type='hidden' name='discount' value="<?php echo $menuItem['Discount'] ?>">

    <button class='minus' type='submit' name='remove'>-</button>
    <span class='quantity'>
<?php 
$fetch_cart="SELECT COUNT('MenuId') as count FROM m_menuitems WHERE MenuId=$menuItem[MenuId]";
$run=mysqli_query($con,$fetch_cart);
$fetch=mysqli_fetch_array($run);
$data=$fetch['count'];
echo $data;
?>
    </span>
    <button class='plus' type='submit' name='add'>+</button>
</form>

                      <?php
                  
        
            echo "</div>";
            echo "</div>";
            echo "</div>";

        }
        if ($currentCategory != "") {
            echo "</div>";
        }
        

$select_count="SELECT count(MenuId) as t_count FROM m_menuitems";
$fetch_select_count=mysqli_query($con,$select_count);
$fetch_t_count=mysqli_fetch_array($fetch_select_count);
$t_count=$fetch_t_count['t_count'];
?>
    

<div class="footer-bar">
        <a href="#" class="footer-link">
            <i class="fa-solid fa-house footer-icon"></i>
            <span>Home</span>
        </a>
        <a href="#" class="footer-link">
            <i class="fa-solid fa-bars footer-icon"></i>
            <span>Menu</span>
        </a>
        <a href="addcart.php" class="footer-link">
           
    <i class="fa-solid fa-cart-shopping footer-icon"><span class="text-danger mx-2" style="color:red;margin-left:8%;"><?php echo $t_count ?></span></i>
    
    <span>Cart</span>
</a>

    </div>



    <script>
     // When the "Add" button is clicked, show the quantity section
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const quantitySection = this.nextElementSibling;
        quantitySection.style.display = 'flex';
        this.style.display = 'none'; // Hide the "Add" button after it's clicked
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Handle "View More" / "View Less" functionality
    document.querySelectorAll('.view-more').forEach(button => {
        button.addEventListener('click', function() {
            this.previousElementSibling.style.display = 'none';
            this.nextElementSibling.style.display = 'inline-block';
            this.parentNode.querySelector('.description.full').style.display = 'block';
            this.parentNode.querySelector('.description.full').style.whiteSpace = 'normal';

            this.style.display = 'none';
        });
    });

    document.querySelectorAll('.view-less').forEach(button => {
        button.addEventListener('click', function() {
            this.previousElementSibling.style.display = 'inline-block';
            this.previousElementSibling.previousElementSibling.style.display = 'block';
            this.parentNode.querySelector('.description.full').style.display = 'none';
            this.style.display = 'none';
        });
    });

  
    

// Quantity increment/decrement
document.querySelectorAll('.plus').forEach(button => {
    button.addEventListener('click', function() {
        let quantity = this.previousElementSibling;
        quantity.textContent = parseInt(quantity.textContent) + 1;

        // Get the product details from data attributes
        const productName = this.closest('.product-item').querySelector('.add-to-cart').dataset.name;
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const product = cart.find(item => item.name === productName);
        
        // Update the quantity in local storage
        if (product) {
            product.quantity = parseInt(quantity.textContent);
            localStorage.setItem('cart', JSON.stringify(cart));
        }
    });
});

document.querySelectorAll('.minus').forEach(button => {
    button.addEventListener('click', function() {
        let quantity = this.nextElementSibling;
        if (parseInt(quantity.textContent) > 1) {
            quantity.textContent = parseInt(quantity.textContent) - 1;

            // Get the product details from data attributes
            const productName = this.closest('.product-item').querySelector('.add-to-cart').dataset.name;
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const product = cart.find(item => item.name === productName);

            // Update the quantity in local storage
            if (product) {
                product.quantity = parseInt(quantity.textContent);
                localStorage.setItem('cart', JSON.stringify(cart));
            }
        }
    });
});

  // Filter by Veg/Non-Veg
    const vegSwitch = document.getElementById('vegSwitch');
    vegSwitch.addEventListener('change', function() {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            const isVeg = item.querySelector('.food-icon').src.includes('vegicon');
            if (this.checked && !isVeg) {
                item.style.display = 'none';
            } else {
                item.style.display = 'flex';
            }
        });
    });
});

function updateCart() {
    const price = 10; // Assume ₹10 per item
    let totalItems = 0;
    let totalBill = 0;

    document.querySelectorAll('.quantity').forEach(span => {
        totalItems += parseInt(span.textContent);
    });

    totalBill = totalItems * price;
    document.getElementById('total-items').textContent = totalItems;
    document.getElementById('total-bill').textContent = totalBill;
}
// Toggle Cart visibility when the "Cart" link is clicked
document.querySelector('.footer-link[href="#cart"]').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent default anchor behavior

    const cart = document.getElementById('cart');
    const isCartVisible = cart.style.display === 'block';

    // Toggle cart visibility
    if (isCartVisible) {
        cart.style.display = 'none';
    } else {
        cart.style.display = 'block';
    }
});

// Hide the cart when other footer links are clicked
document.querySelectorAll('.footer-link').forEach(link => {
    link.addEventListener('click', function (event) {
        if (this.getAttribute('href') !== '#cart') {
            document.getElementById('cart').style.display = 'none';
        }
    });
});


    </script>

<script>
    // let view_more=document.querySelector('#more');
    // view_more.addEventListener('click',()=>{
    //     alert("hello");
    // })
   
        // document.getElementById('myForm').addEventListener('submit', function(event) {
        //     event.preventDefault(); // Prevent the default form submission

        //     const formData = new FormData(this);

        //     fetch('demo.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(response => {
        //         return response.text(); // or response.json() depending on your server response
        //     })
        //     .then(data => {
        //         console.log('Success:', data);
        //         // Handle the response data here
        //     })
        //     .catch((error) => {
        //         console.error('Error:', error);
        //         // Handle errors here
        //     });
        // });
    
    </script>
 <!-- Footer Bar -->
   
</body>
</html>













        
       
        
        


















