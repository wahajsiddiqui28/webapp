<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Allow requests from any origin (React app is on http://localhost:3000)
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// If the request is an OPTIONS request (preflight), just return a 200 status
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database connection  
$conn = new mysqli('localhost', 'root', 'frdp123', 'my_web_app'); // Update with your database name
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$email = $data->email;
$password = $data->password;

// Sanitize input to avoid SQL injection
$username = $conn->real_escape_string($username);
$email = $conn->real_escape_string($email);
$password = $conn->real_escape_string($password);

// Hash password before storing (use stronger hashing for production)
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$passwordHash')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'User registered successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>
