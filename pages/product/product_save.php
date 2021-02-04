<?php
include('../header.php');

$mode =                 $_REQUEST['mode'];
$pd_id =                $_REQUEST['pd_id'];
$pd_name =              $_REQUEST['pd_name'];
$cat_id =               $_REQUEST['cat_id'];
$brand_id =               $_REQUEST['brand_id'];
$unit_type =               $_REQUEST['unit_type'];
$pd_price =               $_REQUEST['pd_price'];
$pd_code =               $_REQUEST['pd_code'];
$prod_type =               $_REQUEST['prod_type'];
$hst =               $_REQUEST['hst'];
$reward_point =               $_REQUEST['reward_point'];
$pd_prev_price =               $_REQUEST['pd_prev_price'];
$pd_qty =               $_REQUEST['pd_qty'];
$product_detail =               $_REQUEST['product_detail'];
$product_specification =               $_REQUEST['product_specification'];
$product_warranty =               $_REQUEST['product_warranty'];
$product_highlight =               $_REQUEST['product_highlight'];

$upsstat =               $_REQUEST['upsstat'];
$on_sale =               $_REQUEST['on_sale'];
$color_apply=            $_REQUEST['color_apply'];
$size_apply=            $_REQUEST['size_apply'];
if($_REQUEST['feature_stat']=="on"){$feature_stat=1;}else{$feature_stat='';}
if($_REQUEST['new_stat']=="on"){$new_stat=1;}else{$new_stat='';}
if($_REQUEST['popular_stat']=="on"){$popular_stat=1;}else{$popular_stat='';}
if($_REQUEST['upsstat']=="on"){$upsstat=1;}else{$upsstat='';}
if($_REQUEST['on_sale']=="on"){$on_sale=1;}else{$on_sale='';}

$category_name = pick('tbl_category','cat_name',"cat_id='".$cat_id."'");

if ($mode == 1) {
    $thumbnail = $_FILES['pd_thumbnail']['name'];
    $target = $folfer_loc.'products/thumbnails/' . basename($thumbnail);
    move_uploaded_file($_FILES['pd_thumbnail']['tmp_name'], $target);
	$width=300;
	$height=300;
	$quality=60;
	 copyImage($target,$target, $width, $height, $quality);

    $sql = "INSERT 
            INTO tbl_product (
                pd_name,
                cat_id,
                brand_id,
                unit_type,
                pd_price,
                pd_code,
                prod_type,
                hst,
                reward_point,
                pd_prev_price,
                pd_qty,
                popular_stat,
                upsstat,
                new_stat,
                product_detail,
                product_specification,
                product_warranty,
                feature_stat,
                pd_thumbnail,
                onsale_stat,
                color_apply,
                size_apply,
				product_highlight
            ) 
            VALUES (
                '$pd_name',
                '$cat_id',
                '$brand_id',
                '$unit_type',
                '$pd_price',
                '$pd_code',
                '$prod_type',
                '$hst',
                '$reward_point',
                '$pd_prev_price',
                '$pd_qty',
                '$popular_stat',
                '$upsstat',
                '$new_stat',
                '$product_detail',
                '$product_specification',
                '$product_warranty',
                '$feature_stat',
                '$thumbnail',
                '$on_sale',
                '$color_apply',
                '$size_apply',
				'$product_highlight'
            )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $last_id = mysqli_insert_id($conn);
    
    
    if($color_apply==0){
        $colors=$_REQUEST['colors'];
        foreach($colors as $color){
       $sqls = " INSERT INTO `tbl_product_color`( `pid`, `color_id`)
            VALUES(".$last_id." , ".$color.")";
             $runSqls = mysqli_query($conn,$sqls) or die(mysqli_error($conn));
        }
    }
    if($size_applyy==0){
        $sizes=$_REQUEST['sizes'];
        foreach($sizes as $size){
            $sqls = " INSERT INTO `tbl_product_size`( `pid`, `size_id`)
            VALUES(".$last_id." , ".$size.")";
             $runSqls = mysqli_query($conn,$sqls) or die(mysqli_error($conn));
        }
    }

    if(!empty($_FILES['pro_img_name']['name'][0])){
        productImagsUpload($folfer_loc.'/products/', $category_name, $pd_name, $_FILES['pro_img_name'], 'tbl_product_images', $last_id);
    }

    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}
else{
    

    /******** Finally Update Product Table ******/
    $updateSql = "UPDATE tbl_product
            SET 
                pd_name  = '$pd_name',
                cat_id = '$cat_id',
                brand_id = '$brand_id',
                unit_type = '$unit_type',
                pd_price = '$pd_price',
                pd_code = '$pd_code',
                prod_type = '$prod_type',
                hst = '$hst',
                reward_point = '$reward_point',
                pd_prev_price = '$pd_prev_price',
               
                popular_stat = '$popular_stat',
                upsstat = '$upsstat',
                new_stat = '$new_stat',
                product_detail = '$product_detail',
                product_specification = '$product_specification',
                feature_stat = '$feature_stat',
                product_warranty = '$product_warranty',
                onsale_stat='$on_sale',
                color_apply='$color_apply',
                size_apply='$size_apply',
				product_highlight='$product_highlight'
            WHERE pd_id = '$pd_id'";
    $runUpdate = mysqli_query($conn,$updateSql) or die(mysqli_error($conn));
    
    if($color_apply==0){
        $colors=$_REQUEST['colors'];
       mysqli_query($conn, "DELETE FROM `tbl_product_color` WHERE `pid`=".$pd_id."");
        foreach($colors as $color){
       $sqls = " INSERT INTO `tbl_product_color`( `pid`, `color_id`)
            VALUES(".$pd_id." , ".$color.")";
             $runSqls = mysqli_query($conn,$sqls) or die(mysqli_error($conn));
        }
    }
    if($size_applyy==0){
        $sizes=$_REQUEST['sizes'];
        mysqli_query($conn, "DELETE FROM `tbl_product_size` WHERE `pid`=".$pd_id."");
        foreach($sizes as $size){
            $sqls = " INSERT INTO `tbl_product_size`( `pid`, `size_id`)
            VALUES(".$pd_id." , ".$size.")";
             $runSqls = mysqli_query($conn,$sqls) or die(mysqli_error($conn));
        }
    }
	
	
	// Upload New Product Images if image isset
    if(!empty($_FILES['pd_thumbnail']['name'])){
        $sthumImgSql = "SELECT pd_thumbnail FROM tbl_product WHERE pd_id = '$pd_id'";
        $sthumnail = mysqli_query($conn,$sthumImgSql) or die(mysqli_error($conn));
        while($rowthum=mysqli_fetch_array($sthumnail)){
            extract($rowthum);
            unlink($folfer_loc."products/thumbnails/{$pd_thumbnail}");
        }

        $thumbnail = $_FILES['pd_thumbnail']['name'];
        $target = $folfer_loc.'products/thumbnails/' . basename($thumbnail);
        move_uploaded_file($_FILES['pd_thumbnail']['tmp_name'], $target);
		$width=300;
		$height=300;
		$quality=60;
	 copyImage($target,$target, $width, $height, $quality);
        $imgUpdateSql = "UPDATE tbl_product
                SET pd_thumbnail = '$thumbnail'
                WHERE pd_id = '$pd_id'";
        mysqli_query($conn,$imgUpdateSql) or die(mysqli_error($conn));
    }

    /*****  if isset new product images */
    if(!empty($_FILES['pro_img_name']['name'][0])){
        
        productImagsUpload($folfer_loc.'products/', $category_name, $pd_name, $_FILES['pro_img_name'], 'tbl_product_images', $pd_id);
    }
	
    if($runUpdate){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }

}

?>