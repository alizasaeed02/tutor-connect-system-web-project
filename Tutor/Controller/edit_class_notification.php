<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $class_date = $_POST['class_date'];
    $from_time = $_POST['from_time'];
    $to_time = $_POST['to_time'];


    $sql = "UPDATE class_notification SET course_id = ?, title = ?, content = ?, class_date = ?, from_time = ?, to_time = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssi", $course_id, $title, $content, $class_date, $from_time, $to_time, $id);

    if ($stmt->execute()) {
        // Redirect or display success message
        $_SESSION['message'] = "Class Notification Successfully Updated.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../class_notification.php");
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
