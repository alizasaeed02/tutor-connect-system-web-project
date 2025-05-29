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

    $title = "Submit Complaint";

    // Fetch complaints submitted by the user
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM complaints WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $content = "../Parent/submit_complaint_content.php"; // Content file for the complaint form
    include '../setting/_Layout.php';
?>
