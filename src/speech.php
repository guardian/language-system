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

$fh = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$_POST['subtitles'],'r');
$data_to_write = '<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.w3.org/2001/10/synthesis http://www.w3.org/TR/speech-synthesis/synthesis.xsd" xml:lang="en-US">';

$lines = file(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$_POST['subtitles']);//file in to an array
#echo $lines[1]; //line 2
$first_run = 1;

$line_counter = 0;
while ($line = fgets($fh)) {
  	$line_counter++;
	if (($line_counter != 1) && ($line_counter != 2)){
		if(empty(trim($line))) {
			$line_counter = 0;
			$data_to_write .= $line;
		} else {
  			#echo($line);
  			$data_to_write .= $line;
  			$data_to_write .= "\n";
  			#echo '<br />';
  		}
	} elseif ($line_counter == 2) {
		$time_one = intval(substr($line, 0, 2)) * 3600000;
		$time_one = (intval(substr($line, 3, 2)) * 60000) + $time_one;
		$time_one = (intval(substr($line, 6, 2)) * 1000) + $time_one;
		$time_one = intval(substr($line, 9, 3)) + $time_one;
		
		if ($first_run == 1) {
			$first_run = 0;
		} else {
			$data_to_write .= '<break time="'.($time_one - $time_two).'ms" />';
		}
		
		$time_two = intval(substr($line, 17, 2)) * 3600000;
		$time_two = (intval(substr($line, 20, 2)) * 60000) + $time_two;
		$time_two = (intval(substr($line, 23, 2)) * 1000) + $time_two;
		$time_two = intval(substr($line, 26, 3)) + $time_two;
		
	}
	
}
fclose($fh);

$data_to_write .= '</speak>';
$myfile = file_put_contents(getenv('LANGUAGE_WORKING').'/'.$_POST['subtitles'].'.ssml', $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

exec('espeak -m -f '.getenv('LANGUAGE_WORKING').'/'.$_POST['subtitles'].'.ssml --stdout | '.getenv('LANGUAGE_FFMPEG').' -i - -ar 44100 -ac 2 -ab 192k -f mp3 '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');


if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'])) {
	mkdir(getenv('LANGUAGE_RENDERS').'/'.$_GET['id']);
}

chmod(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'], 0777);

$render_number = 0;
$number_found = 0;

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$media[1])) {

	exec(getenv('LANGUAGE_FFMPEG').' -y -i '.getenv('LANGUAGE_UPLOADS').'/'.$media[1].' -itsoffset '.substr($lines[1], 0, 2).':'.substr($lines[1], 3, 2).':'.substr($lines[1], 6, 2).' -i '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3 -acodec copy -vcodec copy -map 0:0 -map 1:0 '.getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$media[1]);
	
} else {
	while ($number_found == 0) {
		$render_number++;
		if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$render_number.'_'.$media[1])) {
			$number_found = 1;
		}
	}
	exec(getenv('LANGUAGE_FFMPEG').' -y -i '.getenv('LANGUAGE_UPLOADS').'/'.$media[1].' -itsoffset '.substr($lines[1], 0, 2).':'.substr($lines[1], 3, 2).':'.substr($lines[1], 6, 2).' -i '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3 -acodec copy -vcodec copy -map 0:0 -map 1:0 '.getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$render_number.'_'.$media[1]);
}


header("Location: media.php?id=".$_GET['id']);
exit;
?>
		</font>
	</body>
</html>