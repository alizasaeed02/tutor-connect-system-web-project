<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'verify') {
    $course_registration_id = $_POST['id'];

    // Update payment status to "Verified"
    $stmt = $conn->prepare("UPDATE course_registration SET payment_status = 'Verified' WHERE id = ?");
    $stmt->bind_param("i", $course_registration_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Payment verified successfully.";
        $_SESSION['message_class'] = "alert-success";
    } else {
        $_SESSION['message'] = "Failed to verify payment.";
        $_SESSION['message_class'] = "alert-danger";
    }

    $stmt->close();
    $conn->close();

    header("Location: ../pending_payment.php");
    exit();
}
?>
