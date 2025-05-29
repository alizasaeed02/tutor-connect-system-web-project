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

$title = "Assignment Submission";

// Fetch course_registration
$user_id = $_SESSION['user_id']; // Assuming you have the user ID in session

$sql = "SELECT course_registration.*, courses.name AS course_name, courses.description AS course_description, 
        deadline_materials.id AS deadline_materials_id, deadline_materials.title, deadline_materials.type, deadline_materials.content, deadline_materials.file_path, 
        deadline_materials.from_date, deadline_materials.to_date, 
        assignment_submissions.obtained_marks, assignment_submissions.total_marks
        FROM course_registration 
        JOIN courses ON course_registration.course_id = courses.id
        JOIN deadline_materials ON course_registration.course_id = deadline_materials.course_id
        LEFT JOIN assignment_submissions ON deadline_materials.id = assignment_submissions.deadline_material_id AND assignment_submissions.user_id = course_registration.user_id
        WHERE assignment_submissions.user_id = ? AND (deadline_materials.type = 'assignment' OR deadline_materials.type = 'quiz')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // 'i' for integer
$stmt->execute();
$result = $stmt->get_result();   

$content = "../Student/show_submitted_assignment_content.php";
include '../setting/_Layout.php';
?>
