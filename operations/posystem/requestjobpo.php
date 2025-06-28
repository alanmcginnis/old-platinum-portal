<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

  $vendorErr = $jobphasecatErr = $employeeErr = $descriptionErr = $priceErr = "";
  $vendor = $jobphasecat = $employee = $description = $price = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;
    if (empty($_POST["vendor"])) {
      $vendorErr = "Missing";
      $valid = false;
    }
    else {
      $vendor = $_POST["vendor"];
	  $vendor = substr($vendor,0,30);
    }

    if (empty($_POST["jobphasecat"])) {
      $jobphasecatErr = "Missing";
      $valid = false;
    }
    else {
      $jobphasecat = $_POST["jobphasecat"];
	  $jobphasecat = substr($jobphasecat,0,70);
	  
    }

    if (empty($_POST["employee"])) {
      $employeeErr = "Missing";
      $valid = false;
    }
    else {
      $employee = $_POST["employee"];
	  $employee = substr($employee,0,30);
    }

    if (empty($_POST["description"])) {
      $descriptionErr = "Missing";
      $valid = false;
    }
    else {
      $description = $_POST["description"];
	  $description = substr($description,0,30);
    }

    if ($valid) {

// START OF POSUBMIT.PHP
	  header("refresh:20;url=viewjobposbydate.php");
      echo "<h1>Purchase Order Submitted</h1>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $vendor = test_input($_POST["vendor"]);
          $jobphasecat = test_input($_POST["jobphasecat"]);
          $jobnumber = substr($jobphasecat,0,4);
          $employee = test_input($_POST["employee"]);
          $description = test_input($_POST["description"]);
          $price = test_input($_POST["price"]);
        }

        include('../../dbconnectpath.php');

        $Conf = new DBConn;

        // Create connection
        $conn = mysqli_connect($Conf->servername, $Conf->username, $Conf->password, $Conf->dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO newpos (vendor, jobnumber, jobphasecat, emp, description, price, timestamp)
            VALUES ('" . $vendor . "','" . $jobnumber . "','" . $jobphasecat . "','" . $employee . "','" . $description . "','" . $price . "', now())";

        if ($result = $conn->query($sql)) {
          echo "Your PO # for:<br><br>" . $vendor . ", " . $jobphasecat . ", " . $employee . ", " . $description . ", " . $price . "<br><br>";
          echo "is: ".$jobnumber.".".str_pad($conn->insert_id,3,"0",STR_PAD_LEFT);;
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

// END OF POSUBMIT.PHP

      exit();
    }
  }
?>
<html>
  <head>
    <img src="/images/Logo.png" width="182" height="82" alt="Platinum Industrial, Inc." />
    <title>Request Purchase Order</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <style>
      .error {color: #FF0000;}
    </style>
  </head>

  <body>
    <h1>Request Purchase Order</h1>
    <p style="color:red">If this vendor will be performing any work onsite, <a href="/neweeportal.html">request a subcontract</a> in place of a purchase order.</p>
    <?php
    include('../../dbconnectpath.php');

	$Conf = new DBConn;

	// Create connection
	$conn = mysqli_connect($Conf->servername, $Conf->username, $Conf->password, $Conf->dbname);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table>
    <tr>
	<td>
		<label for="vendor">Vendor:</label>
		<select name="vendor" id="vendor" value="<?php echo htmlspecialchars($vendor);?>">
			<?php
			$sql = "SELECT * FROM vendors ORDER BY name ASC";
			if (empty($vendor)) {
				echo "<option disabled selected value></option>";
			}
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo "<option></option>";
				// Output data of each row
				while($row = $result->fetch_assoc()) {
					echo "<option>" . $row["name"] . "</option>";
				}
				echo "<option>New vendor</option>";
			} else {
				echo "0 results";
			}
			?>
		</select>
		<span class="error"><?php echo $vendorErr;?></span>
	</td>
	</tr>

	<tr>
	<td>
	<label for="jobphasecat">Job:</label>
	<select name="jobphasecat" id="jobphasecat" value="<?php echo htmlspecialchars($jobphasecat);?>">
	<?php
	$sql = "SELECT * FROM jobphasecat ORDER BY jobphasecat ASC";
	if (empty($jobphasecat)) {
	  echo "<option disabled selected value></option>";
	}
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// Output data of each row
		echo "<option></option>";
		while($row = $result->fetch_assoc()) {
		  echo "<option>" . $row["jobphasecat"] . " - " . $row["description"] . "</option>";
		}
	  } else {
		echo "0 results";
	  }
	?>
	</select>
	<span class="error"><?php echo $jobphasecatErr;?></span>
	</td>
	</tr>

	<tr>
	<td>
	 <label for="employee">Employee:</label>
	  <select name="employee" id="employee" value="<?php echo htmlspecialchars($employee);?>">
		<?php
		  $sql = "SELECT name FROM employees ORDER BY name ASC";
		  if (empty($employee)) {
			echo "<option disabled selected value></option>";
		  }
		  $result = $conn->query($sql);
		  if ($result->num_rows > 0) {
			  // Output data of each row
			  echo "<option></option>";
			  while($row = $result->fetch_assoc()) {
				echo "<option>" . $row["name"] . "</option>";
			  }
			} else {
			  echo "0 results";
			}
		?>
	  </select>
	  <span class="error"><?php echo $employeeErr;?></span>
	</td>
	</tr>

	<tr>
	<td>
	 <label for="description">Description:</label>
	  <input type="text" id="description" name="description" maxlength="30"> (max 30 char)
	<span class="error"><?php echo $descriptionErr;?></span>
	</td>
	</tr>

	<tr>
	<td>
	 <label for="price">Price:</label>
	  <input type="text" id="price" name="price" onkeypress="return isNumberKey(event)" maxlength="10"> (max 10 char)
	  <span class="error"><?php echo $priceErr;?></span>
	</td>
	</tr>

    <?php
      $conn->close();
    ?>

    </table>
    <input type="submit">
    </form>

<?php

include('../../footer_posystem.php');

?>

</body>

</html>
