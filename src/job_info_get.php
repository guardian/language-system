<html>
	<head>
		<title>
			Language System - Job Information
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

<?php
include('database.php');
include('session.php');
sleep(1);
$result = mysqli_query($database, "SELECT * FROM jobs where input1 = '".$_GET['id']."' and user = '".$login_session."' ORDER BY id DESC limit 1");
$job = mysqli_fetch_array($result);

if ($_GET['type'] == 't') {
	header("Location: job_info.php?id=".$job[0]."&type=t");
} else {
	header("Location: job_info.php?id=".$job[0]);
}
exit;
?>
		</font>
	</body>
</html>
