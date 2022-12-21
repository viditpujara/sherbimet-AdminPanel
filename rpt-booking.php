<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "User Wise Booking Report";

?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title; ?> | <?php echo $project_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="dist/img/AdminLTELogo.png" type="image/x-icon">


</head>

<body>
    <center>
        <h3><?php echo $project_title; ?></h3>
    </center>

    <center>
        <h2><?php echo $page_title ?></h2>
    </center>
    <hr />

    <!-- <a href="#" onclick="window.print();">Print</a> -->
    <a href="#" class="mybtn hidediv">Print</a>
    <br>


    <?php

    echo " Date:" . date("d-m-Y");

    ?>
    <br><br>
    <form method="get" class="hidediv">
    <label>Start Date :</label>
          <input type="date" name="start_date" value="<?php 
          if(isset($_GET["start_date"]))
          { 
              echo $_GET["start_date"];} ?>">
          <label>End Date :</label>
          <input type="date" name="end_date" value="<?php 
          if(isset($_GET["end_date"]))
          { 
              echo $_GET["end_date"];} ?>">
        <label>User :</label>
        <select name='user_id'>
            <option value=''>All</option>
            <?php
            $query_list = mysqli_query($conn, "SELECT * FROM `tbl_user` where user_type_id='2'") or die(mysqli_error($conn));
            while ($row_list = mysqli_fetch_array($query_list)) {
                if (isset($_GET["user_id"])) {
                    if ($row_list["user_id"] == $_GET["user_id"]) {
                        $select = "selected";
                    } else {
                        $select = "";
                    }
                } else {
                    $select = "";
                }

            ?>
                <option value="<?php echo $row_list["user_id"]; ?>" <?php echo $select; ?>>
                    <?php echo $row_list["user_name"]; ?></option>
            <?php } ?>
        </select>

        <label>Status :</label>
        <select name='status_id'>
            <option value=''>All</option>
            <?php
            $query_list_1 = mysqli_query($conn, "SELECT * FROM `tbl_status`") or die(mysqli_error($conn));
            while ($row_list_1 = mysqli_fetch_array($query_list_1)) {
                if (isset($_GET["status_id"])) {
                    if ($row_list_1["status_id"] == $_GET["status_id"]) {
                        $select_1 = "selected";
                    } else {
                        $select_1 = "";
                    }
                } else {
                    $select_1 = "";
                }

            ?>
                <option value="<?php echo $row_list_1["status_id"]; ?>" <?php echo $select_1; ?>>
                    <?php echo $row_list_1["status_name"]; ?></option>
            <?php } ?>
        </select>


        <input type="submit">
    </form>
   <button  class="mybtn2">Reset</button>
    <?php
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        if ($user_id == "") {
            $search = "";
        } else {
            $search = "and user_id='{$user_id}'";
        }
    } else {

        $search = "";
    }

    if (isset($_GET['status_id'])) {
        $status_id = $_GET['status_id'];
        if ($status_id == "") {
            $search_status = "";
        } else {
             
             $search_status = "and status_id='{$status_id}'";
        }
    } else {

        $search_status = "";
    }

    

    if (isset($_GET['start_date'])) {
        $start_date = $_GET['start_date'];
        if ($start_date == "") {
            $search_start_date = "";
        } else {
             
             $search_start_date = "and booking_date>='{$start_date}'";
        }
    } else {

        $search_start_date = "";
    }
    
    if (isset($_GET['end_date'])) {
        $end_date = $_GET['end_date'];
        if ($end_date == "") {
            $search_end_date = "";
        } else {
             
             $search_end_date = "and booking_date<='{$end_date}'";
        }
    } else {

        $search_end_date = "";
    }

    $query = mysqli_query($conn, "select * from tbl_request where `is_delete`='0'  $search $search_status $search_start_date $search_end_date") or die(mysqli_error($conn));

    $count = mysqli_num_rows($query);
    ?>
    <br />
    <center><?php
            if ($count == "0") {
                echo "No";
            } else {
                echo $count;
            } ?> Records Found</center>
    <br />
    <?php
    if ($count > 0) {
    ?>

        <table align='center' style='text-align:center;' width='100%' border='1'>
            <tr>
                <th>Srno</th>

                <th>Package</th>
                <th>User</th>
                <th>Worker</th>

                <th>Booking Date & Time</th>
                <th>Status</th>
                   <th>Payment Method</th>
                <th>Total Amount</th>

            </tr>
            <?php
            $x = "1";
            while ($row = mysqli_fetch_array($query)) {

                $query_1 = mysqli_query($conn, "SELECT * FROM `tbl_user` where `user_id` ='{$row["user_id"]}'") or die(mysqli_error($conn));
                $row_1 = mysqli_fetch_array($query_1);

                $query_2 = mysqli_query($conn, "SELECT * FROM `tbl_package` where `package_id` ='{$row["package_id"]}'") or die(mysqli_error($conn));
                $row_2 = mysqli_fetch_array($query_2);
                
                $query_worker = mysqli_query($conn,"select * from tbl_worker where worker_id='{$row["worker_id"]}'")or die(mysqli_error($conn));
                $count_w=mysqli_num_rows($query_worker);
                
                if($count_w>0)
                {
                  
                  $row_worker= mysqli_fetch_array($query_worker);
                  $worker_first_name = $row_worker['worker_first_name'];
                  $worker_middle_name = $row_worker['worker_middle_name'];
                  $worker_last_name = $row_worker['worker_last_name'];
               
                }
                else{
                  $worker_name = "";
                  
                }
                $worker_name = $worker_first_name." ".$worker_middle_name." ".$worker_last_name;

                $query_4 = mysqli_query($conn, "SELECT * FROM `tbl_status` where `status_id` ='{$row["status_id"]}'") or die(mysqli_error($conn));
                $row_4 = mysqli_fetch_array($query_4);
            ?>
                <tr>
                    <td><?php echo $x++; ?></td>
                    <td><?php echo $row_2['package_name']; ?></td>

                    <td><?php echo $row_1['user_name']; ?></td>
                    <td><?php echo $worker_name;?></td>
                    <td><?php echo date("d-m-Y", strtotime($row['booking_date'])); ?> & <?php echo date("h:i a", strtotime($row['booking_time'])); ?></td>
                    <td><?php echo $row_4['status_name']; ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td>Rs.<?php echo $row['booking_totalamount']; ?></td>








                </tr>
            <?php
            }
            ?>
        </table>
    <?php

    } else {
        // echo "No Records Found";
    }
    ?>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        
        $(".mybtn2").hide();
        $(".mybtn").click(function(){
  $(".hidediv").hide();
  window.print();
  $(".mybtn2").show();
});
$(".mybtn2").click(function(){
  $(".hidediv").show();
  $(".mybtn2").hide();
});  
        // 
    
});
    
  
    </script>
</body>

</html>