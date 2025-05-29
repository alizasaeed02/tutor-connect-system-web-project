<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'create') {
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $class_date = $_POST['class_date'];
    $from_time = $_POST['from_time'];
    $to_time = $_POST['to_time'];


    $sql = "INSERT INTO class_notification (course_id, user_id, title, content, class_date, from_time, to_time, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssss", $course_id, $user_id, $title, $content, $class_date, $from_time, $to_time);

    if ($stmt->execute()) {
        // Redirect or display success message
        $_SESSION['message'] = "Class Notification Successfully Uploaded.";
        $_SESSION['message_class'] = "alert-success";
        header('Location: ../class_notification.php');
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
