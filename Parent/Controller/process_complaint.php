<?php
session_start();
require '../../Database/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Process complaint submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $complaint_text = $_POST['complaint_text'];

    // Insert complaint into the database
    $sql = "INSERT INTO complaints (user_id, complaint_text) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $complaint_text);
    if ($stmt->execute()) {
        // Complaint submitted successfully
        $_SESSION['message'] = "Complaint Submit successfully.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../submit_complaint.php"); // Redirect to a success page
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
