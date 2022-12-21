<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Subservice Wise Package Report";

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
    
        <label>Service :</label>
        <select name='subservice_id'>
            <option value=''>All</option>
            <?php
            $query_list_1 = mysqli_query($conn, "SELECT * FROM `tbl_subservice`") or die(mysqli_error($conn));
            while ($row_list_1 = mysqli_fetch_array($query_list_1)) {
                if (isset($_GET["subservice_id"])) {
                    if ($row_list_1["subservice_id"] == $_GET["subservice_id"]) {
                        $select_1 = "selected"; 
                    } else {
                        $select_1 = "";
                    }
                } else {
                    $select_1 = "";
                }

            ?>
            <option value="<?php echo $row_list_1["subservice_id"]; ?>" <?php echo $select_1; ?>>
                <?php echo $row_list_1["subservice_name"]; ?></option>
            <?php } ?>
        </select>
    



        <input type="submit">
    </form>
    <button class="mybtn2">Reset</button>
    <?php


    if (isset($_GET['subservice_id'])) {
        $subservice_id = $_GET['subservice_id'];
        if ($subservice_id == "") {
            $search = "";
        } else {
             
             $search = "and subservice_id='{$subservice_id}'";
        }
    } else {

        $search = "";
    }

 

  

    $query = mysqli_query($conn, "select * from tbl_package where `is_search`='1'  $search  ") or die(mysqli_error($conn));

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

            <th>Package Name</th>
            <th>Price</th>
            <th>Subservice</th>
            <th>Image</th>
            
            


        </tr>
        <?php
            $x = "1";
            while ($row = mysqli_fetch_array($query)) {

                


                $query_4 = mysqli_query($conn, "SELECT * FROM `tbl_subservice` where `subservice_id` ='{$row["subservice_id"]}'") or die(mysqli_error($conn));
                $row_4 = mysqli_fetch_array($query_4);
            ?>
        <tr>
            <td><?php echo $x++; ?></td>

            <td><?php echo $row['package_name']; ?></td>
            <td>Rs.<?php echo $row['package_price']; ?></td>
            <td><?php echo $row_4['subservice_name']; ?></td>
            <td><img src="images/package/<?php echo $row['package_image'];?>" style="width: 30px;height: 30px;"></td>
          








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