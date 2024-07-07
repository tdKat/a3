<?php
$conn = new mysqli('localhost', 'root', '', 'car_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT a.id, a.client_name, a.phone, a.car_license, a.appointment_date, m.name as mechanic_name
        FROM appointments a
        JOIN mechanics m ON a.mechanic_id = m.id";
$result = $conn->query($sql);

$appointments = [];
while($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

echo json_encode($appointments);
$conn->close();
?>
