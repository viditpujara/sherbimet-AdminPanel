<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Profile";
$list_link = "profile-edit.php";
$add_link = "user-add.php";
$table = "tbl_admin";
$primary_key = "admin_id";

$editid = $admin_id;


if (isset($_POST['update'])) {

    $id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $admin_email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    

    
     $query_check = mysqli_query($conn, "select lower(admin_email) from $table where admin_email=lower('{$admin_email}') and NOT $primary_key = '{$id}'") or die(mysqli_error($conn));

  $count = mysqli_num_rows($query_check);
  
  if($count>0)
  {
         echo "<script>alert('Email Already Exist');window.location='$list_link';</script>";
  }
    else{
            $admin_name = mysqli_real_escape_string($conn, $_POST['admin_name']);
  $_SESSION["adminemail"]=$admin_email;
       $admin_mobile = mysqli_real_escape_string($conn, $_POST['admin_mobile']);
 
             //product image name
      $cphoto = $_FILES['admin_profile']['name'];
   $path = 'images/profile/';
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
      if(file_exists('images/profile/'.$cust_photo))
              
                                      {
          if($cust_photo == "noimage.png")
          {
              
          }else{
          
                                          unlink('images/profile/'.$cust_photo);
          }
                                      }
     }                               
                                 $cimg =$cimg;
     
       move_uploaded_file($_FILES['admin_profile']['tmp_name'], $destination);
       }
        
    
    
    $queryupdate = mysqli_query($conn, "update $table set `admin_name`='{$admin_name}', `admin_email`='{$admin_email}', `admin_mobile`='{$admin_mobile}',admin_profile='{$cimg}' where $primary_key='{$id}'") or die(mysqli_error($conn));



    if ($queryupdate) {
echo "<script>alert('Your Record Updated Successfully');window.location='$list_link';</script>";
       
    }
    else{
        echo "<script>alert('Your Record Not Update');window.location='$list_link';</script>";
              
            }
    }
}


//if (!isset($_GET['eid']) || empty($_GET['eid'])) {
//    header("location:$list_link");
//}

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
                <form role="form" id="profile-edit" method="post" action="#" enctype="multipart/form-data">
              <!-- /.card-header -->
              <div class="card-body">
               <div class="row">
                       <input type="hidden" class="form-control" name="admin_id"  value="<?php echo $row_list['admin_id']; ?>"  required>
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text"  name="admin_name" onkeyup ="Validatestring(this)" value="<?php echo $row_list['admin_name']; ?>" class="form-control" placeholder="Enter Name" required="">
                      </div>
                    </div>
                      
                     
                      
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="admin_email" value="<?php echo $row_list['admin_email']; ?>" class="form-control" placeholder="Enter Email" required="">
                      </div>
                    </div>
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" maxlength="10"  name="admin_mobile" value="<?php echo $row_list['admin_mobile']; ?>" onkeyup ="Validate(this)"  class="form-control" placeholder="Enter Mobile" required="">
                      </div>
                    </div>
                      
                            <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="admin_profile"  class="form-control"  accept="image/*">
          
          
                        <input type="hidden" name="cust_photo" value="<?php echo $row_list['admin_profile'];?>">
                      </div>
                    </div>
                    
                  </div>
     
                        <div class="row">
                      
                     
                      
                   
                      
                            
                            
                  </div>
                  <div class="row">
                        
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        
             <a href="images/profile/<?php echo $row_list['admin_profile'];?>" target="_blank"><img src="images/profile/<?php echo $row_list['admin_profile']; ?>" style="width: 100px;height: 100px;"></a>
                   
                      </div>
                    </div>
                  </div>
                  
                
                  
              
                    
              </div>
              <div class="card-footer">
                  <button type="submit" name="update" class="btn btn-primary">Update</button>
                  
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
                $("#profile-edit").validate({
                    rules: {
                        
                         admin_name: {
                            required: true,
                            minlength:2

                        },
                       
                        admin_email: {
                            required: true,
                            email:true

                        },
                         admin_mobile: {
                            required: true,
                            minlength: 10,
                            maxlength: 10
                        }
                      
                      
                        
                        
                        
                     

                    },
                    messages: {
                        admin_name: {
                            required: "Please Enter Name"

                        },
                         
                           admin_email: {
                            required: "Please Enter Email",
                            email: "Invalid Email address"

                        },
                           admin_mobile: {
                            required: "Please Enter Your Mobile no.",
                            minlength: "Enter Your 10 digit Mobile no. only",
                            maxlength: "Enter Your 10 digit Mobile no. only",
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
