<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mechanic_name = $_POST['mechanic_name'];
$daily_limit = $_POST['daily_limit'];

$sql = "INSERT INTO mechanics (name, daily_limit) VALUES ('$mechanic_name', $daily_limit)";

$response = array();
if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
}

echo json_encode($response);

$conn->close();
?>
