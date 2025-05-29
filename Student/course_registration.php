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

    $title = "Course Registration";
    // Fetch course_registration
    $user_id = $_SESSION['user_id']; // Assuming you have the user ID in session
    
    $sql = "SELECT course_registration.*, courses.name AS course_name, courses.video_path
        FROM course_registration 
        JOIN courses ON course_registration.course_id = courses.id
        WHERE course_registration.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();   

    $content = "../Student/course_registration_content.php";
    include '../setting/_Layout.php';

?>