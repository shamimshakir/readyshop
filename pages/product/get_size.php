<?php 
include('../header.php');
$mode=$_REQUEST['mode'];
$pd_id=$_REQUEST['pd_id'];
?>
<select multiple="multiple" size="10" name="sizes[]" title="sizes[]">
      
    <?php 
    if($mode==1){
         $query="SELECT
                    `size_id`,
                    `size_display`,
                    `size_type`,
                    `size_remarks`,
                    `status`
                FROM
                    `tbl_size`
                WHERE
                    `status`=0 ";

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["size_id"];
                        $Name=$qry_row["size_display"];
                        print("<option value='$ID'>$Name</option>\n");
                }
    }
    elseif($mode==2){
      $datas=pickArray('tbl_product_size','size_id',"pid= ".$pd_id."");
      print_r( $datas);
       echo $query="SELECT
                        `size_id`,
                        `size_display`,
                        `size_type`,
                        `size_remarks`,
                        `status`
                    FROM
                        `tbl_size`
                    WHERE
                        `status`=0";

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["size_id"];
                        $Name=$qry_row["size_display"];
                        if (in_array($qry_row["size_id"], $datas))
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
   $('select[name="sizes[]"]').bootstrapDualListbox();
</script>