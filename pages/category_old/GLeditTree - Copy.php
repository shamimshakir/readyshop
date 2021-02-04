<?php
if ( isset( $_SESSION[ 'SUserName' ] ) )$SUserName = $_SESSION[ 'SUserName' ];
if ( isset( $_SESSION[ 'SUserID' ] ) )$SUserID = $_SESSION[ 'SUserID' ];
include( "../../library/dbconnect.php" );
?>
<script type='text/javascript' src='assets/plugins/dtree/dtree.js'></script>

Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum, neque amet impedit quod tempore officiis dolorum corporis voluptate omnis enim, officia recusandae quibusdam reiciendis nihil, voluptatum. Corporis eligendi fuga delectus.
<script language='javascript'>
      
      function drawTree(idlist,pidlist,namelist,urllist)
      {
       id = new Array();
       pid = new Array();
       nam = new Array();
       id = idlist.split(' ');
       pid = pidlist.split(' ');
       nam = namelist.split('***#*');
 	   url = urllist.split(' ');
	   
       d = new dTree('d','assets/plugins/dtree/');

       for(var i=0;i<id.length;i++)
        {
           destination = "GLaddElement.php?id="+id[i]+"&pid="+pid[i]+"&lid="+url[i]+""; 
           d.add(parseInt(id[i]),parseInt(pid[i]),nam[i],destination,'','right');
        }

	
      // document.write(d);
		  var s = document.getElementsByTagName('footer');
            s = s[s.length - 1];
            var p = document.createElement('p');
            p.innerHTML = d;
            s.parentNode.insertBefore(p, s);
		  console.log(d);
  // get the "last" script on the page
          
        d.closeAll();
      }
	
</script>

<?php
$tree_query = " Select cat_id,
                      cat_parent_id,
                      cat_name AS description,
					  level_id
                from tbl_category
                order by cat_id";
$rset = mysqli_query( $conn, $tree_query )or die( "Error: " . mysqli_error( $conn ) );
while ( $row = mysqli_fetch_array( $rset ) ) {
  extract( $row );

  $id_tray .= $cat_id . " ";
  $pid_tray .= $cat_parent_id . " ";
  $name_tray .= $description . "***#*";
  $url_tray .= $level_id . " ";

}
?>

     <div class='dtree'> 
		 <?php 
		echo "  <script>
              drawTree('$id_tray','$pid_tray','$name_tray','$url_tray');
      	</script>"
		 ?>
      
      
    </div> 
 
 <div>
  <table border='0' align='center'>
  <tr>
   <td>&nbsp;
         
   </td>
  </tr>
  <tr>
   <td>&nbsp;
     
   </td>
  </tr> 
  <tr>
   <td>
  
   </td>
  </tr>
  </table>
 
 </div>
  
      
    
