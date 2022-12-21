<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "User";
$list_link = "user-list.php";
$add_link = "user-add.php";
$table = "tbl_user";
if (isset($_POST['submit'])) {
  
    $user_mobileno = mysqli_real_escape_string($conn, $_POST['user_mobileno']);
 
    $query_check = mysqli_query($conn, "select lower(user_mobileno) from $table where user_mobileno=lower('{$user_mobileno}')") or die(mysqli_error($conn));

  $count = mysqli_num_rows($query_check);
  
  if($count>0)
  {
         echo "<script>alert('Mobile No Already Exist');window.location='$add_link';</script>";
  }
else{
  $user_lat = mysqli_real_escape_string($conn, $_POST['user_lat']);
  $user_long = mysqli_real_escape_string($conn, $_POST['user_long']);

  $user_first_name = mysqli_real_escape_string($conn, $_POST['user_first_name']);
  $user_middle_name = mysqli_real_escape_string($conn, $_POST['user_middle_name']);
  $user_last_name = mysqli_real_escape_string($conn, $_POST['user_last_name']);

  $user_address_line_1 = mysqli_real_escape_string($conn, $_POST['user_address_line_1']);
  $user_address_line_2 = mysqli_real_escape_string($conn, $_POST['user_address_line_2']);
  $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);
  $pincode_id = mysqli_real_escape_string($conn, $_POST['pincode_id']);
  $language_id = mysqli_real_escape_string($conn, $_POST['language_id']);
  $area_id = mysqli_real_escape_string($conn, $_POST['area_id']);
 $query_city = mysqli_query($conn,"SELECT * FROM `tbl_city` WHERE `city_id`='{$city_id}'")or die(mysqli_error($conn));
 $row_city = mysqli_fetch_array($query_city);
            $city_name = $row_city["city_name"];


            $query_area = mysqli_query($conn,"SELECT * FROM `tbl_area` WHERE `area_id`='{$area_id}'")or die(mysqli_error($conn));
 $row_area = mysqli_fetch_array($query_area);
            $area_name = $row_area["area_name"];

            $query_pincode = mysqli_query($conn,"SELECT * FROM `tbl_pincode` WHERE `pincode_id`='{$pincode_id}'")or die(mysqli_error($conn));
 $row_pincode = mysqli_fetch_array($query_pincode);
            $pincode = $row_pincode["pincode"];

         $user_name = $user_first_name." ".$user_middle_name." ".$user_last_name;
      $user_gender = mysqli_real_escape_string($conn, $_POST['user_gender']);
      $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
       $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
       $user_address = $user_address_line_1." ".$user_address_line_2." ".$city_name." ".$area_name." ".$pincode;
      

     //folder insert productimage
   $cphoto = $_FILES['user_image']['name'];

   
    
    if($cphoto  == "")
    {
       $cimg = "noimage.png"; 
    }
    else{
            $path = 'images/user/';
   $time = time();
   $destination = $path.$time.basename($cphoto);
      move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
   
   
   //database insert img name
    $cimg = $time.basename($cphoto);
    }
    
    
    $queryins = mysqli_query($conn, "insert into $table(user_name,user_gender,user_email,user_mobileno,user_password,user_address,area_id,user_image,insert_datetime,`user_first_name`, `user_middle_name`, `user_last_name`, `user_address_line_1`, `user_address_line_2`, `city_id`, `pincode_id`, `language_id`,`user_lat`,`user_long`)values('{$user_name}','{$user_gender}','{$user_email}','{$user_mobileno}','{$user_password}','{$user_address}','{$area_id}','{$cimg}','{$datetime}','{$user_first_name}','{$user_middle_name}','{$user_last_name}','{$user_address_line_1}','{$user_address_line_2}','{$city_id}','{$pincode_id}','{$language_id}','{$user_lat}','{$user_long}')") or die(mysqli_error($conn));

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
                <form role="form" id="user-add" method="post" action="#" enctype="multipart/form-data">
              <!-- /.card-header -->
              <div class="card-body">
              
                  <div class="row">
                      
                  <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text"  name="user_first_name" onkeyup ="Validatestring(this)"  class="form-control" placeholder="Enter First Name" required="">
                      </div>
                    </div>
                      
                      
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text"  name="user_middle_name" onkeyup ="Validatestring(this)"  class="form-control" placeholder="Enter Middle Name" required="">
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text"  name="user_last_name" onkeyup ="Validatestring(this)"  class="form-control" placeholder="Enter Last Name" required="">
                      </div>
                    </div>
                      
                       <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Gender</label>
                        <select  name="user_gender"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          
                        </select>
                      </div>
                    </div>
                      
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="user_email"  class="form-control" placeholder="Enter Email" required="">
                      </div>
                    </div>
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" maxlength="10"  name="user_mobileno" onkeyup ="Validate(this)"  class="form-control" placeholder="Enter Mobile" required="">
                      </div>
                    </div>
                      
                      
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address Line 1</label>
                        <textarea  name="user_address_line_1"  class="form-control" placeholder="Enter Address Line 1"></textarea>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address Line 2</label>
                        <textarea  name="user_address_line_2"  class="form-control" placeholder="Enter Address Line 2"></textarea>
                      </div>
                    </div>  
                      
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>City</label>
                        <select  name="city_id"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <?php $query_city = mysqli_query($conn,"select * from tbl_city where is_active='1' and is_delete='0'")or die(mysqli_error($conn));
                            while($row_city= mysqli_fetch_array($query_city)){
                            ?>
                            <option value="<?php echo $row_city["city_id"];?>"><?php echo $row_city["city_name"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
                      

                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Pincode</label>
                        <select  name="pincode_id"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <?php $query_pincode = mysqli_query($conn,"select * from tbl_pincode where is_active='1' and is_delete='0'")or die(mysqli_error($conn));
                            while($row_pincode= mysqli_fetch_array($query_pincode)){
                            ?>
                            <option value="<?php echo $row_pincode["pincode_id"];?>"><?php echo $row_pincode["pincode"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Area</label>
                        <select  name="area_id"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <?php $query_area = mysqli_query($conn,"select * from tbl_area")or die(mysqli_error($conn));
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
                        <label>Language</label>
                        <select  name="language_id"  class="form-control" required="">
                            <option value="">-Select-</option>
                            <?php $query_language = mysqli_query($conn,"select * from tbl_language where is_active='1' and is_delete='0'")or die(mysqli_error($conn));
                            while($row_language= mysqli_fetch_array($query_language)){
                            ?>
                            <option value="<?php echo $row_language["language_id"];?>"><?php echo $row_language["language_name"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
    
                   
                    <div class="col-sm-3">
                      
                      <div class="form-group">
                        <label>Latitude</label>
                        <input type="text"  name="user_lat" class="form-control" placeholder="Enter Latitude" required="">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      
                      <div class="form-group">
                        <label>Longitude</label>
                        <input type="text"  name="user_long" class="form-control" placeholder="Enter Longitude" required="">
                      </div>
                    </div>
                      
                       <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="user_password"  class="form-control" placeholder="Enter Password" required="">
                      </div>
                    </div>
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label> Image</label>
                        <input type="file" name="user_image"  class="form-control"  accept="image/*">
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
<?php include 'themepart/footer.php';?>


</div>
<!-- ./wrapper -->


<?php include 'themepart/footer-script.php';?>
<script>
              $(document).ready(function () {

                // validate signup form on keyup and submit
                $("#user-add").validate({
                    rules: {
                        
                      user_first_name: {
                            required: true,
                            

                        },
                        user_middle_name: {
                            required: true,
                            

                        },
                        user_last_name: {
                            required: true,
                            

                        },
                         user_gender: {
                            required: true
                       
                        },
                        user_email: {
                            required: true,
                            email:true

                        },
                         user_mobileno: {
                            required: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        
                         user_password: {
                            required: true,
                             minlength: 6

                        },
                        user_address_line_1: {
                            required: true
                       
                        },
                        user_address_line_2: {
                            required: true
                       
                        },
                        city_id: {
                            required: true
                       
                        },
                        pincode_id: {
                            required: true
                       
                        },
                        language_id: {
                            required: true
                       
                        },
                        user_lat: {
                            required: true
                       
                        },
                        user_long: {
                            required: true
                       
                        }
                      
                        

                    },
                    messages: {
                      user_first_name: {
                            required: "Please Enter First Name"

                        },
                        user_middle_name: {
                            required: "Please Enter Middle Name"

                        },
                        user_last_name: {
                            required: "Please Enter Last Name"

                        },
                          user_gender: {
                            required: "Please Select Gender"

                        },
                           user_email: {
                            required: "Please Enter Email",
                            email: "Invalid Email address"

                        },
                           user_mobileno: {
                            required: "Please Enter Your Mobile no.",
                            minlength: "Enter Your 10 digit Mobile no. only",
                            maxlength: "Enter Your 10 digit Mobile no. only",
                        },
                         user_password: {
                            required: "Please Enter Password",
                           minlength: "Your password must be at least 6 characters long"

                        },
                        user_address_line_1: {
                            required: "Please Enter Address Line 1"

                        },
                        user_address_line_2: {
                            required: "Please Enter Address Line 2"

                        },
                        city_id: {
                            required: "Please Select City"

                        },
                        pincode_id: {
                            required: "Please Select Pincode"

                        },
                        language_id: {
                            required: "Please Select Language"

                        },
                        user_lat: {
                            required: "Please Enter Latitude"

                        },
                        user_long: {
                            required: "Please Enter Longitude"

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
