<div class="modal fade" id="exampleModal-<?php echo $index; ?>" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $index; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-<?php echo $index; ?>"><?php echo $result['MenuName']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($output['result'] as $in => $data): ?>
                        <?php if ($data['active'] == 1 && $data['menu_sold'] == 0): ?>
                            <div class="d-flex">
                                <?php foreach (['menu_id', 'menu_code', 'menu_name', 'rate', 'advance_amt', 'MRP', 'menu_sold', 'active'] as $field): ?>
                                    <input type="hidden" name="<?php echo $field; ?>" value="<?php echo $result[$field]; ?>">
                                <?php endforeach; ?>
                                <input type="hidden" name="discount" value="<?php echo $data['rate'] - $data['MRP']; ?>">
                                <input type="number" id="quantity-<?php echo $index . '-' . $in; ?>" name="quantity" placeholder="Quantity" class="form-control col-lg-4">
                                <p class="mx-5 text-danger"><b style="font-size: large;">Rate: <?php echo $data['rate']; ?></b></p>
                                <p class="text-success"><b style="font-size: large;">Discount: <span id="advanceAmt-<?php echo $index . '-' . $in; ?>"><?php echo $data['rate'] - $data['MRP']; ?></span></b></p>
                            </div>
                            <div>
                                <p class="my-3" style="font-size: larger;">Sub Total: <span id="mrp-<?php echo $index . '-' . $in; ?>"></span></p>
                                <p class="my-3" style="font-size: larger;color:green;">Discount: <span id="discount-<?php echo $index . '-' . $in; ?>"></span></p>
                                <p><b style="font-size: larger;">Total: <span id="total-<?php echo $index . '-' . $in; ?>"></span></b></p>
                            </div>
                            <script>
                                document.getElementById('quantity-<?php echo $index . '-' . $in; ?>').addEventListener('input', function() {
                                    var quantity = this.value;
                                    var rate = <?php echo $data['rate']; ?>;
                                    var discount = <?php echo $data['rate'] - $data['MRP']; ?>;
                                    var subtotal = quantity * rate;
                                    var subdiscount = quantity * discount;
                                    var total = subtotal - subdiscount;
                                    document.getElementById('mrp-<?php echo $index . '-' . $in; ?>').innerText = subtotal;
                                    document.getElementById('total-<?php echo $index . '-' . $in; ?>').innerText = total;
                                    document.getElementById('discount-<?php echo $index . '-' . $in; ?>').innerText = subdiscount;
                                });
                            </script>
                        <?php elseif ($data['active'] == 1 && $data['menu_sold'] != 0): ?>
                            <p class="text-danger">This item is sold..!</p>
                        <?php else: ?>
                            <p class="text-danger">This item is not activated..!</p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="add_cart">Add to cart</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_GET['c'])): 
    $fetch_query = "SELECT * FROM m_booking WHERE menu_id=" . $_GET['c'];
    $fetch_run = mysqli_query($con, $fetch_query);
    $fetch_row_ = mysqli_fetch_array($fetch_run); ?>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $index; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel-<?php echo $index; ?>"><?php echo $fetch_row_['menu_name']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($output['result'] as $in => $data): ?>
                            <?php if ($data['active'] == 1 && $data['menu_sold'] == 0): ?>
                                <div class="d-flex">
                                    <?php foreach (['menu_id', 'menu_code', 'menu_name', 'rate', 'advance_amt', 'MRP', 'menu_sold', 'active'] as $field): ?>
                                        <input type="hidden" name="<?php echo $field; ?>1" value="<?php echo $fetch_row_[$field]; ?>">
                                    <?php endforeach; ?>
                                    <input type="hidden" name="discount1" value="<?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?>">
                                    <p>Quantity:<input type="number" id="quantity1-<?php echo $index . '-' . $in; ?>" name="quantity1" placeholder="Quantity" class="form-control col-lg-8" value="<?php echo $fetch_row_['quantity']; ?>"></p>
                                    <p class="mx-5 text-danger"><b style="font-size: large;">Rate: <?php echo $fetch_row_['rate']; ?></b></p>
                                    <p class="text-success"><b style="font-size: large;">Discount: <span id="advanceAmt1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?></span></b></p>
                                </div>
                                <div>
                                    <p class="my-3" style="font-size: larger;">Sub Total: <span id="mrp1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['subtotal']; ?></span></p>
                                    <p class="my-3" style="font-size: larger;color:green;">Discount: <span id="discount1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['final_discount']; ?></span></p>
                                    <p><b style="font-size: larger;">Total: <span id="total1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['total']; ?></span></b></p>
                                </div>
                                <script>
                                    document.getElementById('quantity1-<?php echo $index . '-' . $in; ?>').addEventListener('input', function() {
                                        var quantity = this.value;
                                        var rate = <?php echo $fetch_row_['rate']; ?>;
                                        var discount = <?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?>;
                                        var subtotal = quantity * rate;
                                        var subdiscount = quantity * discount;
                                        var total = subtotal - subdiscount;
                                        document.getElementById('mrp1-<?php echo $index . '-' . $in; ?>').innerText = subtotal;
                                        document.getElementById('total1-<?php echo $index . '-' . $in; ?>').innerText = total;
                                        document.getElementById('discount1-<?php echo $index . '-' . $in; ?>').innerText = subdiscount;
                                    });
                                </script>
                            <?php elseif ($data['active'] == 1 && $data['menu_sold'] != 0): ?>
                                <p class="text-danger">This item is sold..!</p>
                            <?php else: ?>
                                <p class="text-danger">This item is not activated..!</p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="update_cart">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#exampleModal').modal('show');
        });
    </script>

<?php endif; ?>

<?php if (isset($_POST['add_cart'])): 
    $menu_id = $_POST['menu_id'];
    $menu_code = $_POST['menu_code'];
    $menu_name = $_POST['menu_name'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $discount = $_POST['discount'];
    $advance_amt = $_POST['advance_amt'];
    $MRP = $_POST['MRP'];
    $subtotal = $rate * $quantity;
    $final_discount = $quantity * $discount;
    $total = $subtotal - $final_discount;
    $active = $_POST['active'];
    $menu_sold = $_POST['menu_sold'];

    $add_query = "INSERT INTO m_booking(menu_id,menu_code,menu_name,quantity,rate,advance_amt,MRP,subtotal,final_discount,total,active,menu_sold) VALUES('$menu_id','$menu_code','$menu_name','$quantity','$rate','$advance_amt','$MRP','$subtotal','$final_discount','$total','$active','$menu_sold')";
    $add_query_run = mysqli_query($con, $add_query);

    if ($add_query_run) {
        echo "<script>alert('Booking Successfully Created..');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Booking Not Created..');</script>";
    }
endif; ?>

<?php if (isset($_POST['update_cart'])): 
    $menu_id1 = $_POST['menu_id1'];
    $menu_code1 = $_POST['menu_code1'];
    $menu_name1 = $_POST['menu_name1'];
    $quantity1 = $_POST['quantity1'];
    $rate1 = $_POST['rate1'];
    $discount1 = $_POST['discount1'];
    $advance_amt1 = $_POST['advance_amt1'];
    $MRP1 = $_POST['MRP1'];
    $subtotal1 = $rate1 * $quantity1;
    $final_discount1 = $quantity1 * $discount1;
    $total1 = $subtotal1 - $final_discount1;
    $active1 = $_POST['active1'];
    $menu_sold1 = $_POST['menu_sold1'];

    $update_query = "UPDATE m_booking SET menu_id='$menu_id1', menu_code='$menu_code1', menu_name='$menu_name1', quantity='$quantity1', rate='$rate1', advance_amt='$advance_amt1', MRP='$MRP1', subtotal='$subtotal1', final_discount='$final_discount1', total='$total1', active='$active1', menu_sold='$menu_sold1' WHERE menu_id='$menu_id1'";
    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        echo "<script>alert('Booking Successfully Updated..');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Booking Not Updated..');</script>";
    }
endif; ?>
