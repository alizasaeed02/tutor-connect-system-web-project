<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $course_id = $_POST['course_id'];
    $instructor_id = $_POST['instructor_id'];

    // Check if the combination of course_id and instructor_id already exists
    $check_stmt = $conn->prepare("SELECT * FROM course_instructor_assigned WHERE course_id = ? AND instructor_id = ?");
    $check_stmt->bind_param("ii", $course_id, $instructor_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Record already exists, show an error message
        $_SESSION['message'] = "The course instructor assignment already exists.";
        $_SESSION['message_class'] = "alert-danger";
        $check_stmt->close();
        header("Location: ../courses_assign.php");
        exit;
    }

    $check_stmt->close();

    // Insert new record if it does not already exist
    $stmt = $conn->prepare("INSERT INTO course_instructor_assigned (course_id, instructor_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $course_id, $instructor_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = "Course instructor assignment created successfully.";
    $_SESSION['message_class'] = "alert-success";
    header("Location: ../courses_assign.php");
    exit;
}
?>
