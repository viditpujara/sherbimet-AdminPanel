<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "User Wise Feedback Report";

?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title; ?> | <?php echo $project_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="dist/img/AdminLTELogo.png" type="image/x-icon">
    
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  
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
    
        <label>User :</label>
        <select name='user_id'>
            <option value=''>All</option>
            <?php
            $query_list_1 = mysqli_query($conn, "SELECT * FROM `tbl_user` where user_type_id='2'") or die(mysqli_error($conn));
            while ($row_list_1 = mysqli_fetch_array($query_list_1)) {
                if (isset($_GET["user_id"])) {
                    if ($row_list_1["user_id"] == $_GET["user_id"]) {
                        $select_1 = "selected"; 
                    } else {
                        $select_1 = "";
                    }
                } else {
                    $select_1 = "";
                }

            ?>
            <option value="<?php echo $row_list_1["user_id"]; ?>" <?php echo $select_1; ?>>
                <?php echo $row_list_1["user_name"]; ?></option>
            <?php } ?>
        </select>
    



        <input type="submit">
    </form>
    <button class="mybtn2">Reset</button>
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

 

  

    $query = mysqli_query($conn, "select * from tbl_feedback where `is_delete`='0'  $search  ") or die(mysqli_error($conn));

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

            <th>User</th>
                                                <th>Worker</th>
                                                <th>Date</th>
                                                <th>Rating</th>
                                                <th>Message</th>
            
            


        </tr>
        <?php
            $x = "1";
            while ($row = mysqli_fetch_array($query)) {

                
                $feedback_id = $row['feedback_id'];
                $feedback_date = $row['feedback_date'];
                $feedback_message = $row['feedback_message'];
                $feedback_rating = $row['feedback_rating'];
                $user_id = $row['user_id'];
                $worker_id = $row['worker_id'];

                $query_4 = mysqli_query($conn, "SELECT * FROM `tbl_user` where `user_id` ='{$row["user_id"]}'") or die(mysqli_error($conn));
                $row_4 = mysqli_fetch_array($query_4);
                $query_worker = mysqli_query($conn,"select * from tbl_worker where worker_id='{$worker_id}'")or die(mysqli_error($conn));
                $row_worker= mysqli_fetch_array($query_worker);
                                    $worker_name = $row_worker['worker_name'];
            ?>
        <tr>
            <td><?php echo $x++; ?></td>

    

            
            <td><?php echo $row_4['user_name']; ?></td>
            
            
                                                     <td><?php echo $worker_name; ?></td>
                                                     <td><?php echo date("d-m-Y",strtotime($feedback_date)); ?></td>
                                                       <td><?php 
                                                       
                                                     for($i=0;$i<$feedback_rating;$i++)
                                                     {
                                                         ?>
                                                           
                                                           <i class="fa fa-star" style="color:orange;"></i>
                                                        <?php
                                                     }
                                                       
                                                       ?></td>
                                                         <td><?php echo $feedback_message; ?></td>








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
        $(".mybtn").click(function() {
            $(".hidediv").hide();
            window.print();
            $(".mybtn2").show();
        });
        $(".mybtn2").click(function() {
            $(".hidediv").show();
            $(".mybtn2").hide();
        });
        // 

    });
    </script>
</body>

</html>