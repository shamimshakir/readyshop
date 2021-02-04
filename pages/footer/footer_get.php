<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'footer.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Footer Details</span>
                    </h4>

                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Logo</th>
                                <th class="td-actions">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT 
                                        *
                                      FROM 
                                        tbl_footer
                                      ORDER BY id ASC LIMIT 1");
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $footer_contact;?></td>
                                <td><?php echo $footer_phone ;?></td>
                                <td>
                                    <img style="height: 50px;width: auto;" src="uploads/footer/<?php echo $footer_logo;?>" alt="">
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
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/footer/footer_form.php",
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