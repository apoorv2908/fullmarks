<?php
header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");


$servername = "localhost";
$username = "mylogin123";
$password = "localhost";
$dbname = "fullmarks";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$school_name = $_POST['school_name'];
$class = $_POST['class'];
$student_name = $_POST['student_name'];
$password = $_POST['password'];
$email = $_POST['email'];
$contact_no = $_POST['contact_no'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$profilepic = $_FILES['profilepic']['name'];


// Combine email and contact number
$contact_info = "Email: $email, Contact No: $contact_no";

// Combine country, state, and city
$location_info = "Country: $country, State: $state, City: $city";

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO students (school_name, class, student_name, logo, password, contact_info, location_info) VALUES (?,?,?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $school_name, $class, $student_name, $profilepic, $password,  $contact_info, $location_info);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>
