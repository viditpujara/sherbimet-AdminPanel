<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Service";
$list_link = "service-list.php";
$add_link = "service-add.php";
$table = "tbl_service";
$primary_key = "service_id";

$editid = $_GET['eid'];


if (isset($_POST['update'])) {

    $id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $area_id = mysqli_real_escape_string($conn, $_POST['area_id']);
    
  

    
     $query_check = mysqli_query($conn, "select lower(service_name) from $table where service_name=lower('{$service_name}') and NOT $primary_key = '{$id}'") or die(mysqli_error($conn));

  $count = mysqli_num_rows($query_check);
  
  if($count>0)
  {
         echo "<script>alert('Service Name Already Exist');window.location='$list_link';</script>";
  }
    else{
      
             //product image name
      $cphoto = $_FILES['service_image']['name'];
   $path = 'images/service/';
   $time = time();
   $destination = $path.$time.basename($cphoto);
   

    //product image name
    $cimg = $time.basename($cphoto);
   
    
    //product img name
    $cust_photo  =$_POST["cust_photo"];
        
       if($cphoto=='')
    {
           $cimg =$cust_photo;
       } 
       else{
                if($cust_photo!=='')
     {
      if(file_exists('images/service/'.$cust_photo))
              
                                      {
          if($cust_photo == "noimage.png")
          {
              
          }else{
          
                                          unlink('images/service/'.$cust_photo);
          }
                                      }
     }                               
                                 $cimg =$cimg;
     
       move_uploaded_file($_FILES['service_image']['tmp_name'], $destination);
       }
        
    
    
    $queryupdate = mysqli_query($conn, "update $table set service_name='{$service_name}',area_id='{$area_id}',service_image='{$cimg}' where $primary_key='{$id}'") or die(mysqli_error($conn));



    if ($queryupdate) {
echo "<script>alert('Your Record Updated Successfully');window.location='$list_link';</script>";
       
    }
    else{
        echo "<script>alert('Your Record Not Update');window.location='$list_link';</script>";
              
            }
    }
}


if (!isset($_GET['eid']) || empty($_GET['eid'])) {
    header("location:$list_link");
}

$query_list = mysqli_query($conn, "select * from $table  where $primary_key='{$editid}'")or die(mysqli_error($conn));
$row_list = mysqli_fetch_array($query_list);


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edit <?php echo $page_title;?> | <?php echo $project_title;?></title>
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
              <li class="breadcrumb-item active">Edit <?php echo $page_title;?></li>
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
                <h3 class="card-title">Edit <?php echo $page_title;?></h3>
              </div>
                <form role="form" id="category-edit" method="post" action="#" enctype="multipart/form-data">
              <!-- /.card-header -->
              <div class="card-body">
              
                  <div class="row">
                    <div class="col-sm-3">
                      <!-- text input -->
                          <input type="hidden" class="form-control" name="service_id"  value="<?php echo $row_list['service_id']; ?>"  required>
                      <div class="form-group">
                        <label>Service</label>
                        <input type="text" name="service_name"  value="<?php echo $row_list['service_name']; ?>" class="form-control" placeholder="Enter Service" required="">
                      </div>
                    </div>
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Area</label>
                        <select name="area_id" id="area_id" class="form-control" required="">
                           <?php $query_area = mysqli_query($conn,"select * from tbl_area")or die(mysqli_error($conn));
                        
                            while($row_area= mysqli_fetch_array($query_area)){
                                if($row_area['area_id'] == $row_list['area_id'])
                                {
                                    $selected2  = "selected";
                                }
                                else{
                                    $selected2 ="";
                                }
                            ?>
							   <option value="<?php echo $row_area["area_id"];?>" <?php echo $selected2;?>><?php echo $row_area["area_name"];?></option>
							  <?php }?>
                          
                        </select>
                      </div>
                    </div>

                          <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="service_image"  class="form-control"  accept="image/*">
          
          
                        <input type="hidden" name="cust_photo" value="<?php echo $row_list['service_image'];?>">
                      </div>
                    </div>
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        
             <a href="images/service/<?php echo $row_list['service_image'];?>" target="_blank"><img src="images/service/<?php echo $row_list['service_image']; ?>" style="width: 100px;height: 100px;"></a>
                   
                      </div>
                    </div>
                    
                  </div>
                   
                
                  
                
                  
              
                    
              </div>
              <div class="card-footer">
                  <button type="submit" name="update" class="btn btn-primary">Update</button>
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
                $("#category-edit").validate({
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
