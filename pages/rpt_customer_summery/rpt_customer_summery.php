
<?php include('../header.php')?>


<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body" id="card-body">
                <h4 class="mt-0 header-title d-flex justify-content-between">
                    <span>Customer Summery</span>
                </h4>
                <?php
                include_once '../library/dbconnect.php';
                include_once '../Library/Library.php';

                $SeNTlist1="SELECT
                tbl_customer.cl_id,
                tbl_customer.cl_pin,
                tbl_customer.cl_code,
                tbl_customer.surname,
                tbl_customer.firstname,
                tbl_customer.lastname,
                tbl_customer.address,
                tbl_customer.street,
                tbl_customer.city,
                tbl_customer.postal_code,
                tbl_customer.province,
                tbl_customer.country,
                tbl_customer.phone,
                tbl_customer.email,
                tbl_customer.user_regdate,
                tbl_customer.user_last_login,
                tbl_customer.reward_point,
                tbl_customer.customer_type
            FROM
                tbl_customer";
                $rSeNTlist1=mysqli_query($conn,$SeNTlist1) or die();
                $numrows=mysqli_num_rows($rSeNTlist1);
                if($numrows>0){
                    $i=0;
                    echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Street</th>
                        <th>City</th>
                        <th>Postal_code</th>
                        <th>Province</th>
                        <th>Total Point</th>
                    </tr>
                </thead>";
                    while($rows=mysqli_fetch_array($rSeNTlist1)){
                        extract($rows);
                        echo"<tr>
                        <td>$email </td>
                        <td>$surname $firstname </td>
                        <td>$phone </td>
                        <td>$address</td>
                        <td>$street </td>
                        <td>$city </td>
                        <td>$postal_code </td>
                        <td>$province </td>
                        <td>$reward_point </td>
                    </tr>";
                        $i++;
                    }
                }else{
                    echo "<center><b> Data Not Found.....</b>";
                }
                ?>
            </div>
        </div>
    </div>
</div>




