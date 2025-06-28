<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

  $vendorErr = $glcodeErr = $employeeErr = $descriptionErr = $priceErr = "";
  $vendor = $glcode = $employee = $description = $price = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;
    if (empty($_POST["vendor"])) {
      $vendorErr = "Missing";
      $valid = false;
    }
    else {
      $vendor = $_POST["vendor"];
    }

    if (empty($_POST["glcode"])) {
      $glcodeErr = "Missing";
      $valid = false;
    }
    else {
      $glcode = $_POST["glcode"];
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

    if ($valid) {

// START OF POSUBMIT.PHP
      echo "<h1>Purchase Order Submitted</h1>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $vendor = test_input($_POST["vendor"]);
          $glcode = test_input($_POST["glcode"]);
          $employee = test_input($_POST["employee"]);
          $description = test_input($_POST["description"]);
          $price = test_input($_POST["price"]);
        }

        include('../dbconnectpath.php');

        $Conf = new DBConn;

        // Create connection
        $conn = mysqli_connect($Conf->servername, $Conf->username, $Conf->password, $Conf->dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO ohpos (vendor, glcode, emp, description, price, timestamp)
            VALUES ('" . $vendor . "','" . $glcode . "','" . $employee . "','" . $description . "','" . $price . "', now())";

        if ($result = $conn->query($sql)) {
          echo "Your PO # for:<br><br>" . $vendor . ", " . $glcode . ", " . $employee . ", " . $description . ", " . $price . "<br><br>";
          echo "is: ".$conn->insert_id;
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

      echo "<h3><a href=\"/neweeportal.html\">Employee portal</a></h3>";
// END OF POSUBMIT.PHP

      exit();
    }
  }
?>
<html>
  <head>
    <img src="/images/Logo.png" width="182" height="82" alt="Platinum Industrial, Inc." />
    <title>Request Overhead Purchase Order</title>
    <link rel="stylesheet" type="text/css" href="default_style.css">
    <style>
      .error {color: #FF0000;}
    </style>
  </head>

  <body>
    <h1>Request Overhead Purchase Order</h1>
    <?php
      // connect to the database
        include('../dbconnectpath.php');

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
      Vendor:
    </td>
    <td>
      <select name="vendor" value="<?php echo htmlspecialchars($vendor);?>">
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
      GL Code:
      </td>
      <td>
      <select name="glcode" value="<?php echo htmlspecialchars($glcode);?>">
      <?php
        $sql = "SELECT * FROM glcodes ORDER BY glcode ASC";
        if (empty($glcode)) {
          echo "<option disabled selected value></option>";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
              echo "<option>" . $row["glcode"] . " - " . $row["name"] . "</option>";
            }
          } else {
            echo "0 results";
          }
      ?>
      </select>
      <span class="error"><?php echo $glcodeErr;?></span>
      </td>
      </tr>

      <tr>
        <td>
          Employee:
        </td>
        <td>
          <select name="employee" value="<?php echo htmlspecialchars($employee);?>">
            <?php
              $sql = "SELECT name FROM employees ORDER BY name ASC";
              if (empty($employee)) {
                echo "<option disabled selected value></option>";
              }
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  // Output data of each row
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
          Description:
        </td>
        <td>
          <input type="text" name="description" onkeypress="return isNumberKey(event)" maxlength="30" value="<?php echo htmlspecialchars($description);?>"> (max 30 char)
          <span class="error"><?php echo $descriptionErr;?></span>
        </td>
      </tr>

      <tr>
        <td>
          Price:
        </td>
        <td>
          <input type="text" name="price" onkeypress="return isNumberKey(event)" maxlength="9"> (max 9 char)
        </td>
      </tr>

    <?php
      $conn->close();
    ?>

    </table>
    <input type="submit">
    </form>

    <?php
      include('../footer_posystem.php');
    ?>

  </body>

</html>
