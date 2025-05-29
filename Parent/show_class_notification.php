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
$title = "Show Class Notification";

// Get the parent_student_id of the logged-in parent
$parent_student_id = $user['parent_student_id']; // Ensure this is set correctly in your user data fetching

// Fetch course class_notification for the child(s) assigned to the parent
$user_id = $_SESSION['user_id']; // Assuming you have the user ID in session

$sql = "SELECT class_notification.*, courses.name AS course_name 
        FROM class_notification 
        JOIN courses ON class_notification.course_id = courses.id
        JOIN course_registration ON class_notification.course_id = course_registration.course_id
        JOIN users AS u ON course_registration.user_id = u.id 
        WHERE u.id = ? OR u.parent_student_id = ?
        ORDER BY class_notification.id DESC";                        

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $parent_student_id, $parent_student_id); // Bind the parent's student ID
$stmt->execute();
$result = $stmt->get_result();   

$content = "../Parent/show_class_notification_content.php";
include '../setting/_Layout.php';

?>
