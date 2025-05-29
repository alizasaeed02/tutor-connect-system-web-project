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

// Fetch total courses assigned to this specific instructor
$sql_courses = "SELECT COUNT(*) as total_courses FROM course_instructor_assigned WHERE instructor_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $user_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();
$total_courses = $result_courses->fetch_assoc()['total_courses'];
$stmt_courses->close();

// Fetch total students registered in the specific courses assigned to the instructor
$sql_students = "SELECT COUNT(DISTINCT course_registration.user_id) as total_students 
                 FROM course_registration 
                 JOIN course_instructor_assigned ON course_registration.course_id = course_instructor_assigned.course_id 
                 WHERE course_instructor_assigned.instructor_id = ?";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("i", $user_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();
$total_students = $result_students->fetch_assoc()['total_students'];
$stmt_students->close();

// Fetch total assignments uploaded by the specific instructor
$sql_assignments = "SELECT COUNT(*) as total_assignments FROM deadline_materials WHERE user_id = ? AND type = 'assignment'";
$stmt_assignments = $conn->prepare($sql_assignments);
$stmt_assignments->bind_param("i", $user_id);
$stmt_assignments->execute();
$result_assignments = $stmt_assignments->get_result();
$total_assignments = $result_assignments->fetch_assoc()['total_assignments'];
$stmt_assignments->close();

// Fourth statistic: Total quizzes uploaded by the specific instructor
$sql_quizzes = "SELECT COUNT(*) as total_quizzes FROM deadline_materials WHERE user_id = ? AND type = 'quiz'";
$stmt_quizzes = $conn->prepare($sql_quizzes);
$stmt_quizzes->bind_param("i", $user_id);
$stmt_quizzes->execute();
$result_quizzes = $stmt_quizzes->get_result();
$total_quizzes = $result_quizzes->fetch_assoc()['total_quizzes'];
$stmt_quizzes->close();

$title = "Instructor Dashboard";
$content = "../Tutor/instructor_dashboard_content.php";
include '../setting/_Layout.php';
?>