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
			<?php
			if ($login_session_user_type != 'a') {
				echo 'You are not a logged in as an administrator.';
			} else {
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					if($_POST['Sub'] == 'Update Message') {
						$sql = "UPDATE settings SET text='".$_POST['message']."' WHERE name='front_page_message'";
						mysqli_query($database, $sql);
					}
					if($_POST['Sub'] == 'Change Quota') {
						$sql = "UPDATE settings SET number='".$_POST['quota']."' WHERE name='amazon_transcribe_quota'";
						mysqli_query($database, $sql);
					}
					if($_POST['Sub'] == 'Change Settings') {
						$sql = "UPDATE settings SET decimal_number='".$_POST['pounds']."' WHERE name='pounds_sterling_per_usa_dollar'";
						mysqli_query($database, $sql);
						$sql = "UPDATE settings SET decimal_number='".$_POST['euros']."' WHERE name='euros_per_usa_dollar'";
						mysqli_query($database, $sql);
					}
					if($_POST['Sub'] == 'Add') {
						mysqli_query($database, "INSERT INTO users (name,password,type) VALUES ('".$_POST['name']."','".$_POST['password']."','".$_POST['type']."')");
					}
				}
				?>
				<table cellspacing="8">
					<tr valign="top">
						<td>
							<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" size="-1">
								<div class="controlbox">
									<strong>Front Page Message</strong>
									<br />
									<br />
									<?php
									$result = mysqli_query($database, "SELECT text FROM settings where name = 'front_page_message'");
									$front_page_message = mysqli_fetch_array($result);
									?>
									<form class="form" action="" method="POST">
										<input name="message" type="text" hidden />
										<textarea name="message" rows="16" cols="64"><?php echo $front_page_message[0]; ?></textarea>
										<br />
										<br />
										<input type="submit" name="Sub" value="Update Message">
									</form>
								</div>
								<br />
								<br />
								<div class="controlbox">
									<strong>Amazon Transcibe Usage</strong>
									<br />
									<br />
									<?php
									$result2 = mysqli_query($database, "SELECT number FROM settings where name = 'amazon_transcribe_usage'");
									$amazon_transcribe_usage = mysqli_fetch_array($result2);
									?>
									Usage to date: <?php echo $amazon_transcribe_usage[0]; ?> seconds
									<br />
									<br />
									<?php
									$result4 = mysqli_query($database, "SELECT decimal_number FROM settings where name = 'amazon_transcribe_usa_dollar_cost'");
									$amazon_transcribe_usa_dollar_cost = mysqli_fetch_array($result4);
									$result5 = mysqli_query($database, "SELECT decimal_number FROM settings where name = 'pounds_sterling_per_usa_dollar'");
									$pounds_sterling_per_usa_dollar = mysqli_fetch_array($result5);
									$result6 = mysqli_query($database, "SELECT decimal_number FROM settings where name = 'euros_per_usa_dollar'");
									$euros_per_usa_dollar = mysqli_fetch_array($result6);
									?>
									Cost to date: $<?php echo (round($amazon_transcribe_usa_dollar_cost[0] * $amazon_transcribe_usage[0],2)); ?> / &pound;<?php echo (round($amazon_transcribe_usa_dollar_cost[0] * $amazon_transcribe_usage[0] * $pounds_sterling_per_usa_dollar[0], 2)); ?> / &euro;<?php echo (round($amazon_transcribe_usa_dollar_cost[0] * $amazon_transcribe_usage[0] * $euros_per_usa_dollar[0], 2)); ?>
									<br />
									<br />
									<?php
									$result3 = mysqli_query($database, "SELECT number FROM settings where name = 'amazon_transcribe_quota'");
									$amazon_transcribe_quota = mysqli_fetch_array($result3);
									?>
									Quota: <?php echo $amazon_transcribe_quota[0]; ?> seconds
									<br />
									<br />
									Cost of quota: $<?php echo (round($amazon_transcribe_usa_dollar_cost[0] * $amazon_transcribe_quota[0],2)); ?> / &pound;<?php echo (round($amazon_transcribe_usa_dollar_cost[0] * $amazon_transcribe_quota[0] * $pounds_sterling_per_usa_dollar[0], 2)); ?> / &euro;<?php echo (round($amazon_transcribe_usa_dollar_cost[0] * $amazon_transcribe_quota[0] * $euros_per_usa_dollar[0], 2)); ?>
									<br />
									<br />
									<form class="form" action="" method="POST">
										New quota: <input name="quota" type="text" size="10" value="<?php echo $amazon_transcribe_quota[0]; ?>">
										<br />
										<br />
										<input type="submit" name="Sub" value="Change Quota">
									</form>
								</div>
							</font>
						</td>
						<td>
							<font face="Century Gothic,Avant Garde,Apple Gothic,AppleGothic,URW Gothic L,Avant Garde,Futura,sans-serif" size="-1">
								<div class="controlbox">
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
								</div>
								<br />
								<div class="controlbox">
									<strong>Currency Conversion</strong>
									<br />
									<br />
									<form class="form" action="" method="POST">
										Pounds Sterling per USA Dollar: <?php echo round($pounds_sterling_per_usa_dollar[0], 2); ?>
										<br />
										<br />
										New setting: <input name="pounds" type="text" size="4" value="<?php echo round($pounds_sterling_per_usa_dollar[0], 2); ?>">
										<br />
										<br />
										<br />
										Euros per USA Dollar: <?php echo round($euros_per_usa_dollar[0], 2); ?>
										<br />
										<br />
										New setting: <input name="euros" type="text" size="4" value="<?php echo round($euros_per_usa_dollar[0], 2); ?>">
										<br />
										<br />
										<input type="submit" name="Sub" value="Change Settings">
									</form>
								</div>
								<br />
								<div class="controlbox">
									<strong>Add User</strong>
									<br />
									<br />
									<form class="form" action="" method="POST">
										Name: <input name="name" type="text" size="20" value="">
										<br />
										<br />
										Password: <input name="password" type="text" size="20" value="">
										<br />
										<br />
										Type: <select name="type">
											<option value="u">User</option>
											<option value="p">Power User</option>
											<option value="a">Administrator</option>
										</select>
										<br />
										<br />
										<input type="submit" name="Sub" value="Add">
									</form>
								</div>
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
