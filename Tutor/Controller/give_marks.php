<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'give_marks') {
    $assignment_id = $_POST['assignment_id'];
    $total_marks = $_POST['total_marks'];
    $obtained_marks = $_POST['obtained_marks'];

    // Update the assignment marks and set is_get_marks to 1
    $stmt = $conn->prepare("UPDATE assignment_submissions SET total_marks=?, obtained_marks=?, is_get_marks=1 WHERE id=?");
    $stmt->bind_param("iii", $total_marks, $obtained_marks, $assignment_id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../show_submitted_assignments.php");
    exit;
}
?>
