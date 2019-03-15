<html>
	<head>
		<title>
			Language System - Jobs
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

			$page_offset = 0;

			if (isset($_GET['p'])) {
				if (($_GET['p'] != '') && ($_GET['p'] != '1')) {
					$page_offset = (intval($_GET['p']) * 32) - 32;
				}
			}

			$result = mysqli_query($database, "SELECT * FROM jobs ORDER BY id DESC LIMIT 32 OFFSET ".$page_offset);

			if (isset($_GET['p'])) {
				if ($_GET['p'] != '1') {
					echo '<a href="job_list.php?p='.(intval($_GET['p']) - 1).'">< Previous</a> Page <a href="job_list.php?p='.(intval($_GET['p']) + 1).'">Next ></a>';
				} else {
					echo 'Page <a href="job_list.php?p=2">Next ></a>';
				}
			} else {
				echo 'Page <a href="job_list.php?p=2">Next ></a>';
			}
			echo '<br />';
			?>

			<table cellpadding="4">
				<tr>
					<th>
						Id.
					</th>
					<th>
						Name
					</th>
					<th>
						Type
					</th>
					<th>
						User
					</th>
					<th>
						Start (UNIX)
					</th>
					<th>
						End (UNIX)
					</th>
					<th>
						Start (Human Friendly)
					</th>
					<th>
						End (Human Friendly)
					</th>
					<th>
						Status
					</th>
					<th>
						Input 1
					</th>
					<th>
						Input 2
					</th>
					<th>
						Input 3
					</th>
					<th>
						Input 4
					</th>
					<th>
						Input 5
					</th>
					<th>
						Input 6
					</th>
					<th>
						Input 7
					</th>
					<th>
						Input 8
					</th>
					<th>
						Output 1
					</th>
					<th>
						Output 2
					</th>
					<th>
						Output 3
					</th>
					<th>
						Output 4
					</th>
					<th>
						Output 5
					</th>
					<th>
						Output 6
					</th>
					<th>
						Output 7
					</th>
					<th>
						Output 8
					</th>
				</tr>
			<?php

			while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
				echo '<tr>';
				$finish = '';
				if (isset($row[5])) {
					$finish = date('G:i:s j/n/Y', $row[5]);
				}
				echo '<td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[5].'</td><td>'.date('G:i:s j/n/Y', $row[4]).'</td><td>'.$finish.'</td><td>'.$row[6].'</td><td>'.$row[7].'</td><td>'.$row[8].'</td><td>'.$row[9].'</td><td>'.$row[10].'</td><td>'.$row[11].'</td><td>'.$row[12].'</td><td>'.$row[13].'</td><td>'.$row[14].'</td><td>'.$row[15].'</td><td>'.$row[16].'</td><td>'.$row[17].'</td><td>'.$row[18].'</td><td>'.$row[19].'</td><td>'.$row[20].'</td><td>'.$row[21].'</td><td>'.$row[22].'</td>';
				echo '</tr>';
			}

			?>
			</table>

			<?php

			echo '<br clear="all" />';

			if (isset($_GET['p'])) {
				if ($_GET['p'] != '1') {
					echo '<a href="job_list.php?p='.(intval($_GET['p']) - 1).'">< Previous</a> Page <a href="job_list.php?p='.(intval($_GET['p']) + 1).'">Next ></a>';
				} else {
					echo 'Page <a href="job_list.php?p=2">Next ></a>';
				}
			} else {
				echo 'Page <a href="job_list.php?p=2">Next ></a>';
			}
			?>

		</font>
	</body>
</html>
