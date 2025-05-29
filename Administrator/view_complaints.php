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

    // Fetch all complaints
    $sql = "SELECT complaints.*, users.username AS student_name 
            FROM complaints 
            JOIN users ON complaints.user_id = users.id
            ORDER BY complaints.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $title = "View Complaints";
    $content = "../Administrator/view_complaints_content.php"; // Content file for viewing complaints
    include '../setting/_Layout.php';
?>

