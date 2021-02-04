<?php
include('../header.php');
extract($_REQUEST);
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
$path = $folfer_loc;

$logoimg = $_FILES['logo']['name'];
$logotmp = $_FILES['logo']['tmp_name'];
$logoext = strtolower(pathinfo($logoimg, PATHINFO_EXTENSION));
$logo_final_image = rand(1000,1000000).$logoimg;
$logo_imageName = strtolower($logo_final_image);
$logopath = $path.$logo_imageName;

$faviconimg = $_FILES['favicon']['name'];
$favicontmp = $_FILES['favicon']['tmp_name'];
$favext = strtolower(pathinfo($faviconimg, PATHINFO_EXTENSION));
$favicon_final_image = rand(1000,1000000).$faviconimg;
$favicon_imageName = strtolower($favicon_final_image);
$faviconpath = $path.$favicon_imageName;

$contact_phone =      $_REQUEST['contact_phone'];
$contact_email =     $_REQUEST['contact_email'];
$contact_map_location =     $_REQUEST['contact_map_location'];

$sql = mysqli_query($conn, "UPDATE tbl_company_setup 
    SET 	
        company_name = '$company_name',							
        website_slogan = '$website_slogan',							
        website_url = '$website_url',		
        comp_address = '$comp_address',
        contact_phone = '$contact_phone',
        contact_email = '$contact_email',
        contact_map_location = '$contact_map_location'
		");

if(in_array($logoext, $valid_extensions)) {
    $rmvSqllogo = mysqli_query($conn, "SELECT logo FROM tbl_company_setup");
    $logoimage=mysqli_fetch_array($rmvSqllogo);
    unlink($folfer_loc.$logoimage['logo']);
    if(move_uploaded_file($logotmp,$logopath)){
        $sql = mysqli_query($conn, "UPDATE tbl_company_setup SET logo = '$logo_imageName'");
    }
}

if(in_array($favext, $valid_extensions)) {
    $rmvSql = mysqli_query($conn, "SELECT favicon FROM tbl_company_setup");
    $image=mysqli_fetch_array($rmvSql);
    unlink($folfer_loc.$image['favicon']);
    if(move_uploaded_file($favicontmp,$faviconpath)){
        $sql = mysqli_query($conn, "UPDATE tbl_company_setup SET favicon = '$favicon_imageName'");
    }
}

$stc_sql=mysqli_query($conn, "UPDATE tbl_parameter SET parameter_value='$site_theme_color' WHERE parameter_name='site_theme_color'");
$ptcq_sql=mysqli_query($conn, "UPDATE tbl_parameter SET parameter_value='$product_tab_column_qty' WHERE parameter_name='product_tab_column_qty'");
$c_sql=mysqli_query($conn, "UPDATE tbl_parameter SET parameter_value='$currency' WHERE parameter_name='currency'");
$b_sql=mysqli_query($conn, "UPDATE tbl_parameter SET parameter_value='$brand' WHERE parameter_name='brand'");
$clr_sql=mysqli_query($conn, "UPDATE tbl_parameter SET parameter_value='$color' WHERE parameter_name='color'");
$p_sql=mysqli_query($conn, "UPDATE tbl_parameter SET parameter_value='$price' WHERE parameter_name='price'");

if($sql && $stc_sql && $ptcq_sql && $c_sql && $b_sql && $clr_sql && $p_sql){
    echo "Data successfully updated";
}else{
    echo "Failed to update data";
}

?>