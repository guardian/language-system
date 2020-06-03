<?php
include('jobs.php');

$name = 'Text to SRT';
$type = 'Conversion';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];

$new_job = register_job($name,$type,$user,$input1,$input2);

//Start of job code

update_job($new_job,'Running');

include 'database.php';

mkdir(getenv('LANGUAGE_SUBTITLES').'/'.$input1);
chmod(getenv('LANGUAGE_SUBTITLES').'/'.$input1, 0777);

$lines_count = 0;
$fhc = fopen(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$input2,'r');

while ($linec = fgets($fhc)) {
        $lines_count++;
}

fclose($fhc);

$fh = fopen(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$input2,'r');

$data_to_write ='';

$lines = file(getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$input2);//file in to an array

$first_run = 1;
$line_counter = 0;
$count_lines = 0;
$subtitles = 0;
$time_seconds = 0;
while ($line = fgets($fh)) {
  $count_lines++;
  if ($count_lines >= $lines_count) {
  	//break;
  }
  $line_counter++;

  if(!empty(trim($line))) {
    $subtitles++;
    $split_line = str_split($line, 128);
    foreach($split_line as &$line_part) {
      $data_to_write .= $subtitles."\n";
      $hours = sprintf('%02d', floor($time_seconds / 3600));
      $minutes = sprintf('%02d', floor(($time_seconds / 60) % 60));
      $seconds = sprintf('%02d', $time_seconds % 60);
      $data_to_write .= $hours.":".$minutes.":".$seconds.",000 --> ";
      $time_seconds = $time_seconds + 8;
      $hours = sprintf('%02d', floor($time_seconds / 3600));
      $minutes = sprintf('%02d', floor(($time_seconds / 60) % 60));
      $seconds = sprintf('%02d', $time_seconds % 60);
      $data_to_write .= $hours.":".$minutes.":".$seconds.",000\n";
      $time_seconds = $time_seconds + 2;
		  $data_to_write .= $line_part;
      $data_to_write .= "\n";
    }
  }
}
fclose($fh);

$myfile = file_put_contents(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$new_job.'.srt', $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

$output = getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$new_job.'.srt';

//End of job code

finish_job($new_job,'Succeeded',$output);
?>
