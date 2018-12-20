<?php
include('jobs.php');

$name = 'eSpeak';
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

$fh = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2,'r');
$data_to_write = '<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.w3.org/2001/10/synthesis http://www.w3.org/TR/speech-synthesis/synthesis.xsd" xml:lang="'.$input3.'">';

$lines = file(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2);//file in to an array
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
$myfile = file_put_contents(getenv('LANGUAGE_WORKING').'/'.$input2.'.ssml', $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1)) {
	mkdir(getenv('LANGUAGE_RENDERS').'/'.$input1);
}

chmod(getenv('LANGUAGE_RENDERS').'/'.$input1, 0777);

$render_number = 0;
$number_found = 0;

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$media[1].'.wav')) {

	exec('espeak -m -f '.getenv('LANGUAGE_WORKING').'/'.$input2.'.ssml -w '.getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$media[1].'.wav', $exec_output, $result);

	$output = getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$media[1].'.wav';
} else {
	while ($number_found == 0) {
		$render_number++;
		if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$media[1].'.wav')) {
			$number_found = 1;
		}
	}
	exec('espeak -m -f '.getenv('LANGUAGE_WORKING').'/'.$input2.'.ssml -w '.getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$media[1].'.wav', $exec_output, $result);
	
	$output = getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$media[1].'.wav';
}

unlink(getenv('LANGUAGE_WORKING').'/'.$input2.'.ssml');

//End of job code

if ($result == 0) {
	finish_job($new_job,'Succeeded',$output);
} else {
	finish_job($new_job,'Failed');
} 

?>