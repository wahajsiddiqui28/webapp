<?php
// Allow CORS (Cross-Origin Resource Sharing)
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Database connection
$servername = "localhost";
$username = "root";
$password = "frdp123";
$dbname = "my_web_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all posts from the database
$sql = "SELECT * FROM posts ORDER BY created_at DESC"; // Assuming there is a 'created_at' column
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

echo json_encode(['success' => true, 'data' => $posts]);

// Close the connection
$conn->close();
?>
