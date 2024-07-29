<?php
include 'database.php';
$target_dir = getenv('LANGUAGE_UPLOADS')."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$mediaFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000000000000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($mediaFileType != "mp4" && $mediaFileType != "mxf" && $mediaFileType != "mov" && $mediaFileType != "mpg" && $mediaFileType != "MP4" && $mediaFileType != "MXF" && $mediaFileType != "MOV" && $mediaFileType != "MPG" && $mediaFileType != "wav" && $mediaFileType != "WAV" && $mediaFileType != "mp3" && $mediaFileType != "MP3" && $mediaFileType != "aiff" && $mediaFileType != "AIFF") {
    echo "Sorry, only MP4, MXF, MOV, MPG, WAV, MP3, and AIFF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	$mediaType = 'v';
	if ($mediaFileType == "wav" || $mediaFileType == "WAV" || $mediaFileType == "mp3" || $mediaFileType == "MP3" || $mediaFileType == "aiff" || $mediaFileType == "AIFF") {
		$mediaType = 'a';
	}

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        $processed_name = str_replace(" ", "_", $_FILES["fileToUpload"]["name"]);
        $final_name = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $processed_name);

        rename(getenv('LANGUAGE_UPLOADS').'/'.$_FILES["fileToUpload"]["name"], getenv('LANGUAGE_UPLOADS').'/'.$final_name);

        mysqli_query($database, "INSERT INTO files (filename,extension,type) VALUES ('".$final_name."','".$mediaFileType."','".$mediaType."')");
        $lastid = mysqli_insert_id();
        if ($mediaType == 'v') {
        	exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$final_name.' -ss 00:00:05.000 -vf scale=-1:200 -vframes 1 '.getenv('LANGUAGE_THUMBNAILS').'/'.$lastid.'.png');
        }
        header("Location: index.php");
   		exit;

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>
