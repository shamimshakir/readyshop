<?php
include('../header.php');

$id = $_REQUEST['id'];
$views = $_REQUEST['node'];
$addp = $_REQUEST['ap'];
$editp = $_REQUEST['ep'];
$deletep = $_REQUEST['dp'];


$res = mysqli_query($conn, " DELETE FROM _user_permission WHERE user_id='$id' ");

//for ($i = 0; $i < count($id); $i++)

foreach ($views as $index => $view) {
    //echo $view;
    $res1 = mysqli_query($conn, "SELECT
								pid
							FROM
								_tree_entries
							WHERE
								id = '$view'
								");

    $row = mysqli_fetch_array($res1);
    extract($row);
    $res2 = mysqli_query($conn, "INSERT INTO 
								_user_permission 
								(
									user_id,
									id,
									 `addp`,
									`editp`,
									`accessall`,
									`pid`
								)
							VALUES
							(
								'$id',
								'$view',
								'$addp[$index]',
								'$editp[$index]',
								'$deletep[$index]',
								'$pid'
							)");


}
if($res2)
{
    //echo "1";
    echo "Data successfully updated";
}
else
{
    //echo "2";
    echo "Failed to update data";
}