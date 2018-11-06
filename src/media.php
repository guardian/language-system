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
				
				
				if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'])) {
					mkdir(getenv('LANGUAGE_RENDERS').'/'.$_GET['id']);
				}
				
				chmod(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'], 0777);
				
				$render_number = 0;
				$number_found = 0;
				
				if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$media[1])) {
				
					exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$media[1].' -vf subtitles='.getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$_POST['subtitles'].' '.getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$media[1]);
					
				} else {
					while ($number_found == 0) {
						$render_number++;
						if (!file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$render_number.'_'.$media[1])) {
							$number_found = 1;
						}
					}
					exec(getenv('LANGUAGE_FFMPEG').' -i '.getenv('LANGUAGE_UPLOADS').'/'.$media[1].' -vf subtitles='.getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$_POST['subtitles'].' '.getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$render_number.'_'.$media[1]);
				}
				
				#exec('ffmpeg -i uploads/'.$media[1].' -filter:v subtitles=subtitles/'.$_GET['id'].'/'.$_POST['subtitles'].' -c:a copy -c:v libx264 -crf 22 -preset veryfast renders/'.$_GET['id'].'/'.$media[1]);
				
				#ffmpeg -i input.mp4 -filter:v subtitles=subtitle.srt -c:a copy -c:v libx264 -crf 22 -preset veryfast output.mp4
				
				#ffmpeg -i infile.mp4 -i infile.srt -c copy -c:s mov_text outfile.mp4
				

				
			}
			

			#print_r($media);
			
			echo 'Media Filename: '.$media[1];
			echo '<br /><br />';
			
			if ((substr($media[1], -4) != '.mov') && (substr($media[1], -4) != '.mxf')) {
				echo '<video width="512" height="512" controls>';
  				echo '<source src="'.getenv('LANGUAGE_UPLOADS').'/'.$media[1].'" type="video/mp4">';
				echo '</video>'; 
			} else {
				echo '<img height="200" src="'.getenv('LANGUAGE_THUMBNAILS').'/'.$_GET['id'].'.png">';
			}

			echo '<br /><br />';
			
			echo '<strong>Subtitle Upload</strong><br />';
			echo '<form action="uploadsubtitles.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">';
    		?>Select subtitles to upload:
    			<input type="file" name="fileToUpload" id="fileToUpload">
    			<input type="submit" value="Upload Subtitles" name="submit">
			</form>
			<?php
			echo '<br /><br />';
			echo '<strong>Rendering</strong><br />';
			echo '<form action="media.php?id='.$_GET['id'].'" method="POST">';
			echo '<select name="subtitles">';
			$dir    = 'subtitles/'.$_GET['id'];
			$files1 = scandir($dir);
			
			foreach ($files1 as $file) {
				if (($file != '.') && ($file != '..')) {
					if (substr($file, -4) == '.srt') {
						echo '<option value="'.$file.'">'.$file.'</option>';
					}
				}
			}
			echo '</select>';
			echo '<input type="submit" value="Render">';
				
			echo '</form>';
			echo '<br /><br />';
		
			echo '<strong>Machine Translation</strong><br />';
		
			echo '<form action="translate.php?id='.$_GET['id'].'" method="POST">';
			echo '<select name="subtitles">';
			$dir    = 'subtitles/'.$_GET['id'];
			$files1 = scandir($dir);
			
			foreach ($files1 as $file) {
				if (($file != '.') && ($file != '..')) {
					if (substr($file, -4) == '.srt') {
						echo '<option value="'.$file.'">'.$file.'</option>';
					}
				}
			}
			echo '</select>';
			echo ' Source: <select name="source">';
			echo '<option value="en">English</option>';
			echo '<option value="af">Afrikaans</option>';
			echo '<option value="sq">Albanian</option>';
			echo '<option value="am">Amharic</option>';
			echo '<option value="ar">Arabic</option>';
			echo '<option value="hy">Armenian</option>';
			echo '<option value="az">Azeerbaijani</option>';
			echo '<option value="eu">Basque</option>';
			echo '<option value="be">Belarusian</option>';
			echo '<option value="bn">Bengali</option>';
			echo '<option value="bs">Bosnian</option>';
			echo '<option value="bg">Bulgarian</option>';
			echo '<option value="ca">Catalan</option>';
			echo '<option value="ceb">Cebuano</option>';
			echo '<option value="zh-CN">Chinese (Simplified)</option>';
			echo '<option value="zh-TW">Chinese (Traditional)</option>';
			echo '<option value="co">Corsican</option>';
			echo '<option value="hr">Croatian</option>';
			echo '<option value="cs">Czech</option>';
			echo '<option value="da">Danish</option>';
			echo '<option value="nl">Dutch</option>';
			echo '<option value="eo">Esperanto</option>';
			echo '<option value="et">Estonian</option>';
			echo '<option value="fi">Finnish</option>';
			echo '<option value="fr">French</option>';
			echo '<option value="fy">Frisian</option>';
			echo '<option value="gl">Galician</option>';
			echo '<option value="ka">Georgian</option>';
			echo '<option value="de">German</option>';
			echo '<option value="el">Greek</option>';
			echo '<option value="gu">Gujarati</option>';
			echo '<option value="ht">Haitian Creole</option>';
			echo '<option value="ha">Hausa</option>';
			echo '<option value="haw">Hawaiian</option>';
			echo '<option value="he">Hebrew</option>';
			echo '<option value="hi">Hindi</option>';
			echo '<option value="hmn">Hmong</option>';
			echo '<option value="hu">Hungarian</option>';
			echo '<option value="is">Icelandic</option>';
			echo '<option value="ig">Igbo</option>';
			echo '<option value="id">Indonesian</option>';
			echo '<option value="ga">Irish</option>';
			echo '<option value="it">Italian</option>';
			echo '<option value="ja">Japanese</option>';
			echo '<option value="jw">Javanese</option>';
			echo '<option value="kn">Kannada</option>';
			echo '<option value="kk">Kazakh</option>';
			echo '<option value="km">Khmer</option>';
			echo '<option value="ko">Korean</option>';
			echo '<option value="ku">Kurdish</option>';
			echo '<option value="ky">Kyrgyz</option>';
			echo '<option value="lo">Lao</option>';
			echo '<option value="la">Latin</option>';
			echo '<option value="lv">Latvian</option>';
			echo '<option value="lt">Lithuanian</option>';
			echo '<option value="lb">Luxembourgish</option>';
			echo '<option value="mk">Macedonian</option>';
			echo '<option value="mg">Malagasy</option>';
			echo '<option value="ms">Malay</option>';
			echo '<option value="ml">Malayalam</option>';
			echo '<option value="mt">Maltese</option>';
			echo '<option value="mi">Maori</option>';
			echo '<option value="mr">Marathi</option>';
			echo '<option value="mn">Mongolian</option>';
			echo '<option value="my">Myanmar</option>';
			echo '<option value="ne">Nepali</option>';
			echo '<option value="no">Norwegian</option>';
			echo '<option value="ny">Nyanja</option>';
			echo '<option value="ps">Pashto</option>';
			echo '<option value="fa">Persian</option>';
			echo '<option value="pl">Polish</option>';
			echo '<option value="pt">Portuguese</option>';
			echo '<option value="pa">Punjabi</option>';
			echo '<option value="ro">Romanian</option>';
			echo '<option value="ru">Russian</option>';
			echo '<option value="sm">Samoan</option>';
			echo '<option value="gd">Scots Gaelic</option>';
			echo '<option value="sr">Serbian</option>';
			echo '<option value="st">Sesotho</option>';
			echo '<option value="sn">Shona</option>';
			echo '<option value="sd">Sindhi</option>';
			echo '<option value="si">Sinhala</option>';
			echo '<option value="sk">Slovak</option>';
			echo '<option value="sl">Slovenian</option>';
			echo '<option value="so">Somali</option>';
			echo '<option value="es">Spanish</option>';
			echo '<option value="su">Sundanese</option>';
			echo '<option value="sw">Swahili</option>';
			echo '<option value="sv">Swedish</option>';
			echo '<option value="tl">Tagalog</option>';
			echo '<option value="tg">Tajik</option>';
			echo '<option value="ta">Tamil</option>';
			echo '<option value="te">Telugu</option>';
			echo '<option value="th">Thai</option>';
			echo '<option value="tr">Turkish</option>';
			echo '<option value="uk">Ukrainian</option>';
			echo '<option value="ur">Urdu</option>';
			echo '<option value="uz">Uzbek</option>';
			echo '<option value="vi">Vietnamese</option>';
			echo '<option value="cy">Welsh</option>';
			echo '<option value="xh">Xhosa</option>';
			echo '<option value="yi">Yiddish</option>';
			echo '<option value="yo">Yoruba</option>';
			echo '<option value="zu">Zulu</option>';
			echo '</select>';
			
			echo ' Target: <select name="target">';
			echo '<option value="af">Afrikaans</option>';
			echo '<option value="sq">Albanian</option>';
			echo '<option value="am">Amharic</option>';
			echo '<option value="ar">Arabic</option>';
			echo '<option value="hy">Armenian</option>';
			echo '<option value="az">Azeerbaijani</option>';
			echo '<option value="eu">Basque</option>';
			echo '<option value="be">Belarusian</option>';
			echo '<option value="bn">Bengali</option>';
			echo '<option value="bs">Bosnian</option>';
			echo '<option value="bg">Bulgarian</option>';
			echo '<option value="ca">Catalan</option>';
			echo '<option value="ceb">Cebuano</option>';
			echo '<option value="zh-CN">Chinese (Simplified)</option>';
			echo '<option value="zh-TW">Chinese (Traditional)</option>';
			echo '<option value="co">Corsican</option>';
			echo '<option value="hr">Croatian</option>';
			echo '<option value="cs">Czech</option>';
			echo '<option value="da">Danish</option>';
			echo '<option value="nl">Dutch</option>';
			echo '<option value="en">English</option>';
			echo '<option value="eo">Esperanto</option>';
			echo '<option value="et">Estonian</option>';
			echo '<option value="fi">Finnish</option>';
			echo '<option value="fr">French</option>';
			echo '<option value="fy">Frisian</option>';
			echo '<option value="gl">Galician</option>';
			echo '<option value="ka">Georgian</option>';
			echo '<option value="de">German</option>';
			echo '<option value="el">Greek</option>';
			echo '<option value="gu">Gujarati</option>';
			echo '<option value="ht">Haitian Creole</option>';
			echo '<option value="ha">Hausa</option>';
			echo '<option value="haw">Hawaiian</option>';
			echo '<option value="he">Hebrew</option>';
			echo '<option value="hi">Hindi</option>';
			echo '<option value="hmn">Hmong</option>';
			echo '<option value="hu">Hungarian</option>';
			echo '<option value="is">Icelandic</option>';
			echo '<option value="ig">Igbo</option>';
			echo '<option value="id">Indonesian</option>';
			echo '<option value="ga">Irish</option>';
			echo '<option value="it">Italian</option>';
			echo '<option value="ja">Japanese</option>';
			echo '<option value="jw">Javanese</option>';
			echo '<option value="kn">Kannada</option>';
			echo '<option value="kk">Kazakh</option>';
			echo '<option value="km">Khmer</option>';
			echo '<option value="ko">Korean</option>';
			echo '<option value="ku">Kurdish</option>';
			echo '<option value="ky">Kyrgyz</option>';
			echo '<option value="lo">Lao</option>';
			echo '<option value="la">Latin</option>';
			echo '<option value="lv">Latvian</option>';
			echo '<option value="lt">Lithuanian</option>';
			echo '<option value="lb">Luxembourgish</option>';
			echo '<option value="mk">Macedonian</option>';
			echo '<option value="mg">Malagasy</option>';
			echo '<option value="ms">Malay</option>';
			echo '<option value="ml">Malayalam</option>';
			echo '<option value="mt">Maltese</option>';
			echo '<option value="mi">Maori</option>';
			echo '<option value="mr">Marathi</option>';
			echo '<option value="mn">Mongolian</option>';
			echo '<option value="my">Myanmar</option>';
			echo '<option value="ne">Nepali</option>';
			echo '<option value="no">Norwegian</option>';
			echo '<option value="ny">Nyanja</option>';
			echo '<option value="ps">Pashto</option>';
			echo '<option value="fa">Persian</option>';
			echo '<option value="pl">Polish</option>';
			echo '<option value="pt">Portuguese</option>';
			echo '<option value="pa">Punjabi</option>';
			echo '<option value="ro">Romanian</option>';
			echo '<option value="ru">Russian</option>';
			echo '<option value="sm">Samoan</option>';
			echo '<option value="gd">Scots Gaelic</option>';
			echo '<option value="sr">Serbian</option>';
			echo '<option value="st">Sesotho</option>';
			echo '<option value="sn">Shona</option>';
			echo '<option value="sd">Sindhi</option>';
			echo '<option value="si">Sinhala</option>';
			echo '<option value="sk">Slovak</option>';
			echo '<option value="sl">Slovenian</option>';
			echo '<option value="so">Somali</option>';
			echo '<option value="es">Spanish</option>';
			echo '<option value="su">Sundanese</option>';
			echo '<option value="sw">Swahili</option>';
			echo '<option value="sv">Swedish</option>';
			echo '<option value="tl">Tagalog</option>';
			echo '<option value="tg">Tajik</option>';
			echo '<option value="ta">Tamil</option>';
			echo '<option value="te">Telugu</option>';
			echo '<option value="th">Thai</option>';
			echo '<option value="tr">Turkish</option>';
			echo '<option value="uk">Ukrainian</option>';
			echo '<option value="ur">Urdu</option>';
			echo '<option value="uz">Uzbek</option>';
			echo '<option value="vi">Vietnamese</option>';
			echo '<option value="cy">Welsh</option>';
			echo '<option value="xh">Xhosa</option>';
			echo '<option value="yi">Yiddish</option>';
			echo '<option value="yo">Yoruba</option>';
			echo '<option value="zu">Zulu</option>';
			echo '</select>';
			
			echo '<input type="submit" value="Translate">';
				
			echo '</form>';
			
			echo '<br /><br />';
			
			echo '<strong>Machine Transcription</strong><br />';
		
			echo '<form action="transcribe.php?id='.$_GET['id'].'" method="POST">';

			echo ' Source Language: <select name="source">';
			echo '<option value="en">English</option>';
			echo '<option value="af">Afrikaans</option>';
			echo '<option value="sq">Albanian</option>';
			echo '<option value="ar">Arabic</option>';
			echo '<option value="hy">Armenian</option>';
			echo '<option value="az">Azeerbaijani</option>';
			echo '<option value="eu">Basque</option>';
			echo '<option value="be">Belarusian</option>';
			echo '<option value="bn">Bengali</option>';
			echo '<option value="bs">Bosnian</option>';
			echo '<option value="bg">Bulgarian</option>';
			echo '<option value="ca">Catalan</option>';
			echo '<option value="ceb">Cebuano</option>';
			echo '<option value="zh-CN">Chinese (Simplified)</option>';
			echo '<option value="zh-TW">Chinese (Traditional)</option>';
			echo '<option value="hr">Croatian</option>';
			echo '<option value="cs">Czech</option>';
			echo '<option value="da">Danish</option>';
			echo '<option value="nl">Dutch</option>';
			echo '<option value="eo">Esperanto</option>';
			echo '<option value="et">Estonian</option>';
			echo '<option value="fi">Finnish</option>';
			echo '<option value="fr">French</option>';
			echo '<option value="gl">Galician</option>';
			echo '<option value="ka">Georgian</option>';
			echo '<option value="de">German</option>';
			echo '<option value="el">Greek</option>';
			echo '<option value="gu">Gujarati</option>';
			echo '<option value="ht">Haitian Creole</option>';
			echo '<option value="ha">Hausa</option>';
			echo '<option value="iw">Hebrew</option>';
			echo '<option value="hi">Hindi</option>';
			echo '<option value="hmn">Hmong</option>';
			echo '<option value="hu">Hungarian</option>';
			echo '<option value="is">Icelandic</option>';
			echo '<option value="ig">Igbo</option>';
			echo '<option value="id">Indonesian</option>';
			echo '<option value="ga">Irish</option>';
			echo '<option value="it">Italian</option>';
			echo '<option value="ja">Japanese</option>';
			echo '<option value="jw">Javanese</option>';
			echo '<option value="kn">Kannada</option>';
			echo '<option value="kk">Kazakh</option>';
			echo '<option value="km">Khmer</option>';
			echo '<option value="ko">Korean</option>';
			echo '<option value="lo">Lao</option>';
			echo '<option value="la">Latin</option>';
			echo '<option value="lv">Latvian</option>';
			echo '<option value="lt">Lithuanian</option>';
			echo '<option value="mk">Macedonian</option>';
			echo '<option value="mg">Malagasy</option>';
			echo '<option value="ms">Malay</option>';
			echo '<option value="ml">Malayalam</option>';
			echo '<option value="mt">Maltese</option>';
			echo '<option value="mi">Maori</option>';
			echo '<option value="mr">Marathi</option>';
			echo '<option value="mn">Mongolian</option>';
			echo '<option value="my">Myanmar</option>';
			echo '<option value="ne">Nepali</option>';
			echo '<option value="no">Norwegian</option>';
			echo '<option value="ny">Nyanja</option>';
			echo '<option value="fa">Persian</option>';
			echo '<option value="pl">Polish</option>';
			echo '<option value="pt">Portuguese</option>';
			echo '<option value="pa">Punjabi</option>';
			echo '<option value="ro">Romanian</option>';
			echo '<option value="ru">Russian</option>';
			echo '<option value="sr">Serbian</option>';
			echo '<option value="st">Sesotho</option>';
			echo '<option value="si">Sinhala</option>';
			echo '<option value="sk">Slovak</option>';
			echo '<option value="sl">Slovenian</option>';
			echo '<option value="so">Somali</option>';
			echo '<option value="es">Spanish</option>';
			echo '<option value="su">Sundanese</option>';
			echo '<option value="sw">Swahili</option>';
			echo '<option value="sv">Swedish</option>';
			echo '<option value="tl">Tagalog</option>';
			echo '<option value="tg">Tajik</option>';
			echo '<option value="ta">Tamil</option>';
			echo '<option value="te">Telugu</option>';
			echo '<option value="th">Thai</option>';
			echo '<option value="tr">Turkish</option>';
			echo '<option value="uk">Ukrainian</option>';
			echo '<option value="ur">Urdu</option>';
			echo '<option value="uz">Uzbek</option>';
			echo '<option value="vi">Vietnamese</option>';
			echo '<option value="cy">Welsh</option>';
			echo '<option value="yi">Yiddish</option>';
			echo '<option value="yo">Yoruba</option>';
			echo '<option value="zu">Zulu</option>';
			echo '</select>';
			
			echo '<input type="submit" value="Transcribe">';
				
			echo '</form>';
			
			echo '<br /><br />';
			
			
			echo '<strong>Machine Speech</strong><br />';
		
			echo '<form action="speech.php?id='.$_GET['id'].'" method="POST">';
			echo '<select name="subtitles">';
			$dir    = 'subtitles/'.$_GET['id'];
			$files1 = scandir($dir);
			
			foreach ($files1 as $file) {
				if (($file != '.') && ($file != '..')) {
					if (substr($file, -4) == '.srt') {
						echo '<option value="'.$file.'">'.$file.'</option>';
					}
				}
			}
			echo '</select>';
			
			echo '<input type="submit" value="Render">';
				
			echo '</form>';
			
			echo '<br /><br />';
			
			if (file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'])) {
			
				echo '<strong>Renders</strong><br />';
			
				$files = scandir(getenv('LANGUAGE_RENDERS').'/'.$_GET['id']);
				foreach($files as $file) {
					if (($file != '.') && ($file != '..')) {
						echo '<a href="'.getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$file.'">'.$file.'</a><br />';
					}
				}
				echo '<br /><br />';
			}
			
			if (file_exists(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'])) {
			
				echo '<strong>Subtitles</strong><br />';
			
				$files = scandir(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id']);
				foreach($files as $file) {
					if (($file != '.') && ($file != '..')) {
						if (substr($file, -4) == '.srt') {
							echo '<a href="'.getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$file.'">'.$file.'</a><br />';
						}
					}
				}
				echo '<br /><br />';
			}
			
			?>
		</font>
	</body>
</html>