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

    $user_id = $_SESSION['user_id'];

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo "User not found!";
        exit;
    }

    // Fetch user experiences
    $stmt_exp = $conn->prepare("SELECT * FROM experiences WHERE user_id = ?");
    $stmt_exp->bind_param("i", $user_id);
    $stmt_exp->execute();
    $exp_result = $stmt_exp->get_result();
    $stmt_exp->close();


    $title = "Users";
    $content = "../Tutor/profile_content.php";
    include '../setting/_Layout.php';
?>