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

$title = "Manage Courses";

// Fetch courses and their corresponding sections
$sql = "SELECT courses.*, sections.name as section_name, sections.id as section_id 
        FROM courses 
        LEFT JOIN sections ON courses.section_id = sections.id";
$result = $conn->query($sql);

// Fetch sections for the dropdown
$sections_sql = "SELECT * FROM sections";
$sections_result = $conn->query($sections_sql);

// Define the content file to be included in the layout
$content = "../Administrator/courses_content.php";
include '../setting/_Layout.php';

$conn->close();
?>
