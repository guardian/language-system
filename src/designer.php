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

			if (isset($_GET['remove'])) {
				if ($_GET['remove'] == 'yes') {
						$sql = "DELETE FROM complex WHERE id='".$_GET['row']."'";
						mysqli_query($database, $sql);
				}
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if($_POST['Sub'] == 'Change Name') {
					$sql = "UPDATE complex SET name='".$_POST['newname']."' WHERE name='".$_GET['name']."'";
					mysqli_query($database, $sql);
					header('Location: designer.php?name='.$_POST['newname']);
				}
				if($_POST['Sub'] == 'Update Data') {
					$starthere = $_POST['rowstart'];
					$finishhere = $_POST['rowfinish'];
					$currentplace = $starthere;
					while ($currentplace <= $finishhere) {
						if (isset($_POST['step'.$currentplace])) {
							$sql = "UPDATE complex SET step='".$_POST['step'.$currentplace]."', job='".$_POST['job'.$currentplace]."', input1='".$_POST['input1_'.$currentplace]."', input2='".$_POST['input2_'.$currentplace]."', input3='".$_POST['input3_'.$currentplace]."', input4='".$_POST['input4_'.$currentplace]."', input5='".$_POST['input5_'.$currentplace]."', input6='".$_POST['input6_'.$currentplace]."', input7='".$_POST['input7_'.$currentplace]."', input8='".$_POST['input8_'.$currentplace]."', previous='".$_POST['previous'.$currentplace]."', set1='".$_POST['set1_'.$currentplace]."', set2='".$_POST['set2_'.$currentplace]."', set3='".$_POST['set3_'.$currentplace]."', set4='".$_POST['set4_'.$currentplace]."', set5='".$_POST['set5_'.$currentplace]."', set6='".$_POST['set6_'.$currentplace]."', set7='".$_POST['set7_'.$currentplace]."', set8='".$_POST['set8_'.$currentplace]."' WHERE id='".$currentplace."'";
							mysqli_query($database, $sql);
						}
						$currentplace++;
					}
				}
				if($_POST['Sub'] == 'New Step') {
					$result=mysqli_query($database, "SELECT count(*) as total from complex WHERE name='".$_GET['name']."'");
					$data=mysqli_fetch_assoc($result);
					$sql = "INSERT INTO complex (name,step) VALUES ('".$_GET['name']."','".($data['total']+1)."')";
					mysqli_query($database, $sql);
				}
				if($_POST['Sub'] == 'Delete Job') {
					$sql = "DELETE FROM complex WHERE name='".$_GET['name']."'";
					mysqli_query($database, $sql);
					header('Location: designer_menu.php');
				}
			}

			include('navigation.php');
			?>
			<br /><br />
			<form action="" method="POST">
				<input type="text" size="80" name="newname" value="<?php echo $_GET['name'];?>">
				<input type="submit" name="Sub" value="Change Name">
			</form>
			<br />
			<form action="" method="POST">
			<table cellspacing="12">
				<tr>
					<th>
						Step
					</th>
					<th>
						Job
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
						Previous
					</th>
					<th>
						Set 1
					</th>
					<th>
						Set 2
					</th>
					<th>
						Set 3
					</th>
					<th>
						Set 4
					</th>
					<th>
						Set 5
					</th>
					<th>
						Set 6
					</th>
					<th>
						Set 7
					</th>
					<th>
						Set 8
					</th>
				</tr>

			<?php
			$result = mysqli_query($database, "SELECT * FROM complex WHERE name='".$_GET['name']."' ORDER BY id");
			$firstloop = 1;
			while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
				echo '<tr><td>';
				if ($firstloop == 1) {
					echo '<input type="hidden" name="rowstart" value="'.$row[0].'">';
					$firstloop = 0;
				}
				echo '<input type="text" size="5" name="step'.$row[0].'" value="'.$row[2].'"></td>
				<td>
				<select name="job'.$row[0].'">
					<option value="'.$row[3].'">'.$row[3].'</option>';

					$cdir = scandir('jobs');
			    foreach ($cdir as $key => $value)
			    {
			       if (!in_array($value,array(".","..","complex.php")))
			       {
								echo '<option value="'.$value.'">'.$value.'</option>';
			       }
			    }

				echo '</select>
				</td>
				<td><input type="text" size="1" name="input1_'.$row[0].'" value="'.$row[4].'"></td>
				<td><input type="text" size="1" name="input2_'.$row[0].'" value="'.$row[5].'"></td>
				<td><input type="text" size="1" name="input3_'.$row[0].'" value="'.$row[6].'"></td>
				<td><input type="text" size="1" name="input4_'.$row[0].'" value="'.$row[7].'"></td>
				<td><input type="text" size="1" name="input5_'.$row[0].'" value="'.$row[8].'"></td>
				<td><input type="text" size="1" name="input6_'.$row[0].'" value="'.$row[9].'"></td>
				<td><input type="text" size="1" name="input7_'.$row[0].'" value="'.$row[10].'"></td>
				<td><input type="text" size="1" name="input8_'.$row[0].'" value="'.$row[11].'"></td>
				<td><input type="text" size="3" name="previous'.$row[0].'" value="'.$row[12].'"></td>
				<td><input type="text" size="8" name="set1_'.$row[0].'" value="'.$row[13].'"></td>
				<td><input type="text" size="8" name="set2_'.$row[0].'" value="'.$row[14].'"></td>
				<td><input type="text" size="8" name="set3_'.$row[0].'" value="'.$row[15].'"></td>
				<td><input type="text" size="8" name="set4_'.$row[0].'" value="'.$row[16].'"></td>
				<td><input type="text" size="8" name="set5_'.$row[0].'" value="'.$row[17].'"></td>
				<td><input type="text" size="8" name="set6_'.$row[0].'" value="'.$row[18].'"></td>
				<td><input type="text" size="8" name="set7_'.$row[0].'" value="'.$row[19].'"></td>
				<td><input type="text" size="8" name="set8_'.$row[0].'" value="'.$row[20].'"></td>
				<td><button><a class="complex" href="?name='.$_GET['name'].'&remove=yes&row='.$row[0].'">Remove Step</a></button></td>';
				echo '</tr>';
				$lastrow = $row[0];
			}

			?>
			</table>
				<?php
				echo '<input type="hidden" name="rowfinish" value="'.$lastrow.'">';
				?>
				<input type="submit" name="Sub" value="Update Data">
			</form>
			<br />
			<form action="" method="POST">
				<input type="submit" name="Sub" value="New Step">
			</form>
			<br /><br /><br />
			<form action="" method="POST">
				<input type="submit" name="Sub" value="Delete Job">
			</form>
		</font>
	</body>
</html>
