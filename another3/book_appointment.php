<?php
$conn = new mysqli('localhost', 'root', '', 'car_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$client_name = $_POST['name'];
$phone = $_POST['phone'];
$car_color = $_POST['car_color'];
$car_license = $_POST['car_license'];
$car_engine_number = $_POST['car_engine_number'];
$appointment_date = $_POST['appointment_date'];
$mechanic_id = $_POST['mechanic_id'];

$check = "SELECT COUNT(*) as count FROM appointments WHERE mechanic_id = $mechanic_id AND appointment_date = $appointment_date;";
$stmt = $conn->prepare($check);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

$daily_limit = "SELECT daily_limit FROM mechanics WHERE id = $mechanic_id";
$stmt = $conn->prepare($daily_limit);
$stmt->execute();
$result = $stmt->get_result();
$mechanic = $result->fetch_assoc();
$stmt->close();

if ($row >= $mechanic) {
    echo json_encode(["success" => false, "message" => "Mechanic is fully booked on this date."]);
    $conn->close();
    exit();
}

$sql = "INSERT INTO appointments (client_name, phone, car_color, car_license, car_engine_number, appointment_date, mechanic_id) VALUES ($client_name, $phone, $car_color, $car_license, $car_engine_number, $appointment_date, $mechanic_id);";
$stmt = $conn->prepare($sql);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to book appointment."]);
}

$stmt->close();
$conn->close();
?>
