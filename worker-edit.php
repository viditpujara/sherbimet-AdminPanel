<?php
include 'class/at-class.php';
include 'class/session-check.php';
$page_title = "Worker";
$list_link = "worker-list.php";
$add_link = "worker-add.php";
$table = "tbl_worker";
$primary_key = "worker_id";

$editid = $_GET['eid'];


if (isset($_POST['update'])) {

    $id = mysqli_real_escape_string($conn, $_POST['worker_id']);

    
    $worker_mobile = mysqli_real_escape_string($conn, $_POST['worker_mobile']);
    
     $query_check = mysqli_query($conn, "select lower(worker_mobile) from $table where worker_mobile=lower('{$worker_mobile}') and NOT $primary_key = '{$id}'") or die(mysqli_error($conn));

  $count = mysqli_num_rows($query_check);
  
  if($count>0)
  {
         echo "<script>alert('Mobile No Already Exist');window.location='$list_link';</script>";
  }
    else{
      $worker_first_name = mysqli_real_escape_string($conn, $_POST['worker_first_name']);
      $worker_middle_name = mysqli_real_escape_string($conn, $_POST['worker_middle_name']);
      $worker_last_name = mysqli_real_escape_string($conn, $_POST['worker_last_name']);
    
             $worker_name = $worker_first_name." ".$worker_middle_name." ".$worker_last_name;
    
             $worker_address_line_1 = mysqli_real_escape_string($conn, $_POST['worker_address_line_1']);
             $worker_address_line_2 = mysqli_real_escape_string($conn, $_POST['worker_address_line_2']);

       
             $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);
           $pincode_id = mysqli_real_escape_string($conn, $_POST['pincode_id']);
           $language_id = mysqli_real_escape_string($conn, $_POST['language_id']);

           $query_city = mysqli_query($conn,"SELECT * FROM `tbl_city` WHERE `city_id`='{$city_id}'")or die(mysqli_error($conn));
           $row_city = mysqli_fetch_array($query_city);
                      $city_name = $row_city["city_name"];
    
                      $query_pincode = mysqli_query($conn,"SELECT * FROM `tbl_pincode` WHERE `pincode_id`='{$pincode_id}'")or die(mysqli_error($conn));
                      $row_pincode = mysqli_fetch_array($query_pincode);
                                 $pincode = $row_pincode["pincode"];
    
                                 $package_id = mysqli_real_escape_string($conn, $_POST['package_id']);


                                 $query_11 = mysqli_query($conn,"SELECT * FROM `tbl_package` WHERE `package_id`='{$package_id}'")or die(mysqli_error($conn));
                                 $row_11 = mysqli_fetch_array($query_11);
    
                                 $query_2 = mysqli_query($conn,"SELECT * FROM `tbl_subservice` WHERE `subservice_id`='{$row_11["subservice_id"]}'")or die(mysqli_error($conn));
                                 $row_2 = mysqli_fetch_array($query_2);
    
                                 $service_id = $row_2["service_id"];
    
                                 $query_3 = mysqli_query($conn,"SELECT * FROM `tbl_service` WHERE `service_id`='{$service_id}'")or die(mysqli_error($conn));
                                 $row_3 = mysqli_fetch_array($query_3);
    
                                            $area_id = $row_3["area_id"];
    
                                 $query_area = mysqli_query($conn,"SELECT * FROM `tbl_area` WHERE `area_id`='{$area_id}'")or die(mysqli_error($conn));
                                 $row_area = mysqli_fetch_array($query_area);
                                            $area_name = $row_area["area_name"];
    
                                            $worker_address = $worker_address_line_1." ".$worker_address_line_2." ".$city_name." ".$area_name." ".$pincode;
    
                                            $aadharcard_no = mysqli_real_escape_string($conn, $_POST['aadharcard_no']);
                                            $worker_dob = mysqli_real_escape_string($conn, $_POST['worker_dob']);


                                            $worker_email = mysqli_real_escape_string($conn, $_POST['worker_email']);
      $worker_gender = mysqli_real_escape_string($conn, $_POST['worker_gender']);
    
       $worker_password = mysqli_real_escape_string($conn, $_POST['worker_password']);
      
         $worker_experience = mysqli_real_escape_string($conn, $_POST['worker_experience']);
       $worker_price ="0";
             //product image name
      $cphoto = $_FILES['worker_image']['name'];
   $path = 'images/worker/';
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
      if(file_exists('images/worker/'.$cust_photo))
              
                                      {
          if($cust_photo == "noimage.png")
          {
              
          }else{
          
                                          unlink('images/worker/'.$cust_photo);
          }
                                      }
     }                               
                                 $cimg =$cimg;
     
       move_uploaded_file($_FILES['worker_image']['tmp_name'], $destination);
       }
        
    
    
    $queryupdate = mysqli_query($conn, "update $table set worker_name='{$worker_name}',worker_gender='{$worker_gender}',worker_email='{$worker_email}',worker_mobile='{$worker_mobile}',worker_password='{$worker_password}',worker_address='{$worker_address}',package_id='{$package_id}',worker_image='{$cimg}',worker_experience='{$worker_experience}',worker_price='{$worker_price}',update_datetime='{$datetime}',`worker_first_name`='{$worker_first_name}',`worker_middle_name`='{$worker_middle_name}',`worker_last_name`='{$worker_last_name}',`worker_address_line_1`='{$worker_address_line_1}',`worker_address_line_2`='{$worker_address_line_2}',`city_id`='{$city_id}',`pincode_id`='{$pincode_id}',`language_id`='{$language_id}',`aadharcard_no`='{$aadharcard_no}',`worker_dob`='{$worker_dob}' where $primary_key='{$id}'") or die(mysqli_error($conn));



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
                <form role="form" id="user-edit" method="post" action="#" enctype="multipart/form-data">
              <!-- /.card-header -->
              <div class="card-body">
               <div class="row">
                       <input type="hidden" class="form-control" name="worker_id"  value="<?php echo $row_list['worker_id']; ?>"  required>
                       <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text"  name="worker_first_name" value="<?php echo $row_list['worker_first_name']; ?>" onkeyup ="Validatestring(this)"  class="form-control" placeholder="Enter First Name" required="">
                      </div>
                    </div>
                      
                      
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text"  name="worker_middle_name" value="<?php echo $row_list['worker_middle_name']; ?>" onkeyup ="Validatestring(this)"  class="form-control" placeholder="Enter Middle Name" required="">
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text"  name="worker_last_name" value="<?php echo $row_list['worker_last_name']; ?>" onkeyup ="Validatestring(this)"  class="form-control" placeholder="Enter Last Name" required="">
                      </div>
                    </div>
                      
                       <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Gender</label>
                        <select  name="worker_gender"  class="form-control" required="">
                            <option value="<?php echo $row_list['worker_gender']; ?>"><?php echo $row_list['worker_gender']; ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          
                        </select>
                      </div>
                    </div>
                      
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="worker_email" value="<?php echo $row_list['worker_email']; ?>" class="form-control" placeholder="Enter Email" required="">
                      </div>
                    </div>
                      
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" maxlength="10"  name="worker_mobile" value="<?php echo $row_list['worker_mobile']; ?>" onkeyup ="Validate(this)"  class="form-control" placeholder="Enter Mobile" required="">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Date Of Birth</label>
                        <input type="date" name="worker_dob"  class="form-control" value="<?php echo $row_list['worker_dob']; ?>" required="">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Aadharcard No</label>
                        <input type="text" name="aadharcard_no"  class="form-control"  value="<?php echo $row_list['aadharcard_no']; ?>" placeholder="Enter Aadharcard No" required="">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address Line 1</label>
                        <textarea  name="worker_address_line_1"  class="form-control" placeholder="Enter Address Line 1"><?php echo $row_list['worker_address_line_1']; ?></textarea>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address Line 2</label>
                        <textarea  name="worker_address_line_2"  class="form-control" placeholder="Enter Address Line 2"><?php echo $row_list['worker_address_line_2']; ?></textarea>
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

                              if($row_city['city_id'] == $row_list['city_id'])
                              {
                                  $selected_1  = "selected";
                              }
                              else{
                                  $selected_1 ="";
                              }
                            ?>
                            <option value="<?php echo $row_city["city_id"];?>" <?php echo $selected_1;?>><?php echo $row_city["city_name"];?></option>
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
                              if($row_pincode['pincode_id'] == $row_list['pincode_id'])
                              {
                                  $selected_2  = "selected";
                              }
                              else{
                                  $selected_2 ="";
                              }
                            ?>
                            <option value="<?php echo $row_pincode["pincode_id"];?>" <?php echo $selected_2;?>><?php echo $row_pincode["pincode"];?></option>
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
                              if($row_language['language_id'] == $row_list['language_id'])
                              {
                                  $selected_3  = "selected";
                              }
                              else{
                                  $selected_3 ="";
                              }
                            ?>
                            <option value="<?php echo $row_language["language_id"];?>" <?php echo $selected_3;?>><?php echo $row_language["language_name"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
                   
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Package</label>
                        <select  name="package_id" id="package_id"  class="form-control action" required="">
                            <option value="">-Select-</option>
                            <?php $query_1 = mysqli_query($conn,"select * from tbl_package  order by package_name asc")or die(mysqli_error($conn));
                            while($row_1= mysqli_fetch_array($query_1)){
                              if($row_1['package_id'] == $row_list['package_id'])
                              {
                                  $selected  = "selected";
                              }
                              else{
                                  $selected ="";
                              }
                            ?>
                            <option value="<?php echo $row_1["package_id"];?>" <?php echo $selected;?>><?php echo $row_1["package_name"];?></option>
                            <?php }?>
                        </select>
                      </div>
                    </div>


                    
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="worker_password" value="<?php echo $row_list['worker_password']; ?>"  class="form-control" placeholder="Enter Password" required="">
                      </div>
                    </div>
                   

                  </div>
                  
     
                        <div class="row">
                    
                      
                     
                      
                      
                            
                      
                      
                            
                            
                        <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="worker_image"  class="form-control"  accept="image/*">
          
          
                        <input type="hidden" name="cust_photo" value="<?php echo $row_list['worker_image'];?>">
                      </div>
                    </div>
                      
                             <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        
             <a href="images/worker/<?php echo $row_list['worker_image'];?>" target="_blank"><img src="images/worker/<?php echo $row_list['worker_image']; ?>" style="width: 100px;height: 100px;"></a>
                   
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
<?php include 'themepart/footer-script.php';?>
<script>
              $(document).ready(function () {

                // validate signup form on keyup and submit
                $("#user-edit").validate({
                    rules: {
                        
                      worker_first_name: {
                            required: true,
                            

                        },
                        worker_middle_name: {
                            required: true,
                            

                        },
                        worker_last_name: {
                            required: true,
                            

                        },
                         worker_gender: {
                            required: true
                       
                        },
                        worker_email: {
                            required: true,
                            email:true

                        },
                         worker_mobile: {
                            required: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        
                         worker_password: {
                            required: true,
                             minlength: 6

                        },
                      
                        
                        worker_experience: {
                            required: true
                       
                        },
                        // worker_price: {
                        //     required: true
                       
                        // },
                        worker_address_line_1: {
                            required: true
                       
                        },
                        worker_address_line_2: {
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
                        worker_dob: {
                            required: true
                       
                        },
                        aadharcard_no: {
                            required: true
                       
                        },
                        package_id:{
                          required: true
                        }
                      
                        
                        
                        
                     

                    },
                    messages: {
                      worker_first_name: {
                            required: "Please Enter First Name"

                        },
                        worker_middle_name: {
                            required: "Please Enter Middle Name"

                        },
                        worker_last_name: {
                            required: "Please Enter Last Name"

                        },
                          worker_gender: {
                            required: "Please Select Gender"

                        },
                           worker_email: {
                            required: "Please Enter Email",
                            email: "Invalid Email address"

                        },
                           worker_mobile: {
                            required: "Please Enter Your Mobile no.",
                            minlength: "Enter Your 10 digit Mobile no. only",
                            maxlength: "Enter Your 10 digit Mobile no. only",
                        },
                         worker_password: {
                            required: "Please Enter Password",
                           minlength: "Your password must be at least 6 characters long"

                        },
                          
                          worker_experience: {
                            required: "Please Enter Experience"

                        },
                        // worker_price: {
                        //     required: "Please Enter Price"

                        // },
                        worker_address_line_1: {
                            required: "Please Enter Address Line 1"

                        },
                        worker_address_line_2: {
                            required: "Please Enter Address Line 2"

                        },
                        worker_dob: {
                            required: "Please Enter Price"

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
                        aadharcard_no: {
                            required: "Please Enter Aadharcard No"

                        },
                        worker_dob: {
                            required: "Please Select Date Of Birth"

                        },
                        package_id:{
                          required: "Please Select Package"
                        }
                       
                        
                        

                    }
                });

            });
            </script>
   <script>
$(document).ready(function(){
 $('.action').change(function(){

   
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   
   var query = $(this).val();
   var result = '';
   if(action == "category_id")
   {
    result = 'area';
   }
   
   $.ajax({
    url:"ajax/fetch.php",
    method:"POST",
    data:{action:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
   })
  }
 });
});
</script>
</body>
</html>
