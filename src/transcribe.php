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

			include 'database.php';
			$result = mysql_query("SELECT id, filename FROM files where id = '".$_GET['id']."'");
			$media = mysql_fetch_array($result);
			
			mkdir(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id']);
			chmod(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'], 0777);

			exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$media[1].' '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');
			exec('autosub -F srt -S '.$_POST['source'].' -D '.$_POST['source'].' -o '.getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$media[1].'.srt  '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');
			unlink(getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');
			header("Location: media.php?id=".$_GET['id']);
   			exit;
?>
		</font>
	</body>
</html>