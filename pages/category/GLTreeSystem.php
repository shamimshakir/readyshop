<?php
include( '../header.php' );
$pageid = $_REQUEST[ 'page' ];
$user_role = $_SESSION[ 'user_profile_id' ];
$addper = 0;
$addper = PermissionVerification( $user_role, $pageid, 'add' );
?>
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
  <div class="row">
    <div class="col-12">
      <div class="card m-b-20">
        <div class="card-body" id="card-body">
          <div class="row">
            <div class="col-sm-12" id="left_side"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModalsmall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
     
      
    </div>
  </div>
</div>
<script>
function left() {
    $.ajax({
        type: "GET",
        url: "pages/category/GLeditTree.php",
        dataType: "html"
    }).done(function(msg) {
        $("#left_side").html(msg);
		$("#right_side").html('');
    })
}
left() ;
/*function right() {
        $.ajax({
            type: "GET",
            url: "pages/category/GLaddElement.php",
            dataType: "html"
        }).done(function(msg) {
            $("#right").html(msg);
        })
    }	*/
	
</script>
<?php include('../footer.php')?>
