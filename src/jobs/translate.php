<?php
include('jobs.php');

$name = 'Google Translate PHP';
$type = 'Translation';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];
$input3 = $argv[4];
$input4 = $argv[5];

$new_job = register_job($name,$type,$user,$input1,$input2,$input3,$input4);

//Start of job code

update_job($new_job,'Running');

require __DIR__ . '/../vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

$fh = fopen(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input2,'r');
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
  			$data_to_write .= GoogleTranslate::trans($line, $input4, $input3);
  			$data_to_write .= "\n";
  			#echo '<br />';
  		}
	} else {
		$data_to_write .= $line;
	}

}
fclose($fh);

$myfile = file_put_contents(getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input4.'_'.$input2, $data_to_write.PHP_EOL , FILE_APPEND | LOCK_EX);

$output = getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input4.'_'.$input2;
$output2 = $input4.'_'.$input2;

//End of job code

finish_job($new_job,'Succeeded',$output,$output2);

?>
