<html>
	<head>
		<title>
			Language System - Administration
		</title>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body bgcolor="#000000" text="#fbfbfb" link="#dfe7ff" VLINK="#f7e1ff" ALINK="#ffe1e2">
		<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" SIZE="-1">
			<?php
			include 'database.php';
			include('session.php');
			include('navigation.php');
			?>
			<br />
			<br />
			<br />
			<?php
			if ($login_session_user_type != 'a') {
				echo 'You are not a logged in as an administrator.';
			} else {
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$sql = "UPDATE settings SET text='".$_POST['message']."' WHERE name='front_page_message'";
					mysqli_query($database, $sql);
					header('Location: admin.php');
				}
				?>
				<table cellspacing="16">
					<tr valign="top">
						<td>
							<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" size="-1">
								<strong>Front Page Message</strong>
								<br />
								<br />
								<?php
								$result = mysqli_query($database, "SELECT text FROM settings where name = 'front_page_message'");
								$front_page_message = mysqli_fetch_array($result);
								?>
								<form action="" method="POST">
									<input name="message" type="text" hidden />
									<textarea name="message" rows="16" cols="64"><?php echo $front_page_message[0]; ?></textarea>
									<br />
									<br />
									<input type="submit" name="Sub" value="Update Message">
								</form>
							</font>
						</td>
						<td>
							<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" size="-1">
								<strong>System Information</strong>
								<br />
								<br />
							<?php
							$load = sys_getloadavg();
							echo "Load averages: " . $load[0] . " " . $load[1] . " " . $load[2];
							echo '<br /><br />';
							$proc_uptime   = @file_get_contents('/proc/uptime');
							$uptime_num   = floatval($proc_uptime);
							$uptime_secs  = fmod($uptime_num, 60); $uptime_num = (int)($uptime_num / 60);
							$uptime_mins  = $uptime_num % 60;      $uptime_num = (int)($uptime_num / 60);
							$uptime_hours = $uptime_num % 24;      $uptime_num = (int)($uptime_num / 24);
							$uptime_days  = $uptime_num;
							echo "Uptime: " . $uptime_days . " days " . $uptime_hours . " hours " . $uptime_mins . " minutes " . intval($uptime_secs) . " seconds ";
							?>
							</font>
						</td>
					</tr>
				</table>
				<?php
			}
			?>
		</font>
	</body>
</html>
