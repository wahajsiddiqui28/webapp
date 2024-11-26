<?php
// Allow CORS (Cross-Origin Resource Sharing)
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "frdp123"; // Replace with your database password
$dbname = "my_web_app"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// File upload logic
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    // File path to save
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = basename($_FILES['file']['name']);
    $fileName = urlencode($fileName); // Sanitize the file name
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];

    // Set upload directory with absolute path (backend/uploads/)
    $uploadDir = __DIR__ . '/uploads/';
    $destinationPath = $uploadDir . $fileName;

    // Move file to the destination folder
    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        // File uploaded successfully

        // Extract data from form
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Insert into database (save the relative path)
        $sql = "INSERT INTO posts (title, description, file_path) VALUES ('$title', '$description', 'uploads/$fileName')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Post uploaded successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
}

// Close the connection
$conn->close();

?>
