<?php
session_start();
require '../Database/config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch user data
$user = getUserData($_SESSION['user_id']);

$title = "All Assignments and Quizzes for Students";

// Fetch all assignments and quizzes for all students where is_get_marks = 1
$sql = "SELECT 
            u.id AS student_id, 
            u.username AS student_name, 
            c.name AS course_name, 
            c.description AS course_description, 
            dm.id AS deadline_materials_id, 
            dm.title, 
            dm.type, 
            dm.content, 
            dm.file_path, 
            dm.from_date, 
            dm.to_date, 
            asub.obtained_marks, 
            asub.total_marks
        FROM 
            course_registration AS cr
        JOIN 
            courses AS c ON cr.course_id = c.id
        JOIN 
            deadline_materials AS dm ON cr.course_id = dm.course_id
        LEFT JOIN 
            assignment_submissions AS asub ON dm.id = asub.deadline_material_id AND asub.user_id = cr.user_id
        JOIN 
            users AS u ON cr.user_id = u.id
        WHERE 
            dm.type IN ('assignment', 'quiz') AND
            asub.is_get_marks = 1"; // Add this condition

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();   

$content = "../Administrator/show_submitted_assignment_content.php"; // Change this if necessary
include '../setting/_Layout.php';
?>
