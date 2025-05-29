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

    // Fetch courses for feedback
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT id, name FROM courses"; // Assuming students can give feedback on all courses
    $result = $conn->query($sql);

    $title = "Submit Course Feedback";
    $content = "../Student/submit_feedback_content.php"; // Content file for the feedback form
    include '../setting/_Layout.php';
?>
