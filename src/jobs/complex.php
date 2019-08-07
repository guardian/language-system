
<?php
include('jobs.php');

$name = 'Complex';
$type = 'Complex';
$user = $argv[1];
$input1 = $argv[2];
$input2 = $argv[3];
$input3 = $argv[4];

$new_job = register_job($name,$type,$user,$input1,$input2,$input3);

//Start of job code

update_job($new_job,'Running');
sleep(2);
include 'database.php';

$result = mysqli_query($database, "SELECT * FROM complex WHERE name = '".$input2."' ORDER BY step");

$first_step = 1;
$step_place = 1;

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {

  $set_place = 1;

  $i1 = '';
  $i2 = '';
  $i3 = '';
  $i4 = '';
  $i5 = '';
  $i6 = '';
  $i7 = '';
  $i8 = '';

  while ($set_place < 9) {
    if ($first_step != 1) {
      if ($row[(3+$set_place)] != '') {

        $job_has_run = 0;

        while ($job_has_run == 0) {
          sleep(5);
          $result6 = mysqli_query($database, "SELECT * FROM jobs where input1 = '".$input1."' and user = '".$user."' ORDER BY id DESC limit 1");
          $job2 = mysqli_fetch_array($result6);
          ${"step_id" . ($step_place-1)} = $job2[0];
          $job_id = $job2[0];
          if ($row[12] != '') {
            $job_id = ${"step_id" . $row[12]};
          }
          $result5 = mysqli_query($database, "SELECT * FROM jobs where id = '".$job_id."' ORDER BY id DESC limit 1");
          $job = mysqli_fetch_array($result5);
          if (($job[6] == 'Succeeded') || ($job[6] == 'Failed')) {
          	$job_has_run = 1;
          }

        }
        ${"i" . $set_place} = $job[(14+$row[(3+$set_place)])];
      }
    }
    if ($row[(12+$set_place)] != '') {
      if ($row[(12+$set_place)] == '#file#') {
        $result8 = mysqli_query($database, "SELECT id, filename FROM files where id = '".$input1."'");
        $media = mysqli_fetch_array($result8);
        ${"i" . $set_place} = $media[1];
      } elseif ($row[(12+$set_place)] == '#subtitles#') {
        ${"i" . $set_place} = $input3;
      } else {
        ${"i" . $set_place} = $row[(12+$set_place)];
      }
    }

    $set_place++;
  }

  if ($first_step == 1) {
    $first_step = 0;
  }

  exec("php jobs/".$row[3]." ".$user." ".$input1." ".$i2." ".$i3." ".$i4." ".$i5." ".$i6." ".$i7." ".$i8." >&- <&- >/dev/null &");
  $step_place++;
}

//End of job code

finish_job($new_job,'Succeeded');

?>
