<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'profile.php'");
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
                            <button class="btn btn-primary" onClick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th> Sl </th>
                            <th> Name</th>
                            <th> Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $res = mysqli_query($conn, "SELECT * FROM user_profile");
                        $i = 1;
                        while ($row = mysqli_fetch_array($res)) {
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['profile_name'];?></td>
                                <td align="right">
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['user_profile_id'];?>)"><i class="mdi mdi-grease-pencil"></i> Edit</button><?php } ?>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="permission_2(<?php echo $row['user_profile_id'];?>)"> Set Permission</button><?php } ?>
                                </td>
                            </tr>

                            <?php
                            $i++;
                        } ?>
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
            url: "pages/profile/profile_form.php",
            data: {
                mode:1
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
	function edit(user_profile_id) {
        $.ajax({
            type: "POST",
            url: "pages/profile/profile_form.php",
            data: {
                mode: 2,
                user_profile_id : user_profile_id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function permission_2(id) {
        $.ajax({
            type: "POST",
            url: "pages/profile/profile_permission.php",
            data: {
                id : id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
                
            }
        });
    }
</script>