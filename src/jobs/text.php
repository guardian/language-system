<?php
include('jobs.php');

$name = 'SRT to text';
$type = 'Conversion';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];

$new_job = register_job($name,$type,$user,$input1,$input2);

//Start of job code

update_job($new_job,'Running');

include 'database.php';

mkdir(getenv('LANGUAGE_TEXT').'/'.$input1);
chmod(getenv('LANGUAGE_TEXT').'/'.$input1, 0777);

$lines_count = 0;
$fhc = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2,'r');

while ($linec = fgets($fhc)) {
        $lines_count++;
}

fclose($fhc);

$fh = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2,'r');

$data_to_write ='';

$lines = file(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2);//file in to an array

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
		} else {
			$data_to_write .= $line;
  	}
	}
}
fclose($fh);

$myfile = file_put_contents(getenv('LANGUAGE_TEXT').'/'.$input1.'/'.$new_job.'.txt', $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

$output = getenv('LANGUAGE_TEXT').'/'.$input1.'/'.$new_job.'.txt';

//End of job code

finish_job($new_job,'Succeeded',$output);
?>
