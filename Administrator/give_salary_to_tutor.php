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

    $title = "Give Salary to Tutor";

    // Fetch tutors for the dropdown
    $tutorQuery = "SELECT users.id AS tutor_id, users.username AS tutor_name FROM users WHERE users.role_id = 2";
    $tutorResult = $conn->query($tutorQuery);

    // Fetch transaction records
    $query = "SELECT * 
            FROM salaries s 
            JOIN users u ON s.tutor_id = u.id
            ORDER BY s.id DESC";
    $transactionResult = $conn->query($query);

    $content = "../Administrator/give_salary_to_tutor_content.php";
    include '../setting/_Layout.php';
?>
