<html>
	<head>
		<title>
			Language System
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

<?php

require __DIR__ . '/vendor/autoload.php';


use Stichoza\GoogleTranslate\TranslateClient;

#$tr = new TranslateClient('en', 'fr');

$tr = new TranslateClient(); // Default is from 'auto' to 'en'
$tr->setSource('en'); // Translate from English
$tr->setTarget('fr'); // Translate to Georgian
#$tr->setUrlBase('http://translate.google.cn/translate_a/single'); // Set Google Translate URL base (This is not necessary, only for some countries)

echo $tr->translate('Hello World!');


echo '<br /><br />';
echo TranslateClient::translate('en', 'de', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'es', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'ru', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'pt', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'nl', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'ur', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'zh-CN', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'ja', 'Hello World!');
echo '<br /><br />';
echo TranslateClient::translate('en', 'ar', 'Hello World!');
?>
		</font>
	</body>
</html>