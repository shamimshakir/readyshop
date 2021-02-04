<?php include('../header.php')?>
<style>
#load {
	height: 100%;
	width: 100%;
}
#load {
	position : fixed;
	z-index : 99; /* or higher if necessary */
	top : 0;
	left : 0;
	overflow : hidden;
	text-indent : 100%;
	font-size : 0;
	opacity : 0.6;
	background : #E0E0E0 url('pages/category/loading.gif') center no-repeat;
}
.del-button {
	cursor: pointer;
	text-decoration: none;
}
.edit-button {
	cursor: pointer;
	text-decoration: none;
}
.span-right {
	float: right;
}
</style>
<style>
.del-button {
	cursor: pointer;
	text-decoration: none;
}
.edit-button {
	cursor: pointer;
	text-decoration: none;
}
.span-right {
	float: right;
}
.dd, .dd-list {
	display: block;
	padding: 0;
	list-style: none
}
.dd, .dd-item>button, .dd-list {
	position: relative
}

@media only screen and (max-width: 767px) and (-webkit-min-device-pixel-ratio: 0) {
.ui-jqgrid .ui-jqgrid-pager>.ui-pager-control>.ui-pg-table>tbody>tr>td#grid-pager_center>.ui-pg-table {
	width: 300px
}
}
.dd {
	margin: 0;
	max-width: 600px;
	line-height: 20px
}
.dd-list {
	margin: 0
}
.dd-list .dd-list {
	padding-left: 30px
}
.dd-collapsed .dd-list {
	display: none
}
.dd-empty, .dd-item, .dd-placeholder {
	display: block;
	position: relative;
	margin: 0;
	padding: 0;
	min-height: 20px;
	line-height: 20px
}
.dd-handle, .dd2-content {
	display: block;
	min-height: 38px;
	margin: 5px 0;
	padding: 8px 12px;
	background: #F8FAFF;
	border: 1px solid #DAE2EA;
	color: #515151;
	text-decoration: none;
	font-weight: 700;
	box-sizing: border-box
}
.dd-handle:hover, .dd2-content:hover {
	color: #5F5F5F;
	background: #F4F6F7;
	border-color: #DCE2E8
}
.dd-handle[class*=btn-], .dd2-content[class*=btn-] {
	color: #FFF;
	border: none;
	padding: 9px 12px
}
.dd-handle[class*=btn-]:hover, .dd2-content[class*=btn-]:hover {
	opacity: .85;
	color: #FFF
}
.dd2-handle+.dd2-content, .dd2-handle+.dd2-content[class*=btn-] {
	padding-left: 44px
}
.dd-handle[class*=btn-]:hover, .dd2-content[class*=btn-] .dd2-handle[class*=btn-]:hover+.dd2-content[class*=btn-] {
	color: #FFF
}
.dd-item>button:hover~.dd-handle, .dd-item>button:hover~.dd2-content {
	color: #438EB9;
	background: #F4F6F7;
	border-color: #DCE2E8
}
.dd-item>button:hover~.dd-handle[class*=btn-], .dd-item>button:hover~.dd2-content[class*=btn-] {
	opacity: .85;
	color: #FFF
}
.dd2-handle:hover~.dd2-content {
	color: #438EB9;
	background: #F4F6F7;
	border-color: #DCE2E8
}
.dd2-handle:hover~.dd2-content[class*=btn-] {
	opacity: .85;
	color: #FFF
}
.dd2-item.dd-item>button {
	margin-left: 34px
}
.dd-item>button {
	display: block;
	z-index: 1;
	cursor: pointer;
	float: left;
	width: 25px;
	height: 20px;
	margin: 5px 1px 5px 5px;
	padding: 0;
	text-indent: 100%;
	white-space: nowrap;
	overflow: hidden;
	border: 0;
	background: 0 0;
	font-size: 12px;
	line-height: 1;
	text-align: center;
	font-weight: 700;
	top: 4px;
	left: 1px;
	color: #707070
}
.dd-item>button:before {
	font-family: FontAwesome;
	content: '\f067';
	display: block;
	position: absolute;
	width: 100%;
	text-align: center;
	text-indent: 0;
	font-weight: 400;
	font-size: 14px
}
.dd-item>button[data-action=collapse]:before {
	content: '\f068'
}
.dd-item>button:hover {
	color: #707070
}
.dd-item.dd-colored>button, .dd-item.dd-colored>button:hover {
	color: #EEE
}
.dd-empty, .dd-placeholder {
	margin: 5px 0;
	padding: 0;
	min-height: 30px;
	background: #F0F9FF;
	border: 2px dashed #BED2DB;
	box-sizing: border-box
}
.dd-empty {
	border-color: #AAA;
	border-style: solid;
	background-color: #e5e5e5
}
.dd-dragel {
	position: absolute;
	pointer-events: none;
	z-index: 999;
	opacity: .8
}
.dd-dragel>li>.dd-handle {
	color: #4B92BE;
	background: #F1F5FA;
	border-color: #D6E1EA;
	border-left: 2px solid #777;
	position: relative
}
.dd-dragel>li>.dd-handle[class*=btn-] {
	color: #FFF
}
.dd-dragel>.dd-item>.dd-handle {
	margin-top: 0
}
.dd-list>li[class*=item-] {
	border-width: 0;
	padding: 0
}
.dd-list>li[class*=item-]>.dd-handle {
	border-left: 2px solid;
	border-left-color: inherit
}
.dd-list>li>.dd-handle .sticker {
	position: absolute;
	right: 0;
	top: 0
}
.dd-dragel>li>.dd2-handle, .dd2-handle {
	left: 0;
	top: 0;
	width: 36px;
	margin: 0;
	text-align: center;
	padding: 0!important;
	line-height: 38px;
	height: 38px;
	background: #EBEDF2;
	border: 1px solid #DEE4EA;
	cursor: pointer;
	overflow: hidden;
	position: absolute;
	z-index: 1
}
.dd-dragel>li>.dd2-handle, .dd2-handle:hover {
	background: #E3E8ED
}
.dd2-handle[class*=btn-] {
	text-shadow: none!important;
	background: rgba(0, 0, 0, .1)!important;
	border-right: 1px solid #EEE
}
.dd2-handle[class*=btn-]:hover {
	background: rgba(0, 0, 0, .08)!important
}
.dd-dragel .dd2-handle[class*=btn-] {
	border-color: transparent #EEE transparent transparent
}
.dd2-handle.btn-yellow {
	background: rgba(0, 0, 0, .05)!important;
	border-right: 1px solid #FFF
}
.dd2-handle.btn-yellow:hover {
	background: rgba(0, 0, 0, .08)!important
}
.dd-dragel .dd2-handle.btn-yellow {
	border-color: transparent #FFF transparent transparent
}
.dd-item>.dd2-handle .drag-icon {
	display: none
}
.dd-dragel>.dd-item>.dd2-handle .drag-icon {
	display: inline
}
.dd-dragel>.dd-item>.dd2-handle .normal-icon {
	display: none
}
.span-right {
	float: right;
}
.dd-item > button[data-action="collapse"]:before {
	content: '-';
	color: #707070;
}
</style>
<div id="mainContent">
 
  <div class="card m-b-20">
    <div class="card-body" id="card-body">
      <h4 class="mt-0 header-title d-flex justify-content-between"> <span>Manu Management</span> </h4>
      <div class="panel-body">
        <div class="preloader" id="loaders" style="display:none" >
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
          </svg>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <link rel="stylesheet" href="pages/mamumanagement/style.css">
            <?php

            ?>
            <div id="load"></div>
            <menu id="nestable-menu">
              <button id="save" class="btn btn-sm btn-success" type="button">Save <i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i></button>
              <button type="button" data-action="expand-all" class="btn btn-sm btn-warning" >Expand All <i class="ace-icon fa fa-expand icon-on-right bigger-110"></i></button>
              <button type="button" data-action="collapse-all" class="btn btn-sm btn-primary">Collapse All <i class="ace-icon fa fa-compress icon-on-right bigger-110"></i></button>
            </menu>
            <div class="cf nestable-lists">
              <div class="dd" id="nestable">
                <?php

                $query = mysqli_query( $conn, "select * from _tree_entries where view_status='ON' order by sl " );

                $ref = [];
                $items = [];


                while ( $data = mysqli_fetch_assoc( $query ) ) {

                  $thisRef = & $ref[ $data[ 'id' ] ];
                  $thisRef[ 'parent' ] = $data[ 'pid' ];
                  $thisRef[ 'label' ] = $data[ 'NodeName' ];
                  $thisRef[ 'file_name' ] = $data[ 'file_name' ];
                  $thisRef[ 'file_location' ] = $data[ 'file_location' ];
                  $thisRef[ 'icon' ] = $data[ 'icon' ];
                  $thisRef[ 'serial' ] = $data[ 'sl' ];
                  $thisRef[ 'color' ] = $data[ 'color' ];
                  $thisRef[ 'view_status' ] = $data[ 'view_status' ];
                  $thisRef[ 'id' ] = $data[ 'id' ];

                  if ( $data[ 'pid' ] == 0 ) {
                    $items[ $data[ 'id' ] ] = & $thisRef;
                  } else {
                    $ref[ $data[ 'pid' ] ][ 'child' ][ $data[ 'id' ] ] = & $thisRef;
                  }

                }


                function get_menu( $items, $class = 'dd-list' ) {

                  $html = "<ol class=\"" . $class . "\" id=\"menu-id\">";
                  foreach ( $items as $key => $value ) {
                    $html .= '<li class="dd-item dd2-item" data-id="' . $value[ 'id' ] . '">
    <div class="dd-handle dd2-handle">
        <i class="normal-icon ace-icon fa ' . $value[ 'icon' ] . ' ' . $value[ 'color' ] . ' bigger-130"></i>
        <i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
    </div>
    <div class="dd2-content">
        <span id="label_show' . $value[ 'id' ] . '">' . $value[ 'label' ] . '</span>
        <span class="span-right" >
        <span style="font-size: 8px;" id="link_show' . $value[ 'id' ] . '">' . $value[ 'file_location' ] . '/' . $value[ 'file_name' ] . '</span> &nbsp;&nbsp; 
            <a class="edit-button blue" id="' . $value[ 'id' ] . '" label="' . $value[ 'label' ] . '" link="' . $value[ 'file_name' ] . '" file_location="' . $value[ 'file_location' ] . '" ><i class="fa fa-pencil"></i></a>
            <a class="del-button red" id="' . $value[ 'id' ] . '"><i class="fa fa-trash"></i></a>
        </span> 
    </div>';
                    if ( array_key_exists( 'child', $value ) ) {
                      $html .= get_menu( $value[ 'child' ], 'child' );
                    }
                    $html .= "</li>";
                  }
                  $html .= "</ol>";
                  return $html;
                }

                print get_menu( $items );

                ?>
              </div>
            </div>
            <p></p>
            <input type="hidden" id="nestable-output">
          </div>
          <div class="col-sm-6">
            <div class="widget-box">
              <div class="widget-header">
                <h4 class="widget-title">ADD / Edit Menu</h4>
              </div>
              <div class="widget-body">
                <div class="widget-main no-padding">
                  <form id="modal_form" method="post" >
                    <!-- <legend>Form</legend> -->
                    <fieldset>
                      <div class="col-md-12 ">
                        <label for="">Menu display Name</label>
                        <input type="text" class="form-control " id="label" placeholder="Fill label" required>
                      </div>
                     <div class="col-md-12">
                        <label for="">File Name</label>
                         <input type="text" class="form-control " id="link" placeholder="Fill link" required>
                      </div>
                      <div class="col-md-12">
                        <label for="">File Location </label>
                         <input type="text" class="form-control " id="file_location" placeholder="Fill file location" required>
                      </div>
                     
                    </fieldset>
					  <hr>
                    <div class="col-md-12 center">
                      <button id="submit" type="submit" class="btn btn-sm btn-success">Submit <i class="ace-icon fa fa-floppy-o icon-on-right bigger-110"></i></button>
                      <button id="reset" type="button" class="btn btn-sm btn-danger">Reset <i class="ace-icon fa fa-retweet icon-on-right bigger-110"></i></button>
                    </div>
                    <input type="hidden" id="id">
                  </form>
                </div>
              </div>
            </div>
            <br/>
            <br />
          </div>
          <script>

$(document).ready(function()
{

var updateOutput = function(e)
{
var list   = e.length ? e : $(e.target),
output = list.data('output');
if (window.JSON) {
output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
} else {
output.val('JSON browser support required for this demo.');
}
};

// activate Nestable for list 1
$('#nestable').nestable({
group: 1
})
.on('change', updateOutput);



// output initial serialised data
updateOutput($('#nestable').data('output', $('#nestable-output')));

$('#nestable-menu').on('click', function(e)
{
//alert('here');
var target = $(e.target),
action = target.data('action');
//alert(action);
if (action === 'expand-all') {
$('.dd').nestable('expandAll');
}
if (action === 'collapse-all') {
$('.dd').nestable('collapseAll');
}
});


});
</script> 
          <script>
$(document).ready(function(){
$("#load").hide();


$("#save").click(function(){
alertify.confirm('Hello Sir,', 'Are you sure to change menu order', 
function(){
$("#load").show();
var dataString = { 
data : $("#nestable-output").val(),
};
$.ajax({
type: "POST",
url: "pages/mamumanagement/save.php",
data: dataString,
cache : false,
success: function(data){
$("#load").hide();
alertify.success('Data has been saved');
} ,error: function(xhr, status, error) {

alertify.error(error);
},
});
}
, function(){ alertify.error('Cancel')});
});
$(document).on("click",".del-button",function() {
var id = $(this).attr('id');
alertify.confirm('Hello Sir,', 'Are you sure , Delete this item', 
function(){
$("#load").show();

$.ajax({
type: "POST",
url: "pages/mamumanagement/delete.php",
data: { id : id },
cache : false,
success: function(data){
	console.log(data);
  $("#load").hide();
  $("li[data-id='" + id +"']").remove();
 // alert(data);
 alertify.success('Successfully delete your Data'); 
} ,error: function(xhr, status, error) {
  alertify.error(error);
},
});
}
, function(){ alertify.error('Cancel')});
});
$(document).on("click",".edit-button",function() {
var id = $(this).attr('id');
var label = $(this).attr('label');
var link = $(this).attr('link');
	
var file_location = $(this).attr('file_location');
var icon = $(this).attr('icon');

$("#id").val(id);
$("#label").val(label);
$("#link").val(link);
$("#file_location").val(file_location);
});

$(document).on("click","#reset",function() {
$('#label').val('');
$('#link').val('');
$('#id').val('');
$("#file_location").val('');
});

});
$(document).ready(function(e) {
$("#load").hide();
$("#modal_form").on('submit', (function(e) {
e.preventDefault();
var dataString = { 
label : $("#label").val(),
link : $("#link").val(),
file_location : $("#file_location").val(),

id : $("#id").val()
};
//$("#load").show();  
$.ajax({
type: "POST",
url: "pages/mamumanagement/save_menu.php",
data: dataString,
dataType: "json",
cache : false,
success: function(data){
console.log(data)
if(data.type == 'add'){
 $("#menu-id").append(data.menu);
	
 alertify.success('Successfully Save your Data');
} 
else if(data.type == 'edit'){
 $('#label_show'+data.id).html(data.label);
 $('#link_show'+data.id).html(data.link);

alertify.success('Successfully Update your Data'); 
}
$('#label').val('');
$('#link').val('');
$('#id').val('');
$("#file_location").val();
$("#icon").val();
//$("#load").hide();

} ,error: function(xhr, status, error) {
alertify.error(error);
},
});	
}));
});
</script> 
        </div>
        <div class="col-sm-6"></div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include('../footer.php')?>
