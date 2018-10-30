<html>
	<head>
		<title>
			Language System
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

			
			<?php
			
			include 'database.php';
			$result = mysql_query("SELECT id, filename FROM files where id = '".$_GET['id']."'");
			$media = mysql_fetch_array($result);
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				#echo $_POST['subtitles'];
				
				#ffmpeg -i video.avi -vf subtitles=subtitle.srt out.avi
				
				
				if (!file_exists('renders/'.$_GET['id'])) {
					mkdir('renders/'.$_GET['id']);
				}
				
				chmod('renders/'.$_GET['id'], 0777);
				
				$render_number = 0;
				$number_found = 0;
				
				if (!file_exists('renders/'.$_GET['id'].'/'.$media[1])) {
				
					exec('/home/dave/Downloads/ffmpeg -i uploads/'.$media[1].' -vf subtitles=subtitles/'.$_GET['id'].'/'.$_POST['subtitles'].' renders/'.$_GET['id'].'/'.$media[1]);
					
				} else {
					while ($number_found == 0) {
						$render_number++;
						if (!file_exists('renders/'.$_GET['id'].'/'.$render_number.'_'.$media[1])) {
							$number_found = 1;
						}
					}
					exec('/home/dave/Downloads/ffmpeg -i uploads/'.$media[1].' -vf subtitles=subtitles/'.$_GET['id'].'/'.$_POST['subtitles'].' renders/'.$_GET['id'].'/'.$render_number.'_'.$media[1]);
				}
				
				#exec('ffmpeg -i uploads/'.$media[1].' -filter:v subtitles=subtitles/'.$_GET['id'].'/'.$_POST['subtitles'].' -c:a copy -c:v libx264 -crf 22 -preset veryfast renders/'.$_GET['id'].'/'.$media[1]);
				
				#ffmpeg -i input.mp4 -filter:v subtitles=subtitle.srt -c:a copy -c:v libx264 -crf 22 -preset veryfast output.mp4
				
				#ffmpeg -i infile.mp4 -i infile.srt -c copy -c:s mov_text outfile.mp4
				

				
			}
			

			#print_r($media);
			
			echo 'Media Filename: '.$media[1];
			echo '<br /><br />';

			echo '<video width="512" height="512" controls>';
  			echo '<source src="uploads/'.$media[1].'" type="video/mp4">';
			echo '</video>'; 

			

			echo '<br /><br />';
			
			
			echo '<form action="uploadsubtitles.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">';
    		?>Select subtitles to upload:
    			<input type="file" name="fileToUpload" id="fileToUpload">
    			<input type="submit" value="Upload Subtitles" name="submit">
			</form>
			<?php
			echo '<br /><br />';
		
			echo '<form action="media.php?id='.$_GET['id'].'" method="POST">';
			echo '<select name="subtitles">';
			$dir    = 'subtitles/'.$_GET['id'];
			$files1 = scandir($dir);
			
			foreach ($files1 as $file) {
				if (($file != '.') && ($file != '..')) {
					echo '<option value="'.$file.'">'.$file.'</option>';
				}
			
			}
			echo '</select>';
			echo '<input type="submit" value="Render">';
				
			echo '</form>';
			echo '<br /><br />';
			
			if (file_exists('renders/'.$_GET['id'])) {
			
				echo '<strong>Renders</strong><br />';
			
				$files = scandir('renders/'.$_GET['id']);
				foreach($files as $file) {
					if (($file != '.') && ($file != '..')) {
						echo '<a href="renders/'.$_GET['id'].'/'.$file.'">'.$file.'</a><br />';
					}
				}
			}

			?>
		</font>
	</body>
</html>