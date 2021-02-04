<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'coupon.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Coupon</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Value</th>
                            <th>Multiple</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th class="td-actions">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT coupons.*, 
                                Date(coupons.start_date) as startDate, 
                                Date(coupons.end_date) AS endDate 
                                FROM coupons");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['code'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td><?php echo $row['value'];?></td>
                                <td><?php echo $row['multiple'];?></td>
                                <td><?php echo $row['startDate'];?></td>
                                <td><?php echo $row['endDate'];?></td>
                                <td><?php
                                    if ( $active == 1 ) {
                                      ?>
                                      <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
                                      <?php }  ?>
                                </td>
                                <td>
                                     <div>
                                        <input type="checkbox" id="switch<?php echo $i;?>" switch="none"  value="1" onclick="update_status(<?php echo $id;?>)" 
                                            <?php if ( $active == 0 ) { echo "checked";}else{ }?>
                                            >
                                        <label for="switch<?php echo $i;?>" data-on-label="On" data-off-label="Off" ></label>
                                    </div>
                                </td>
                                <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)">  Edit
                                    </button><?php } ?>
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
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/coupon/coupon_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/coupon/coupon_form.php",
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
                table: "coupons",
                idField: "id",
                id: id,
                status: "active"
            },
            success: function (response){
                alertify.set('notifier','position', 'bottom-right');
                alertify.success(response);
                view_data();
            }
        });
    }
</script>