<?php include('../header.php');
   $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'advmanagement.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Advertisement  Management</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Company Name</th>
                                <th>Business Type</th>
                                <th>Company URL</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Position</th>
                                <th>Logo</th>
                                <th class="td-actions">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($conn, "SELECT tbl_adv.*, tbl_business_type.business_type 
                                                                AS 
                                                                    busiType
                                                                FROM 
                                                                    tbl_adv
                                                                LEFT JOIN 
                                                                    tbl_business_type 
                                                                ON 
                                                                    tbl_business_type.btype_id = tbl_adv.business_type ");
                            $i = 1;
                            while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $row['comp_name'];?></td>
                                    <td><?php echo $row['busiType'];?></td>
                                    <td><?php echo $row['comp_url'];?></td>
                                    <td><?php echo $row['comp_status'];?></td>
                                    <td><?php echo $row['start_date'];?></td>
                                    <td><?php echo $row['end_date'];?></td>
                                    <td><?php echo $row['adv_position'];?></td>
                                    <td>
                                        <img style="height: 50px;max-width: 50px;" src="<?php echo $folder_admin; ?>adv/<?php echo $row['comp_image'];?>" alt="">
                                    </td>
                                    <td>
                                        <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['adv_id'];?>)" >
                                             Edit
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
            url: "pages/advmanagement/advmanagement_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(adv_id) {
        $.ajax({
            type: "POST",
            url: "pages/advmanagement/advmanagement_form.php",
            data: {
                mode: 2,
                adv_id : adv_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
</script>