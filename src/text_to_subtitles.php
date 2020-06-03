<html>
	<head>
		<title>
			Language System
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

<?php
include('database.php');
include('session.php');

$result = mysqli_query($database, "SELECT id, filename, extension, type FROM files where id = '".$_GET['id']."'");
$media = mysqli_fetch_array($result);

exec("php jobs/text_to_subtitles.php ".$login_session." ".$_GET['id']." ".$media[1]." >&- <&- >/dev/null &");

header("Location: job_info_get.php?id=".$_GET['id']."&type=t");
exit;
?>
		</font>
	</body>
</html>
