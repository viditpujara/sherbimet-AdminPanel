<?php
session_start();

session_destroy();

   //echo "<script>window.location='../index.php?success=1&msg=You have Successfully Logged Out';</script>";
 //  echo "<script>window.location='../index.php;alert('You have Successfully Logged In');</script>";
   echo "<script>alert('You have Successfully Logout');
                         window.location='index.php';
           </script>";
?>
