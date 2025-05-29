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

// Fetch total users
$total_users_query = "SELECT COUNT(*) as total FROM users WHERE role_id != 3";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total'];

// Fetch total students (assuming role_id for students is 1)
$total_students_query = "SELECT COUNT(*) as total FROM users WHERE role_id = 1";
$total_students_result = $conn->query($total_students_query);
$total_students = $total_students_result->fetch_assoc()['total'];

// Fetch total instructors (assuming role_id for instructors is 2)
$total_instructors_query = "SELECT COUNT(*) as total FROM users WHERE role_id = 2";
$total_instructors_result = $conn->query($total_instructors_query);
$total_instructors = $total_instructors_result->fetch_assoc()['total'];

// Fetch total Tutors
$total_courses_query = "SELECT COUNT(*) as total FROM courses";
$total_courses_result = $conn->query($total_courses_query);
$total_courses = $total_courses_result->fetch_assoc()['total'];

$title = "Admin Dashboard";
$content = "../Administrator/admin_dashboard_content.php";
include '../setting/_Layout.php';
?>