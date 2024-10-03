<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Cart List</title>
</head>
<body>
<?php
// $con = mysqli_connect('localhost', 'root', '', 'mmd');
include('connection.php');
$sql = "SELECT * FROM m_menuitems";
$run = mysqli_query($con, $sql);

// Initialize an array to hold grouped items
$cart_items = [];

while ($fetch = mysqli_fetch_array($run)) {
    $menu_id = $fetch['MenuId'];
    $menu_subcat = $fetch['MenuSubCategoryName'];
    $menu_name = $fetch['MenuName'];
    $menu_imageUrl = $fetch['MenuImageUrl'];
    $menu_des = $fetch['Description'];
    $rate = $fetch['Rate'];
    $menu_type_id = $fetch['MenuTypeId'];
    $discount = $fetch['Discount'];

    // Calculate discounted price
    $discounted_price = $rate - ($rate * $discount / 100);

    // If item already exists in cart, increase quantity and update price
    if (isset($cart_items[$menu_id])) {
        $cart_items[$menu_id]['quantity']++;
        $cart_items[$menu_id]['total_price'] += $discounted_price;
    } else {
        // Add new item to cart
        $cart_items[$menu_id] = [
            'name' => $menu_name,
            'subcat' => $menu_subcat,
            'imageUrl' => $menu_imageUrl,
            'description' => $menu_des,
            'price' => $rate,
            'discount' => $discount,
            'discounted_price' => $discounted_price,
            'quantity' => 1,
            'total_price' => $discounted_price,
            'type_id' => $menu_type_id
        ];
    }
}

// Calculate the total amount for all items
$total_rate = 0;
foreach ($cart_items as $item) {
    $total_rate += $item['total_price'];
}
?>

<div class="container my-4">
    <h4 class="text-center p-3">Cart List</h4>
    <div class="mb-3">
        <a href="demo.php" class="btn btn-danger">Go back</a>
    </div>
    <div class="row">
        <?php foreach ($cart_items as $item) { ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?php echo $item['imageUrl']; ?>" class="card-img-top" alt="<?php echo $item['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $item['name']; ?></h5>
                    <p class="text-muted">Subcategory: <?php echo $item['subcat']; ?></p>
                    <p class="text-muted">Type ID: <?php echo $item['type_id']; ?></p>
                    <p class="mb-1"><strong>Price:</strong> ₹<?php echo number_format($item['price'], 2); ?></p>
                    <?php if ($item['discount'] > 0) : ?>
                    <p class="text-success"><strong>Discount:</strong> <?php echo $item['discount']; ?>% off</p>
                    <p class="text-danger"><strong>Discounted Price:</strong> ₹<?php echo number_format($item['discounted_price'], 2); ?></p>
                    <?php endif; ?>
                    <p class="mb-1"><strong>Quantity:</strong> <?php echo $item['quantity']; ?></p>
                    <p><strong>Total Price:</strong> ₹<?php echo number_format($item['total_price'], 2); ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <h5>Total Amount: <strong>₹<?php echo number_format($total_rate, 2); ?></strong></h5>
                <a href="#" class="btn btn-primary mt-3">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
