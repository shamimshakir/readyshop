<?php include('../header.php');
    $SUserID =$_SESSION[ "user_profile_id" ];
    $pageid = pick('_tree_entries', 'id', "file_name = 'user_guide.php'");
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
                    <?php 
                        $res = mysqli_query( $conn, "SELECT * FROM user_guide" );
                        $i = 1;
                        while ( $row = mysqli_fetch_array( $res ) ) {
                        extract( $row );
                    ?>
                    <div class="videoCard">
                        <h5 class="d-flex justify-content-lg-between">
                          <span><?php echo $question; ?></span>
                          <?php if($editper>0){ ?>
                          <span><button class="btn btn-primary btn-xs" onclick="edit(<?php echo $row['id'];?>)"> <i class="mdi mdi-grease-pencil"></i> Edit </button></span>
                      <?php } ?>
                      </h5>
                        <?php echo $video; ?>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/user_guide/user_guide_form.php",
            data: {
                mode:1
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
	function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/user_guide/user_guide_form.php",
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