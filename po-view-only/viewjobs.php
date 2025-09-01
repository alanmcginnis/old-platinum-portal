<html>
  <head>
    <a href="/"><img src="/images/Logo.png" width="182" height="82" alt="Platinum Industrial, Inc." /></a>
    <title>View Job / Phase / Category</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>

  <body>

  <h1>View Job / Phase / Category</h1>

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

$sql = "SELECT * FROM jobphasecat ORDER BY jobphasecat";

// get the records from the database
if ($result = $conn->query($sql))
{
// display records if there are records to display
if ($result->num_rows > 0)
{
// display records in a table
echo "<table border='1' cellpadding='10'>";

// set table headers
echo "<tr> <th>Job.Phase.Category</th> <th>Client</th> <th>Description</th> <th>Address</th> <th>City</th> <th>State</th> <th>Zip</th> <th>PM</th>";
// echo "<th></th><th></th>";
echo "</tr>";

while ($row = $result->fetch_object())
{
// set up a row for each record
echo "<tr>";
echo "<td>" . $row->jobphasecat . "</td>";
echo "<td>" . $row->client . "</td>";
echo "<td>" . $row->description . "</td>";
echo "<td>" . $row->add1 . "</td>";
echo "<td>" . $row->add2 . "</td>";
echo "<td>" . $row->add3 . "</td>";
echo "<td>" . $row->add4 . "</td>";
echo "<td>" . $row->pm . "</td>";
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

?>

</body>
</html>
