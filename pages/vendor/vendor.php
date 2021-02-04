<?php
	include( '../header.php' );
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
                        <span>Vendor</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="tableData" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Reg Date</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th class="td-actions">Edit</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    $( document ).ready(function() {
		table =$('#tableData').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"searching": true,
		"stateSave": true,
		"responsive": true,
		"pageLength": 100,
		"bLengthChange": true,
		
		"ajax":{
			url :"pages/vendor/vendor_get.php?page=<?php echo $pageid?>", // json datasource
			type: "GET",
            datatype: "json",	
			dataFilter:function(inData){
				 // what is being sent back from the server (if no error)
				//console.log(inData);
				 return inData;
			 },
			data:function(outData){
             // what is being sent to the server
            //console.log(outData);
             return outData;
         	},
			 error:function(err, status){
             // what error is seen(it could be either server side or client side.
             console.log(err);
         	},		
		  }
		}); 
	});

    function view_data() {
        $(".active").click();
        $("li.active .submenu").css("height", "auto");
    };

	function add() {
        $.ajax({
            type: "POST",
            url: "pages/vendor/vendor_form.php?page=<?php echo $_REQUEST['page']?>",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    
	function edit(vendor_id) {
        $.ajax({
            type: "POST",
            url: "pages/vendor/vendor_form.php?page=<?php echo $_REQUEST['page']?>",
            data: {
                mode: 2,
                vendor_id : vendor_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }

    function update_status(id) {
        $.ajax({
            type: "POST",
            url: "pages/update_status_ajax.php",
            data: {
                table: "tbl_vendor",
                idField: "vendor_id",
                id: id,
                status: "status"
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }

</script>



