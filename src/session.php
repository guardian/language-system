<?php
   include('database.php');
   session_start();

   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($database,"select name, type from users where name = '$user_check' ");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['name'];
   $login_session_user_type = $row['type'];

   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>
