<?php
include 'class/at-class.php';



if ($_POST) 
{
    $email = mysqli_real_escape_string($conn ,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
  
    
    
  
    
  $query = mysqli_query($conn, "select *from tbl_admin where admin_email='{$email}' and admin_password='{$password}'") or die(mysqli_error($conn));

   $count = mysqli_num_rows($query);
   
   if($count>0)
   {
       $row = mysqli_fetch_array($query);        
       
                                      $email =$row['admin_email'];
                                       $ad_name =$row['admin_name'];
                                        
                                    
                                    $_SESSION["adminemail"] = $email;
                                     $_SESSION["adminname"] = $ad_name;

                                     
                                        echo "<script>alert('You have Successfully Logged In');window.location='dashboard.php';</script>";
                                      
   }
 else {

           echo "<script>alert('Username and Password Wrong');window.location='index.php';</script>";
          ?>
<?php

   }
                                    
}
else{
       header("location:index.php");
}

?>