<?php 
include('../header.php');

$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];
$addper = 0;
$addper = PermissionVerification( $user_role, $pageid, 'add' );
?>

<div id="mainContent">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body" id="card-body">

                    <h4 class="mt-0 header-title d-flex justify-content-between">
                        <span>Theme CSS</span>
                        <?php if($addper>0){?><span>
                            <button class="btn btn-primary" onclick="add()">Add new</button>
                        </span><?php } ?>
                    </h4>
                    <table id="tableData" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Label</th>
                            <th>Item / Selector</th>
                            <th>Status</th>
                            <th>Preview</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>

<script>


    $( document ).ready(function() {
        table =$('#tableData').DataTable({
        "bProcessing": true,
        "serverSide": true,
        "searching": true,
        "stateSave": true,
        "pageLength": 10,
        "bLengthChange": true,
        "ajax":{
            url :"pages/theme_css/theme_css_get.php?page=<?php echo $pageid?>", // json datasource
            type: "GET",
            datatype: "json",   
            dataFilter:function(inData){
                // what is being sent back from the server (if no error)
                // console.log(inData);
                return inData;
            },
            data:function(outData){
             // what is being sent to the server
            //console.log(outData);
                return outData;
            },
            error:function(err, status){
             // what error is seen(it could be either server side or client side.
                console.log(err);
            },      
          }
        });
        
    });

    function view_data() {
        $(".active").click();
        $("li.active .submenu").css("height", "auto");
    };
    
    function add() {
        $.ajax({
            type: "POST",
            url: "pages/theme_css/theme_css_form.php?page=<?php echo $_REQUEST['page']?>",
            data: {},
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    function edit(id) {
        $.ajax({
            type: "POST",
            url: "pages/theme_css/theme_css_form.php?page=<?php echo $_REQUEST['page']?>",
            data: {
                mode: 2,
                id : id,
            },
            success: function (response){
                $( '#mainContent' ).html(response);
            }
        });
    }
    // function sendData(){
    //     $.ajax({
    //         type: "POST",
    //         url: "pages/theme_css/theme_css_get.php",
    //         data: $('#reportForm').serialize()
    //     }).done(function(msg) {
    //         console.log(msg)
    //         $("#mainContent").html(msg);
    //     }).fail(function() {
    //         alert("error");
    //     });
    // }


</script>



