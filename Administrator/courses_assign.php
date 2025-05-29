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

    $title = "Tutor Assigned";

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    // Fetch course instructor assignments
    $sql = "SELECT course_instructor_assigned.*, courses.name AS course_name, users.username AS instructor_name 
            FROM course_instructor_assigned
            JOIN courses ON course_instructor_assigned.course_id = courses.id
            JOIN users ON course_instructor_assigned.instructor_id = users.id
            WHERE users.role_id = 2";  // Ensuring only instructors are fetched
    $result = $conn->query($sql);

    $content = "../Administrator/courses_assign_content.php";
    include '../setting/_Layout.php';

?>