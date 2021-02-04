<?php include('../header.php');
    $SUserID =$_SESSION['user_profile_id'];
    $pageid = pick('_tree_entries', 'id', "file_name = 'customer.php'");
    $addper=PermissionVerification($SUserID,$pageid,'add');
    $editper=PermissionVerification($SUserID,$pageid,'edit');
?>
<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Shop Information 
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#guide_modal" onclick="showGuideModal(4)">?</button>
                        </span>

                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>

                    <table id="datatable" class="table table-bordered table-hover table-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Name</th>
                                <th>Domain</th>
                                <th>Business Type</th>
                                <th>Request Date</th>
                                <th>Phone</th>
                                <th>Token</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <!-- <th class="td-actions">Edit</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n=1;
                        $i=1;
                        $res = mysqli_query($conn, "SELECT 
                                        tbl_shop_user.*, tbl_business_type.business_type as btype
                                      FROM 
                                        tbl_shop_user
                                      LEFT JOIN tbl_business_type ON tbl_business_type.btype_id=tbl_shop_user.business_type
                                      ORDER BY id ASC");
                        while ($row = mysqli_fetch_array($res)) { extract($row); ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $name;?></td>
                                <td><?php if($domain!=''){ echo "<a target='_blank' href='http://$domain'>$domain</a>"; } elseif($sub_domain!='') { echo "<a target='_blank' href='http://$sub_domain.readyshop.cloud'>$sub_domain.readyshop.cloud</a>"; } else {} ?></td>
                                <td><?php echo $btype ;?></td>
                                <td><?php echo $req_date ;?></td>
                                <td><?php echo $mobile ;?></td>
                                <td><?php echo $tocken ;?></td>
                                <td><?php echo $email ;?></td>
                                <td><?php
                                    if ( $status == 1 ) {
                                      ?>
                                      <span class="badge badge-pill badge-success" id="pd_status"  >Yes</span><br>
                                      <?php }else{ ?>
                                      <span class="badge badge-pill badge-danger" id="pd_status" >No</span><br>
                                      <?php }  ?>
                                </td>
                                
                                
                                <!-- <td>
                                    <?php if($editper>0){?><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)" data-toggle="modal" data-target="#myModal">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </button><?php } ?>
                                </td> -->
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
            url: "pages/customer/customer_form.php",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/customer/customer_form.php",
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
