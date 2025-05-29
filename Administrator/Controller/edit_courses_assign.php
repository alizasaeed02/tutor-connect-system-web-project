<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $course_id = $_POST['course_id'];
    $instructor_id = $_POST['instructor_id'];

    // Check if the combination of course_id and instructor_id already exists
    $check_stmt = $conn->prepare("SELECT * FROM course_instructor_assigned WHERE course_id = ? AND instructor_id = ? AND id != ?");
    $check_stmt->bind_param("iii", $course_id, $instructor_id, $id);
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

    // Update record if it does not already exist
    $stmt = $conn->prepare("UPDATE course_instructor_assigned SET course_id = ?, instructor_id = ? WHERE id = ?");
    $stmt->bind_param("iii", $course_id, $instructor_id, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = "Course instructor assignment updated successfully.";
    $_SESSION['message_class'] = "alert-success";
    header("Location: ../courses_assign.php");
    exit;
}
?>
