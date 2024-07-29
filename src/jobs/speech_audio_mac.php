<?php
include('jobs.php');

$name = 'Mac OS';
$type = 'Speech Rendering to Audio';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];
$input3 = $argv[4];

$new_job = register_job($name,$type,$user,$input1,$input2,$input3);

//Start of job code

update_job($new_job,'Running');

include 'database.php';
$result = mysqli_query($database, "SELECT id, filename FROM files where id = '".$input1."'");
$media = mysqli_fetch_array($result);

$lines_count = 0;
$fhc = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2,'r');

while ($linec = fgets($fhc)) {
        $lines_count++;
}

fclose($fhc);

$fh = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2,'r');

$data_to_write ='';

$lines = file(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2);//file in to an array
#echo $lines[1]; //line 2
$first_run = 1;
$line_counter = 0;
$count_lines = 0;
while ($line = fgets($fh)) {
  $count_lines++;
  if ($count_lines >= $lines_count) {
          break;
  }
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
			$data_to_write .= '[[slnc '.$time_one.']]';
		} else {
			$data_to_write .= '[[slnc '.($time_one - $time_two).']]';
		}

		$time_two = intval(substr($line, 17, 2)) * 3600000;
		$time_two = (intval(substr($line, 20, 2)) * 60000) + $time_two;
		$time_two = (intval(substr($line, 23, 2)) * 1000) + $time_two;
		$time_two = intval(substr($line, 26, 3)) + $time_two;

	}

}
fclose($fh);

$myvoicefile = file_put_contents(getenv('LANGUAGE_WORKING').'/speech_settings/voice.txt', $input3);
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
