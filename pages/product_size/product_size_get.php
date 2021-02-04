<?php include('../header.php');
    $SUserID =$_SESSION['user_profile_id'];
    $pageid = pick('_tree_entries', 'id', "file_name = 'product_size.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Product Size</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Size Display</th>
                                <!-- <th>Size type</th> -->
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th class="td-actions">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        $res = mysqli_query($conn, "SELECT 
                                        *
                                      FROM 
                                        tbl_size
                                      ORDER BY size_id ASC");
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $size_display;?></td>
                                <!-- <td><?php echo $size_type ;?></td> -->
                                <td><?php echo $size_remarks ;?></td>
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
                                            <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $row['size_id']; ?>)" 
                                                <?php if ( $status == 0 ) { echo "checked";}else{ }?>
                                                >
                                            <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                                        </div>
                                    </td>
                                
                                <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['size_id'];?>)" data-toggle="modal" data-target="#myModal">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </button><?php } ?>
                                </td>
                            </tr>

                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/product_size/product_size_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    } 
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/product_size/product_size_form.php",
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
                table: "tbl_size",
                idField: "size_id",
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
