<?php
include 'database.php';
$target_dir = getenv('LANGUAGE_UPLOADS')."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

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
if($imageFileType != "mp4" && $imageFileType != "mxf" && $imageFileType != "mov"
&& $imageFileType != "mpg" ) {
    echo "Sorry, only MP4, MXF, MOV & MPG files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        mysql_query("INSERT INTO files (filename) VALUES ('".$_FILES["fileToUpload"]["name"]."')");
        $lastid = mysql_insert_id();
        exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$_FILES["fileToUpload"]["name"].' -ss 00:00:05.000 -vf scale=-1:200 -vframes 1 '.getenv('LANGUAGE_THUMBNAILS').'/'.$lastid.'.png');
        header("Location: index.php");
   		exit;
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>