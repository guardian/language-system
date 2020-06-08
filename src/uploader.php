<?php
include 'database.php';
include('session.php');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

function getDuration($filePath)
{
    exec(getenv('LANGUAGE_FFMPEG').' -i'." '$filePath' 2>&1 | grep Duration | awk '{print $2}' | tr -d ,",$O,$S);
    if(!empty($O[0]))
    {
        return $O[0];
    }else
    {
        return false;
    }
}


/*
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	exit; // finish preflight CORS requests here
}
*/

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$targetDir = getenv('LANGUAGE_UPLOADS');
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
	@mkdir($targetDir);
}

// Get a file name
if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files
if ($cleanupTargetDir) {
	if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	}

	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// If temp file is current file proceed to the next
		if ($tmpfilePath == "{$filePath}.part") {
			continue;
		}

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
	if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
	}

	// Read binary input stream and append it to temp file
	if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
} else {
	if (!$in = @fopen("php://input", "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
}

while ($buff = fread($in, 4096)) {
	fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off
	rename("{$filePath}.part", $filePath);

	$mediaFileType = pathinfo($filePath,PATHINFO_EXTENSION);

	$mediaType = 'v';
  if ($mediaFileType == "txt" || $mediaFileType == "TXT") {
		$mediaType = 't';
	}
	if ($mediaFileType == "wav" || $mediaFileType == "WAV" || $mediaFileType == "mp3" || $mediaFileType == "MP3" || $mediaFileType == "aiff" || $mediaFileType == "AIFF") {
		$mediaType = 'a';
	}

	$processed_name = str_replace(" ", "_", $fileName);
	$final_name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $processed_name);

  rename($filePath, getenv('LANGUAGE_UPLOADS').'/'.$final_name);

  $duration = '00:00:00.00';
  if ($mediaType != 't') {
	   $duration = getDuration(getenv('LANGUAGE_UPLOADS').'/'.$final_name);
  }

	mysqli_query($database, "INSERT INTO files (filename,extension,type,duration,owner) VALUES ('".$final_name."','".$mediaFileType."','".$mediaType."','".$duration."','".$login_session_user_id."')");
    $lastid = mysqli_insert_id($database);
    mkdir($targetDir.'/'.$lastid);
    rename($targetDir.'/'.$final_name, $targetDir.'/'.$lastid.'/'.$final_name);
    if ($mediaType == 'v') {
        exec(getenv('LANGUAGE_FFMPEG').' -i '.$targetDir.'/'.$lastid.'/'.$final_name.' -ss 00:00:05.000 -vf scale=-1:200 -vframes 1 '.getenv('LANGUAGE_THUMBNAILS').'/'.$lastid.'.png');
    }
    if ($mediaType == 'a') {
      exec('php /opt/justwave/justwave.cli.php '.$targetDir.'/'.$lastid.'/'.$final_name.' width=357 height=200 wave_color=#FFFFFF back_color=#222222');
      $likely_file_name = str_replace($mediaFileType,"png",$final_name);
      $micro_seconds_current = 0;
      while((!file_exists('waves/'.$likely_file_name)) && ($micro_seconds_current < 120000000)) {
        usleep(200000);
        $micro_seconds_current = $micro_seconds_current + 200000;
      }
      rename('waves/'.$likely_file_name, getenv('LANGUAGE_WORKING').'/'.$likely_file_name);
      $im = imagecreatefrompng(getenv('LANGUAGE_WORKING').'/'.$likely_file_name);
      $im2 = imagecrop($im, ['x' => 1, 'y' => 0, 'width' => 356, 'height' => 200]);
      imagepng($im2, getenv('LANGUAGE_THUMBNAILS').'/'.$lastid.'.png');
      imagedestroy($im2);
      imagedestroy($im);
      unlink(getenv('LANGUAGE_WORKING').'/'.$likely_file_name);
    }
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
