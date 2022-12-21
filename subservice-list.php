<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Subservice";
$list_link = "subservice-list.php";
$add_link = "subservice-add.php";
$table = "tbl_subservice";
$primary_key = "subservice_id";
$edit_link = "subservice-edit.php";
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
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Srno</th>
                                              
                                                  <th>Subservice</th>
                                                 <th>Service</th>
                                                <th>Image</th>

                                                <th>Action</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query_list = mysqli_query($conn, "select * from $table  order by $primary_key desc") or die(mysqli_error($conn));


                                            $x = 1;
                                            while ($row = mysqli_fetch_array($query_list)) {

                                                $subservice_id = $row['subservice_id'];
                                                $subservice_name = $row['subservice_name'];
                                                 $subservice_image = $row['subservice_image'];
                                                   
                                                   $service_id = $row['service_id'];
                                                            $query_1 = mysqli_query($conn,"select * from tbl_service where service_id='{$service_id}'")or die(mysqli_error($conn));
                            $row_1= mysqli_fetch_array($query_1);
                             $service_name = $row_1['service_name'];
                                                ?>

                                                <tr>

                                                    <td><?php echo $x++; ?></td>
                                                    <td><?php echo $subservice_name; ?></td>
                                                     <td><?php echo $service_name; ?></td>
                                                 <td><img src="images/service/<?php echo $subservice_image;?>" style="width: 50px;height: 50px;"></td>
                                                    <td><a href="<?php echo $edit_link;?>?eid=<?php echo $subservice_id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil-alt"></i></a>  <button class="btn btn-danger btn-xs delete_record" type="button" name="submit" data-order-id="<?php echo $subservice_id; ?>" value="<?php echo $subservice_id; ?>"><i class="fa fa-trash"></i></button></td>
                                                    
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                        
                                    </table>
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


            <?php include'themepart/footer.php'; ?>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <?php include'themepart/footer-script.php'; ?>
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
                        url: 'ajax/action-2.php',
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
