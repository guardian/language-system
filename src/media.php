<html>
	<head>
		<title>
			Language System
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">


			<?php

			include 'database.php';
			include('session.php');
			include('jobs.php');
			$result = mysqli_query($database, "SELECT id, filename, extension, type, duration FROM files where id = '".$_GET['id']."'");
			$media = mysqli_fetch_array($result);

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				#echo $_POST['subtitles'];

				#ffmpeg -i video.avi -vf subtitles=subtitle.srt out.avi

				#exec('ffmpeg -i uploads/'.$media[1].' -filter:v subtitles=subtitles/'.$_GET['id'].'/'.$_POST['subtitles'].' -c:a copy -c:v libx264 -crf 22 -preset veryfast renders/'.$_GET['id'].'/'.$media[1]);

				#ffmpeg -i input.mp4 -filter:v subtitles=subtitle.srt -c:a copy -c:v libx264 -crf 22 -preset veryfast output.mp4

				#ffmpeg -i infile.mp4 -i infile.srt -c copy -c:s mov_text outfile.mp4

			}

			#print_r($media);
			include('navigation.php');
			echo '<br /><br />';
			echo '<div class="infobox">';
			echo 'Media Filename: '.$media[1];
			echo '</div>';
			echo '<div class="previewbox">';

			if (($media[2] == 'mov') || ($media[2] == 'mxf') || ($media[2] == 'MOV') || ($media[2] == 'MXF')) {
				echo '<img height="200" src="'.getenv('LANGUAGE_THUMBNAILS').'/'.$_GET['id'].'.png">';
			} elseif (($media[2] == 'aiff') || ($media[2] == 'AIFF')) {
				if (file_exists(getenv('LANGUAGE_THUMBNAILS').'/'.$_GET['id'].'.png')){
					echo '<img height="200" src="'.getenv('LANGUAGE_THUMBNAILS').'/'.$_GET['id'].'.png">';
				} else {
					echo '<img height="200" src="images/audio.png">';
				}
			} else {
				if (($media[2] == 'wav') || ($media[2] == 'WAV') || ($media[2] == 'mp3') || ($media[2] == 'MP3')) {
					echo '<video width="512" height="48" controls>';
  					echo '<source src="'.getenv('LANGUAGE_UPLOADS').'/'.$_GET['id'].'/'.$media[1].'" type="video/mp4">';
					echo '</video>';
				} else {
					echo '<video width="512" height="512" controls>';
  					echo '<source src="'.getenv('LANGUAGE_UPLOADS').'/'.$_GET['id'].'/'.$media[1].'" type="video/mp4">';
					echo '</video>';
				}
			}

			echo '</div>';

			echo '<div class="controlbox">';
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

			echo '</form></div>';

			echo '<br /><br />';

			$result2 = mysqli_query($database, "SELECT number FROM settings where name = 'amazon_transcribe_quota'");
			$amazon_transcribe_quota = mysqli_fetch_array($result2);
			$result3 = mysqli_query($database, "SELECT number FROM settings where name = 'amazon_transcribe_usage'");
			$amazon_transcribe_usage = mysqli_fetch_array($result3);

			if ($amazon_transcribe_quota[0] > ($amazon_transcribe_usage[0] + (substr($media[4], 0, 2) * 3600) + (substr($media[4], 3, 2) * 60) + substr($media[4], 6, 2))) {
				echo '<div class="controlbox">';
				echo '<strong>Machine Transcription (Amazon)</strong><br />';

				echo '<form action="transcribe_amazon.php?id='.$_GET['id'].'" method="POST">';

				echo ' Source Language: <select name="source">';
				echo '<option value="en-GB">English (British)</option>';
				echo '<option value="en-US">English (United States of America)</option>';
				echo '<option value="en-AU">English (Australian)</option>';
				echo '<option value="en-IN">English (Indian)</option>';
				echo '<option value="fr-FR">French</option>';
				echo '<option value="fr-CA">French (Canadian)</option>';
				echo '<option value="de-DE">German</option>';
				echo '<option value="it-IT">Italian</option>';
				echo '<option value="es-ES">Spanish</option>';
				echo '<option value="es-US">Spanish (United States of America)</option>';
				echo '<option value="pt-BR">Portuguese</option>';
				echo '<option value="ar-SA">Arabic</option>';
				echo '<option value="hi-IN">Hindi</option>';
				echo '<option value="ko-KR">Korean</option>';
				echo '</select>';

				echo '<input type="submit" value="Transcribe">';

				echo '</form>';
				$duration = (substr($media[4], 0, 2) * 3600) + (substr($media[4], 3, 2) * 60) + substr($media[4], 6, 2);
				if (substr($media[4], 9, 2) > 49) {
					$duration = $duration + 1;
				}
				$result5 = mysqli_query($database, "SELECT decimal_number FROM settings where name = 'amazon_transcribe_usa_dollar_cost'");
				$amazon_transcribe_usa_dollar_cost = mysqli_fetch_array($result5);
				$result6 = mysqli_query($database, "SELECT decimal_number FROM settings where name = 'pounds_sterling_per_usa_dollar'");
				$pounds_sterling_per_usa_dollar = mysqli_fetch_array($result6);
				$result7 = mysqli_query($database, "SELECT decimal_number FROM settings where name = 'euros_per_usa_dollar'");
				$euros_per_usa_dollar = mysqli_fetch_array($result7);
				$dollar_cost = 0.01;
				$dollar_cost_unfixed = round($amazon_transcribe_usa_dollar_cost[0] * $duration,2);
				if ($dollar_cost_unfixed > 0) {
					$dollar_cost = $dollar_cost_unfixed;
				}
				$pound_cost = 0.01;
				$pound_cost_unfixed = round($amazon_transcribe_usa_dollar_cost[0] * $duration * $pounds_sterling_per_usa_dollar[0], 2);
				if ($pound_cost_unfixed > 0) {
					$pound_cost = $pound_cost_unfixed;
				}
				$euro_cost = 0.01;
				$euro_cost_unfixed = round($amazon_transcribe_usa_dollar_cost[0] * $duration * $euros_per_usa_dollar[0], 2);
				if ($euro_cost_unfixed > 0) {
					$euro_cost = $euro_cost_unfixed;
				}
				echo 'Cost: $' . $dollar_cost . ' / &pound;' . $pound_cost . ' / &euro;' . $euro_cost;
				echo '</div>';
			} else {
				echo '<div class="controlbox">';
				echo 'Amazon Transcibe is not avalible for this item because the quota would be exceeded.';
				echo '</div>';
			}
			echo '<div class="controlbox">';
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

			echo '</form></div>';

			echo '<div class="controlbox">';
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

			echo ' Language: <select name="language">';
			echo '<option value="en">English</option>';
			echo '<option value="en-gb">English (British)</option>';
			echo '<option value="en-uk-rp">English (Received Pronunciation)</option>';
			echo '<option value="en-us">English (USA)</option>';
			echo '<option value="en-uk-north">English (Northern England)</option>';
			echo '<option value="en-uk-wmids">English (West Midlands)</option>';
			echo '<option value="en-sc">English (Scotland)</option>';
			echo '<option value="en-wi">English (West Indies)</option>';
			echo '<option value="af">Afrikaans</option>';
			echo '<option value="sq">Albanian</option>';
			echo '<option value="an">Aragonese</option>';
			echo '<option value="hy">Armenian</option>';
			echo '<option value="hy-west">Armenian (West)</option>';
			echo '<option value="bs">Bosnian</option>';
			echo '<option value="bg">Bulgarian</option>';
			echo '<option value="ca">Catalan</option>';
			echo '<option value="zh">Chinese (Mandarin)</option>';
			echo '<option value="zh-yue">Chinese (Cantonese)</option>';
			echo '<option value="hr">Croatian</option>';
			echo '<option value="cs">Czech</option>';
			echo '<option value="da">Danish</option>';
			echo '<option value="nl">Dutch</option>';
			echo '<option value="eo">Esperanto</option>';
			echo '<option value="et">Estonian</option>';
			echo '<option value="fa">Farsi</option>';
			echo '<option value="fa-pin">Farsi (Pinglish)</option>';
			echo '<option value="fi">Finnish</option>';
			echo '<option value="fr-fr">French</option>';
			echo '<option value="fr-be">French (Belgium)</option>';
			echo '<option value="ka">Georgian</option>';
			echo '<option value="de">German</option>';
			echo '<option value="el">Greek</option>';
			echo '<option value="grc">Greek (Ancient)</option>';
			echo '<option value="hi">Hindi</option>';
			echo '<option value="hu">Hungarian</option>';
			echo '<option value="is">Icelandic</option>';
			echo '<option value="id">Indonesian</option>';
			echo '<option value="ga">Irish</option>';
			echo '<option value="it">Italian</option>';
			echo '<option value="kn">Kannada</option>';
			echo '<option value="ku">Kurdish</option>';
			echo '<option value="la">Latin</option>';
			echo '<option value="lv">Latvian</option>';
			echo '<option value="lt">Lithuanian</option>';
			echo '<option value="jbo">Lojban</option>';
			echo '<option value="mk">Macedonian</option>';
			echo '<option value="ms">Malay</option>';
			echo '<option value="ml">Malayalam</option>';
			echo '<option value="ne">Nepali</option>';
			echo '<option value="no">Norwegian</option>';
			echo '<option value="pl">Polish</option>';
			echo '<option value="pt-pt">Portuguese</option>';
			echo '<option value="pt-br">Portuguese (Brazil)</option>';
			echo '<option value="pa">Punjabi</option>';
			echo '<option value="ro">Romanian</option>';
			echo '<option value="ru">Russian</option>';
			echo '<option value="sr">Serbian</option>';
			echo '<option value="sk">Slovak</option>';
			echo '<option value="es">Spanish</option>';
			echo '<option value="es-la">Spanish (American)</option>';
			echo '<option value="sw">Swahili</option>';
			echo '<option value="sv">Swedish</option>';
			echo '<option value="ta">Tamil</option>';
			echo '<option value="tr">Turkish</option>';
			echo '<option value="vi">Vietnamese</option>';
			echo '<option value="vi-hue">Vietnamese (Hue)</option>';
			echo '<option value="vi-sgn">Vietnamese (South)</option>';
			echo '<option value="cy">Welsh</option>';
			echo '</select>';

			echo '<input type="submit" name="video" value="Render to Video">';
			echo '<input type="submit" name="audio" value="Render to Audio">';

			echo '</form></div>';

			echo '<div class="controlbox">';
			echo '<strong>Machine Speech (Mac OS)</strong><br />';

			echo '<form action="speechmac.php?id='.$_GET['id'].'" method="POST">';
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

			echo ' Voice: <select name="voice">';
			echo '<option value="Kate">Kate (British English)</option>';
			echo '<option value="Serena">Serena (British English)</option>';
			echo '<option value="Daniel">Daniel (British English)</option>';
			echo '<option value="Fiona">Fiona (Scottish English)</option>';
			echo '<option value="Moira">Moira (Irish English)</option>';
			echo '<option value="Veena">Veena (Indian English)</option>';
			echo '<option value="Karen">Karen (Australian English)</option>';
			echo '<option value="Tessa">Tessa (South African English)</option>';
			echo '<option value="Allison">Allison (United States of America English)</option>';
			echo '<option value="Ava">Ava (United States of America English)</option>';
			echo '<option value="Samantha">Samantha (United States of America English)</option>';
			echo '<option value="Susan">Susan (United States of America English)</option>';
			echo '<option value="Ting-Ting">Ting-Ting (Chinese)</option>';
			echo '<option value="Sin-ji">Sin-ja (Hong Kong Chinese)</option>';
			echo '<option value="Mei-Jia">Mei-Jia (Taiwanese Chinese)</option>';
			echo '<option value="Audrey">Audrey (French)</option>';
			echo '<option value="Aurelie">Aurelie (French)</option>';
			echo '<option value="Anna">Anna (German)</option>';
			echo '<option value="Markus">Markus (German)</option>';
			echo '<option value="Petra">Petra (German)</option>';
			echo '<option value="Yannick">Yannick (German)</option>';
			echo '<option value="Lekha">Lekha (Hindi)</option>';
			echo '<option value="Kyoko">Kyoko (Japanese)</option>';
			echo '<option value="Otoya">Otoya (Japanese)</option>';
			echo '<option value="Katya">Katya (Russian)</option>';
			echo '<option value="Milena">Milena (Russian)</option>';
			echo '<option value="Jorge">Jorge (Spanish)</option>';
			echo '<option value="Monica">Monica (Spanish)</option>';
			echo '</select>';

			echo '<input type="submit" name="video" value="Render to Video">';
			echo '<input type="submit" name="audio" value="Render to Audio">';

			echo '</form></div>';

			if ($media[3] == 'v') {
				echo '<div class="controlbox">';
				echo '<strong>Subtitle Rendering</strong><br />';
				echo '<form action="subtitles.php?id='.$_GET['id'].'" method="POST">';
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

				echo '</form></div>';
			}

			echo '<div class="controlbox">';
			echo '<strong>Complex Jobs</strong><br />';

			echo '<form action="complex_start.php?id='.$_GET['id'].'" method="POST">';
			echo '<select name="job">';
			$result4 = mysqli_query($database, "SELECT DISTINCT name FROM complex ORDER BY name");
			while ($row = mysqli_fetch_array($result4, MYSQLI_NUM)) {
				echo "<option value='".$row[0]."'>".$row[0]."</option>";
			}
			echo '</select>';
			echo ' Subtitles:<select name="subtitles">';
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
			echo '<input type="submit" value="Run">';
			echo '</form></div>';

			echo '<div class="controlbox">';
			echo '<strong>Subtitle Upload</strong><br />';
			echo '<form action="uploadsubtitles.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">';
    		?>Select subtitles to upload:
    			<input type="file" name="fileToUpload" id="fileToUpload">
    			<input type="submit" value="Upload Subtitles" name="submit">
			</form>
			<?php
			echo '</div>';

			if (file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'])) {
				echo '<div class="outputbox">';
				echo '<strong>Renders</strong><br />';

				$files = scandir(getenv('LANGUAGE_RENDERS').'/'.$_GET['id']);
				foreach($files as $file) {
					if (($file != '.') && ($file != '..')) {
						echo '<a href="'.getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/'.$file.'">'.$file.'</a><br />';
					}
				}
				echo '</div>';
			}

			if (file_exists(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'])) {
				echo '<div class="outputbox">';
				echo '<strong>Subtitles</strong><br />';

				$files = scandir(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id']);
				foreach($files as $file) {
					if (($file != '.') && ($file != '..')) {
						if (substr($file, -4) == '.srt') {
							echo '<a href="'.getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$file.'">'.$file.'</a> <a href="text.php?id='.$_GET['id'].'&file='.$file.'">(Convert to text)</a><br />';
						}
					}
				}
				echo '</div>';
			}

			if (file_exists(getenv('LANGUAGE_JSON').'/'.$_GET['id'])) {
				echo '<div class="outputbox">';
				echo '<strong>Amazon Transcribe Files</strong><br />';

				$files = scandir(getenv('LANGUAGE_JSON').'/'.$_GET['id']);
				foreach($files as $file) {
					if (($file != '.') && ($file != '..')) {
						if (substr($file, -5) == '.json') {
							echo '<a href="'.getenv('LANGUAGE_JSON').'/'.$_GET['id'].'/'.$file.'">'.$file.'</a><br />';
						}
					}
				}
				echo '</div>';
			}

			if (file_exists(getenv('LANGUAGE_TEXT').'/'.$_GET['id'])) {
				echo '<div class="outputbox">';
				echo '<strong>Text Files</strong><br />';

				$files = scandir(getenv('LANGUAGE_TEXT').'/'.$_GET['id']);
				foreach($files as $file) {
					if (($file != '.') && ($file != '..')) {
						if (substr($file, -4) == '.txt') {
							echo '<a href="'.getenv('LANGUAGE_TEXT').'/'.$_GET['id'].'/'.$file.'">'.$file.'</a><br />';
						}
					}
				}
				echo '</div>';
			}

			?>
		</font>
	</body>
</html>
