<html>
	<head>
		<title>
			Language System
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">
			Welcome to the Language System.
			<br />
			<br />
			<br />
			
			<?php
			
			include 'database.php';
			
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
			
			$result = mysql_query("SELECT id, filename FROM files ORDER BY id DESC LIMIT 16 OFFSET ".$page_offset);
			
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

			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				#printf("ID: %s  Filename: %s", $row[0], $row[1]);
				echo '<div class="mediabox">';
				echo '<a href="media.php?id='.$row[0].'">'.$row[1].'</a>';
				echo '<br />';
				echo '<a href="media.php?id='.$row[0].'"><img height="200" src="'.getenv('LANGUAGE_THUMBNAILS').'/'.$row[0].'.png"></a>';
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
			<form action="upload.php" method="post" enctype="multipart/form-data">
    			Select file to upload:
    			<input type="file" name="fileToUpload" id="fileToUpload">
    			<input type="submit" value="Upload File" name="submit">
			</form>
			
		</font>
	</body>
</html>