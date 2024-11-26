<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    exit(0);
}

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: http://localhost:3000');

// Database connection
$servername = "localhost";
$username = "root";
$password = "frdp123";
$dbname = "my_web_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Check and handle file upload
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = urlencode(basename($_FILES['file']['name']));
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];

    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $destinationPath = $uploadDir . $fileName;

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi', 'application/octet-stream'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    if (!in_array(strtolower($fileExtension), $allowedExtensions) || !in_array($fileType, $allowedMimeTypes)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit();
    }

    $maxFileSize = 5 * 1024 * 1024 * 1024; // 5GB
    if ($fileSize > $maxFileSize) {
        echo json_encode(['success' => false, 'message' => 'File size exceeds 5GB']);
        exit();
    }

    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = "INSERT INTO posts (title, description, file_path) VALUES ('$title', '$description', 'uploads/$fileName')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Post uploaded successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
}

$conn->close();
?>
