<?php include('../header.php');
session_start();
$SUserName = $_SESSION['SUserName'];
$SUserID   = $_SESSION['User_ID'];
$user_profile_id   = $_SESSION['user_profile_id'];

$idp = $_REQUEST['id'];

$res = mysqli_query($conn, "SELECT
        profile_name as type_name
    FROM
        user_profile
    WHERE
        user_profile_id='$idp'");
$row = mysqli_fetch_array($res);
extract($row);

?>

<div id="mainContent">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">User Permission for '<?php echo $type_name; ?>'</h4>
                    <form id="userForm" class="" action="#" novalidate="">
                        <input type="hidden" name="id" value="<?php echo $idp;?>">
<?php
    
    if($user_profile_id == 1){
        function build_permission_menu($parentId){
            global $conn;
            $ids = $_REQUEST['id'];
            $sql1Parent = "SELECT
                id,
                pid,
                NodeName,
                (Select COUNT(pid) from _tree_entries as test where test.pid=_tree_entries.id) as haschild,
                per.sid,
                per.addp,
                per.editp,
                per.accessall
            FROM
                _tree_entries
            LEFT JOIN(
                SELECT
                    id AS sid,
                    addp,
                    editp,
                    accessall
                FROM
                    _user_permission
                WHERE
                    user_id = $ids
            ) AS per
            ON
                per.sid = _tree_entries.id
                WHERE pid = $parentId";
                
            $parentNodesRes = mysqli_query($conn, $sql1Parent);
 
            while($parentNodes = mysqli_fetch_assoc($parentNodesRes)){
                extract($parentNodes);
                $condview = $id == $sid ? 'checked' : '';
                $condadd = $addp == $sid &&  $addp!=NULL ? 'checked' : '';
                $condedit = $editp == $sid &&  $editp!=NULL ? 'checked' : '';
                $condaccessall = $accessall == $sid &&  $accessall!=NULL ? 'checked' : '';
                
                
                if($parentId == 0){
                    echo "<tr>
                        <td><strong>{$parentNodes['NodeName']}</strong></td>
                        <td><input type='checkbox' name='node[$id]' value='$id' $condview></td>
                        <td><input type='checkbox' name='ap[$id]' value='$id' $condadd></td>
                        <td><input type='checkbox' name='ep[$id]' value='$id' $condedit></td>
                        <td><input type='checkbox' name='dp[$id]' value='$id' $condaccessall></td>
                    </tr>";
                }else{
                    echo "<tr>
                        <td>{$parentNodes['NodeName']}</td>
                        <td><input type='checkbox' name='node[$id]' value='$id' $condview></td>
                        <td><input type='checkbox' name='ap[$id]' value='$id' $condadd></td>
                        <td><input type='checkbox' name='ep[$id]' value='$id' $condedit></td>
                        <td><input type='checkbox' name='dp[$id]' value='$id' $condaccessall></td>
                    </tr>";
                }
                
                if($haschild > 0){
                    build_permission_menu($id);
                }
            }
            
        }
        
         echo "<table class='table tree-2 table-bordered table-striped table-condensed'> 
        <tr >
            <td>Module/Node</td>
            <td>View</td>
            <td>Add</td>
            <td>Edit</td>
            <td>Access All</td>
        </tr>";
        build_permission_menu(0);
        echo "</table>";
    }
?>
                        <div class="form-group mb-0 mt-2 d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-secondary waves-effect" onclick="view_data()">Cancel</button>
                                <button type="button" onclick="persave()" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function persave() {
        $.ajax({
            type: "POST",
            url: "pages/profile/permission_save.php",
            data: $('#userForm').serialize()
        }).done(function(response) {
            alertify.set('notifier','position', 'bottom-right');
            alertify.success(response);
            view_data();
            console.log(response)
        }).fail(function() {
            alertify.notify(response, 'error', 3);
        });
    }
</script>