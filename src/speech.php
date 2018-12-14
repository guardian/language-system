<html>
	<head>
		<title>
			Language System
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

<?php
include('session.php');
include('jobs.php');

if (isset($_POST['video'])) {
	start_job('speech_video.php',$login_session,$_GET['id'],$_POST['subtitles'],$_POST['language']);
} else {
	start_job('speech_audio.php',$login_session,$_GET['id'],$_POST['subtitles'],$_POST['language']);
}

header("Location: media.php?id=".$_GET['id']);
exit;
?>
		</font>
	</body>
</html>