<?php
header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 0);
error_reporting(E_ALL);

//Database credentials
$host = "sql12.freesqldatabase.com";
$user = "sql12806020";
$password = "eBc7WZv9NN";
$database = "sql12806020";
$port = 3306;

//Create mysqli connection and set charset
$conn = @new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

//Use UTF-8 charset for correct encoding
if (! $conn->set_charset('utf8mb4')) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to set charset"
    ], JSON_UNESCAPED_UNICODE);
    exit();
}
//Query feedback
$sql = "SELECT feedback_id, f_name AS first_name, l_name AS last_name, message FROM feedback";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Query failed: " . $conn->error
    ], JSON_UNESCAPED_UNICODE);
    $conn->close();
    exit();
}
//Fetch data
$data = [];
while ($row = $result->fetch_assoc()) {
    if (isset($row['f_name']) && !isset($row['first_name'])) {
        $row['first_name'] = $row['f_name'];
    }
    if (isset($row['l_name']) && !isset($row['last_name'])) {
        $row['last_name'] = $row['l_name'];
    }
    $data[] = $row;
}
$conn->close();
echo json_encode([
    "status" => "success",
    "message" => "Feedback loaded successfully",
    "data" => $data
], JSON_UNESCAPED_UNICODE);
?>