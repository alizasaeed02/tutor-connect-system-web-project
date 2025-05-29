<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['id']);

    $sql = "UPDATE users SET isActive = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User approved successfully!";
        $_SESSION['message_class'] = "alert-success";
    } else {
        $_SESSION['message'] = "Error approving user!";
        $_SESSION['message_class'] = "alert-danger";
    }

    $stmt->close();
    $conn->close();
    header('Location: ../user.php');
    exit();
}
?>
