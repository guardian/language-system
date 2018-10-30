<html>
	<head>
		<title>
			Language System
		</title>
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">
			Welcome to the Language System.
			<br />
			<br />
			<br />
			
			<?php
			
			include 'database.php';
			
			$dir    = 'uploads/';
			$files1 = scandir($dir);
			
			/*
			foreach ($files1 as $file) {
			
				echo '<br />'. $file;
			
			}*/
			
			
			$result = mysql_query("SELECT id, filename FROM files");

			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				#printf("ID: %s  Filename: %s", $row[0], $row[1]);
				echo '<br />';
				echo '<a href="media.php?id='.$row[0].'">'.$row[1].'</a>';
			}
			
			#print_r($files1);

			
			?>
			<br />
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