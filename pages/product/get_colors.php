<?php 
include('../header.php');
$mode=$_REQUEST['mode'];
$pd_id=$_REQUEST['pd_id'];
?>
<select multiple="multiple" size="10" name="colors[]" title="colors[]">
      
    <?php 
    if($mode==1){
        $query=" select
                                color_id,
                                color_name
                         FROM
                                tbl_color 
                                WHERE `color_status`=1 ";

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["color_id"];
                        $Name=$qry_row["color_name"];
                        print("<option value='$ID'>$Name</option>\n");
                }
    }
    elseif($mode==2){
      $datas=pickArray('tbl_product_color','color_id',"pid= ".$pd_id."");
      print_r( $datas);
       echo $query=" select
                                color_id,
                                color_name
                         FROM
                                tbl_color WHERE
    `color_status`=1 ";

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["color_id"];
                        $Name=$qry_row["color_name"];
                        if (in_array($qry_row["color_id"], $datas))
                          {
                          print("<option value='$ID' selected>$Name</option>\n");
                          }
                        else
                          {
                          print("<option value='$ID' >$Name</option>\n");
                          }
                        
                }
    
    }
    ?>
  </select>
<script>
  var demo1 = $('select[name="colors[]"]').bootstrapDualListbox();
</script>