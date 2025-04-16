<?php
session_start();
include 'database.php'; // Ensure this connects to the database properly

if (isset($_POST['send_message'])) {
    // Retrieve sender details from session
    $sender_id = $_SESSION['user_id'];
    $sender_type = $_SESSION['user_type'];

    // Retrieve receiver details from form submission
    $receiver_id = isset($_POST['receiver_id']) ? intval($_POST['receiver_id']) : null;
    $receiver_type = isset($_POST['receiver_type']) ? $_POST['receiver_type'] : null;
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validate inputs
    if ($receiver_id === null || empty($receiver_type) || empty($message)) {
        die("Invalid input: Receiver ID, type, or message is missing.");
    }

    // Prepare and execute the query
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, sender_type, receiver_id, receiver_type, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $sender_id, $sender_type, $receiver_id, $receiver_type, $message);

    if ($stmt->execute()) {
        echo "<p>Message sent successfully!</p>";
        header("Location: dashboard.php");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
} else {
    echo "No message data received.";
}
?>


