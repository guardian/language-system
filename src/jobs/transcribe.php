<?php
include('jobs.php');

$name = 'Autosub';
$type = 'Subtitle Transcription';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];

$new_job = register_job($name,$type,$user,$input1,$input2);

//Start of job code

update_job($new_job,'Running');

include 'database.php';
$result = mysqli_query($database, "SELECT id, filename FROM files where id = '".$input1."'");
$media = mysqli_fetch_array($result);

mkdir(getenv('LANGUAGE_SUBTITLES').'/'.$input1);
chmod(getenv('LANGUAGE_SUBTITLES').'/'.$input1, 0777);

exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$media[1].' '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');
exec('/opt/venv/bin/python3 /opt/venv/bin/autosub -F srt -S '.$input2.' -D '.$input2.' -o '.getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$media[1].'.srt  '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3', $exec_output, $exec_result);
$output = getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$media[1].'.srt';
$output2 = $media[1].'.srt';
unlink(getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');

//End of job code

if ($exec_result == 0) {
	finish_job($new_job,'Succeeded',$output,$output2);
} else {
	finish_job($new_job,'Failed');
}

?>
