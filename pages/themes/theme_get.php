<?php include('../header.php');
    $SUserID =$_SESSION['user_profile_id'];
    $pageid = pick('_tree_entries', 'id', "file_name = 'tag.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Themes</span>
                        <span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span>
                    </h4>

                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Theme Name</th>
                                <th>Active Status</th>
                                <th>Edit Status</th>
                                <th class="td-actions">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT 
                                        *
                                      FROM 
                                        tbl_theme
                                      ORDER BY id ASC");
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $theme_name;?></td>
                                <td><?php
                                    if ( $status == 1 ) {
                                      ?>
                                      <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
                                      <?php }  ?>
                                </td>
                                <td><?php
                                    if ( $edit_status == 1 ) {
                                      ?>
                                      <span class="badge badge-pill badge-success" id="pd_status"  >Active</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger" id="pd_status" >Inactive</span><br>
                                      <?php }  ?>
                                </td>
                                <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)" data-toggle="modal" data-target="#myModal">
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
            url: "pages/themes/theme_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/themes/theme_form.php",
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
