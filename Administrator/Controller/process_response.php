<?php
session_start();
require '../../Database/config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) { // Assuming role_id 3 is for admin
    header("Location: index.php");
    exit;
}

// Process response submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['complaint_id'])) {
        $complaint_id = $_POST['complaint_id'];
        $admin_response = $_POST['admin_response'];

        // Update complaint with the admin's response
        $sql = "UPDATE complaints SET admin_response = ?, status = 'resolved' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $admin_response, $complaint_id);
        
        if ($stmt->execute()) {
            // Response submitted successfully
            $_SESSION['message'] = "Complaint Response Submitted successfully.";
            $_SESSION['message_class'] = "alert-success";
            header("Location: ../view_complaints.php"); // Redirect to the complaints view page
            exit;
        } else {
            // Handle errors
            $_SESSION['message'] = "Database error: " . htmlspecialchars($stmt->error);
            $_SESSION['message_class'] = "alert-danger";
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "No complaint ID specified.";
        exit;
    }
}

$stmt->close();
$conn->close();
?>
