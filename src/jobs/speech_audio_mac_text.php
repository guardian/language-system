<?php
include('jobs.php');

$name = 'macOS for Text';
$type = 'Speech Rendering to Audio';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];

$new_job = register_job($name,$type,$user,$input1,$input2);

//Start of job code

update_job($new_job,'Running');

include 'database.php';
$result = mysqli_query($database, "SELECT id, filename FROM files where id = '".$input1."'");
$media = mysqli_fetch_array($result);

$lines_count = 0;
$fhc = fopen(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$media[1],'r');

while ($linec = fgets($fhc)) {
        $lines_count++;
}

fclose($fhc);

$fh = fopen(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$media[1],'r');

$data_to_write ='';

$lines = file(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$media[1]);//file in to an array

$first_run = 1;
$line_counter = 0;
$count_lines = 0;
while ($line = fgets($fh)) {
  $line_counter++;
	$data_to_write .= $line;
}
fclose($fh);

$myvoicefile = file_put_contents(getenv('LANGUAGE_WORKING').'/speech_settings/voice.txt', $input2);
sleep(1);
$myfile = file_put_contents(getenv('LANGUAGE_WORKING').'/speech_in/'.$new_job.'.txt', $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

$seconds_to_wait = $line_counter * 6000000;

usleep($seconds_to_wait);

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1)) {
	mkdir(getenv('LANGUAGE_RENDERS').'/'.$input1);
}

chmod(getenv('LANGUAGE_RENDERS').'/'.$input1, 0777);

copy(getenv('LANGUAGE_WORKING').'/speech_out/'.$new_job.'.txt.aiff',getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$new_job.'.aiff');


unlink(getenv('LANGUAGE_WORKING').'/speech_in/'.$new_job.'.txt');

unlink(getenv('LANGUAGE_WORKING').'/speech_settings/voice.txt');

unlink(getenv('LANGUAGE_WORKING').'/speech_out/'.$new_job.'.txt.aiff');

$output = getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$new_job.'.aiff';

//End of job code
finish_job($new_job,'Succeeded',$output);
?>
