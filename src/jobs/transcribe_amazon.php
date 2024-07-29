<?php
include('jobs.php');

$name = 'Amazon Transcribe';
$type = 'Subtitle Transcription';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];

$new_job = register_job($name,$type,$user,$input1,$input2);

//Start of job code

function formatTime($time) {
  $a = explode(".", $time);
  $date = new DateTime('1970-01-01');
  $date->add(new DateInterval('PT'.$a[0].'S'));
  return $date->format('H:i:s').','.$a[1];
}

update_job($new_job,'Running');

require __DIR__ . '/../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$sharedConfig = [
    'profile' => 'default',
    'region' => getenv('LANGUAGE_AWS_REGION'),
//		'debug'   => true,
    'version' => 'latest'
];

$sdk = new Aws\Sdk($sharedConfig);

$s3Client = $sdk->createS3();

include 'database.php';
$result = mysqli_query($database, "SELECT id, filename, duration FROM files where id = '".$input1."'");
$media = mysqli_fetch_array($result);

$result2 = mysqli_query($database, "SELECT number FROM settings where name = 'amazon_transcribe_quota'");
$amazon_transcribe_quota = mysqli_fetch_array($result2);
$result3 = mysqli_query($database, "SELECT number FROM settings where name = 'amazon_transcribe_usage'");
$amazon_transcribe_usage = mysqli_fetch_array($result3);

if ($amazon_transcribe_quota[0] > ($amazon_transcribe_usage[0] + (substr($media[2], 0, 2) * 3600) + (substr($media[2], 3, 2) * 60) + substr($media[2], 6, 2))) {
  exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$input1.'/'.$media[1].' -vn -sn -c:a mp3 -ab 192k '.getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');

  mkdir(getenv('LANGUAGE_SUBTITLES').'/'.$input1);
  chmod(getenv('LANGUAGE_SUBTITLES').'/'.$input1, 0777);

  $result = $s3Client->putObject([
      'Bucket' => getenv('LANGUAGE_AWS_BUCKET'),
      'Key' => $media[1].'.mp3',
  		'Body'   => fopen(getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3', 'r'),
  		'ACL'    => 'public-read'
  ]);

  $client = new Aws\TranscribeService\TranscribeServiceClient([
  'region'  => getenv('LANGUAGE_AWS_REGION'),
  'version' => '2017-10-26'
  ]);

  $result = $client->startTranscriptionJob([
      'LanguageCode' => $input2,
      'Media' => [
          'MediaFileUri' => 'https://'.getenv('LANGUAGE_AWS_BUCKET').'.s3-'.getenv('LANGUAGE_AWS_REGION').'.amazonaws.com/'.$media[1].'.mp3',
      ],
      'MediaFormat' => 'mp3',
      'OutputBucketName' => getenv('LANGUAGE_AWS_BUCKET'),
      'TranscriptionJobName' => $media[1].'_'.$new_job,
  ]);

  $result2 = mysqli_query($database, "SELECT number FROM settings where name = 'amazon_transcribe_usage'");
  $amazon_transcribe_usage = mysqli_fetch_array($result2);

  $number_to_set = $amazon_transcribe_usage[0] + (substr($media[2], 0, 2) * 3600) + (substr($media[2], 3, 2) * 60) + substr($media[2], 6, 2);

  mysqli_query($database, "UPDATE settings SET number='".$number_to_set."' WHERE name = 'amazon_transcribe_usage'");

  $number_of_loops = 0;
  $job_status = 'running';

  while ($number_of_loops < 1000) {
    $number_of_loops++;
    $result2 = $client->getTranscriptionJob([
        'TranscriptionJobName' => $media[1].'_'.$new_job,
    ]);
    if ($result2['TranscriptionJob']['TranscriptionJobStatus'] == 'COMPLETED') {
      $job_status = 'completed';
      break;
    }
    if ($result2['TranscriptionJob']['TranscriptionJobStatus'] == 'FAILED') {
      $job_status = 'failed';
      break;
    }
    sleep(10);
  }

  unlink(getenv('LANGUAGE_WORKING').'/'.$media[1].'.mp3');

  if ($job_status == 'completed') {
    mkdir(getenv('LANGUAGE_JSON').'/'.$input1);
    chmod(getenv('LANGUAGE_JSON').'/'.$input1, 0777);

    $result3 = $s3Client->getObject([
        'Bucket' => 'language-system-test-media',
        'Key' => $media[1].'_'.$new_job.'.json',
    		'SaveAs' => getenv('LANGUAGE_JSON').'/'.$input1.'/'.$media[1].'.json'
    ]);

    sleep(30);

    $json_file = getenv('LANGUAGE_JSON').'/'.$input1.'/'.$media[1].'.json';
    $aws_json_data = json_decode(file_get_contents($json_file));

    $srt = "";
    $start_time = "";
    $end_time = "";
    $sentence = "";
    $n = 1;
    $t = 1;
    $wtb = 10;
    $c = count($aws_json_data->results->items);

    for ($i = 0; $i < $c; $i++) {
      if ($aws_json_data->results->items[$i]->type == "pronunciation") {
        if ($start_time == "") $start_time = $aws_json_data->results->items[$i]->start_time;
        $end_time = $aws_json_data->results->items[$i]->end_time;
        $sentence .= $aws_json_data->results->items[$i]->alternatives[0]->content." ";
        $t++;
      } elseif ($aws_json_data->results->items[$i]->type == "punctuation" && $aws_json_data->results->items[$i]->alternatives[0]->content == ".") {
        if ($sentence != '') {
          $srt .= $n."\n";
          $srt .= formatTime($start_time)." --> ".formatTime($end_time)."\n".$sentence."\n\n";
          $sentence = "";
          $start_time = "";
          $n++;
          $t = 1;
        }
      }
      if ($t > $wtb) {
        $srt .= $n."\n";
        $srt .= formatTime($start_time)." --> ".formatTime($end_time)."\n".$sentence."\n\n";
        $sentence = "";
        $start_time = "";
        $n++;
        $t = 1;
      }
    }

    $output = getenv('LANGUAGE_JSON').'/'.$input1.'/'.$media[1].'.json';
    $output2 = getenv('LANGUAGE_SUBTITLES').'/'.$input1.'/amazon_'.$media[1].'.srt';

    file_put_contents($output2, $srt);

    finish_job($new_job,'Succeeded',$output,$output2);
  } else {
    finish_job($new_job,'Failed');
  }
} else {
  finish_job($new_job,'Failed');
}
?>
