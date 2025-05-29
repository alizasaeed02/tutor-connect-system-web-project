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

    // Fetch feedback data for courses
    $sql = "SELECT course_feedback.*, courses.name AS course_name, users.username AS student_name 
            FROM course_feedback 
            JOIN courses ON course_feedback.course_id = courses.id 
            JOIN users ON course_feedback.user_id = users.id
            ORDER BY course_feedback.created_at DESC";                         
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $title = "View Course Feedback";
    $content = "../Administrator/view_feedback_content.php"; // Content file for displaying feedback
    include '../setting/_Layout.php';
?>
