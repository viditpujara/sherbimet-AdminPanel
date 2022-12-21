<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Subservice";
$list_link = "subservice-list.php";
$add_link = "subservice-add.php";
$table = "tbl_subservice";

if (isset($_POST['submit'])) {
    $subservice_name = mysqli_real_escape_string($conn, $_POST['subservice_name']);

 
    $query_check = mysqli_query($conn, "select lower(subservice_name) from $table where subservice_name=lower('{$subservice_name}')") or die(mysqli_error($conn));

  $count = mysqli_num_rows($query_check);
  
  if($count>0)
  {
         echo "<script>alert('Subservice Name Already Exist');window.location='$add_link';</script>";
  }
else{
   
//        $sub_service_id = mysqli_real_escape_string($conn, $_POST['sub_service_id']);
       
       $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
       

     //folder insert productimage
   $cphoto = $_FILES['subservice_image']['name'];

   
    
    if($cphoto  == "")
    {
       $cimg = "noimage.png"; 
    }
    else{
            $path = 'images/service/';
   $time = time();
   $destination = $path.$time.basename($cphoto);
      move_uploaded_file($_FILES['subservice_image']['tmp_name'], $destination);
   
   
   //database insert img name
    $cimg = $time.basename($cphoto);
    }
    
    
    $queryins = mysqli_query($conn, "insert into $table(subservice_name,subservice_image,service_id)values('{$subservice_name}','{$cimg}','{$service_id}')") or die(mysqli_error($conn));

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
                        <label>Subservice</label>
                        <input type="text" name="subservice_name" class="form-control" placeholder="Enter Subservice" required="">
                      </div>
                    </div>
                      
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Service</label>
                        <select  name="service_id"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <?php $query_1 = mysqli_query($conn,"select * from tbl_service order by service_name asc")or die(mysqli_error($conn));
                            while($row= mysqli_fetch_array($query_1)){
                            ?>
                            <option value="<?php echo $row["service_id"];?>"><?php echo $row["service_name"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
                      
     <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label> Image</label>
                        <input type="file" name="subservice_image"  class="form-control"  accept="image/*">
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
                        subservice_name: {
                            required: true,
                            minlength:2

                        },
                        service_id: {
                            required: true
                       
                        }
                        
                        
                        
                     

                    },
                    messages: {
                        subservice_name: {
                            required: "Please Enter Subservice Name"

                        },
                          service_id: {
                            required: "Please Select Service"

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
