<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, daily_limit FROM mechanics;";
$result = $conn->query($sql);

$mechanics = array();
while ($row = $result->fetch_assoc()) {
    $mechanics[] = $row;
}

echo json_encode($mechanics);

$conn->close();
?>
