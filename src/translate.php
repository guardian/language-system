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

require __DIR__ . '/vendor/autoload.php';


use Stichoza\GoogleTranslate\TranslateClient;


$fh = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$_POST['subtitles'],'r');
$data_to_write = '';

$line_counter = 0;
while ($line = fgets($fh)) {
  	$line_counter++;
	if (($line_counter != 1) && ($line_counter != 2)){
		if(empty(trim($line))) {
			$line_counter = 0;
			$data_to_write .= $line;
		} else {
  			#echo($line);
  			$data_to_write .= TranslateClient::translate($_POST['source'], $_POST['target'], $line);
  			$data_to_write .= "\n";
  			#echo '<br />';
  		}
	} else {
		$data_to_write .= $line;
	}
	
}
fclose($fh);


$myfile = file_put_contents(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$_POST['target'].'_'.$_POST['subtitles'], $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

?>
		</font>
	</body>
</html>