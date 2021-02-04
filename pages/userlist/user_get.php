<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'user.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>User</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th> Sl </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Mobile </th>
                            <th> Status </th>
                            <th> Action </th>
                            <th class="td-actions"> Edit </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $res = mysqli_query($conn, "SELECT * FROM users");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res))
                        {
                            extract($row);


                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['real_name'];?></td>
                                <td><?php echo $row['user_email'];?></td>
                                <td><?php echo $row['mobile'];?></td>
                                <td><?php
                                    if ( $status == 1 ) {
                                      ?>
                                      <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
                                      <?php }  ?>
                                </td>
                                <td>
                                     <div>
                                        <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $user_id; ?>)" 
                                            <?php if ( $status == 0 ) { echo "checked";}else{ }?>
                                            >
                                        <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                                    </div>
                                </td>
                                <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['user_id'];?>)"> Edit</button><?php } ?>
                                </td>
                            </tr>

                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
	$(document).ready(function() {
    	$('#datatable').DataTable({
			"searching": true,
			"stateSave": true,
			"pageLength": 100,
			"bLengthChange": true,
		});
	});
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/userlist/user_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(user_id) {
        $.ajax({
            type: "POST",
            url: "pages/userlist/user_form.php",
            data: {
                mode: 2,
                user_id : user_id,
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
                table: "users",
                idField: "user_id",
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