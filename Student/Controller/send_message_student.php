<?php
session_start();
require '../../Database/config.php';

if (isset($_POST['receiver_id']) && isset($_POST['message'])) {
    $sender_id = $_SESSION['user_id']; // Student ID
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Insert the message into the database
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();

    echo "Message sent.";
}

$conn->close();
?>
