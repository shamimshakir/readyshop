<?php include('../header.php');
$mode = 1;


?>
<style>
    tbody tr td button#addRowBtn {
        display: none;
    }

    tbody tr:first-child td button#removeRowBtn {
        display: none;
    }

    tbody tr:first-child td button#addRowBtn {
        display: block;
    }
    button#addRowBtn {
        border: none;
        background: #7a6fbe;
        color: #fff;
        border-radius: 3px;
        outline: none;
    }
    
    button#removeRowBtn {
        border: none;
        background: #d4716a;
        color: #fff;
        border-radius: 3px;
        outline: none;
        font-size: 15px;
        padding: 0 8px;
    }
</style>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <?php if ($mode == 1){ ?>
                        <h4 id="myModalLabel">New Order</h4>
                    <?php }?>


                    <form id="orderAddForm" class="" action="#" novalidate="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cl_id" class="control-label">Select Customer <span style="color:red;">*</span></label>
                                <select class="form-control select2" id="cl_id" name="cl_id" required>
                                    <option value="0">Select Customer</option>
                                    <?php $cres = mysqli_query($conn, "SELECT CONCAT(firstname, ' ', lastname) AS customer_name, cl_id FROM tbl_customer");
                                        while ($cRow = mysqli_fetch_assoc($cres)) {  echo '<pre>'; print_r($cRow);?>
                                            <option value="<?php echo $cRow['cl_id']; ?>"><?php echo $cRow['customer_name']; ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <h5>Products Selection</h5>
                        <table class="table table-bordered productReceiveDetailsTable">
                            <thead>
                            <tr>
                                <th>Category<span style="color:red;">*</span></th>
                                <th>Product<span style="color:red;">*</span></th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity<span style="color:red;">*</span></th>
                                <th>Unit Price<span style="color:red;">*</span></th>
                                <th>Total Price</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $lastid=0;
                            if ($_POST['mode'] == '2'){
                                $SeNTlist = "SELECT * FROM trn_mat_receive_detail WHERE invoiceobject_id = '$inv_id' ";
                                $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
                                $rowNewsTls=mysqli_num_rows($ExSeNTlist);
                                while($rowNewsTl=mysqli_fetch_array($ExSeNTlist)){
                                    extract($rowNewsTl);
                                    ?>

                                    <tr class="items">
                                        <input type="hidden" name="id[]" value="<?php echo $sl_no;?>" />
                                        <td>
                                            <select name='cat_id[]' id='cat_id' class='form-control'>
                                                <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",$cat_id);?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name='txtprod_id[]' id='txtprod_id' class='form-control'>
                                                <?php createCombo("Product","tbl_product","pd_id","pd_name","ORDER BY pd_name ",$prod_id);?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name='size_id[]' id='size_id' class='form-control'>
                                                <?php createCombo("Size","tbl_size","size_id","size_display","ORDER BY size_display ",$size_id);?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name='color_id[]' id='color_id' class='form-control'>
                                                <?php createCombo("Color","tbl_color","color_id","color_name"," where color_status=1 ORDER BY color_name ",$color_id);?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="qty[]" class="form-control qty" value="<?php echo $qty;?>" id="qty" />
                                        </td>
                                        <td>
                                            <input type="text" name="unit[]" class="form-control unit" value="<?php echo $unit;?>" id="unit" />
                                        </td>
                                        <td align="right">
                                            <input type="text" name="total[]" class="form-control total" value="<?php echo $total;?>" id="total" />
                                        </td>
                                        <td>
                                            <button id="addRowBtn">+</button>
                                            <button id="removeRowBtn">-</button>
                                        </td>
                                    </tr>
                                    <?php $lastid=$sl_no; } }else{  $lastid=$lastid+1;  } ?>
                            <tr class="items">
                                <input type="hidden" name="id[]" value="<?php echo $lastid;?>" />
                                <td>
                                    <select name='cat_id[]' id='cat_id' class='form-control'>
                                        <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",'');?>
                                    </select>
                                </td>
                                <td>
                                    <select name='txtprod_id[]' id='txtprod_id' class='form-control'>
                                        <?php createCombo("Product","tbl_product","pd_id","pd_name","ORDER BY pd_name ",'');?>
                                    </select>
                                </td>
                                <td>
                                    <select name='size_id[]' id='size_id' class='form-control'>
                                        <?php createCombo("Size","tbl_size","size_id","size_display","ORDER BY size_display ",'');?>
                                    </select>
                                </td>
                                <td>
                                    <select name='color_id[]' id='color_id' class='form-control'>
                                        <?php createCombo("Color","tbl_color","color_id","color_name"," where color_status=1 ORDER BY color_name ",'');?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="qty[]" class="form-control qty" value="" id="qty" >
                                </td>
                                <td>
                                    <input type="text" name="unit[]" class="form-control unit" value="" id="unit">
                                </td>
                                <td align="right">
                                    <input type="text" name="total[]" class="form-control total" value=""  readonly/>
                                </td>
                                <td>
                                    <button id="addRowBtn">+</button>
                                    <button id="removeRowBtn">-</button>
                                </td>
                            </tr>
                            </tbody>
							<tr class="shipping">
                                <td>Shipping</td>
								<td colspan="4"></td>
                                <td style="display: flex;justify-content: flex-end;">
                                   
                                    
                                </td>
								<td align="right" >
									<p class="sippingPriceP"></p>
									<input type="hidden" name="sippingPrice" id="sippingPrice" value="">
								</td>
								<td></td>
                            </tr>
                            <tr>
                                <td colspan='6' style="text-align:right;">Grand Total</td>
                                <td  align="right"><strong><span class="prReceiveTotalAmnt"><?php echo $total_bill; ?></span></strong></td>
                                <input type="hidden" name="total_bill" class="form-control" value="<?php echo $total_bill; ?>" id="total_bill" />
                                <td></td>
                            </tr>
                        </table>

                        <h5>Billing Address</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="" for="billing_first_name">Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="" placeholder="" id="billing_first_name" name="billing_first_name" class="input-text " required readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="" for="billing_email">Email Address <span style="color:red;">*</span></label>
                                <input type="email" class="form-control" value="" placeholder="" id="billing_email" name="billing_email" class="input-text " required readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="" for="billing_phone">Phone </label>
                                <input type="tel" class="form-control" value="" placeholder="" id="billing_phone" name="billing_phone" class="input-text " required readonly>
                            </div>
							 <div class="col-lg-4">
							  <div class="form-group">
								<label for="country" >Country <span style="color: red">*</span></label>
								<select class="form-control select2" name='billing_country' id='billing_country' required>
								  <?php
								  createCombo( "Country", "tbl_country", "id", "country_desc", "Order by country_desc", '' );
								  ?>
								</select>
							  </div>
							</div>
							<div class="col-lg-4">
							  <div class="form-group">
								<label for="inputCity">State/Province/District <span style="color: red">*</span></label>
								<select name="billing_district" id="billing_district" class="form-control select2" required onchange="shippingPriceShowInp_Chcek_out(this.value)">
								  <option value="">Select City</option>
								  <?php
								  createCombo( "City", "tbl_shipping_costs", "id", "location", "Order by location", '' );
								  ?>
								</select>
							  </div>
							</div>
							<div class="col-md-4">
                                    <label class="" for="billing_address_1">Address <span style="color:red;">*</span></label>
                                    <input type="text" value="" placeholder="Street address" id="billing_address_1" name="billing_address_1" class="input-text form-control" required readonly>
                                </div> 
                            
                            <div class="col-md-4">
                                <label class="" for="billing_state">Street</label>
                                <input type="text" class="form-control" value="" placeholder="" id="billing_street" name="billing_street" class="input-text ">
                            </div>
                            <div class="col-md-4">
                                <label class="" for="billing_postcode">Postcode / ZIP </label>
                                <input type="text" class="form-control" value="" placeholder="" id="billing_postcode" name="billing_postcode" class="input-text ">
                            </div>
                        </div>
                        <h5>Shipping Address</h5>
                        <p id="ship-to-different-address">
                           <label class="checkbox" for="ship-to-different-address-checkbox">Ship to a different address?</label>
                            <input type="checkbox" value="1" class="input-checkbox" id="ship-to-different-address-checkbox">
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="" for="order_comments">Order Notes</label>
                                <textarea cols="5" rows="2" placeholder="Notes about your order, e.g. special notes for delivery." id="order_comments" class="input-text form-control" name="order_comments"></textarea>
                            </div>
                        </div>
                        <div class="hiddenInputs" style="display: none">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="shiping_first_name">Name <span style="color:red;">*</span></label>
                                    <input type="text" value="" placeholder="" id="shiping_first_name" name="shiping_first_name" class="input-text form-control" required >
                                </div>
                                <div class="col-md-4">
                                    <label class="" for="shiping_email">Email Address <span style="color:red;">*</span></label>
                                    <input type="email" value="" placeholder="" id="shiping_email" name="shiping_email" class="input-text form-control" required >
                                </div>  
                                <div class="col-md-4">
                                    <label class="" for="shiping_phone">Phone <span style="color:red;">*</span></label>
                                    <input type="tel" value="" placeholder="" id="shiping_phone" name="shiping_phone" class="input-text form-control" required >
                                </div> 
								
								<div class="col-lg-4">
							  <div class="form-group">
								<label for="country" >Country <span style="color: red">*</span></label>
								<select class="form-control select2" name='shiping_country' id='shiping_country' required>
								  <?php
								  createCombo( "Country", "tbl_country", "id", "country_desc", "Order by country_desc", '' );
								  ?>
								</select>
							  </div>
							</div>
							<div class="col-lg-4">
							  <div class="form-group">
								<label for="shiping_district">State/Province/District <span style="color: red">*</span></label>
								<select name="shiping_district" id="shiping_district" class="form-control select2" required onchange="shippingPriceShowInp_Chcek_out(this.value)">
								  <option value="">Select City</option>
								  <?php
								  createCombo( "City", "tbl_shipping_costs", "id", "location", "Order by location", '' );
								  ?>
								</select>
							  </div>
							</div>
								
								<div class="col-md-4">
                                    <label class="" for="shiping_address_1">Address <span style="color:red;">*</span></label>
                                    <input type="text" value="" placeholder="Street address" id="shiping_address_1" name="shiping_address_1" class="input-text form-control" required readonly>
                                </div> 
                                <div class="col-md-4">
                                    <label class="" for="shiping_state">Street</label>
                                    <input type="text" value="<?php echo $street;?>" placeholder="" id="shiping_street" name="shiping_street" class="input-text form-control">
                                </div>  
                                <div class="col-md-4">
                                    <label class="" for="shiping_postcode">Postcode / ZIP</label>
                                    <input type="text" value="" placeholder="" id="shiping_postcode" name="shiping_postcode" class="input-text form-control">
                                </div>  
                            </div>
                        </div>
                        <div class="wc_payment_method payment_method_cod" style="margin-top: 20px;">
                            <input type="radio" data-order_button_text="" value="cod" name="payment_method" class="input-radio" id="payment_method_cod" checked>
                            <label for="payment_method_cod">Cash on Delivery</label>
                        </div>
                        <div class="form-group mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                <?php if ($mode == 1){ ?>
                                    <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                                <?php } ?>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
 $(document).ready(function() {
    $('.select2').select2();
    shippingPriceShowInp(1);
});

$(document).ready(function() {
    $('#ship-to-different-address-checkbox').change(function() {
        if (!this.checked)
            $('.hiddenInputs').fadeOut('slow');
        else
            $('.hiddenInputs').fadeIn('slow');
    });
});

$("button#addRowBtn").click(function(e) {
    e.preventDefault();
    var lastRow = $('.productReceiveDetailsTable tbody>tr.items:last');
    lastRow.clone(true).insertAfter(lastRow).find('input[type="text"]').val("");
    MyRowId();
});
$("button#removeRowBtn").click(function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    findTotal();
});

MyRowId = function() {
    var myid = 1;
    $('tr.items').each(function(i, el) {
        var $this = $(this);
        $this.find('[name="id\\[\\]"]').val(myid.toFixed(0));
        myid++;
    });

};

$(".qty, .unit").change(function() {
    let currentTr = this.closest('tr');

    let qty = $(currentTr).find('.qty').get(0).value;
    let unit = $(currentTr).find('.unit').get(0).value;
    let subtotal = Number(unit) * Number(qty);
    $(currentTr).find('.total').val(subtotal);
    findTotal();

});

function findTotal() {
    var arr = document.getElementsByName('total[]');
    var tot = 0;
    for (var i = 0; i < arr.length; i++) {
        if (parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    //return tot;


    var sippingPrice = $("#sippingPrice").val();

    $('.prReceiveTotalAmnt').text(parseFloat(tot) + parseFloat(sippingPrice));
    $('#total_bill').val(parseFloat(tot) + parseFloat(sippingPrice));
}


$(document).on('change', 'select[name="cat_id[]"]', function() {
    var total = 0;
    var $nowRow = $(this).closest("tr")[0].rowIndex;
    $('tr.items').each(function(i, el) {
        var $this = $(this);
        if (i == ($nowRow - 1)) {
            $.ajax({
                url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=pd_id,pd_name&table=tbl_product&conditions=where cat_id=" + $this.find('select[name="cat_id[]"]').val() + " &firstText=Select a Product&selectedValue=",
                success: function(html) {
                    $this.find('select[name="txtprod_id[]"]').html(html);
                }
            });
        }
    });
});
$(document).on('change', 'select[name="txtprod_id[]"]', function() {
    var total = 0;
    var $nowRow = $(this).closest("tr")[0].rowIndex;
    $('tr.items').each(function(i, el) {
        var $this = $(this);
        if (i == ($nowRow - 1)) {
            $.ajax({
                url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=tbl_product_color.color_id,color_name&table=tbl_product_color left join tbl_color on tbl_product_color.color_id=tbl_color.color_id&conditions=where pid=" + $this.find('select[name="txtprod_id[]"]').val() + " and color_status=1 &firstText=Select a Color&selectedValue=",
                success: function(html) {
                    $this.find('select[name="color_id[]"]').html(html);
                }
            });
        }
    });
});


$(document).on('change', 'select[name="txtprod_id[]"]', function() {
    var total = 0;
    var $nowRow = $(this).closest("tr")[0].rowIndex;
    $('tr.items').each(function(i, el) {
        var $this = $(this);
        if (i == ($nowRow - 1)) {
            $.ajax({
                url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=tbl_product_size.size_id,size_display&table=tbl_product_size left join tbl_size on tbl_product_size.size_id=tbl_size.size_id&conditions=where pid=" + $this.find('select[name="txtprod_id[]"]').val() + " and status=0 &firstText=Select a Size&selectedValue=",
                success: function(html) {
                    $this.find('select[name="size_id[]"]').html(html);
                }
            });
        }
    });
});

$(document).on('change', 'select[name="txtprod_id[]"]', function() {
    var total = 0;
    var $nowRow = $(this).closest("tr")[0].rowIndex;
    $('tr.items').each(function(i, el) {
        var $this = $(this);
        if (i == ($nowRow - 1)) {
            $.ajax({
                type: "POST",
                url: "pages/get_data.php",
                data: {
                    table: 'tbl_product',
                    id: $this.find('select[name="txtprod_id[]"]').val(),
                    where: 'pd_id'
                }
            }).
            done(function(response) {
                //console.log(response);
                var obj = JSON.parse(response);
                //console.log(obj);
                if (obj.success === 'fail') {
                    $this.find('input[name="unit[]"]').val('');
                } else {
                    console.log(obj.pd_price);
                    $this.find('input[name="unit[]"]').val(obj.pd_price);
                }

            })
        }
    });
});

function save() {
    if ($('form#orderAddForm').parsley().validate()) {
        $.ajax({
            type: "POST",
            url: "pages/order/order_save.php",
            data: $('#orderAddForm').serialize()
        }).done(function(response) {
            alertify.set('notifier', 'position', 'bottom-right');
            alertify.success(response);
            view_data();
            console.log(response)
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
}

/*function shippingPriceShowInp(val) {
	
    $.ajax({
        type: "POST",
        url: "../../front_xhr/get_shipping_price.php",
        data: {
            shipping_id: val
        }
    }).done(function(response) {
        $(".sippingPriceP").html(response);
        $("#sippingPrice").val(response);
        findTotal();
    })
}*/
	
function shippingPriceShowInp_Chcek_out(val) {
       
		if($("#ship-to-different-address-checkbox").is(':checked') ) {
    		var sid=$("#shiping_district").val();
		} else {
			var sid=$("#billing_district").val();
		}
        $.ajax({
            type: "POST",
            url: "../../front_xhr/get_shipping_price.php",
            data: {
                shipping_id: sid
            }
        }).done(function(response) {
			
            $(".sippingPriceP").html(parseFloat(response).toFixed(2));
        	$("#sippingPrice").val(response);
			 findTotal();
            
        })
    }	
	
	
	
$("#cl_id").change(function() {
    var clid = $("#cl_id").val();
    $.ajax({
        type: "POST",
        url: "pages/get_data.php",
        data: {
            table: 'tbl_customer',
            id: clid,
            where: 'cl_id'
        }
    }).
    done(function(response) {
        console.log(response);
        var obj = JSON.parse(response);
        //console.log(obj);
        if (obj.success === 'fail') {
            $('#billing_first_name').val('');
            $('#billing_email').val('');
            $('#billing_phone').val('');
            $('#billing_country').val('');
            $('#billing_district').val('');
            $('#city').val('');
            $('#billing_postcode').val('');
            $('#billing_address_1').val('');

            $('#shiping_first_name').val('');
            $('#shiping_email').val('');
            $('#shiping_phone').val('');
            $('#shiping_country').val('');
            $('#shiping_address_1').val('');
            $('#shiping_district').val('');
            $('#shiping_street').val('');
            $('#shiping_postcode').val('');
        } else {
            $('#billing_first_name').val(obj.firstname);
            $('#billing_email').val(obj.email);
            $('#billing_phone').val(obj.phone);
            $('#billing_country').val(obj.country);
            $('#billing_district').val(obj.district);
            $('#city').val(obj.city);
            $('#billing_postcode').val(obj.postal_code);
            $('#billing_address_1').val(obj.address);

            $('#shiping_first_name').val(obj.firstname);
            $('#shiping_email').val(obj.email);
            $('#shiping_phone').val(obj.phone);
            $('#shiping_country').val(obj.country);
            $('#shiping_address_1').val(obj.address);
            $('#shiping_district').val(obj.district);
            $('#shiping_street').val(obj.city);
            $('#shiping_postcode').val(obj.postal_code);
            $('.select2').select2();
			shippingPriceShowInp_Chcek_out(1);
        }
    })

});
$(document).on('change', '#billing_country', function() {
    var nowRow = $("#billing_country").val();
    $.ajax({
        url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,location&table=tbl_shipping_costs&conditions=where country_id=" + nowRow + " &firstText=Select a City&selectedValue=",
        success: function(html) {
            $('#billing_district').html(html);
        }
    });
});
$(document).on('change', '#shiping_country', function() {
    var nowRow = $("#shiping_country").val();
    $.ajax({
        url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,location&table=tbl_shipping_costs&conditions=where country_id=" + nowRow + " &firstText=Select a City&selectedValue=",
        success: function(html) {
            $('#shiping_district').html(html);
        }
    });
});
</script>
