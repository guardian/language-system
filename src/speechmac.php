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
include('session.php');

if (isset($_POST['video'])) {
	exec("php jobs/speech_video_mac.php ".$login_session." ".$_GET['id']." ".$_POST['subtitles']." ".$_POST['voice']." >&- <&- >/dev/null &");
} else {
	exec("php jobs/speech_audio_mac.php ".$login_session." ".$_GET['id']." ".$_POST['subtitles']." ".$_POST['voice']." >&- <&- >/dev/null &");
}

header("Location: job_info_get.php?id=".$_GET['id']);
exit;
?>
		</font>
	</body>
</html>
