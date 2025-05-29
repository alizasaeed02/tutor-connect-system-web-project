<style>
    /* Custom styles for the search input */
.input-group {
    border-radius: 0.5rem;
    overflow: hidden; /* To make sure the border radius is respected */
    transition: all 0.3s ease; /* Transition for the whole group */
}

.input-group-text {
    background-color: #007bff; /* Bootstrap primary color */
    color: white; /* Text color */
    transition: background-color 0.3s ease; /* Transition for background color */
}

.input-group-text:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

.form-control {
    border: 2px solid #007bff; /* Matching border color */
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Transition for border and shadow */
}

.form-control:focus {
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add shadow on focus */
    border-color: #0056b3; /* Darker border color on focus */
    outline: none; /* Remove default outline */
}

.btn-primary {
    border-radius: 0; /* Make the button edges square to fit in the group */
    transition: transform 0.3s ease; /* Button transform effect */
}

.btn-primary:hover {
    transform: scale(1.05); /* Scale up on hover */
}

</style>

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

$title = "Course Registration";

// Assuming role_id for tutors is 2
$tutor_role_id = 2;

// Updated SQL to include sections
$sql = "SELECT 
            course_instructor_assigned.*, 
            courses.name AS course_name, 
            courses.description, 
            courses.price, 
            courses.video_path, 
            users.username AS tutor_name, 
            users.profile_photo AS tutor_image,
            sections.name AS section_name  -- Include section name
        FROM 
            course_instructor_assigned 
        JOIN 
            courses ON course_instructor_assigned.course_id = courses.id
        JOIN 
            users ON course_instructor_assigned.instructor_id = users.id
        JOIN 
            sections ON courses.section_id = sections.id  -- Join sections
        WHERE 
            users.role_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tutor_role_id);
$stmt->execute();
$result = $stmt->get_result();

$content = "../Student/course_registration_fee_content.php";
include '../setting/_Layout.php';

$conn->close();
?>
