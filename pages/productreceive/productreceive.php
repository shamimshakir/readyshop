<?php
include( '../header.php' );
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];
$addper = 0;
echo $addper = PermissionVerification( $user_role, $pageid, 'add' );
echo $stock_maintain = pick( 'tbl_parameter', 'parameter_status', " parameter_name= 'stock_inventory'" );
?>
<div id="mainContent">
  <div class="row">
    <div class="col-12">
      <div class="card m-b-20">
        <div class="card-body" id="card-body">
          <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Product Receive</span> <span>
            <?php if($addper>0 && $stock_maintain==0){?>
            <button class="btn btn-primary" onclick="add()">Add new</button>
            <?php }?>
            </span> </h4>
          <form id="reportForm">
            <div class="row">
              <div class="col-md-3">
                <label for="client_id">Vendor </label>
                <?php echo "<select name='client_id' id='client_id' class='form-control' required>";
                createCombo( "Vendor", "tbl_vendor", "vendor_id", "vendor_name", "ORDER BY vendor_name ", $client_id );
                echo "</select>";
                ?> </div>
              <div class="col-md-3">
                <label for="txtpd_id">Category</label>
                <select name='txtcat_id' id='txtcat_id' class="form-control" onchange="productOptionByCat(this.value)">
                  <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",$cat_id); ?>
                </select>
              </div>
              <div class="col-md-3">
                <label class="control-label">Select Product</label>
                <select class="form-control select2 s_product_id" name='s_product_id' id='s_product_id'>
                  <option value="0">Select category first</option>
                </select>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-3">
                <label class="control-label">Bill No.</label>
                <input class="form-control" name='bill_no' id="bill_no" />
              </div>
              <div class="col-md-3">
                <label for="txtfromentry_date">Received date From</label>
                <input type="date" class="form-control" name="txtfromentry_date" id="txtfromentry_date" value="<?php echo $fromentry_date; ?>"/>
              </div>
              <div class="col-md-3">
                <label for="txttoentry_date">To</label>
                <input type="date" class="form-control" name="txttoentry_date" id="txttoentry_date" value="<?php echo $toentry_date; ?>" />
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-primary" style="margin-top: 20px;" id="btn-filter">Show Report</button>
              </div>
            </div>
          </form>
          <table id="tableData" class="table table-bordered table-condensed table-striped table-hover color-table info-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
              <tr>
                <th>Sl</th>
                <th>Invoice No.</th>
                <th>Invoice Date</th>
                <th>Client</th>
                <th>Total Bill</th>
                <th>Entry Date</th>
                <th>Update Date</th>
                <th class="td-actions">Acitons</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <!-- end col --> 
  </div>
</div>
<script>
    // function view_data() {
    //     $.ajax({
    //         type: "GET",
    //         url: "pages/productreceive/productreceive_get.php",
    //         dataType: "html"
    //     }).done(function(msg) {
    //         $("#mainContent").html(msg);
    //     })
    // }
    // view_data();
    
    $( document ).ready(function() {
		table =$('#tableData').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"searching": false,
		"stateSave": true,
			"responsive": true,
		"pageLength": 20,
		"bLengthChange": false,
		"ajax":{
			url :"pages/productreceive/productreceive_get.php?page=<?php echo $pageid?>", // json datasource
			type: "GET",
            datatype: "json",	
			dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
				// console.log(inData);
				 return inData;
			 },
			data:{
             // what is being sent to the server
            //console.log(outData);
            client_id : $('#client_id').val(),
			txtcat_id : $('#txtcat_id').val(),
			s_product_id : $('#s_product_id').val(),
			bill_no : $('#bill_no').val(),
			txtfromentry_date : $('#txtfromentry_date').val(),
			txttoentry_date : $('#txttoentry_date').val(),
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
             console.log(err);
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
			  "responsive": true,
			"stateSave": true,
			"pageLength": 20,
			"bLengthChange": false,
			 "ajax":{
			   url :"pages/productreceive/productreceive_get.php?page=<?php echo $pageid?>", // json datasource
				type: "post",  // type of method  ,GET/POST/DELETE
				
				dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
				// console.log(inData);
				 return inData;
			 },
			data:{
            client_id : $('#client_id').val(),
			txtcat_id : $('#txtcat_id').val(),
			s_product_id : $('#s_product_id').val(),
			bill_no : $('#bill_no').val(),
			txtfromentry_date : $('#txtfromentry_date').val(),
			txttoentry_date : $('#txttoentry_date').val(),
				
            
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
             console.log(err);
         	},	
			  }
			});  
		});
		});
    function view_data() {
        $(".active").click();
        $("li.active .submenu").css("height", "auto");
    };
		
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/productreceive/productreceive_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }		
		
    function edit(invoiceobjet_id) {
        $.ajax({
            type: "POST",
            url: "pages/productreceive/productreceive_form.php",
            data: {
                mode: 2,
                invoiceobjet_id : invoiceobjet_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }

</script> 
