<?php
   include("database.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($database,$_POST['username']);
      $mypassword = mysqli_real_escape_string($database,$_POST['password']);

      $sql = "SELECT id FROM users WHERE name = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($database,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);

      if($count == 1) {
         $_SESSION['login_user'] = $myusername;

         header("location: index.php");
      }else {
         $error = "Your user name or password is invalid";
      }
   }
?>
<html>
   <head>
      <title>Language System - Login Page</title>
      <link rel="stylesheet" type="text/css" href="main.css">
   </head>
   <body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">
		  <div align = "center">
			 <div style = "width:300px; border: solid 1px #333333; " align = "left">
				<div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				<div style = "margin:30px">
				   <form action = "" method = "post">
					  <label>User Name  :</label><input type = "text" name = "username" class = "box"/><br /><br />
					  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
					  <input type = "submit" value = " Submit "/><br />
				   </form>
				   <div style = "font-size:11px; color:#ff9999; margin-top:10px"><?php if (isset($error)) { echo $error; } ?></div>
				</div>
			 </div>
		  </div>
      </font>
   </body>
</html>
