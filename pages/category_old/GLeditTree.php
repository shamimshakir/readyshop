<?php
include "../../library/dbconnect.php";
include "../../library/library.php";
session_start();
?>

<link rel="stylesheet" href="pages/category/style.css">
<div class="row">
  <div class="col-sm-12">
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

        $query = mysqli_query( $conn, "SELECT
										  `cat_id`,
										  `cat_parent_id`,
										  `cat_name`,
										  `cat_description`,
										  `cat_image`,
										  `level_id`,
										  `act_status`
										FROM
										  `tbl_category`
										  where act_status=1
										  order by cat_id" );

        $ref = [];
        $items = [];


        while ( $data = mysqli_fetch_assoc( $query ) ) {

          $thisRef = & $ref[ $data[ 'cat_id' ] ];
          $thisRef[ 'cat_parent_id' ] = $data[ 'cat_parent_id' ];
          $thisRef[ 'cat_name' ] = $data[ 'cat_name' ];
          $thisRef[ 'cat_description' ] = $data[ 'cat_description' ];
          $thisRef[ 'cat_image' ] = $data[ 'cat_image' ];
          $thisRef[ 'level_id' ] = $data[ 'level_id' ];
          $thisRef[ 'act_status' ] = $data[ 'act_status' ];
          $thisRef[ 'cat_id' ] = $data[ 'cat_id' ];

          if ( $data[ 'cat_parent_id' ] == 0 ) {
            $items[ $data[ 'cat_id' ] ] = & $thisRef;
          } else {
            $ref[ $data[ 'cat_parent_id' ] ][ 'child' ][ $data[ 'cat_id' ] ] = & $thisRef;
          }

        }


        function get_menu( $items, $class = 'dd-list' ) {

          $html = "<ol class=\"" . $class . "\" id=\"menu-id\">";
          foreach ( $items as $key => $value ) {
            $html .= '<li class="dd-item dd2-item" data-id="' . $value[ 'cat_id' ] . '">
    <div class="dd-handle dd2-handle">
        <i class="normal-icon ace-icon fa fa-th-list bigger-130"></i>
        <i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
    </div>
    <div class="dd2-content">
        <span id="label_show' . $value[ 'cat_id' ] . '">' . $value[ 'cat_name' ] . '</span>
        <span class="span-right" >
        <span style="font-size: 8px;" id="link_show' . $value[ 'cat_id' ] . '">' . $value[ 'cat_description' ] . '</span> &nbsp;&nbsp; 
            <a class="edit-button blue" id="' . $value[ 'cat_id' ] . '" cat_name="' . $value[ 'cat_name' ] . '" cat_description="' . $value[ 'cat_description' ] . '" cat_image="' . $value[ 'cat_image' ] . '" level_id="' . $value[ 'level_id' ] . '" catagory_code="' . $value[ 'catagory_code' ] . '" cat_parent_id="' . $value[ 'cat_parent_id' ] . '"  ><i class="fa fa-pencil"></i></a>
            <a class="del-button red" id="' . $value[ 'cat_id' ] . '"><i class="fa fa-trash"></i></a>
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
 <script >

    $(document).ready(function() {

        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
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

        $('#nestable-menu').on('click', function(e) {
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


    }); </script>  
	<script >
    $(document).ready(function() {
        $("#load").hide();
        $("#save").click(function() {
            alertify.confirm('Hello Sir,', 'Are you sure to change menu order',
                function() {
                    $("#load").show();
                    var dataString = {
                        data: $("#nestable-output").val(),
                    };
                    $.ajax({
                        type: "POST",
                        url: "pages/category/save.php",
                        data: dataString,
                        cache: false,
                        success: function(data) {
							//console.log(data);
                            $("#load").hide();
                            alertify.success('Data has been saved');
                        },
                        error: function(xhr, status, error) {

                            alertify.error(error);
                        },
                    });
                },
                function() {
                    alertify.error('Cancel')
                });
        });
		
        $(document).on("click", ".del-button", function() {
            var id = $(this).attr('id');
            alertify.confirm('Hello Sir,', 'Are you sure , Delete this item',
                function() {
                  //  $("#load").show();

                    $.ajax({
                        type: "POST",
                        url: "pages/category/delete.php",
                        data: {
                            id: id
                        },
                        cache: false,
                        success: function(data) {
                            console.log(data);
                          //  $("#load").hide();
                            $("li[data-id='" + id + "']").remove();
                            // alert(data);
                            alertify.success('Successfully delete your Data');
                        },
                        error: function(xhr, status, error) {
                            alertify.error(error);
                        },
                    });
                },
                function() {
                    alertify.error('Cancel')
                });
        });
		
        $(document).on("click", ".edit-button", function() {
			console.log('asdasdasd');
            var id = $(this).attr('id');
            var pid = $(this).attr('cat_parent_id');
            var nam = $(this).attr('cat_description');
            var lid = $(this).attr('level_id');           
            var code = $(this).attr('catagory_code');

			$.ajax({
				type: "GET",
				url: "pages/category/GLaddElement.php",
				dataType: "html",
				type: "post",  // type of method  ,GET/POST/DELETE
				data: {
					id:id,
					pid:pid,
					lid:lid,
					nam:nam,
					code:code
				},
			}).done(function(msg) {
				console.log(msg);
				$("#right_side").html(msg);
			})
           
        });

        $(document).on("click", "#reset", function() {
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
            label: $("#label").val(),
            link: $("#link").val(),
            file_location: $("#file_location").val(),

            id: $("#id").val()
        };
        //$("#load").show();  
        $.ajax({
            type: "POST",
            url: "pages/category/save_menu.php",
            data: dataString,
            dataType: "json",
            cache: false,
            success: function(data) {
                console.log(data)
                if (data.type == 'add') {
                    $("#menu-id").append(data.menu);

                    alertify.success('Successfully Save your Data');
                } else if (data.type == 'edit') {
                    $('#label_show' + data.id).html(data.label);
                    $('#link_show' + data.id).html(data.link);

                    alertify.success('Successfully Update your Data');
                }
                $('#label').val('');
                $('#link').val('');
                $('#id').val('');
                $("#file_location").val();
                $("#icon").val();
                //$("#load").hide();

            },
            error: function(xhr, status, error) {
                alertify.error(error);
            },
        });
    }));
}); 
	</script> 
</div>
