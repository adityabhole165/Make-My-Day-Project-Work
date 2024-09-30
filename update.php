<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'mmd');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetching specific cart item to edit (for example, using menu_id passed as a GET parameter)
$menu_id_to_edit = $_GET['menu_id'];
$query = "SELECT * FROM m_booking WHERE mob = '$_SESSION[mobile]' AND menu_id = '$menu_id_to_edit'";
$results = mysqli_query($con, $query);

if (!$results) {
    die("Query failed: " . mysqli_error($con));
}

$item = mysqli_fetch_assoc($results);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cart Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 1.5rem; /* Padding for the card */
            margin: 1rem; /* Margin around the card */
        }
        .modal-title {
            font-weight: bold;
            color: #007bff; /* Title color */
        }
        .rate, .discount {
            font-size: 1.25rem; /* Increased font size for Rate and Discount */
            font-weight: bold; /* Make text bold */
        }
        .quantity-container {
            width: 70%; /* Decrease width of Quantity input */
            margin-bottom: 1rem; /* Margin for quantity container */
        }
        .total {
            font-weight: bold;
            font-size: 1.5rem; /* Increased font size for total */
            color: #dc3545; /* Total amount color */
        }
        .summary p {
            margin: 0; /* Remove default margin for summary paragraphs */
            padding: 0.5rem 0; /* Padding for summary paragraphs */
        }
        .fw-bold {
            font-weight: bold;
        }
        label {
            margin-bottom: 0.5rem; /* Margin below labels */
        }
        input[type="date"], input[type="number"], .btn {
            margin-top: 0.5rem; /* Space above input fields and buttons */
            padding: 0.5rem; /* Padding for input fields */
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100" style="height: 80vh;">
    <div class="card" style="max-width: 500px; width: 100%;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="modal-title"><?php echo $item['menu_name']; ?></h5>
            <a href="cart_product_list.php" class="btn-close" aria-label="Close"></a>
        </div>

        <div class="card-body">
            <form action="update_cart_item.php" method="POST">
                <input type="hidden" name="menu_id" value="<?php echo $item['menu_id']; ?>">

                <!-- Quantity -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <div class="input-group quantity-container">
                        <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo $item['quantity']; ?>" required>
                    </div>
                </div>

                <!-- Price and Discount Display -->
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <label class="fw-bold">Rate:</label>
                        <span class="rate">₹<?php echo $item['rate']; ?></span>
                    </div>
                    <div>
                        <label class="fw-bold">Discount:</label>
                        <span class="discount">₹<?php echo $item['final_discount']; ?></span>
                    </div>
                </div>

                <!-- Date Selection -->
                <div class="mb-3">
                    <label for="date" class="form-label">Select Date:</label>
                    <input type="date" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <!-- Subtotal, Discount, and Total Summary -->
                <div class="summary mt-3">
                    <p>Sub Total: ₹<span id="subtotal">0</span></p>
                    <p>Discount: ₹<span id="display-discount">0</span></p>
                    <p class="total">Total: ₹<span id="total">0</span></p>
                </div>

                <!-- Update Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Script to dynamically update total, subtotal, and discount based on quantity input
document.getElementById('quantity').addEventListener('input', updateValues);

function updateValues() {
    var quantity = parseInt(document.getElementById('quantity').value);
    var rate = parseFloat(<?php echo $item['rate']; ?>);
    var discount = parseFloat(<?php echo $item['final_discount']; ?>);

    var subtotal = quantity * rate;
    var totalDiscount = quantity * discount;
    var total = subtotal - totalDiscount;

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('display-discount').innerText = totalDiscount.toFixed(2);
    document.getElementById('total').innerText = total.toFixed(2);
}

// Trigger the update function on page load to show the correct values
updateValues();
</script>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
