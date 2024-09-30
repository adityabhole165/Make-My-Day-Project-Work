<?php
if (isset($_GET['c'])) {
    $fetch_ = "SELECT * FROM m_booking WHERE menu_id= ".$_GET['c']."  AND mob = $_SESSION[mobile] ";
    $fetch_run = mysqli_query($con, $fetch_);

    $fetch_row_ = mysqli_fetch_array($fetch_run);
?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $index; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel-<?php echo $index; ?>"><?php echo $fetch_row_['menu_name']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.replace('validate_otp2.php')"></button>
                    </div>
                    <div class="modal-body">
                        <?php foreach($output['result'] as $in => $data): ?>
                            
                    <?php
                       
                        if($fetch_row_['active'] == 1 && $fetch_row_['menu_sold'] == 0): ?>
                            <div class="d-flex">
                                <input type="hidden" name="menu_id1" value="<?php echo $fetch_row_['menu_id']; ?>">
                                <input type="hidden" name="hotel_id1" value="<?php echo $result['hotel_id']; ?>">
                                <input type="hidden" name="section_id1" value="<?php echo $result['section_id']; ?>">
                                <input type="hidden" name="menu_code1" value="<?php echo $fetch_row_['menu_code']; ?>">
                                <input type="hidden" name="menu_name1" value="<?php echo $fetch_row_['menu_name']; ?>">
                                <input type="hidden" name="rate1" value="<?php echo $fetch_row_['rate']; ?>">
                                <input type="hidden" name="discount1" value="<?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?>">
                                <input type="hidden" name="advance_amt1" value="<?php echo $fetch_row_['advance_amt']; ?>">
                                <input type="hidden" name="MRP1" value="<?php echo $fetch_row_['MRP']; ?>">
                                <input type="hidden" name="menu_sold1" value="<?php echo $fetch_row_['menu_sold']; ?>">
                                <input type="hidden" name="active1" value="<?php echo $fetch_row_['active']; ?>">

                                <p>Quantity:<input type="number" id="quantity1-<?php echo $index . '-' . $in; ?>" name="quantity1" placeholder="Quantity" class="form-control col-lg-8" value="<?php echo $fetch_row_['quantity'] ?>"></p>
                                <p class="mx-5 text-danger"><b style="font-size: large;">Rate: <?php echo $fetch_row_['rate']; ?></b></p>
                                <p class="text-success"><b style="font-size: large;">Discount: <span id="advanceAmt1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?></span></b></p>
                            </div>
                            <div class="date col-5">
                                <label for="">Select Date:</label>
                                <input type="date" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div>
                                <p class="my-3" style="font-size: larger;">Sub Total: <span id="mrp1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['subtotal']; ?></span></p>
                                <p class="my-3" style="font-size: larger;color:green;">Discount: <span id="discount1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['final_discount']; ?></span></p>
                                <p><b style="font-size: larger;">Total: <span id="total1-<?php echo $index . '-' . $in; ?>"><?php echo $fetch_row_['total']; ?></span></b></p>
                            </div>
                           
                            <script>
                                document.getElementById('quantity1-<?php echo $index . '-' . $in; ?>').addEventListener('input', function() {
                                    var quantity = document.getElementById('quantity1-<?php echo $index . '-' . $in; ?>').value;
                                    var rate = <?php echo $fetch_row_["rate"]; ?>;
                                    var discount = <?php echo $fetch_row_['rate'] - $fetch_row_['MRP']; ?>;
                                    var subdiscount = quantity * discount;
                                    var subtotal = quantity * rate;
                                    var total = subtotal - subdiscount;
                                    document.getElementById('mrp1-<?php echo $index . '-' . $in; ?>').innerText = subtotal;
                                    document.getElementById('total1-<?php echo $index . '-' . $in; ?>').innerText = total;
                                    document.getElementById('discount1-<?php echo $index . '-' . $in ?>').innerText = subdiscount;
                                });
                            </script>
                        <?php elseif($fetch_row_['active'] == 1 && $fetch_row_['menu_sold'] != 0): ?>
                            <div>
                                <p class="text-danger text-center">This item is sold out..!</p>
                            </div>
                        <?php else: ?>
                            <div>
                                <p class="text-danger">This item is not activated..!</p>
                            </div>
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
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        });
    </script>

<?php
}
?>
