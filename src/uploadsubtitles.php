<?php
include 'database.php';
$target_dir = getenv('LANGUAGE_SUBTITLES')."/".$_GET['id']."/";
$final_name = str_replace(" ", "_", basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir . $final_name;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

mkdir(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id']);
chmod(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'], 0777);

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
if($imageFileType != "srt" && $imageFileType != "SRT") {
    echo "Sorry, only SRT files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". $final_name. " has been uploaded.";
		header("Location: media.php?id=".$_GET['id']);
   		exit;
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>