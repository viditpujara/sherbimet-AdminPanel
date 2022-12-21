<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Worker";
$list_link = "worker-list.php";
$add_link = "worker-add.php";
$table = "tbl_worker";
$primary_key = "worker_id";
$edit_link = "worker-edit.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>List <?php echo $page_title; ?> | <?php echo $project_title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php
        include 'themepart/header-script.php';
        ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <?php
            include 'themepart/top-header.php';
            ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?php
            include 'themepart/sidebar.php';
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $page_title; ?></h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo $home_page; ?>">Home</a></li>
                                    <li class="breadcrumb-item active">List <?php echo $page_title; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List <?php echo $page_title; ?></h3>
                                    <a href="<?php echo $add_link;?>" class="btn btn-primary float-right">Add <?php echo $page_title;?></a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Srno</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                    <th>Mobile</th>
                                                <th>Gender</th>
                                              
                                                  <th>Package</th>
                                                  <th>City</th>
                                                   <th>Pincode</th>
                                                  
                                                  <th>Language</th>
                                                <th>Image</th>

                                                <th>Action</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query_list = mysqli_query($conn, "select * from $table where is_delete='0' order by $primary_key desc") or die(mysqli_error($conn));


                                            $x = 1;
                                            while ($row = mysqli_fetch_array($query_list)) {

                                                $worker_id = $row['worker_id'];
                                                $worker_name = $row['worker_name'];
                                                 $worker_gender = $row['worker_gender'];
                                                 $worker_email = $row['worker_email'];
                                                 $user_mobile = $row['worker_mobile'];
                                                 $worker_address = $row['worker_address'];

                                                 $city_id = $row['city_id'];
                                                 $pincode_id = $row['pincode_id'];
                                                 $language_id =$row['language_id'];
                                                
                                                 
                                                   $worker_image = $row['worker_image'];



                                                   

                                                   $package_id = $row['package_id'];



                                                            $query_sub = mysqli_query($conn,"select * from tbl_package where package_id='{$package_id}'")or die(mysqli_error($conn));
                            $row_sub= mysqli_fetch_array($query_sub);
                             $package_name = $row_sub['package_name'];



                             $query_city = mysqli_query($conn,"SELECT * FROM `tbl_city` WHERE `city_id`='{$city_id}'")or die(mysqli_error($conn));
                             $row_city = mysqli_fetch_array($query_city);
                                        $city_name = $row_city["city_name"];
                            
                            
                                        
                            
                                        $query_pincode = mysqli_query($conn,"SELECT * FROM `tbl_pincode` WHERE `pincode_id`='{$pincode_id}'")or die(mysqli_error($conn));
                             $row_pincode = mysqli_fetch_array($query_pincode);
                                        $pincode = $row_pincode["pincode"];

                                        $query_language = mysqli_query($conn,"SELECT * FROM `tbl_language` WHERE `language_id`='{$language_id}'")or die(mysqli_error($conn));
                             $row_language = mysqli_fetch_array($query_language);
                                        $language_name = $row_language["language_name"];
                                                ?>

                                                <tr>

                                                    <td><?php echo $x++; ?></td>
                                                    <td><?php echo $worker_name; ?></td>
                                                    
                                                      <td><?php echo $worker_email; ?></td>
                                                       <td><?php echo $user_mobile; ?></td>
                                                        <td><?php echo $worker_gender; ?></td>
                                                 
                                                       <td><?php  echo $package_name; ?></td>
<td><?php  echo $city_name; ?></td>
                                                       <td><?php  echo $pincode; ?></td>
                                                    
                                                    <td><?php echo $language_name; ?></td>
                                                    <td><img src="images/worker/<?php echo $worker_image;?>" style="width: 50px;height: 50px;"></td>
                                                    <td><a href="<?php echo $edit_link;?>?eid=<?php echo $worker_id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil-alt"></i></a>  <button class="btn btn-danger btn-xs delete_record" type="button" name="submit" data-order-id="<?php echo $worker_id; ?>" value="<?php echo $worker_id; ?>"><i class="fa fa-trash"></i></button></td>
                                                    
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                        
                                    </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->


            <?php include 'themepart/footer.php'; ?>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <?php include 'themepart/footer-script.php'; ?>
        <!-- page script -->
        <script>
            $(function () {
                $("#example1").DataTable();
        //    $('#example2').DataTable({
        //      "paging": true,
        //      "lengthChange": false,
        //      "searching": false,
        //      "ordering": true,
        //      "info": true,
        //      "autoWidth": false,
        //    });
            });



            $(document).on("click", '.delete_record', function () {

                var id = $(this).val();
                var action = 'delete';
                var tbl_name = '<?php echo $table; ?>';
                var field_name = '<?php echo $primary_key; ?>';
                if (confirm("Are you sure you want to Delete Record?"))
                {

                    $.ajax({
                        url: 'ajax/action.php',
        //				url:"action.php",
                        method: "POST",
                        data: {id: id, action: action, tbl_name: tbl_name, field_name: field_name},
                        success: function ()
                        {
                            //load_cart_data();
                         
                            alert("Your Record Deleted successfully");
                     
                               location.reload(true);
                        }
                    })

                    // window.location.href='category-list.php';
                    location.reload(true);

                } else
                {
        //                location.reload(true);
        //			return false;

                }


            });
        </script>
    </body>
</html>
