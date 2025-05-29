<?php
session_start();
require '../../Database/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Process feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    // Insert feedback into the database
    $sql = "INSERT INTO course_feedback (course_id, user_id, rating, comments) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $course_id, $user_id, $rating, $comments);
    if ($stmt->execute()) {
        // Feedback submitted successfully
        $_SESSION['message'] = "Feedback Submit successfully.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../submit_feedback.php"); // Redirect to a success page
        exit;
    } else {
        // Handle errors
        $_SESSION['message'] = "Database error: " . htmlspecialchars($stmt->error);
        $_SESSION['message_class'] = "alert-danger";
        echo "Error: " . $stmt->error;
    }
}
$stmt->close();
$conn->close();
?>
