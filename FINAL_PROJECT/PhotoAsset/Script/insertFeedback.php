<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database credentials
$conn = new mysqli(
    "sql12.freesqldatabase.com",
    "sql12806020",
    "eBc7WZv9NN",
    "sql12806020",
    3306
);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed"], JSON_UNESCAPED_UNICODE);
    exit;
}

// Get POST data
// only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"], JSON_UNESCAPED_UNICODE);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true) ?: [];

$f_name = trim($data["f_name"] ?? "");
$l_name = trim($data["l_name"] ?? "");
// accept either 'message' or the older 'feedback' field
$message = trim($data["message"] ?? ($data["feedback"] ?? ""));

// Validate input
if (empty($f_name) || empty($l_name) || empty($message)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "All fields are required"], JSON_UNESCAPED_UNICODE);
    exit;
}

// Insert data
$stmt = $conn->prepare("INSERT INTO feedback (f_name, l_name, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $f_name, $l_name, $message);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Feedback submitted successfully"], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to insert feedback: " . $stmt->error], JSON_UNESCAPED_UNICODE);
}

$stmt->close();
$conn->close();
?>

