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

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    // Fetch course class_notification
    $user_id = $_SESSION['user_id']; // Assuming you have the user ID in session
    
    // Fetch all course class notifications
    $sql = "SELECT cn.*, 
        c.name AS course_name, 
        IFNULL(un.is_read, 0) AS is_read 
    FROM class_notification cn
    JOIN courses c ON cn.course_id = c.id
    LEFT JOIN user_notifications un ON cn.id = un.notification_id AND un.user_id = ?
    ORDER BY cn.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    

    $content = "../Administrator/show_class_notification_content.php";
    include '../setting/_Layout.php';

?>