<?php
include('jobs.php');

$name = 'FFMPEG';
$type = 'Subtitle Rendering';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];
$input3 = $argv[4];

$new_job = register_job($name,$type,$user,$input1,$input2,$input3);

//Start of job code

update_job($new_job,'Running');

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1)) {
	mkdir(getenv('LANGUAGE_RENDERS').'/'.$input1);
}

chmod(getenv('LANGUAGE_RENDERS').'/'.$input1, 0777);

$render_number = 0;
$number_found = 0;

if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$input2)) {

	exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$input2.' -vf subtitles='.getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input3.' '.getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$input2, $exec_output, $result);

	$output = getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$input2;

} else {
	while ($number_found == 0) {
		$render_number++;
		if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$input2)) {
			$number_found = 1;
		}
	}
	exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$input2.' -vf subtitles='.getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/'.$input3.' '.getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$input2, $exec_output, $result);

	$output = getenv('LANGUAGE_RENDERS').'/'.$input1.'/'.$render_number.'_'.$input2;
}

//End of job code

if ($result == 0) {
	finish_job($new_job,'Succeeded',$output);
} else {
	finish_job($new_job,'Failed');
}
?>
