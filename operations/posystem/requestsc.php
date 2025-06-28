<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

  $subcontractorErr = $jobnumberErr = $jobphasecatErr = $employeeErr = $descriptionErr = $priceErr = $contactErr = $other_contactErr = $start_dateErr = $typeErr = "";
  $subcontractor = $jobnumber = $jobphasecat = $employee = $description = $price = $contact = $other_contact = $start_date = $type = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;
    if (empty($_POST["subcontractor"])) {
      $subcontractorErr = "Missing";
      $valid = false;
    }
    else {
      $subcontractor = $_POST["subcontractor"];
    }

    if (empty($_POST["jobphasecat"])) {
      $jobphasecatErr = "Missing";
      $valid = false;
    }
    else {
      $jobphasecat = $_POST["jobphasecat"];
	  $job = substr($jobphasecat,0,4);
    }

    if (empty($_POST["employee"])) {
      $employeeErr = "Missing";
      $valid = false;
    }
    else {
      $employee = $_POST["employee"];
    }

    if (empty($_POST["description"])) {
      $descriptionErr = "Missing";
      $valid = false;
    }
    else {
      $description = $_POST["description"];
    }

    if (empty($_POST["contact"])) {
      $contactErr = "Contact missing";
      $valid = false;
    }
    else {
      $contact = $_POST["contact"];
    }

	if (empty($_POST["other_contact"]) and $contact == "Other") {
      $other_contactErr = "Missing";
      $valid = false;
    }
    else {
      $other_contact = $_POST["other_contact"];
    }

    if (empty($_POST["start_date"])) {
      $start_dateErr = "Missing";
      $valid = false;
    }
    else {
      $start_date = $_POST["start_date"];
    }

    if (empty($_POST["type"])) {
      $typeErr = "Missing";
      $valid = false;
    }
    else {
      $type = $_POST["type"];
    }

    if ($valid) {

// START OF SCSUBMIT.PHP
	  header("refresh:20;url=viewscsbydate.php");
      echo "<h1>Subcontract Request Submitted</h1>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$subcontractor = test_input($_POST["subcontractor"]);
			$jobphasecat = test_input($_POST["jobphasecat"]);
			$jobnumber = substr($jobphasecat,0,4);
			$employee = test_input($_POST["employee"]);
			$description = test_input($_POST["description"]);
			$description = substr($description,0,255);
			$price = test_input($_POST["price"]);
			$contact = test_input($_POST["contact"]);
			$other_contact = test_input($_POST["other_contact"]);
			$start_date = test_input($_POST["start_date"]);
			$type =test_input($_POST["type"]);
        }

        include('../../dbconnectpath.php');

        $Conf = new DBConn;

        // Create connection
        $conn = mysqli_connect($Conf->servername, $Conf->username, $Conf->password, $Conf->dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO scs (subcontractor, jobnumber, jobphasecat, description, employee, price, contact, other_contact, start_date, type, timestamp)
            VALUES ('" . $subcontractor . "','" . $jobnumber . "','" . $jobphasecat . "','" . $description . "','" . $employee . "','" . $price . "','" . $contact . "','" . $other_contact . "','" . $start_date . "','" . $type . "', now())";

        if ($result = $conn->query($sql)) {
			if($contact=="Other") {
				echo "Your SC # for:<br><br>Subcontractor: " . $subcontractor . "<br>Project: " . $jobphasecat . "<br>Scope: " . $description . "<br>Requested by: " . $employee . "<br>Contract amount: " . $price . "<br>Site contact: " . $other_contact . "<br>Start date: " . $start_date . "<br>Contract type: " . $type . "<br><br>";
			}
			else {
				echo "Your SC # for:<br><br><strong>Subcontractor: </strong>" . $subcontractor . "<br><strong>Project: </strong>" . $jobphasecat . "<br><strong>Scope: </strong>" . $description . "<br><strong>Requested by: </strong>" . $employee . "<br><strong>Contract amount: </strong>" . $price . "<br><strong>Site contact: </strong>" . $contact . "<br><strong>Start date: </strong>" . $start_date . "<br><strong>Contract type: </strong>" . $type . "<br><br>";
			}
		  echo "is: ".$jobnumber.".".str_pad($conn->insert_id,3,"0",STR_PAD_LEFT);
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

// END OF SCSUBMIT.PHP

      exit();
    }
  }
?>
<html>
  <head>
    <img src="/images/Logo.png" width="182" height="82" alt="Platinum Industrial, Inc." />
    <title>Request Subcontract</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <style>
      .error {color: #FF0000;}
    </style>
  </head>

  <body>
    <h1>Request Subcontract</h1>
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
	 <label for="subcontractor">Subcontractor:</label>
      <select name="subcontractor" id="subcontractor" value="<?php echo htmlspecialchars($subcontractor);?>">
      <?php
        $sql = "SELECT * FROM subcontractors ORDER BY name ASC";
        if (empty($subcontractor)) {
          echo "<option disabled selected value></option>";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Output data of each row
			echo "<option></option>";
			while($row = $result->fetch_assoc()) {
              echo "<option>" . $row["name"] . "</option>";
            }
			echo "<option>New vendor</option>";
          } else {
            echo "0 results";
          }
      ?>
      </select>
      <span class="error"><?php echo $subcontractorErr;?></span>
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
          <textarea id="description" name="description" rows="4" cols="50"></textarea> (max 255 char)
          <span class="error"><?php echo $descriptionErr;?></span>
        </td>
      </tr>

	  <tr>
        <td>
          <input type="radio" id="Lump Sum" name="type" value="Lump Sum">
		  <label for="Lump Sum">Lump Sum</label><br>
		  <input type="radio" id="T&M" name="type" value="T&M">
		  <label for="T&M">Time and Materials</label><br>
		  <span class="error"><?php echo $typeErr;?></span>
        </td>
      </tr>

      <tr>
        <td>
		 <label for="price">Price:</label>
          <input type="text" id="price" name="price" onkeypress="return isNumberKey(event)" maxlength="10"> (max 10 char)
		  <span class="error"><?php echo $priceErr;?></span>
        </td>
      </tr>

	  <tr>
        <td>
		 <label for="contact">Site Contact:</label>
          <select name="contact" id="contact" value="<?php echo htmlspecialchars($contact);?>">
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
				  echo "<option>Other</option>";
                } else {
                  echo "0 results";
                }
            ?>
          </select>
		  <span class="error"><?php echo $contactErr;?></span>
        </td>
      </tr>

	  <tr>
        <td>
		 <label for="price">If "Other":</label>
          <input type="text" id="other_contact" name="other_contact" onkeypress="return isNumberKey(event)" maxlength="30"> (max 30 char)
		  <span class="error"><?php echo $other_contactErr;?></span>
        </td>
      </tr>

	  <tr>
        <td>
		 <label for="start_date">Start Date:</label>
          <input type="date" id="start_date" name="start_date">
		  <span class="error"><?php echo $start_dateErr;?></span>
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
