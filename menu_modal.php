<!-- menu_modal.php -->
<?php if (isset($result)) : ?>
    <div class="modal fade" id="menuModal-<?php echo $result['MenuID']; ?>" tabindex="-1" aria-labelledby="menuModalLabel-<?php echo $result['MenuID']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="menuModalLabel-<?php echo $result['MenuID']; ?>"><?php echo $result['MenuName']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($output['result'] as $in => $data) : ?>
                            <?php if ($data['active'] == 1 && $data['menu_sold'] == 0) : ?>
                                <div class="d-flex fields">
                                    <input type="hidden" name="menu_id" value="<?php echo $result['MenuID']; ?>">
                                    <input type="hidden" name="menu_code" value="<?php echo $result['MenuCode']; ?>">
                                    <input type="hidden" name="menu_name" value="<?php echo $result['MenuName']; ?>">
                                    <input type="hidden" name="hotel_id" value="<?php echo $result['hotel_id']; ?>">
                                    <input type="hidden" name="section_id" value="<?php echo $result['section_id']; ?>">
                                    <input type="hidden" name="rate" value="<?php echo $data['rate']; ?>">
                                    <input type="hidden" name="discount" value="<?php echo $data['rate'] - $data['MRP']; ?>">
                                    <input type="hidden" name="advance_amt" value="<?php echo $data['AdvanceAmt']; ?>">
                                    <input type="hidden" name="MRP" value="<?php echo $data['MRP']; ?>">
                                    <input type="hidden" name="menu_sold" value="<?php echo $data['menu_sold']; ?>">
                                    <input type="hidden" name="active" value="<?php echo $data['active']; ?>">
                                    <input type="number" id="quantity-<?php echo $result['MenuID'] . '-' . $in; ?>" name="quantity" placeholder="Quantity" class="form-control col-lg-4">
                                    <p class="mx-5 text-danger"><b style="font-size: large;">Rate: <?php echo $data["rate"]; ?></b></p>
                                    <p class="text-success"><b style="font-size: large;">Discount: <span id="advanceAmt-<?php echo $result['MenuID'] . '-' . $in; ?>"><?php echo $data['rate'] - $data['MRP']; ?>.00</span></b></p>
                                </div>
                                <div class="date col-md-5">
                                    <label for="">Select Date:</label>
                                    <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="d-flex">
                                    <div>
                                        <p class="my-3">Sub Total: <span id="mrp-<?php echo $result['MenuID'] . '-' . $in; ?>"></span></p>
                                        <p class="my-3 text-success">Discount: <span id="discount-<?php echo $result['MenuID'] . '-' . $in; ?>"></span></p>
                                        <p><b>Total: <span id="total-<?php echo $result['MenuID'] . '-' . $in; ?>"></span></b></p>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('quantity-<?php echo $result['MenuID'] . '-' . $in; ?>').addEventListener('input', function() {
                                        var quantity = this.value;
                                        var rate = <?php echo $data["rate"]; ?>;
                                        var discount = <?php echo $data['rate'] - $data['MRP']; ?>;
                                        var subtotal = quantity * rate;
                                        var totalDiscount = quantity * discount;
                                        var total = subtotal - totalDiscount;
                                        document.getElementById('mrp-<?php echo $result['MenuID'] . '-' . $in; ?>').innerText = subtotal;
                                        document.getElementById('discount-<?php echo $result['MenuID'] . '-' . $in; ?>').innerText = totalDiscount;
                                        document.getElementById('total-<?php echo $result['MenuID'] . '-' . $in; ?>').innerText = total;
                                    });
                                </script>
                            <?php elseif ($data['active'] == 1 && $data['menu_sold'] != 0) : ?>
                                <div class="text-center">
                                    <h4 class="text-danger">This item is sold out!</h4>
                                </div>
                            <?php else : ?>
                                <div>
                                    <p class="text-danger">This item is not activated!</p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <?php if ($data['active'] == 1 && $data['menu_sold'] == 0) : ?>
                            <button type="submit" class="btn btn-primary" name="add_cart">Add to cart</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
