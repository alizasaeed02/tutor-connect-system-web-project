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

    $title = "Manage Section";

    // Fetch sections from the database
    $sql = "SELECT * FROM sections";
    $result = $conn->query($sql);

    $content = "../Administrator/manage_section_content.php";
    include '../setting/_Layout.php';

?>