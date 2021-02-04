<?php
include( '../header.php' );
$mode = 1;
// if ( isset( $_REQUEST[ 'cl_id' ] ) ) {
//   $cl_id = $_REQUEST[ 'cl_id' ];
//   $mode = 2;
//   $SeNTlist = "SELECT tbl_customer.*, Date(tbl_customer.user_regdate) AS userRegDate FROM tbl_customer WHERE cl_id = '$cl_id' ";
//   $ExSeNTlist = mysqli_query( $conn, $SeNTlist )or die( mysqli_error( $conn ) );
//   $rowNewsTls = mysqli_num_rows( $ExSeNTlist );
//   $rowNewsTl = mysqli_fetch_array( $ExSeNTlist );
//   extract( $rowNewsTl );
// }

?>
<div id="mainContent">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card m-b-20">
        <div class="card-body">
          <?php if ($mode == 1){ ?>
          <h4 class="mt-0 header-title">Add Customer</h4>
          <?php }elseif ($mode == 2){ ?>
          <h4 class="mt-0 header-title">Edit Customer</h4>
          <?php }?>
          <form id="customer_add_form" class="" action="#" novalidate="">
            <input type="hidden" name="mode" value="<?php echo $mode;?>">
            <input type="hidden" name="cl_id" value="<?php  if($mode==2){echo $cl_id;}?>">
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="name">Name<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" placeholder="Name" name="name" id="name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="email">Email<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" placeholder="Email" name="email" id="email" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="mobile">Phone<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" placeholder="Phone Number" name="mobile" id="mobile" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="address">Address<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" placeholder="Address" name="address" id="address" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="business_type">Business Type<span style="color:red;">*</span></label>
                      <select name='business_type' id='business_type' class='form-control' required='' data-parsley-required-message="You must select at least one option.">
                        <?php createCombo("Business Type","tbl_business_type","btype_id","business_type","ORDER BY btype_id ",'');?>
                      </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="req_date">Reg. Day</label>
                      <input type="date" class="form-control" placeholder="Domain" name="req_date" id="req_date" value="<?php echo date('Y-m-d');?>" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <input type="radio" name="domains" value="twoCarDiv"  /> Domain    
                  <input type="radio" name="domains" value="threeCarDiv" /> Sub-Domain

                  <div class="form-group desc"  id="twoCarDiv">
                      <label for="domain">Domain</label>
                      <input type="text" class="form-control" placeholder="Domain" name="domain" id="domain" >
                  </div>
                  <div class="form-group desc" id="threeCarDiv">
                      <label for="sub_domain">Sub Domain</label>
                      <input type="text" class="form-control" placeholder="Sub Domain" name="sub_domain" id="sub_domain" >
                  </div>
                </div>
            </div>
            <div class="form-group mb-0 d-flex justify-content-end">
              <div>
                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                <?php if ($mode == 1){ ?>
                <button type="button" onclick="save()" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                <?php }elseif($mode == 2){ ?>
                <button type="button" onclick="save()"  class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                <?php }?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('../footer.php')?>
<script>
    function save() {
        if($('form').parsley().validate()){
            $.ajax({
                type: "POST",
                url: "pages/customer/customer_save.php",
                data: $('#customer_add_form').serialize()
            }).done(function(response) {
              alertify.set('notifier','position', 'bottom-right');
                if(response == "2"){
                  alertify.error('You must to give a domain or subdomain');
                }else if(response == "3"){
                  alertify.error('This subdomain already used');
                }else if(response == "4"){
                  alertify.error('This domain already used');
                }else{
                  alertify.success(response);
                  view_data();
                }
            })
            .fail(function() {
                alertify.notify(response, 'error', 3000000000)
            });
        }
    }
$(document).on('change', '#country', function(){
    var nowRow =$("#country").val();
    $.ajax({
          url: "AjaxCode/loadajaxcombo.php?options=1&valueColumns=id,location&table=tbl_shipping_costs&conditions=where country_id=" +nowRow+" &firstText=Select a City&selectedValue=" ,
          success: function(html){
          $('#city').html(html);
        }
        });
    });


$(document).ready(function() {
    $("div.desc").hide();
    $("input[name$='domains']").click(function() {
        var test = $(this).val();
        $("div.desc").hide();
        $("#" + test).show();
    });
});
</script> 
