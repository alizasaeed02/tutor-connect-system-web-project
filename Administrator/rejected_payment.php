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

    $title = "Course Rejected Payment";
    
    $sql = "SELECT course_registration.*, courses.name AS course_name
            FROM course_registration
            JOIN courses ON course_registration.course_id = courses.id
            JOIN course_instructor_assigned ON course_registration.course_id = course_instructor_assigned.course_id
            WHERE course_registration.payment_status = 'Rejected'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();   

    $content = "../Administrator/rejected_payment_content.php";
    include '../setting/_Layout.php';
?>
