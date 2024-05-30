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

$company_name = $_POST['company_name'];
$school_name = $_POST['school_name'];
$teacher_name = $_POST['teacher_name'];
$password = $_POST['password'];
$email = $_POST['email'];
$contact_no = $_POST['contact_no'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$zipcode = $_POST['zipcode'];


// Upload logo file
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["logo"]["name"]);
move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);

// Combine email and contact number
$contact_info = "Email: $email, Contact No: $contact_no";

// Combine country, state, and city
$location_info = "Country: $country, State: $state, City: $city";

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO teachers (company_name, teacher_name, school_name, password, logo, contact_info, location_info, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $company_name, $teacher_name, $school_name, $password, $target_file, $contact_info, $location_info, $zipcode);

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
