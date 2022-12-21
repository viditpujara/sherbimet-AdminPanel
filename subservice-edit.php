<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Subservice";
$list_link = "subservice-list.php";
$add_link = "subservice-add.php";
$table = "tbl_subservice";
$primary_key = "subservice_id";

$editid = $_GET['eid'];


if (isset($_POST['update'])) {

    $id = mysqli_real_escape_string($conn, $_POST['subservice_id']);
    $subservice_name = mysqli_real_escape_string($conn, $_POST['subservice_name']);
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    
  

    
     $query_check = mysqli_query($conn, "select lower(subservice_name) from $table where subservice_name=lower('{$subservice_name}') and NOT $primary_key = '{$id}'") or die(mysqli_error($conn));

  $count = mysqli_num_rows($query_check);
  
  if($count>0)
  {
         echo "<script>alert('Subservice Name Already Exist');window.location='$list_link';</script>";
  }
    else{
      
             //product image name
      $cphoto = $_FILES['subservice_image']['name'];
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
     
       move_uploaded_file($_FILES['subservice_image']['tmp_name'], $destination);
       }
        
    
    
    $queryupdate = mysqli_query($conn, "update $table set subservice_name='{$subservice_name}',service_id='{$service_id}',subservice_image='{$cimg}' where $primary_key='{$id}'") or die(mysqli_error($conn));



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
                          <input type="hidden" class="form-control" name="subservice_id"  value="<?php echo $row_list['subservice_id']; ?>"  required>
                      <div class="form-group">
                        <label>Subservice</label>
                        <input type="text" name="subservice_name" value="<?php echo $row_list['subservice_name']; ?>" class="form-control" placeholder="Enter Subservice" required="">
                      </div>
                    </div>
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Service</label>
                        <select name="service_id" id="service_id" class="form-control" required="">
                           <?php $query_1 = mysqli_query($conn,"select * from tbl_service")or die(mysqli_error($conn));
                        
                            while($row_1= mysqli_fetch_array($query_1)){
                                if($row_1['service_id'] == $row_list['service_id'])
                                {
                                    $selected2  = "selected";
                                }
                                else{
                                    $selected2 ="";
                                }
                            ?>
							   <option value="<?php echo $row_1["service_id"];?>" <?php echo $selected2;?>><?php echo $row_1["service_name"];?></option>
							  <?php }?>
                          
                        </select>
                      </div>
                    </div>

                          <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="subservice_image"  class="form-control"  accept="image/*">
          
          
                        <input type="hidden" name="cust_photo" value="<?php echo $row_list['subservice_image'];?>">
                      </div>
                    </div>
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        
             <a href="images/service/<?php echo $row_list['subservice_image'];?>" target="_blank"><img src="images/service/<?php echo $row_list['subservice_image']; ?>" style="width: 100px;height: 100px;"></a>
                   
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
