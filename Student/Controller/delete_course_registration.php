<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $course_registration_id = $_POST['id'];

    // Retrieve the file path before deletion
    $stmt = $conn->prepare("SELECT receipt_path FROM course_registration WHERE id = ?");
    $stmt->bind_param("i", $course_registration_id);
    $stmt->execute();
    $stmt->bind_result($receipt_path);
    $stmt->fetch();
    $stmt->close();

    // Proceed if file path is retrieved
    if ($receipt_path) {
        // Delete the course registration
        $stmt = $conn->prepare("DELETE FROM course_registration WHERE id = ?");
        $stmt->bind_param("i", $course_registration_id);

        if ($stmt->execute()) {
            // Delete the file from the directory
            $file_to_delete = '../../assets/uploads/receipts/' . $receipt_path;
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }

            $_SESSION['message'] = "Course Registration deleted successfully";
            $_SESSION['message_class'] = "alert-success";
        } else {
            $_SESSION['message'] = "Error deleting Course Registration";
            $_SESSION['message_class'] = "alert-danger";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "File path not found.";
        $_SESSION['message_class'] = "alert-danger";
    }

    header("Location: ../course_registration.php");
    exit();
}
$conn->close();
?>

