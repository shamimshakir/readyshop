<?php
include "../../library/dbconnect.php";
include "../../library/library.php";

if ( $_POST[ 'id' ] != '' ) {	
  mysqli_query( $conn, "update _tree_entries set NodeName = '" . $_POST[ 'label' ] . "', file_name  = '" . $_POST[ 'link' ] . "', file_location  = '" . $_POST[ 'file_location' ] . "' where id = '" . $_POST[ 'id' ] . "' " );
  $arr[ 'type' ] = 'edit';
  $arr[ 'label' ] = $_POST[ 'label' ];
  $arr[ 'link' ] = $_POST[ 'link' ];
  $arr[ 'file_location' ] = $_POST[ 'file_location' ];
  $arr[ 'id' ] = $_POST[ 'id' ];
} 
else {
  mysqli_query( $conn, "insert into _tree_entries (NodeName, file_name, file_location,  view_status) values ('" . $_POST[ 'label' ] . "', '" . $_POST[ 'link' ] . "', '" . $_POST[ 'file_location' ] . "', 'ON')" );
	
	
  $arr[ 'menu' ] = '<li class="dd-item dd2-item" data-id="' .  mysqli_insert_id($conn) . '">
					<div class="dd-handle dd2-handle">
						<i class="normal-icon ace-icon fa ' . $_POST[ 'icon' ] . ' ' . $_POST[ 'color' ] . ' bigger-130"></i>
						<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
					</div>
					<div class="dd2-content">
						<span id="label_show' .  mysqli_insert_id($conn) . '">' . $_POST[ 'label' ] . '</span>
						<span class="span-right" >/
						<span style="font-size: 8px;" id="link_show' .  mysqli_insert_id($conn) . '">' . $_POST[ 'file_location' ] . '/' . $_POST[ 'link' ] . '</span> &nbsp;&nbsp; 
							<a class="edit-button blue" id="' .  mysqli_insert_id($conn) . '" label="' . $_POST[ 'label' ] . '" link="' . $_POST[ 'link' ] . '" file_location="' . $_POST[ 'file_location' ] . '" icon="' . $_POST[ 'icon' ] . '" ><i class="fa fa-pencil"></i></a>
							<a class="del-button red" id="' .  mysqli_insert_id($conn) . '"><i class="fa fa-trash"></i></a>
						</span> 
					</div>';

  $arr[ 'type' ] = 'add';
}

print json_encode( $arr );

?>
