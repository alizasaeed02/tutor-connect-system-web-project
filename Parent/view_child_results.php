<?php
session_start();
require '../Database/config.php';

// Check if the user is logged in and is a parent
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch user data
$user = getUserData($_SESSION['user_id']);

// Get the parent_student_id of the logged-in parent
$parent_student_id = $user['parent_student_id']; // Ensure this value is correctly set

$title = "All Assignments and Quizzes for Your Child";

// Fetch all assignments and quizzes for the assigned child where is_get_marks = 1
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
            asub.is_get_marks = 1 AND 
            u.id = ?"; // Use the child's user ID to filter results

// Use the parent's child ID to fetch results
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_student_id); // Bind the parent_student_id
$stmt->execute();
$result = $stmt->get_result();   

$content = "../Parent/view_child_results_content.php"; // Path to the content view
include '../setting/_Layout.php';
?>
