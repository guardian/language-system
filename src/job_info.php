<html>
	<head>
		<title>
			Language System - Job Information
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="refresh" content="4">
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

<?php
include('database.php');

$result = mysqli_query($database, "SELECT * FROM jobs where id = '".$_GET['id']."' ORDER BY id DESC limit 1");
$job = mysqli_fetch_array($result);
echo 'Job Details<br /><br />';
echo 'Id: '.$job[0].'<br />';
echo 'Name: '.$job[1].'<br />';
echo 'Type: '.$job[2].'<br />';
echo 'User: '.$job[3].'<br />';
echo 'Start Time: '.date('G:i:s j/n/Y', $job[4]).'<br />';
echo 'Status: '.$job[6].'<br />';
if ($job[7] != '') {
	echo 'Input 1: '.$job[7].'<br />';
}
if ($job[8] != '') {
	echo 'Input 2: '.$job[8].'<br />';
}
if ($job[9] != '') {
	echo 'Input 3: '.$job[9].'<br />';
}
if ($job[10] != '') {
	echo 'Input 4: '.$job[10].'<br />';
}
if ($job[11] != '') {
	echo 'Input 5: '.$job[11].'<br />';
}
if ($job[12] != '') {
	echo 'Input 6: '.$job[12].'<br />';
}
if ($job[13] != '') {
	echo 'Input 7: '.$job[13].'<br />';
}
if ($job[14] != '') {
	echo 'Input 8: '.$job[14].'<br />';
}

if (($job[6] == 'Succeeded') || ($job[6] == 'Failed')) {
	if ($_GET['type'] == 't') {
		header("Location: text_file.php?id=".$job[7]);
	} else {
		header("Location: media.php?id=".$job[7]);
	}
	exit;
}
?>
		</font>
	</body>
</html>
