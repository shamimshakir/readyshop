
<?php include('../header.php');
    $mode = 1;
    if(isset($_REQUEST['invoiceobjet_id'])){
        $invoiceobjet_id = $_REQUEST['invoiceobjet_id'];
        $mode = 2;
        $inv_id=$_REQUEST['invoiceobjet_id'];
        $SeNTlist = "SELECT * FROM mas_mat_receive WHERE invoiceobjet_id = '$inv_id' ";
        $ExSeNTlist=mysqli_query($conn, $SeNTlist) or die(mysqli_error($conn));
        $rowNewsTl=mysqli_fetch_array($ExSeNTlist);
        extract($rowNewsTl);
    }
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
                        <h4 class="mt-0 header-title">Add Product Receive</h4>
                    <?php }elseif ($mode = 2){ ?>
                        <h4 class="mt-0 header-title">Edit Product Receive</h4>
                    <?php }?>


                    <form id="productReceiveForm" class="" action="#" >
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
						
                        <input type="hidden" name="invoiceobjet_id" value="<?php  if($mode==2){echo $inv_id;}?>">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="client_id">Vendor <span style="color:red;">*</span></label>
                                <?php
                                echo "<select name='client_id' id='client_id' class='form-control' required>";
                                createCombo("Vendor","tbl_vendor","vendor_id","vendor_name"," where status=1 ORDER BY vendor_name ",$client_id);
                                echo "</select>";
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label for="invoice_date">Received Date	</label>
                                <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="<?php if(!empty($invoice_date)){ echo $invoice_date; } else { echo date('Y-m-d', time()); } ?>" Maxlength="30" required>
                            </div>
                            <div class="col-md-4">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" name="comments" id="comments"  rows="3" ><?php echo $comments; ?></textarea>
                            </div>
                        </div>

                        <h4 style="font-size: 15px; font-weight: 600;">Select Products</h4>

                        <table class="table table-bordered productReceiveDetailsTable">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
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
                                            <select name='cat_id[]' id='cat_id' class='form-control' required>
                                                <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",$cat_id);?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name='txtprod_id[]' id='txtprod_id' class='form-control' required>
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
                                            <input type="text" name="qty[]" class="form-control qty" value="<?php echo $qty;?>" required/>
                                        </td>
                                        <td>
                                            <input type="text" name="unit[]" class="form-control unit" value="<?php echo $unit;?>" required/>
                                        </td>
                                        <td>
                                            <input type="text" name="total[]" class="form-control total" value="<?php echo $total;?>"  />
                                        </td>
                                        <td>
                                            <button id="addRowBtn">+</button>
                                            <button id="removeRowBtn">-</button>
                                        </td>
                                    </tr>


                                    <?php $lastid=$sl_no; } }
								else{  $lastid=$lastid+1; ?>
                            <tr class="items">
                                <input type="hidden" name="id[]" value="<?php echo $lastid;?>" />
                                <td>
                                    <select name='cat_id[]' id='cat_id' class='form-control' required>
                                        <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",'');?>
                                    </select>
                                </td>
                                <td>
                                    <select name='txtprod_id[]' id='txtprod_id' class='form-control' required>
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
                                    <input type="text" name="qty[]" class="form-control qty" value="" id="qty" required>
                                </td>
                                <td>
                                    <input type="text" name="unit[]" class="form-control unit" value="" id="unit" required>
                                </td>
                                <td>
                                    <input type="text" name="total[]" class="form-control total" value=""  readonly required/>
                                </td>
                                <td>
                                    <button id="addRowBtn">+</button>
                                    <button id="removeRowBtn">-</button>
                                </td>
                            </tr>
								<?php  } 
								?>
                            </tbody>
                            <tr>
                                <td colspan='6' style="text-align:right;">Grand Total</td>
                                <td style="text-align:center;"><strong><span class="prReceiveTotalAmnt"><?php echo $total_bill; ?></span></strong></td>
                                <input type="hidden" name="total_bill" class="form-control" value="<?php echo $total_bill; ?>" id="total_bill" />
                                <td></td>
                            </tr>
                        </table>

                        <div class="form-group mb-0 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                <?php if ($mode == 1){ ?>
                                    <button type="Submit"  class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                                <?php }elseif($mode == 2){ ?>
                                    <button  type="Submit"  class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                                <?php }?>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
	
	
	
	$(document).ready(function(e) {
			$("#productReceiveForm").on('submit', (function(e) {
				//alert('hello');
				var data=new FormData(this)
			        e.preventDefault();
					
			        $.ajax({
			            url: "pages/productreceive/productreceive_save.php",
                		data: $('#productReceiveForm').serialize(),
			            type: "POST", // Type of request to be send, called as method
			           
			           
			        }).done(function(msg) {
						 alertify.set('notifier','position', 'bottom-right');
							alertify.success(msg);
							view_data();
							console.log(msg) 
					}).fail(function() {
						alertify.error('Error');
					});
			    }));
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
        var myid=1;
        $('tr.items').each(function(i, el) {
            var $this = $(this);
            $this.find('[name="id\\[\\]"]').val(myid.toFixed(0));
            myid++;
        });
		
    };
    
    
    $( ".qty, .unit" ).change(function() {
        let currentTr = this.closest('tr');
        
        let qty = $(currentTr).find('.qty').get(0).value;
        let unit = $(currentTr).find('.unit').get(0).value;
        let subtotal = Number(unit) * Number(qty);
		$(currentTr).find('.total').val(subtotal);
		findTotal();
        
    });
  function findTotal(){
    var arr = document.getElementsByName('total[]');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
	  //return tot;
	  $('.prReceiveTotalAmnt').text(tot);
        $('#total_bill').val( tot)
}

    
    
    
</script>
<script>
$(document).on('change', 'select[name="cat_id[]"]', function(){
		var total = 0;
		var $nowRow =$(this).closest("tr")[0].rowIndex;
		$('tr.items').each(function(i, el){
			var $this = $(this);
			if(i==($nowRow-1))
			{
				$.ajax({
					url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=pd_id,pd_name&table=tbl_product&conditions=where cat_id=" +$this.find('select[name="cat_id[]"]').val()+" &firstText=Select a Product&selectedValue=" ,
					success: function(html){
					$this.find('select[name="txtprod_id[]"]').html(html);
				}
				});
			}
		});
	});
$(document).on('change', 'select[name="txtprod_id[]"]', function(){
		var total = 0;
		var $nowRow =$(this).closest("tr")[0].rowIndex;
		$('tr.items').each(function(i, el){
			var $this = $(this);
			if(i==($nowRow-1))
			{
				$.ajax({
					url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=tbl_product_color.color_id,color_name&table=tbl_product_color left join tbl_color on tbl_product_color.color_id=tbl_color.color_id&conditions=where pid=" +$this.find('select[name="txtprod_id[]"]').val()+" and color_status=1 &firstText=Select a Color&selectedValue=" ,
					success: function(html){
					$this.find('select[name="color_id[]"]').html(html);
				}
				});
			}
		});
	});
$(document).on('change', 'select[name="txtprod_id[]"]', function(){
		var total = 0;
		var $nowRow =$(this).closest("tr")[0].rowIndex;
		$('tr.items').each(function(i, el){
			var $this = $(this);
			if(i==($nowRow-1))
			{
				$.ajax({
					url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=tbl_product_size.size_id,size_display&table=tbl_product_size left join tbl_size on tbl_product_size.size_id=tbl_size.size_id&conditions=where pid=" +$this.find('select[name="txtprod_id[]"]').val()+" and status=0 &firstText=Select a Size&selectedValue=" ,
					success: function(html){
					$this.find('select[name="size_id[]"]').html(html);
				}
				});
			}
		});
	});	
	
	
	
</script>
