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
			$result = mysqli_query($database, "SELECT id, filename, extension, type, duration, owner, private FROM files where id = '".$_GET['id']."'");
			$media = mysqli_fetch_array($result);

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if($_POST['Sub'] == 'Delete') {
					$sql = "DELETE FROM files WHERE id='".$_GET['id']."'";
					mysqli_query($database, $sql);
					if (($_POST['type'] == '2') || ($_POST['type'] == '3')) {
						if (file_exists(getenv('LANGUAGE_UPLOADS').'/'.$_GET['id'].'/'.$media[1])){
							unlink(getenv('LANGUAGE_UPLOADS').'/'.$_GET['id'].'/'.$media[1]);
							rmdir(getenv('LANGUAGE_UPLOADS').'/'.$_GET['id']);
						}
					}
					if ($_POST['type'] == '3') {
						if (file_exists(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'])){
							$files = glob(getenv('LANGUAGE_RENDERS').'/'.$_GET['id'].'/*');
							foreach($files as $file) {
								if (is_file($file)) {
									unlink($file);
								}
							}
							rmdir(getenv('LANGUAGE_RENDERS').'/'.$_GET['id']);
						}
						if (file_exists(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'])){
							$files = glob(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/*');
							foreach($files as $file) {
								if (is_file($file)) {
									unlink($file);
								}
							}
							rmdir(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id']);
						}
						if (file_exists(getenv('LANGUAGE_TEXT').'/'.$_GET['id'])){
							$files = glob(getenv('LANGUAGE_TEXT').'/'.$_GET['id'].'/*');
							foreach($files as $file) {
								if (is_file($file)) {
									unlink($file);
								}
							}
							rmdir(getenv('LANGUAGE_TEXT').'/'.$_GET['id']);
						}
						if (file_exists(getenv('LANGUAGE_JSON').'/'.$_GET['id'])){
							$files = glob(getenv('LANGUAGE_JSON').'/'.$_GET['id'].'/*');
							foreach($files as $file) {
								if (is_file($file)) {
									unlink($file);
								}
							}
							rmdir(getenv('LANGUAGE_JSON').'/'.$_GET['id']);
						}
					}
					header('Location: index.php');
				}
				if($_POST['Sub'] == 'Change') {
					if (isset($_POST['private'])) {
						mysqli_query($database, "UPDATE files SET private='1' WHERE id='".$_GET['id']."'");
					} else {
						mysqli_query($database, "UPDATE files SET private='0' WHERE id='".$_GET['id']."'");
					}
					$result = mysqli_query($database, "SELECT id, filename, extension, type, duration, owner, private FROM files where id = '".$_GET['id']."'");
					$media = mysqli_fetch_array($result);
				}
			}

			include('navigation.php');
			echo '<br /><br />';
			if (($login_session_user_type == 'a') || ($login_session_user_id == $media[5]) || ($media[6] == 0)) {
				echo '<div class="infobox">';
				echo 'Text Filename: '.$media[1];
				echo '</div>';
				echo '<div class="textpreviewbox">';
				$loaded_text = nl2br(file_get_contents(getenv('LANGUAGE_UPLOADS').'/'.$_GET['id'].'/'.$media[1], FALSE, NULL, 0, 1024));
				echo $loaded_text;
				echo '</div>';

				echo '<div class="controlbox">';
				echo '<strong>Convert Text File to Subtiles</strong><br /><br />';
				echo '<form class="form" action="text_to_subtitles.php?id='.$_GET['id'].'" method="POST">';
				echo '<input type="submit" value="Convert">';
				echo '</form></div>';

				echo '<div class="controlbox">';
				echo '<strong>Machine Translation (Text File)</strong><br /><br />';

				echo '<form class="form" action="translate_text.php?id='.$_GET['id'].'&type=t" method="POST">';
				echo 'Source: <select name="source">';
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
				echo '<br /><br />';
				echo 'Target: <select name="target">';
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
				echo '<br /><br />';
				echo '<input type="submit" value="Translate">';

				echo '</form></div>';

				echo '<div class="controlbox">';
				echo '<strong>Machine Speech (Text File)</strong><br /><br />';

				echo '<form class="form" action="speech_text.php?id='.$_GET['id'].'&type=t" method="POST">';
				echo 'Language: <select name="language">';
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
				echo '<br /><br />';
				//echo '<input type="submit" name="video" value="Render to Video">&nbsp;&nbsp;&nbsp;';
				echo '<input type="submit" name="audio" value="Render to Audio">';

				echo '</form></div>';

				echo '<div class="controlbox">';
				echo '<strong>Machine Speech (macOS) (Text File)</strong><br /><br />';

				echo '<form class="form" action="speechmac_text.php?id='.$_GET['id'].'&type=t" method="POST">';
				echo 'Voice: <select name="voice">';
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
				echo '<br /><br />';
				//echo '<input type="submit" name="video" value="Render to Video">&nbsp;&nbsp;&nbsp;';
				echo '<input type="submit" name="audio" value="Render to Audio">';

				echo '</form></div>';

				if (file_exists(getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'])) {
					echo '<div class="controlbox">';
					echo '<strong>Machine Translation (Subtitles)</strong><br /><br />';

					echo '<form class="form" action="translate.php?id='.$_GET['id'].'&type=t" method="POST">';
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
					echo '<br /><br />';
					echo 'Source: <select name="source">';
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
					echo '<br /><br />';
					echo 'Target: <select name="target">';
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
					echo '<br /><br />';
					echo '<input type="submit" value="Translate">';

					echo '</form></div>';

					echo '<div class="controlbox">';
					echo '<strong>Machine Speech (Subtitles)</strong><br /><br />';

					echo '<form class="form" action="speech.php?id='.$_GET['id'].'&type=t" method="POST">';
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
					echo '<br /><br />';
					echo 'Language: <select name="language">';
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
					echo '<br /><br />';
					//echo '<input type="submit" name="video" value="Render to Video">&nbsp;&nbsp;&nbsp;';
					echo '<input type="submit" name="audio" value="Render to Audio">';

					echo '</form></div>';

					echo '<div class="controlbox">';
					echo '<strong>Machine Speech (macOS) (Subtitles)</strong><br /><br />';

					echo '<form class="form" action="speechmac.php?id='.$_GET['id'].'&type=t" method="POST">';
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
					echo '<br /><br />';
					echo 'Voice: <select name="voice">';
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
					echo '<option value="Tingting">Ting-Ting (Chinese)</option>';
					echo '<option value="Sinji">Sin-ja (Hong Kong Chinese)</option>';
					echo '<option value="Meijia">Mei-Jia (Taiwanese Chinese)</option>';
					echo '<option value="Audrey">Audrey (French)</option>';
					echo '<option value="Aurélie">Aurelie (French)</option>';
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
					echo '<option value="Mónica">Monica (Spanish)</option>';
					echo '</select>';
					echo '<br /><br />';
					//echo '<input type="submit" name="video" value="Render to Video">&nbsp;&nbsp;&nbsp;';
					echo '<input type="submit" name="audio" value="Render to Audio">';

					echo '</form></div>';
				}

				echo '<div class="controlbox">';
				echo '<strong>Complex Jobs</strong><br /><br />';

				echo '<form class="form" action="complex_start.php?id='.$_GET['id'].'&type=t" method="POST">';
				echo '<select name="job">';
				$result4 = mysqli_query($database, "SELECT DISTINCT name FROM complex ORDER BY name");
				while ($row = mysqli_fetch_array($result4, MYSQLI_NUM)) {
					echo "<option value='".$row[0]."'>".$row[0]."</option>";
				}
				echo '</select>';
				echo '<br /><br />';
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
				echo '<br /><br />';
				echo '<input type="submit" value="Run">';
				echo '</form></div>';

				echo '<div class="controlbox">';
				echo '<strong>Subtitle Upload</strong><br /><br />';
				echo '<form class="form" action="uploadsubtitles.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">';
	    		?>Select subtitles:
	    			<input type="file" name="fileToUpload" id="fileToUpload">
						<br />
						<br />
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
								echo '<a href="'.getenv('LANGUAGE_SUBTITLES').'/'.$_GET['id'].'/'.$file.'">'.$file.'</a> <a href="text.php?id='.$_GET['id'].'&file='.$file.'&type=t">(Convert to text)</a><br />';
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

				if (($login_session_user_type == 'a') || ($login_session_user_id == $media[5])) {
					echo '<div class="controlbox">';
					echo '<strong>Permissions</strong><br /><br />';
					echo '<form class="form" action="?id='.$_GET['id'].'" method="post">';
		    		?>
						Private: <input type="checkbox" name="private" <?php if ($media[6] == '1') echo "checked='checked'"; ?>>
						<br />
						<br />
		    		<input type="submit" value="Change" name="Sub">
					</form>
					<?php
					echo '</div>';

					echo '<div class="controlbox">';
					echo '<strong>Delete Functions</strong><br /><br />';
					echo '<form class="form" action="?id='.$_GET['id'].'" method="post">';
		    		?>
						<select name="type">
							<option value="1">Record</option>
							<option value="2">Record and text file</option>
							<option value="3">All data</option>
						</select>
						<br />
						<br />
		    		<input type="submit" value="Delete" name="Sub">
					</form>
					<?php
					echo '</div>';
				}
			} else {
				echo 'You do not have permission to view this data.';
			}
			?>
		</font>
	</body>
</html>
