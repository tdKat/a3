<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mechanic_id = $data['id'];
$daily_limit = $data['daily_limit'];

$sql = "UPDATE mechanics SET daily_limit=$daily_limit WHERE id=$mechanic_id";

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
