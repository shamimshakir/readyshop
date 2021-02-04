<?php include('../header.php')?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Page Content</span>
                        <span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span>
                    </h4>

                     <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Page Title</th>
                            <th>Page Name</th>
                            <!-- <th>Page Content</th> -->
                            <th>Status</th>
                            <th>Action</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM tbl_pages_content ");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['page_title'];?></td>
                                <td><?php echo $row['page_name'];?></td>
                                <!-- <td><?php echo $row['page_content'];?></td> -->
                                <td><?php if ( $row['active_status'] == 1 ) { ?>
                                      <span class="badge badge-pill badge-success">Active</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger">Inactive</span><br>
                                      <?php }  ?> </td>
                                <td>
                                     <div>
                                        <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $row['id']; ?>)" 
                                            <?php if ( $row['active_status'] == 0 ) { echo "checked";}else{ }?>
                                            >
                                        <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)">  Edit
                                    </button>
                                </td>
                            </tr>

                            <?php $i++; } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
	$(document).ready(function() {
		$('#datatable').DataTable(
		{
			"searching": true,
			"stateSave": true,
			"pageLength": 100,
			"responsive": true,
			"bLengthChange": true,
		}
		);
	} );
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/page_content/page_content_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/page_content/page_content_form.php",
            data: {
                mode: 2,
                id : id,
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
                table: "tbl_pages_content",
                idField: "id",
                id: id,
                status: "active_status"
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }
</script>