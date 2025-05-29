<?php
session_start();
require '../Database/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch user data
$user = getUserData($_SESSION['user_id']);

$title = "Arrange Meeting Notification";

// Fetch arranged meetings
$user_id = $_SESSION['user_id']; // Assuming you have the user ID in session

$sql = "SELECT arrange_meeting_notification.* FROM arrange_meeting_notification
        WHERE arrange_meeting_notification.user_id = ?
        ORDER BY arrange_meeting_notification.id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$content = "../Tutor/arrange_meeting_notification_content.php";
include '../setting/_Layout.php';

$stmt->close();
?>
