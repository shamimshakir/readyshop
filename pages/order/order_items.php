<?php 
    include('../header.php');
    extract($_POST);

    $orderinfoSql = "SELECT
        tbl_order.product_cost,
        tbl_order.total_cost,
        tbl_order.od_shipping_cost
    FROM
        tbl_order
    WHERE
        tbl_order.od_id = $od_id";
    $res = mysqli_query($conn, $orderinfoSql);
    $orderInfo = mysqli_fetch_assoc($res);
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Change Order Quantity</span>
                        <span>
                            <a class="btn btn-primary" href="#" onclick="view_data()">Order Information</a>
                        </span>
                    </h4>
                    <form id="change_order_qty_form">
                    <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT
                            tbl_order_item.od_qty,
                            tbl_order_item.od_id,
                            tbl_order_item.od_qty * tbl_order_item.pd_price AS product_toal_with_qty,
                            tbl_order_item.pd_price,
                            tbl_order_item.pd_id,
                            tbl_product.pd_name,
                            tbl_product.pd_thumbnail
                        FROM
                            tbl_order_item
                        LEFT JOIN tbl_product ON tbl_product.pd_id = tbl_order_item.pd_id
                        WHERE
                            tbl_order_item.od_id = $od_id");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <input type="hidden" name="product_ids[]" value="<?php echo $row['pd_id'];?>" />
                                <input type="hidden" name="order_id" value="<?php echo $row['od_id'];?>" />
                                <input type="hidden" name="products_prices[]" value="<?php echo $row['pd_price'];?>" />
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['pd_name'];?></td>
                                <td>
                                    <img style="height:50px" src="<?php echo 'uploads/products/thumbnails/'.$pd_thumbnail; ?>" alt="">
                                </td>
                                <td class="prPrice"><?php echo $row['pd_price'];?></td>
                                <td>
                                    <div style="display:flex;" class="orderQuantityChangeDiv">
                                        <button class="btn btn-primary decreaseOrderQtybtn">-</button>
                                        <input 
                                            class="form-control change_item_quantity_input"
                                            id="change_item_quantity_input" 
                                            type="text" 
                                            value="<?php echo $row['od_qty']; ?>" 
                                            name="change_item_quantity_input[]" 
                                        />
                                        <button class="btn btn-primary increaseOrderQtybtn">+</button>
                                    </div>
                                </td>
                                <td class="prSubtotal"><?php echo $row['product_toal_with_qty'];?></td>
                            </tr>

                            <?php $i++; } ?>

                            <tr>
                                <td colspan="5" style="text-align:right"><strong>Subtotal</strong></td>
                                <td>
                                    <strong class="product_cost"><?php echo $orderInfo['product_cost']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align:right"><strong>Shipping Cost</strong></td>
                                <td><strong><?php echo $orderInfo['od_shipping_cost']; ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align:right"><strong>Grand Total</strong></td>
                                <td>
                                    <strong class="total_cost"><?php echo $orderInfo['total_cost']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align:right">
                                    <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                    <button type="button" class="btn btn-primary" onclick="updateOrder()">Update Order</button>
                                </td>
                            </tr>
                        </tbody>
                        
                    </table>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>

    function updateOrder(){
        $.ajax({
            type: "POST",
            url: "pages/order/update_qty_order.php",
            data: $('#change_order_qty_form').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
            console.log(response);
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }

    $( ".decreaseOrderQtybtn" ).click(function(e) {
        e.preventDefault();
        let currentTr = this.closest('tr');
        let qty = $(currentTr).find('.change_item_quantity_input').get(0).value;
        
        let newQty = Number(qty)-1;
        
        if(newQty >= 0){
            $(currentTr).find('.change_item_quantity_input').attr('value', newQty);
            
            let itemPrice = $(currentTr).children('td.prPrice').get(0).innerText;
    
            let prSubtotal = $(currentTr).children('td.prSubtotal').get(0);
            
            prSubtotal.innerText = Number(newQty) * Number(itemPrice);
            
            let allSubtotal = $('.product_cost').get(0).innerText;
            $('.product_cost').get(0).innerText = (Number(allSubtotal) - Number(itemPrice));
        
            let grandTotal = $('.total_cost').get(0).innerText;
            $('.total_cost').get(0).innerText = (Number(grandTotal) - Number(itemPrice));
        }
    });
    
    $( ".increaseOrderQtybtn" ).click(function(e) {
        e.preventDefault();
        let currentTr = this.closest('tr');
        let qty = $(currentTr).find('.change_item_quantity_input').get(0).value;
        
        let newQty = Number(qty)+1;
        
            $(currentTr).find('.change_item_quantity_input').attr('value', newQty);
            
            let itemPrice = $(currentTr).children('td.prPrice').get(0).innerText;
    
            let prSubtotal = $(currentTr).children('td.prSubtotal').get(0);
            
            prSubtotal.innerText = Number(newQty) * Number(itemPrice);
            
            let allSubtotal = $('.product_cost').get(0).innerText;
            $('.product_cost').get(0).innerText = (Number(allSubtotal) + Number(itemPrice));
            
            let grandTotal = $('.total_cost').get(0).innerText;
            $('.total_cost').get(0).innerText = (Number(grandTotal) + Number(itemPrice));
    });
    
</script>