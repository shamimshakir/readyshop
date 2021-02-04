
<?php include('../header.php');
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];
$addper = 0;
$addper = PermissionVerification( $user_role, $pageid, 'add' );
?>

<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Current Order Information</span>
                    </h4>

                    <form id="reportForm" class="form-group">
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="txtod_status">Status</label>
                                <select name='txtod_status' id='txtod_status' class="form-control">
                                    <?php createCombo("Order","tbl_order_status","id","ord_status","  where id  in (5,6) ORDER BY id DESC",$ord_status); ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="txtc_id">Customer</label>
                                <select name='txtc_id' id='txtc_id' class="form-control">
                                    <?php createCombo("Customer","tbl_customer","cl_id","firstname","ORDER BY firstname ",$cl_id); ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="txtfromrec_date" >From</label>
                                <input type="date" class="form-control" name="txtfromrec_date" id="txtfromrec_date" value="<?php echo $fromrec_date; ?>" />
                            </div>
                            <div class="col-lg-2">
                                <label for="txttorec_date">To</label>
                                <input type="date" class="form-control" name="txttorec_date" id="txttorec_date" value="<?php echo $torec_date; ?>" />
                            </div>
                            <div class="col-lg-2">
                                <label for="txtod_no">Order No</label>
                                <input class="form-control" name="txtod_no" id="txtod_no">
                            </div>
                            <div class="col-lg-2">
                                <input value='Show Report' type='button' name='btnsubmit' id="btn-filter" class='forms_button_e btn btn-primary' style="margin-top: 22px;" >
                            </div>
                        </div>
                    </form>

                    <table id="tableData" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Order No</th>
                                <th>Client</th>
                                <th>Payment Status</th>
                                <th>Payment Date</th>
                                <th>Order Date</th>
                                <th>Ship Date</th>
                                <th>Order Status</th>
                                <th>Order Amount</th>
                                <th class="td-actions">Acitons</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $( document ).ready(function() {
		table =$('#tableData').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"searching": false,
		"stateSave": true,
		"pageLength": 10,
		"bLengthChange": false,
		"ajax":{
			url :"pages/order/ordercd_get.php?page=<?php echo $pageid?>", // json datasource
			type: "GET",
            datatype: "json",	
			dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
				//console.log(inData);
				 return inData;
			 },
			data:{
				txtod_status:$('#txtod_status').val(),
				txtc_id:$('#txtc_id').val(),
				txtfromrec_date:$('#txtfromrec_date').val(),
				txttorec_date:$('#txttorec_date').val(),
				txtod_no:$('#txtod_no').val(),
				
             // what is being sent to the server
          // console.log(outData);
             //return outData;
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
            // console.log(err);
         	},		
		  }
		}); 
		$('#btn-filter').click(function(){//button filter event click
		//alert($('#name').val());
		table.destroy();
		table.ajax.reload();  //just reload table
		  table =$('#tableData').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"searching": false,
			"stateSave": true,
			"pageLength": 10,
			"bLengthChange": false,
			 "ajax":{
			   url :"pages/order/ordercd_get.php?page=<?php echo $pageid?>", // json datasource
				type: "post",  // type of method  ,GET/POST/DELETE
				
				dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
				console.log(inData);
				 return inData;
			 },
			data:{
				txtod_status:$('#txtod_status').val(),
				txtc_id:$('#txtc_id').val(),
				txtfromrec_date:$('#txtfromrec_date').val(),
				txttorec_date:$('#txttorec_date').val(),
				txtod_no:$('#txtod_no').val(),
				
             // what is being sent to the server
          // console.log(outData);
             //return outData;
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
            // console.log(err);
         	},	
			  }
			});  
		});
	});

	function viewdata() {
	  $('#btn-filter').click()
	}
    
    
    function view_datacd() {
        $.ajax({
            type: "GET",
            url: "pages/order/ordercd.php",
            dataType: "html"
        }).done(function(msg) {
            $("#mainContent").html(msg);
        })
    }
    
    function order_status_form(od_id) {
        $.ajax({
            type: "POST",
            url: "pages/order/order_status_form.php",
            data: {od_id : od_id},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    
    function payment_amount_form(od_id) {
        $.ajax({
            type: "POST",
            url: "pages/order/payment_amount_form.php",
            data: {od_id : od_id},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    
    function order_items(od_id){
        $.ajax({
            type: "POST",
            url: "pages/order/order_items.php",
            data: {od_id : od_id},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
        
    function order_details(od_id){
        $.ajax({
            type: "POST",
            url: "pages/order/order_details.php",
            data: {od_id : od_id},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
function productOptionByCat(cat) {
        $.ajax({
            type: "POST",
            url: "pages/rpt_product_lsit/get_product_by_cat.php",
            data: {
                cat_id: cat
            }
        }).done(function(msg) {
            $("#s_product_id").html(msg);
        }).fail(function() {
            alert("error");
        });
    }
    $(document).ready(function() {
        $('.s_product_id').select2();
    });
</script>



