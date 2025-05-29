<?php
session_start();
require '../../Database/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
    $user_id = $_SESSION['user_id'];
    $notification_id = intval($_POST['notification_id']);

    // Check if the entry already exists
    $checkQuery = "SELECT * FROM user_notifications WHERE user_id = ? AND notification_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $user_id, $notification_id);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows == 0) {
        // Insert new entry
        $insertQuery = "INSERT INTO user_notifications (user_id, notification_id, is_read, read_at) VALUES (?, ?, 1, NOW())";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $user_id, $notification_id);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $stmt->close();
    $conn->close();

    $_SESSION['message'] = "Read Notifications successfully.";
    $_SESSION['message_class'] = "alert-success";
    // Redirect back to notifications page
    header("Location: ../show_class_notification.php");
    exit;
}
?>

