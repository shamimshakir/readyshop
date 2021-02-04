<?php
session_start();
include "library/dbconnect.php";
include 'library/library.php';
if ( !isset( $_SESSION ) || empty( $_SESSION ) ) {
  header( "Location: login.php" );
  exit();
} else {
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>Ready Shop | Dashboard</title>
<meta content="Admin Dashboard" name="description" />
<meta content="Themesbrand" name="author" />
<link rel="shortcut icon" href="assets/images/favicon.png">
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="assets/css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="assets//plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
<!-- DataTables -->
<link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
<!-- Responsive datatable examples -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Alertify CSS Start -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

<style>
	/*@media only screen and (max-width: 766px) {
	  body {
	    addClass()
	  }
	}*/
</style>
</head>

<body>


<!-- Guide Modal Start -->
<div class="modal fade" id="guide_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    </div>
  </div>
</div>
<!-- Guide Modal End -->


<!-- Begin page -->
<div id="wrapper"> 
  
  <!-- Top Bar Start -->
  <div class="topbar"> 
    
    <!-- LOGO -->
    <div class="topbar-left"> <a href="index.php" class="logo"> <span> 
      <!--                            <img src="assets/images/logo-light.png" alt="" height="18">-->
      <h3 style="color:white; font-size: 20px; padding-top: 16px;">Ready Shop</h3>
      </span> <i><img src="assets/images/logo-sm.png" alt="" height="22"></i> </a> </div>
    <nav class="navbar-custom">
      <ul class="navbar-right d-flex list-inline float-right mb-0">
        <li class="dropdown notification-list">
          <div class="dropdown notification-list nav-pro-img"> <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"> <img src="assets/images/users/user-4.jpg" alt="user" class="rounded-circle"> </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown "> 
              <!-- item--> 
              <a class="dropdown-item" href="profle_update.php" data-loc='pages/profle_update'><i class="mdi mdi-account-circle m-r-5"></i> Profile</a> 
              <!--               <a class="dropdown-item" href="#"><i class="mdi mdi-wallet m-r-5"></i> My Wallet</a> 
              <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5"></i> Lock screen</a>
              <div class="dropdown-divider"></div> --> 
              <a class="dropdown-item text-danger" id="logoutbutton"><i class="mdi mdi-power text-danger"></i> Logout</a> 
              <script> document.getElementById("logoutbutton").onclick = function () {location.href = "logout.php";};  </script> 
            </div>
          </div>
        </li>
      </ul>
      <ul class="list-inline menu-left mb-0">
        <li class="float-left">
          <button class="button-menu-mobile open-left waves-effect"> <i class="mdi mdi-menu"></i> </button>
        </li>
      </ul>
    </nav>
  </div>
  <!-- Top Bar End --> 
  
  <!-- ========== Left Sidebar Start ========== -->
  <div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
      <div id="sidebar-menu"> 
        <!-- Left Menu Start -->
        <ul class="metismenu">
          <li class="menu-title">Main</li>
          <li> <a href="index.php" class="waves-effect"> <i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span> </a> </li>
        </ul>
        <?php

        $SType = $_SESSION[ 'user_profile_id' ];

        $NavSql = "SELECT _tree_entries.id, _tree_entries.pid, 
    _tree_entries.NodeName, 
    _tree_entries.file_name, 
    _tree_entries.file_location, 
    _tree_entries.view_status,
    _tree_entries.icon
        FROM _tree_entries
		JOIN
		(SELECT id 
		FROM _user_permission 
		WHERE user_id = '$SType') t1
		on t1.id=_tree_entries.id
        WHERE
            _tree_entries.view_status = 'ON'
			order by sl
        ";


        $res = mysqli_query( $conn, $NavSql )or die( "database error:" . mysqli_error( $conn ) );
        $menu = array(
          'menus' => array(),
          'parent_menus' => array()
        );
        while ( $row = mysqli_fetch_assoc( $res ) ) {
          $menu[ 'menus' ][ $row[ 'id' ] ] = $row;
          $menu[ 'parent_menus' ][ $row[ 'pid' ] ][] = $row[ 'id' ];
        }

        $html = "<ul class='metismenu' id='side-menu'>";

        foreach ( $menu[ 'parent_menus' ][ 0 ] as $menu_id ) {
          $html .= "<li>
            <a href='javascript:void(0);' class='waves-effect'>
                <i class='mdi mdi-file-check'></i><span> {$menu['menus'][$menu_id]['NodeName']} <span class='float-right menu-arrow'>
                        <i class='mdi mdi-chevron-right'></i>
                </span> </span></a>";
          $html .= "<ul class='submenu'>";
          foreach ( $menu[ 'menus' ] as $index => $val ) {
            if ( $val[ 'pid' ] == $menu_id ) {
              $html .= "<li> <a href='" . $val[ 'file_name' ] . "?page=" . $val[ 'id' ] . "' data-loc='{$val['file_location']}' class='waves-effect'> <i class='mdi mdi-calendar-check'></i> <span> {$val['NodeName']} </span> </a> </li>";
            }
          }
          $html .= '</ul>';
          $html .= "</li>";
        }

        $html .= "</ul>";

        echo $html;
        ?>
      </div>
      <!-- Sidebar -->
      <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left --> 
    
  </div>
  <!-- Left Sidebar End --> 
  
  <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
  <div class="content-page"> 
    <!-- Start content -->
    <div class="content">
      <div class="container-fluid" >
        <div id="result">
          <div class="row">
            <div class="col-sm-12"> 
              <!--<div class="page-title-box">--> 
              <!--<h4 class="page-title" id="page_title">Dashboard</h4>--> 
              <!--<ol class="breadcrumb" id="breadcrumb_here">--> 
              <!--    <li class="breadcrumb-item active">--> 
              <!--        Welcome to Ready Shop Dashboard--> 
              <!--    </li>--> 
              <!--</ol>--> 
              <!--    <div class="state-information d-none d-sm-block">--> 
              <!--        <div class="state-graph">--> 
              <!--            <div id="header-chart-1"></div>--> 
              <!--            <div class="info">Balance $ 2,317</div>--> 
              <!--        </div>--> 
              <!--        <div class="state-graph">--> 
              <!--            <div id="header-chart-2"></div>--> 
              <!--            <div class="info">Item Sold 1230</div>--> 
              <!--        </div>--> 
              <!--    </div>--> 
              
              <!--</div>--> 
            </div>
          </div>
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-cube-outline float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">New Orders</h6>
                    <h5 class="mb-4">#<?php echo pick('tbl_order','COUNT(od_id)',"od_status='New'")?><br>৳<?php echo number_format(pick('tbl_order','SUM(total_cost)',"od_status='New'"),2)?></h5>
                    <!--<span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-buffer float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">Delivered</h6>
                    <h5 class="mb-4">#<?php echo pick('tbl_order','COUNT(od_id)',"od_status='Delivered'")?><br>৳<?php echo number_format(pick('tbl_order','SUM(total_cost)',"od_status='Delivered'"),2)?></h5>
                    
                    <!--<span class="badge badge-danger"> -29% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-tag-text-outline float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">Cancelled</h6>
                    <h5 class="mb-4">#<?php echo pick('tbl_order','COUNT(od_id)',"od_status='Cancelled'")?><br>৳<?php echo number_format(pick('tbl_order','SUM(total_cost)',"od_status='Cancelled'"),2)?></h5>
                    <!--<span class="badge badge-warning"> 0% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-briefcase-check float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">Returned</h6>
                    <h5 class="mb-4">#<?php echo pick('tbl_order','COUNT(od_id)',"od_status='Returned'")?><br>৳<?php echo number_format(pick('tbl_order','SUM(total_cost)',"od_status='Returned'"),2)?></h5>
                    <!--<span class="badge badge-info"> +89% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-cube-outline float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">Purchase</h6>
                    <?php
                    $sql = "SELECT 
									SUM(trn_mat_receive_detail.`qty`) as qtys, 
									SUM(`trn_mat_receive_detail`.`total`) as total
								FROM 
									`trn_mat_receive_detail`
									left join tbl_product ON tbl_product.pd_id=trn_mat_receive_detail.`prod_id`";
                    $ExSeNTlist = mysqli_query( $conn, $sql )or die( mysqli_error( $conn ) );
                    while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
                      extract( $rowNewsTl );
                      ?>
                    <h5 class="mb-4">#<?php echo $qtys;?><br>৳<?php echo number_format($total,2); ?></h5>
                    <?php
                    }
                    ?>
                    </p>
                    <!--<span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-buffer float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">Stock</h6>
                    <p class="mb-4">
                      <?php
                      $sql = "SELECT 
								SUM(`pd_qty`) as qtys, 
								SUM(pd_price*pd_qty) as total
							FROM 
								tbl_product 
								";
                      $ExSeNTlist = mysqli_query( $conn, $sql )or die( mysqli_error( $conn ) );
                      while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
                        extract( $rowNewsTl );
                        ?>
                    <h5 class="mb-4">#<?php echo $qtys;?><br>৳<?php echo number_format($total,2); ?></h5>
                    <?php

                    }
                    ?>
                    </p>
                    <!--<span class="badge badge-danger"> -29% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-tag-text-outline float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">Number OF Client</h6>
                    <h4 class="mb-4"><?php echo pick('tbl_customer','COUNT(cl_id)',"")?></h4>
                    <!--<span class="badge badge-warning"> 0% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-briefcase-check float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">Client With Order</h6>
                    
                      <?php $csql="SELECT 
								COUNT(cs.totalcust) as tclient
							FROM 
								(SELECT 
								COUNT(`od_id`) AS totalcust 
							FROM 
								`tbl_order` 
							group BY 
								`cl_id`) as cs";
						
						$ExSeNTlist = mysqli_query( $conn, $csql )or die( mysqli_error( $conn ) );
                      while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
                        extract( $rowNewsTl );
                        ?>
                    <h5 class="mb-4">#<?php echo $tclient;?></h5>
                    <?php

                    }
                    ?>
                   
                    <!--<span class="badge badge-info"> +89% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
          </div>
		<div class="row">
			<?php 
			$usein=pick("tbl_parameter","parameter_status","parameter_name='nextech_sms'");
	if($usein>0){
			?>
			<div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-briefcase-check float-right"></i> </div>
                  <div class="text-white">
                    <h6 class="text-uppercase mb-3">SMS</h6>
                    
                     
                    <h5 class="mb-4">#
                    <?php
echo pick("tbl_sms_allocation","current_ammount","");
                   
                    ?>
                   </h5>
                    <!--<span class="badge badge-info"> +89% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
			<?php }?>
		</div>
          <div class="row">
            <div class="col-lg-6">
              <div class="card m-b-30">
                <div class="card-body">
                  <h4 class="mt-0 header-title">Status Chart</h4>
                  <?php
                  $sql = "SELECT COUNT(`od_id`) as tamount,`od_status` FROM `tbl_order` GROUP BY `od_status`
								";
                  $ExSeNTlist = mysqli_query( $conn, $sql )or die( mysqli_error( $conn ) );
                  $json_data = array();
                  $total = 0;
                  while ( $rowNewsTl = mysqli_fetch_array( $ExSeNTlist ) ) {
                    extract( $rowNewsTl );
                    $total = $total + $tamount;
                    $json_array[ 'label' ] = $od_status;
                    $json_array[ 'value' ] = $tamount;
                    array_push( $json_data, $json_array );
                  }
                  ?>
                  <div class="row">
                    <div class="col-lg-4" id="legend" class="donut-legend">
                  </div>
                  <div class="col-lg-8" id="morris-donut-example" class="morris-charts morris-chart-height" >
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card m-b-30">
            <div class="card-body">
              <h4 class="mt-0 header-title">Monthly Purchase And Sales</h4>
              
              <div id="morris-bar-example" > </div>
				
				
				<?php 
				$sqls="SELECT 
							r.receive,
							r.dates,
							p.sales
						FROM 
							(SELECT 
							SUM(`total_bill`) as receive,
							DATE_FORMAT(`invoice_date`, '%M %Y') as dates
						FROM 
							`mas_mat_receive` 
						GROUP BY 
							DATE_FORMAT(`invoice_date`, '%m-%Y')) as r
						left join (SELECT 
							SUM(`total_cost`) as sales,
							DATE_FORMAT(`od_date`, '%M %Y') as dates
						FROM 
							`tbl_order` 
						GROUP BY DATE_FORMAT(`od_date`, '%M %Y')) as p  on  p.dates= r.dates";
				$ExSeNTlists = mysqli_query( $conn, $sqls )or die( mysqli_error( $conn ) );
                  $json_datas = array();
                  
                  while ( $rowNewsTls = mysqli_fetch_array( $ExSeNTlists ) ) {
                    extract( $rowNewsTls );
                    
                    $json_arrays[ 'y' ] = $dates;
                    $json_arrays[ 'a' ] = $receive;
					  $json_arrays[ 'b' ] = $sales;
                    array_push( $json_datas, $json_arrays );
                  }
				?>
            </div>
          </div>
        </div>
        <!-- end col --> 
      </div>
     
    </div>
  </div>
  <!-- container-fluid --> 
  
</div>
<!-- content -->

<footer class="footer"> © <?php echo date('Y'); ?> - by Nextech</span> </footer>
</div>

<!-- ============================================================== --> 
<!-- End Right content here --> 
<!-- ============================================================== -->

</div>
<!-- END wrapper --> 

<!-- jQuery  --> 
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/bootstrap.bundle.min.js"></script> 
<script src="assets/js/metisMenu.min.js"></script> 
<script src="assets/js/jquery.slimscroll.js"></script> 
<script src="assets/js/waves.min.js"></script> 
<script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script> 

<!--Morris Chart--> 
<script src="assets/plugins/morris/morris.min.js"></script> 
<script src="assets/plugins/raphael/raphael-min.js"></script> 

<!-- google maps api --> 
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script> 
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> 
<!-- Required datatable js --> 
<script src="assets/plugins/datatables/jquery.dataTables.js"></script> 
<script src="assets/plugins/datatables/datatables.min.js"></script> 
<script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script> 
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script> 
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script> 

<!-- Responsive examples --> 

<script src="assets/plugins/select2/js/select2.min.js"></script> 
<script src="assets/plugins/parsleyjs/parsley.min.js"></script> 
<script src="assets/nestable/jquery.nestable.js"></script> 

<!-- Datatable init js --> 
<script src="assets/pages/datatables.init.js"></script> 
<script src="assets/pages/form-advanced.js"></script> 
<script src="assets/plugins/tinymce/tinymce.min.js"></script> 

<!-- App js --> 
<script src="assets/js/app.js"></script> 
<script src="assets/js/ajax.js"></script> 
<script>

  function showGuideModal(id){
    $.ajax({
        type: "POST",
        url: "pages/guide_modal.php",
        data: {
          id: id
        },
    }).done(function(msg) {
        $(".modal-content").html(msg);
    })
  }

$(document).ready(function () {
	var color_array = ['#03658C', '#7CA69E', '#F2594A', '#F28C4B', '#7E6F6A', '#36AFB2', '#9c6db2', '#d24a67', '#89a958', '#00739a', '#BDBDBD'];
	var Data = <?php echo json_encode($json_data)?> ;
	var total =  <?php echo $total;?>;
	var browsersChart = Morris.Donut({
	    element: 'morris-donut-example',
	    data   : Data,
	    colors: color_array,
	    formatter: function (value, data) { 
	    return Math.floor(value/total*100) + '%'; }
  });
 browsersChart.options.data.forEach(function(label, i) {
	  var legendItem = $('<span></span>').text(label['label'] + " ( " + label['value'] + " )").prepend('<br><span>&nbsp;</span>');
	  legendItem.find('span')
		.css('backgroundColor', browsersChart.options.colors[i])
		.css('width', '20px')
		.css('display', 'inline-block')
		.css('margin', '5px');
	  $('#legend').append(legendItem)
	});
		
	Morris.Bar({
  	  element: 'morris-bar-example',
	  resize: true,
  	  data: <?php echo json_encode($json_datas)?>,
  	  xkey: 'y',
  	  ykeys: ['a', 'b'],
  	  barColors: ['#0b62a4', '#7a92a3'],
  	  labels: ['Purchase', 'Sales' ],
	 barSizeRatio: 0.4,
                resize: true,
  	  hideHover: 'auto'
  	});	
});

var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
if(width.matches){
	document.body.className = "enlarged";
}


</script>
</body>
</html>
<?php } ?>
