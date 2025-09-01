<html>
  <head>
    <a href="/"><img src="/images/Logo.png" width="182" height="82" alt="Platinum Industrial, Inc." /></a>
    <title>View GL Codes</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>

  <body>

  <h1>View GL Codes</h1>

<!--  <p><b>View All</b> | <a href="viewjobs-pg.php">View Paginated</a></p> -->

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

$sql = "SELECT * FROM glcodes ORDER BY glcode";

// get the records from the database
if ($result = $conn->query($sql))
{
// display records if there are records to display
if ($result->num_rows > 0)
{
// display records in a table
echo "<table border='1' cellpadding='10'>";

// set table headers
echo "<tr><th>GL Code</th><th>Description</th>";
// echo "<th></th><th></th>";
echo "</tr>";

while ($row = $result->fetch_object())
{
// set up a row for each record
echo "<tr>";
echo "<td>" . $row->glcode . "</td>";
echo "<td>" . $row->name . "</td>";
// echo "<td><a href='records.php?id=" . $row->jobphasecat . "'>Edit</a></td>";
// echo "<td><a href='delete.php?id=" . $row->jobphasecat . "'>Delete</a></td>";
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
echo "Error: " . $mysqli->error;
}

?>

<?php
  include('../footer_posystem.php');
?>

</body>
</html>
