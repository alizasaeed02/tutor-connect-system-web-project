<?php
session_start();
require '../Database/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$user = getUserData($_SESSION['user_id']);

// Fetch parent data
$parent_id = $_SESSION['user_id']; // Parent ID from session

$title = "View Meeting Notifications";

// SQL query to fetch meeting notifications relevant to all parents
$sql = "SELECT arrange_meeting_notification.*, users.username AS tutor_name 
        FROM arrange_meeting_notification
        JOIN users ON arrange_meeting_notification.user_id = users.id
        ORDER BY arrange_meeting_notification.id DESC"; // Fetch all notifications created by the tutor
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$content = "../Parent/view_meeting_notification_content.php";
include '../setting/_Layout.php';

$stmt->close();
?>
