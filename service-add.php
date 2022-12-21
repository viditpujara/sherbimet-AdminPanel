<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Service";
$list_link = "service-list.php";
$add_link = "service-add.php";
$table = "tbl_service";

if (isset($_POST['submit'])) {
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);

 
    $query_check = mysqli_query($conn, "select lower(service_name) from $table where service_name=lower('{$service_name}')") or die(mysqli_error($conn));

  $count = mysqli_num_rows($query_check);
  
  if($count>0)
  {
         echo "<script>alert('Service Name Already Exist');window.location='$add_link';</script>";
  }
else{
   
//        $sub_area_id = mysqli_real_escape_string($conn, $_POST['sub_area_id']);
       
       $area_id = mysqli_real_escape_string($conn, $_POST['area_id']);
       

     //folder insert productimage
   $cphoto = $_FILES['service_image']['name'];

   
    
    if($cphoto  == "")
    {
       $cimg = "noimage.png"; 
    }
    else{
            $path = 'images/service/';
   $time = time();
   $destination = $path.$time.basename($cphoto);
      move_uploaded_file($_FILES['service_image']['tmp_name'], $destination);
   
   
   //database insert img name
    $cimg = $time.basename($cphoto);
    }
    
    
    $queryins = mysqli_query($conn, "insert into $table(service_name,service_image,area_id)values('{$service_name}','{$cimg}','{$area_id}')") or die(mysqli_error($conn));

    if ($queryins) {
     
          echo "<script>alert('Your Record Added Successfully');window.location='$add_link';</script>";
    } else {
        
            echo "<script>alert('Your Record Not Insert');window.location='$add_link';</script>";
    }
}
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
                        <label>Service</label>
                        <input type="text" name="service_name" class="form-control" placeholder="Enter Service" required="">
                      </div>
                    </div>
                      
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Area</label>
                        <select  name="area_id"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <?php $query_area = mysqli_query($conn,"select * from tbl_area where is_active='1' and  is_delete='0' order by area_name asc")or die(mysqli_error($conn));
                            while($row= mysqli_fetch_array($query_area)){
                            ?>
                            <option value="<?php echo $row["area_id"];?>"><?php echo $row["area_name"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
                      
     <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label> Image</label>
                        <input type="file" name="service_image"  class="form-control"  accept="image/*">
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
                        service_name: {
                            required: true,
                            minlength:2

                        },
                        area_id: {
                            required: true
                       
                        }
                        
                        
                        
                     

                    },
                    messages: {
                        service_name: {
                            required: "Please Enter Service Name"

                        },
                          area_id: {
                            required: "Please Select Area"

                        }

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
