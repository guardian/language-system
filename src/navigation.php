<?php
?>
<a href="index.php">Language System</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="designer_menu.php">Complex Job Designer</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="job_list.php">Jobs</a>
<?php
if ($login_session_user_type == 'a') {
  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php">Administration</a>';
}
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
User: <?php echo $login_session; ?>&nbsp;&nbsp;
<a href="logout.php">Log Out</a>
<?php
?>
