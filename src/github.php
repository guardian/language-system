<html>
	<head>
		<title>
			Language System - Code Updates (GitHub Commits)
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

		<?php
		include('database.php');
		include('session.php');
		include('navigation.php');
		echo '<br /><br />';

		$opts = ['http' => ['method' => 'GET', 'header' => ['User-Agent: PHP']]];
		$context = stream_context_create($opts);
		$json = file_get_contents("https://api.github.com/repos/guardian/language-system/commits", false, $context);
		$obj = json_decode($json, true);
		?>

		<?php foreach ($obj as $o) { ?>

				<div class="git_data_message"><?php echo $o["commit"]["message"]; ?></div>
				<div class="git_data_date"><?php echo $o["commit"]["author"]["date"]; ?></div>
				<div class="git_data_user"><?php echo $o["commit"]["author"]["name"]; ?></div>
				<div class="git_data_email"><?php echo $o["commit"]["author"]["email"]; ?></div>
				<div class="git_data_id"><?php echo $o["sha"]; ?></div>

		<?php } ?>
	</body>
</html>
