<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['receiver_id']) && isset($_GET['receiver_type'])) {
    $caller_id = $_SESSION['user_id'];
    $caller_type = $_SESSION['user_type'];
    $receiver_id = $_GET['receiver_id'];
    $receiver_type = $_GET['receiver_type'];

    $stmt = $conn->prepare("INSERT INTO call_logs (caller_id, caller_type, receiver_id, receiver_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $caller_id, $caller_type, $receiver_id, $receiver_type);

    if ($stmt->execute()) {
        echo "Call logged successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Call Logs</title>
</head>
<body>
    <h1>Call Logs</h1>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
