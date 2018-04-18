<?php
include("dbconfig.php");
include("header.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT name,email,credit FROM users";
$result = $conn->query($sql);

echo '<center><table style="width:50%; margin-top:10px" class="table table-hover"><tr><th>Name</th><th>Email</th><th>Credit</th></tr>';


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["credit"]. "</td></tr>";
    } echo "</table><a href='view.php' class='btn btn-default'>Transfer Credit</a></center>";
} else {
    echo "0 results";
}
$conn->close();
?>
<?php include("footer.php") ?>