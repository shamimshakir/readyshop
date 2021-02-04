<?php
include( '../header.php' );
$SUserID = $_SESSION[ "SUserID" ];
$pageid = pick( '_tree_entries', 'id', "file_name = 'product.php'" );
$addper = PermissionVerification( $SUserID, $pageid, 'add' );
?>
<div id="mainContent">
  <div class="row">
    <div class="col-12">
      <div class="card m-b-20">
        <div class="card-body" id="card-body">
          <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Product</span>
            <?php if($addper>0){?>
            <span>
            <button class="btn btn-primary" onclick="add()">Add new</button>
            </span>
            <?php }?>
          </h4>
          <form id="productSearchForm" class="form-group">
            <div class="row">
              <div class="col-lg-3">
                <label for="cat_id">Category</label>
                <select name='cat_id' id='cat_id_id' class='form-control'>
                  <?php createCombo("Category","tbl_category","cat_id","cat_name","ORDER BY cat_name ",$cat_id);?>
                </select>
              </div>
              <div class="col-lg-3">
                <label for="status">Status</label>
                <select name='status' id='status_id' class='form-control'>
                  <option value="">Select Status</option>
                  <option value="upsstat">Upcoming</option>
                  <option value="popular_stat">Popular</option>
                  <option value="feature_stat">Feature</option>
                  <option value="new_stat">New</option>
                  <option value="onsale_stat">On Sale</option>
                  <option value="pd_status">Inactive</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label for="product">Product</label>
                <input name='product_name' id='product_name' class='form-control' type="text">
              </div>
              <div class="col-lg-2">
                <input value="Filter" type="button" name="btnsubmit" class="forms_button_e btn btn-primary" style="margin-top: 22px;" id="btn-filter">
              </div>
            </div>
          </form>
          <div id="loadProducts">
            <table id="tableData" class="table table-bordered responsive dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Brand</th>
                  <th>Code</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Thumbnail</th>
                  <th>Status/Badge</th>
                  <th class="td-actions"> </th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- end col --> 
  </div>
</div>
<script>
    // function view_data() {
    //     $.ajax({
    //         type: "POST",
    //         url: "pages/product/product_get.php",
    //         data: $('#productSearchForm').serialize()
    //     }).done(function(msg) {
    //         $("#loadProducts").html(msg);
    //         console.log(msg)
    //     });
    // }
    // view_data();
    
    
    $( document ).ready(function() {
		table =$('#tableData').DataTable({
    "responsive": true,
		"bProcessing": true,
		"serverSide": true,
		"searching": false,
		"stateSave": true,
		"pageLength": 100,
		"bLengthChange": false,
		"ajax":{
			url :"pages/product/product_get.php?page=<?php echo $pageid?>", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
			//	console.log(inData);
				 return inData;
			 },
			data:{
             // what is being sent to the server
            // console.log(outData);
                cat_id : $('#cat_id_id').val(),
				status : $('#status_id').val(),
				product_name : $('#product_name').val(),
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
             //console.log(err);
         	},		
		  }
		}); 
		$('#btn-filter').click(function(){//button filter event click
		
		table.destroy();
		table.ajax.reload();  //just reload table
		  table =$('#tableData').DataTable({
      "responsive": true,
			"bProcessing": true,
			"serverSide": true,
			"searching": false,
			"stateSave": true,
			"pageLength": 100,
			"bLengthChange": false,
			 "ajax":{
			   url :"pages/product/product_get.php?page=<?php echo $pageid?>", // json datasource
				type: "post",  // type of method  ,GET/POST/DELETE
				dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
				console.log(inData);
				 return inData;
			 },
			data:{
             // what is being sent to the server
            //console.log(outData);
            cat_id : $('#cat_id_id').val(),
				status : $('#status_id').val(),
				product_name : $('#product_name').val(),
            
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
             //console.log(err);
         	},	
			  }
			});  
		});
	});

    function view_data() {
        $(".active").click();
        $("li.active .submenu").css("height", "auto");
    };
    
    function edit(pd_id) {
        $.ajax({
            type: "POST",
            url: "pages/product/product_form.php",
            data: {
                mode: 2,
                pd_id : pd_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/product/product_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function update_status(statusName, product_id){
        $.ajax({
            type: "POST",
            url: "pages/product/change_product_status.php",
            data: {
                product_id: product_id,
                statusName : statusName,
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        })
    }

</script> 
