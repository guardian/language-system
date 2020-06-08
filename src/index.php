<html>
	<head>
		<title>
			Language System
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
		<script type="text/javascript" src="vendor/moxiecode/plupload/js/plupload.full.min.js"></script>
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">
			<?php
			include 'database.php';
			include('session.php');
			include('navigation.php');
			?>
			<br />
			<br />
			<br />
			<?php

			$dir    = getenv('LANGUAGE_UPLOADS').'/';
			$files1 = scandir($dir);

			/*
			foreach ($files1 as $file) {

				echo '<br />'. $file;

			}*/

			$page_offset = 0;

			if (isset($_GET['p'])) {
				if (($_GET['p'] != '') && ($_GET['p'] != '1')) {
					$page_offset = (intval($_GET['p']) * 16) - 16;
				}
			}

			if ($login_session_user_type == 'a') {
				$result = mysqli_query($database, "SELECT id, filename, extension, type FROM files ORDER BY id DESC LIMIT 16 OFFSET ".$page_offset);
			} else {
				$result = mysqli_query($database, "SELECT id, filename, extension, type FROM files WHERE owner='".$login_session_user_id."' OR private='0' ORDER BY id DESC LIMIT 16 OFFSET ".$page_offset);
			}

			if (isset($_GET['p'])) {
				if ($_GET['p'] != '1') {
					echo '<a href="index.php?p='.(intval($_GET['p']) - 1).'">< Previous</a> Page <a href="index.php?p='.(intval($_GET['p']) + 1).'">Next ></a>';
				} else {
					echo 'Page <a href="index.php?p=2">Next ></a>';
				}
			} else {
				echo 'Page <a href="index.php?p=2">Next ></a>';
			}
			echo '<br />';

			while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
				#printf("ID: %s  Filename: %s", $row[0], $row[1]);
				echo '<div class="mediabox">';
				if ($row[3] == 't') {
					echo '<a href="text_file.php?id='.$row[0].'">'.$row[1].'</a>';
				} else {
					echo '<a href="media.php?id='.$row[0].'">'.$row[1].'</a>';
				}
				echo '<br />';
				if ($row[3] == 'v') {
					echo '<a href="media.php?id='.$row[0].'"><img height="200" src="'.getenv('LANGUAGE_THUMBNAILS').'/'.$row[0].'.png"></a>';
				} elseif (file_exists(getenv('LANGUAGE_THUMBNAILS').'/'.$row[0].'.png')){
					echo '<a href="media.php?id='.$row[0].'"><img height="200" src="'.getenv('LANGUAGE_THUMBNAILS').'/'.$row[0].'.png"></a>';
				} elseif ($row[3] == 't') {
					echo '<a href="text_file.php?id='.$row[0].'">';
					$loaded_text = nl2br(file_get_contents(getenv('LANGUAGE_UPLOADS').'/'.$row[0].'/'.$row[1], FALSE, NULL, 0, 1024));
					echo '<div class="smalltextpreviewbox">'.$loaded_text.'</div></a>';
				} else {
					echo '<a href="media.php?id='.$row[0].'"><img height="200" src="images/audio.png"></a>';
				}
				echo '</div>';
			}

			#print_r($files1);

			echo '<br clear="all" />';

			if (isset($_GET['p'])) {
				if ($_GET['p'] != '1') {
					echo '<a href="index.php?p='.(intval($_GET['p']) - 1).'">< Previous</a> Page <a href="index.php?p='.(intval($_GET['p']) + 1).'">Next ></a>';
				} else {
					echo 'Page <a href="index.php?p=2">Next ></a>';
				}
			} else {
				echo 'Page <a href="index.php?p=2">Next ></a>';
			}
			?>
			<br clear="all" />
			<br />
			<br />
			<strong>Media and Text Upload</strong>
			<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
			<br />
			<div id="container">
				<a id="pickfiles" href="javascript:;">[Select files]</a>
				<a id="uploadfiles" href="javascript:;">[Upload files]</a>
			</div>
			<br />
			<pre id="console"></pre>
			<?php
			$result2 = mysqli_query($database, "SELECT text FROM settings where name = 'front_page_message'");
			$front_page_message = mysqli_fetch_array($result2);
			echo $front_page_message[0];
			?>
			<br />
			<br />
			<a href="github.php">Code Updates (GitHub Commits)</a> <a href="https://github.com/guardian/language-system/issues">Report a bug</a> <a href="https://github.com/guardian/language-system/issues">Request a feature</a>

		</font>

		<script type="text/javascript">
		var uploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight,html4',
			browse_button : 'pickfiles',
			container: document.getElementById('container'),
			url : 'uploader.php',
			flash_swf_url : 'vendor/moxiecode/plupload/js/Moxie.swf',
			silverlight_xap_url : 'vendor/moxiecode/plupload/js/Moxie.xap',
			chunk_size: '512kb',

			filters : {
				max_file_size : '50000mb',
				mime_types: [
					{title : "Video files", extensions : "mov,mp4,mxf,mpg"},
					{title : "Audio files", extensions : "aiff,mp3,wav"},
					{title : "Text files", extensions : "txt"}
				]
			},

			init: {
				PostInit: function() {
					document.getElementById('filelist').innerHTML = '';

					document.getElementById('uploadfiles').onclick = function() {
						uploader.start();
						return false;
					};
				},

				FilesAdded: function(up, files) {
					plupload.each(files, function(file) {
						document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
					});
				},

				UploadProgress: function(up, file) {
					document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
				},

				Error: function(up, err) {
					document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
				}
			}
		});

		uploader.init();

		</script>
	</body>
</html>
