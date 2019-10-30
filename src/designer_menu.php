<html>
	<head>
		<title>
			Language System - Complex Job Designer
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">

			<?php
			include 'database.php';
			include('session.php');

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if($_POST['Sub'] == 'New Complex Job') {
					$newjobname = "NewComplexJob".time();
					$sql = "INSERT INTO complex (name,step) VALUES ('".$newjobname."',1)";
					mysqli_query($database, $sql);
					$sql = "INSERT INTO complex (name,step) VALUES ('".$newjobname."',2)";
					mysqli_query($database, $sql);
					header('Location: designer.php?name='.$newjobname);
				}
			}

			include('navigation.php');
			?>
			<br /><br /><br />
			<form action="" method="POST">
				<input type="submit" name="Sub" value="New Complex Job">
			</form>
			<br />
			<strong>Edit Existing</strong>
			<br /><br />
			<?php

			$result = mysqli_query($database, "SELECT DISTINCT name FROM complex ORDER BY name");
			while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
				echo '<a href="designer.php?name='.$row[0].'">'.$row[0].'</a><br />';
			}

			?>
		</font>
	</body>
</html>
