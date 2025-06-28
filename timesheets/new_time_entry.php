<?php

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$week_endingErr = $timestampErr = $mmErr = $ddErr = $yyyyErr = $nameErr = $jobErr = $phaseErr = $categoryErr = $straightErr = $overErr = $doubleErr = $locationErr = $notesErr = $entered_byErr = $curr_or_prevErr = "";
$week_ending = $timestamp = $mm = $dd = $yyyy = $name = $job = $phase = $category = $straight = $over = $double = $location = $notes = $entered_by = $curr_or_prev = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$valid = true;
    
	if (empty($_POST["week_ending"])) {
		$week_endingErr = "Missing";
		$valid = false;
	}
    else {
		$week_ending = $_POST["week_ending"];
    }

    if (empty($_POST["timestamp"])) {
		$timestampErr = "Missing";
		$valid = false;
	}
    else {
		$timestamp = $_POST["timestamp"];
    }

    if (empty($_POST["mm"])) {
		$mmErr = "Missing";
		$valid = false;
	}
    else {
		$mm = $_POST["mm"];
    }

    if (empty($_POST["dd"])) {
		$ddErr = "Missing";
		$valid = false;
	}
    else {
		$dd = $_POST["dd"];
    }

    if (empty($_POST["yyyy"])) {
		$yyyyErr = "Missing";
		$valid = false;
	}
    else {
		$yyyy = $_POST["yyyy"];
    }

    if (empty($_POST["name"])) {
		$nameErr = "Missing";
		$valid = false;
	}
    else {
		$name = $_POST["name"];
    }

    if (empty($_POST["job"])) {
		$jobErr = "Missing";
		$valid = false;
	}
    else {
		$job = $_POST["job"];
    }

    if (empty($_POST["phase"])) {
		$phaseErr = "Missing";
		$valid = false;
	}
    else {
		$phase = $_POST["phase"];
    }

    if (empty($_POST["category"])) {
		$categoryErr = "Missing";
		$valid = false;
	}
    else {
		$category = $_POST["category"];
    }

    if (empty($_POST["straight"])) {
		$straightErr = "Missing";
		$valid = false;
	}
    else {
		$straight = $_POST["straight"];
    }

    if (empty($_POST["over"])) {
		$overErr = "Missing";
		$valid = false;
	}
    else {
		$over = $_POST["over"];
    }

    if (empty($_POST["double"])) {
		$doubleErr = "Missing";
		$valid = false;
	}
    else {
		$double = $_POST["double"];
    }

    if (empty($_POST["location"])) {
		$locationErr = "Missing";
		$valid = false;
	}
    else {
		$location = $_POST["location"];
    }

    if (empty($_POST["notes"])) {
		$notesErr = "Missing";
		$valid = false;
	}
    else {
		$notes = $_POST["notes"];
    }

    if (empty($_POST["entered_by"])) {
		$entered_byErr = "Missing";
		$valid = false;
	}
    else {
		$entered_by = $_POST["entered_by"];
    }

    if (empty($_POST["curr_or_prev"])) {
		$curr_or_prevErr = "Missing";
		$valid = false;
	}
    else {
		$curr_or_prev = $_POST["curr_or_prev"];
    }

    if ($valid) {
		echo "<h1>New Time Entry Complete</h1>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$week_ending = test_input($_POST["week_ending"]);
			$timestamp = test_input($_POST["timestamp"]);
			$mm = test_input($_POST["mm"]);
			$dd = test_input($_POST["dd"]);
			$yyyy = test_input($_POST["yyyy"]);
			$name = test_input($_POST["name"]);
			$job = test_input($_POST["job"]);
			$phase = test_input($_POST["phase"]);
			$category = test_input($_POST["category"]);
			$straight = test_input($_POST["straight"]);
			$over = test_input($_POST["over"]);
			$double = test_input($_POST["double"]);
			$location = test_input($_POST["location"]);
			$notes = test_input($_POST["notes"]);
			$entered_by = test_input($_POST["entered_by"]);
			$curr_or_prev = test_input($_POST["curr_or_prev"]);
        }

        $servername = "localhost";
        $username = "timeadmin";
        $password = "0bxambzz8HyrNvUm6HIc";
        $dbname = "platinumind_timesheet";

        //	Create connection
        
		$conn = new mysqli($servername, $username, $password, $dbname);

        //	Check connection
        
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO timesheets (week_ending, timestamp, mm, dd, yyyy, name, job, phase, category, straight, over, double, location, notes, entered_by, curr_or_prev) VALUES ('" . $week_ending . "','" . $timestamp . "','" . $mm . "','" . $dd . "','" . $yyyy . "','" . $job . "','" . $name . "','" . $phase . "','" . $category . "','" . $straight . "','" . $over . "','" . $double . "','" . $location . "','" . $notes . "','" . $entered_by . "','" . $curr_or_prev . "')";

        if ($result = $conn->query($sql)) {
			echo "Your time sheet for:<br><br>" . $name . " for " . $mm . $dd . $yyyy . " for $straight straight, $over over, and $double double is complete";
        }
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

		echo "<h3><a href=\"http:\/\/platinumind.com/posystem/new_time_entry.php\">Enter additional time</a></h3>";
		exit();
    }
}
?>
<html>
	<head>
		<img src="../images/Logo.2013.05.06.png" width="182" height="82" alt="Platinum Industrial, Inc." />
		<title>Enter new timesheet</title>
		<link rel="stylesheet" type="text/css" href="default_style.css">
		<style>.error {color: #FF0000;}</style>
	</head>
	<body>
		<h1>Enter new timesheet</h1>
			<?php
			$servername = "localhost";
			$username = "timeadmin";
			$password = "0bxambzz8HyrNvUm6HIc";
			$dbname = "platinumind_timesheet";

			//	Create connection
			
			$conn = new mysqli($servername, $username, $password, $dbname);

			//	Check connection
			
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			?>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table>
				<tr>
					<td>
						<b>Week Ending:</b>
					</td>
					<td>
						<?php
						
						try {
							$tmp_week = new DateTime();								
						}
						catch (Exception $e) {
							echo $e->getMessage();
							exit(1);
						}
						
						$day_of_week = date('l', strtotime($tmp_week->format('m-d-Y')));
						
						while ($day_of_week != 'Sunday') {
							$tmp_week->sub(new DateInterval('P1D'));
							$day_of_week = date('l', strtotime($tmp_week->format('m-d-Y')));
						}
						
						$tmp_week->add(new DateInterval('P1D'));

						?>
						<select name="week_ending" value="<?php echo htmlspecialchars($week_ending);?>">
						<option></option>
						<option><?php echo $tmp_week->format('m-d-Y');?></option>
						<option><?php echo $tmp_week->add(new DateInterval('P7D'))->format('m-d-Y');?></option>
						</select>
						<span class="error"><?php echo $week_endingErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<b>Date Worked:</b>
					</td>
					<td>
						<select name="date_worked" value="<?php echo htmlspecialchars($date_worked);?>">
						<option></option>
						<option><?php echo $tmp_week->format('m-d-Y');?></option>
							<?php
							
							for ($count = 1 ; $count <= 13 ; $count++) {
								$tmp_day{$count} = $tmp_week->sub(new DateInterval('P1D'))->format('m-d-Y');
								echo "<option>" . $tmp_day{$count} . "</option>";
							}
							
							?>
						</select>
						<span class="error"><?php echo $mmErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<b>Employee:</b>
					</td>
					<td>
						<select name="name" value="<?php echo htmlspecialchars($name);?>">
						<option></option>
						<?php
						$sql = "SELECT * FROM employees WHERE active='X' ORDER BY name ASC";
						$result = $conn->query($sql);
						
						if ($result->num_rows > 0) {
							
							//	Output data of each row
							
							while($row = $result->fetch_assoc()) {
								echo "<option>" . $row["name"] . "</option>";
							}
						}
						else {
							echo "0 results";
						}
						
						?>		
						</select>
						<span class="error"><?php echo $nameErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<b>Job, Phase, and Category:</b>
					</td>
					<td>
						<select name="jobphasecat" value="<?php echo htmlspecialchars($jobphasecat);?>">
						<option></option>
						</select>
						<span class="error"><?php echo $jobphasecatErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<b>Straight:</b>
					</td>
					<td>
						<input type="text" name="straight" onkeypress="return isNumberKey(event)" maxlength="2" value="<?php echo htmlspecialchars($straight);?>">
						<span class="error"><?php echo $straightErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<b>Over:</b>
					</td>
					<td>
						<input type="text" name="over" onkeypress="return isNumberKey(event)" maxlength="2" value="<?php echo htmlspecialchars($over);?>">
						<span class="error"><?php echo $straightErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<b>Double:</b>
					</td>
					<td>
						<select name="double" value="<?php echo htmlspecialchars($double);?>">
						<option></option>
						</select>
						<span class="error"><?php echo $doubleErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						Notes:
					</td>
					<td>
						<input type="text" name="notes" onkeypress="return isNumberKey(event)" maxlength="255" value="<?php echo htmlspecialchars($description);?>"> (max 255 char)
						<span class="error"><?php echo $notesErr;?></span>
					</td>
				</tr>
				<?php
				$conn->close();
				?>
			</table>
			<input type="submit">
		</form>
		<a href="view_timesheets.php">View existing time sheets for this week</a><br>
		<a href="edit_timesheets.php">Edit existing time sheets for this week</a>
	</body>
</html>