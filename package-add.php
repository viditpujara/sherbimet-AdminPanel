<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Package";
$list_link = "package-list.php";
$add_link = "package-add.php";
$table = "tbl_package";

if (isset($_POST['submit'])) {
    $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);

 
//     $query_check = mysqli_query($conn, "select lower(package_name) from $table where package_name=lower('{$package_name}')") or die(mysqli_error($conn));

//   $count = mysqli_num_rows($query_check);
  
//   if($count>0)
//   {
//          echo "<script>alert('Service Name Already Exist');window.location='$add_link';</script>";
//   }
// else{
   
//        $sub_subservice_id = mysqli_real_escape_string($conn, $_POST['sub_subservice_id']);
       
       $subservice_id = mysqli_real_escape_string($conn, $_POST['subservice_id']);
       $package_price = mysqli_real_escape_string($conn, $_POST['package_price']);
       $package_details = mysqli_real_escape_string($conn, $_POST['package_details']);
       

     //folder insert productimage
   $cphoto = $_FILES['package_image']['name'];

   
    
    if($cphoto  == "")
    {
       $cimg = "noimage.png"; 
    }
    else{
            $path = 'images/package/';
   $time = time();
   $destination = $path.$time.basename($cphoto);
      move_uploaded_file($_FILES['package_image']['tmp_name'], $destination);
   
   
   //database insert img name
    $cimg = $time.basename($cphoto);
    }
    
    
    $queryins = mysqli_query($conn, "insert into $table(package_name,package_image,subservice_id,package_price,package_details)values('{$package_name}','{$cimg}','{$subservice_id}','{$package_price}','{$package_details}')") or die(mysqli_error($conn));

    if ($queryins) {
     
          echo "<script>alert('Your Record Added Successfully');window.location='$add_link';</script>";
    } else {
        
            echo "<script>alert('Your Record Not Insert');window.location='$add_link';</script>";
    }
// }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Add <?php echo $page_title;?> | <?php echo $project_title;?></title>
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
            <h1><?php echo $page_title;?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $home_page;?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo $list_link;?>">List <?php echo $page_title;?></a></li>
              <li class="breadcrumb-item active">Add <?php echo $page_title;?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add <?php echo $page_title;?></h3>
              </div>
                <form role="form" id="product-add" method="post" action="#" enctype="multipart/form-data">
              <!-- /.card-header -->
              <div class="card-body">
              
                  <div class="row">
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Package Name</label>
                        <input type="text" name="package_name"  class="form-control" placeholder="Enter Package Name" required="">
                      </div>
                    </div>
                      
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Subservice</label>
                        <select  name="subservice_id"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <?php $query_1 = mysqli_query($conn,"select * from tbl_subservice order by subservice_name asc")or die(mysqli_error($conn));
                            while($row= mysqli_fetch_array($query_1)){
                            ?>
                            <option value="<?php echo $row["subservice_id"];?>"><?php echo $row["subservice_name"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" min="0" name="package_price"  class="form-control" placeholder="Enter Price" required="">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Details</label>
                        <textarea name="package_details"  class="form-control" placeholder="Enter Details" required=""></textarea>
                      </div>
                    </div>
                      
     <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label> Image</label>
                        <input type="file" name="package_image"  class="form-control"  accept="image/*">
                      </div>
                    </div>
                      
                   
                  </div>
             
                  
                
                  
              
                    
              </div>
              <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  <a href="<?php echo $list_link;?>" class="btn btn-info">View</a>
<!--                  <button type="submit" class="btn btn-default">Cancel</button>-->
                </div>
              <!-- /.card-body -->
                </form>
            </div>
            <!-- /.card -->
            <!-- general form elements disabled -->

            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include'themepart/footer.php';?>


</div>
<!-- ./wrapper -->


<?php include'themepart/footer-script.php';?>
     <script>
              $(document).ready(function () {

                // validate signup form on keyup and submit
                $("#product-add").validate({
                    rules: {
                        package_name: {
                            required: true,
                            minlength:2

                        },
                        subservice_id: {
                            required: true
                       
                        },
                        package_price: {
                            required: true
                       
                        },
                        package_details: {
                            required: true
                       
                        }
                        
                        
                        
                     

                    },
                    messages: {
                        package_name: {
                            required: "Please Enter Package Name"

                        },
                          subservice_id: {
                            required: "Please Select Subservice"

                        },
                        package_price: {
                            required: "Please Enter Price"

                        },
                        package_details: {
                            required: "Please Enter Details"

                        },

                    }
                });

            });
            </script>
<!--<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>-->
</body>
</html>
