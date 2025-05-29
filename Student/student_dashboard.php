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

// Fetch total courses registered by this student
$sql_courses = "SELECT COUNT(*) as total_courses FROM course_registration WHERE user_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $user_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();
$total_courses = $result_courses->fetch_assoc()['total_courses'];
$stmt_courses->close();

// Fetch total assignments submitted by the student
$sql_assignments = "SELECT COUNT(*) as total_assignments FROM assignment_submissions WHERE user_id = ?";
$stmt_assignments = $conn->prepare($sql_assignments);
$stmt_assignments->bind_param("i", $user_id);
$stmt_assignments->execute();
$result_assignments = $stmt_assignments->get_result();
$total_assignments = $result_assignments->fetch_assoc()['total_assignments'];
$stmt_assignments->close();

// Fetch total quizzes submitted by the student
$sql_quizzes = "SELECT COUNT(*) as total_quizzes FROM deadline_materials 
                JOIN course_registration ON deadline_materials.course_id = course_registration.course_id 
                WHERE deadline_materials.type = 'quiz' AND course_registration.user_id = ?";
$stmt_quizzes = $conn->prepare($sql_quizzes);
$stmt_quizzes->bind_param("i", $user_id);
$stmt_quizzes->execute();
$result_quizzes = $stmt_quizzes->get_result();
$total_quizzes = $result_quizzes->fetch_assoc()['total_quizzes'];
$stmt_quizzes->close();

// Fourth statistic: Total lectures attended by the student
$sql_lectures = "SELECT COUNT(*) as total_lectures FROM deadline_materials 
                 JOIN course_registration ON deadline_materials.course_id = course_registration.course_id 
                 WHERE deadline_materials.type = 'lecture' AND course_registration.user_id = ?";
$stmt_lectures = $conn->prepare($sql_lectures);
$stmt_lectures->bind_param("i", $user_id);
$stmt_lectures->execute();
$result_lectures = $stmt_lectures->get_result();
$total_lectures = $result_lectures->fetch_assoc()['total_lectures'];
$stmt_lectures->close();

$title = "Student Dashboard";
$content = "../Student/student_dashboard_content.php";
include '../setting/_Layout.php';
?>