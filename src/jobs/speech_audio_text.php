<?php
include('jobs.php');

$name = 'eSpeak for Text';
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

$fh = fopen(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$media[1],'r');
$data_to_write = '<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.w3.org/2001/10/synthesis http://www.w3.org/TR/speech-synthesis/synthesis.xsd" xml:lang="'.$input3.'">';

$lines = file(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$media[1]);//file in to an array
#echo $lines[1]; //line 2
$first_run = 1;

$line_counter = 0;
while ($line = fgets($fh)) {
  $data_to_write .= $line;
}
fclose($fh);

$data_to_write .= '</speak>';
$myfile = file_put_contents(getenv('LANGUAGE_WORKING').'/'.$media[1].'.ssml', $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1)) {
	mkdir(getenv('LANGUAGE_RENDERS').'/'.$input1);
}

chmod(getenv('LANGUAGE_RENDERS').'/'.$input1, 0777);

$render_number = 0;
$number_found = 0;

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$media[1].'.wav')) {

	exec('espeak -m -f '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.ssml -w '.getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$media[1].'.wav', $exec_output, $result);

	$output = getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$media[1].'.wav';
} else {
	while ($number_found == 0) {
		$render_number++;
		if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$media[1].'.wav')) {
			$number_found = 1;
		}
	}
	exec('espeak -m -f '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.ssml -w '.getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$media[1].'.wav', $exec_output, $result);

	$output = getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$media[1].'.wav';
}

unlink(getenv('LANGUAGE_WORKING').'/'.$media[1].'.ssml');

//End of job code

if ($result == 0) {
	finish_job($new_job,'Succeeded',$output);
} else {
	finish_job($new_job,'Failed');
}

?>
