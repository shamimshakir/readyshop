<?php
include( '../header.php' );
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];
$addper = 0;
$addper = PermissionVerification( $user_role, $pageid, 'add' );
?>
<div id="mainContent">
  <div>
    <div class="row">
      <div class="col-12">
        <div class="card m-b-20">
          <div class="card-body" id="card-body">
            <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Shipping Cost</span>
              <?php if($addper>0){?>
              <span> <button class="btn btn-primary" onclick="add()">Add new</button> </span>
              <?php } ?>
            </h4>
            <table class="table table-bordered table-condensed table-striped table-hover color-table info-table" id="tableData">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Description</th>
					
                  <th>Image</th>
                  <th class="td-actions">Action</th>
                </tr>
              </thead>
            </table>
          </div>
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
		"searching": true,
		"stateSave": true,
		"pageLength": 20,
		"bLengthChange": true,
		"ajax":{
			url :"pages/shiping/shiping_get.php?page=<?php echo $pageid?>", // json datasource
			type: "GET",
            datatype: "json",	
			dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
				// console.log(inData);
				 return inData;
			 },
			data:function(outData){
             // what is being sent to the server
            // console.log(outData);
             return outData;
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
             console.log(err);
         	},		
		  }
		}); 
		$('#btn-filter').click(function(){//button filter event click
	
		table.destroy();
		table.ajax.reload();  //just reload table
		  table =$('#tableData').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"searching": true,
			"stateSave": true,
			"pageLength": 20,
			"bLengthChange": true,
			"ajax":{
			   url :"pages/shiping/shiping_get.php?page=<?php echo $pageid?>", // json datasource
				type: "post",  // type of method  ,GET/POST/DELETE
				data: {
					id:'1'
				},
				dataFilter:function(inData){
    				 // what is being sent back from the server (if no error)
    				// console.log(inData);
    				 return inData;
    			},
    			data:function(outData){
                     // what is being sent to the server
                    // console.log(outData);
                     return outData;
             	},
    			error:function(err, status){
                     // what error is seen(it could be either server side or client side.
                     console.log(err);
             	},	
			  }
			});  
		});
		});
	function viewdata() {
		  $('#btn-filter').click()
		}
    function add(){
        $.ajax({
            type: "POST",
            url: "pages/shiping/shiping_form.php?page=<?php echo $_REQUEST[ 'page' ];?>",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/shiping/shiping_form.php?page=<?php echo $_REQUEST[ 'page' ];?>",
            data: {
                mode: 2,
                id : id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
          });
    }

</script>