<html>
  <head>
    <img src="/images/Logo.png" width="182" height="82" alt="Platinum Industrial, Inc." />
    <title>View Purchase Orders</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>

  <body>

  <h1>View Purchase Orders</h1>

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

$sql = "SELECT * FROM newpos WHERE display='Y' ORDER BY jobnumber DESC, ponum DESC";

// get the records from the database
if ($result = $conn->query($sql))
{
// display records if there are records to display
if ($result->num_rows > 0)
{
// display records in a table
echo "<table border='1' cellpadding='10'>";

// set table headers
echo "<tr><th>PO #</th><th>Vendor</th><th>Job.Phase.Category</th><th>Description</th><th>Employee</th><th>Price</th><th>Date / Time</th>";
// echo "<th></th><th></th>";
echo "</tr>";

while ($row = $result->fetch_object())
{
// set up a row for each record
echo "<tr>";
echo "<td>" . $row->jobnumber . "." . $row->ponum . "</td>";
echo "<td>" . $row->vendor . "</td>";
echo "<td>" . $row->jobphasecat . "</td>";
echo "<td>" . $row->description . "</td>";
echo "<td>" . $row->emp . "</td>";
echo "<td>" . $row->price . "</td>";
echo "<td>" . $row->timestamp . "</td>";
echo "</tr>";
}

echo "</table>";
}
// if there are no records in the database, display an alert message
else
{
echo "No results to display!";
}
}
// show an error if there is an issue with the database query
else
{
echo "Error: " . $conn->error;
}

// close database connection
$conn->close();

include('../footer_posystem.php');

?>

</body>
</html>
