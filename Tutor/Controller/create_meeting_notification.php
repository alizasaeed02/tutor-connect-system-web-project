<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'create') {
    // Get the input values
    $user_id = $_SESSION['user_id'];  // The tutor's user ID from the session
    $title = $_POST['title'];         // Title of the meeting
    $content = $_POST['content'];     // Content of the meeting
    $meeting_date = $_POST['meeting_date']; // Date of the meeting
    $from_time = $_POST['from_time']; // Starting time of the meeting
    $to_time = $_POST['to_time'];    // Ending time of the meeting

    // SQL query to insert the notification for all parents (no parent_id needed)
    $sql = "INSERT INTO arrange_meeting_notification (user_id, title, content, meeting_date, from_time, to_time, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $title, $content, $meeting_date, $from_time, $to_time);

    if ($stmt->execute()) {
        // Redirect or display success message
        $_SESSION['message'] = "Meeting Notification Successfully Created.";
        $_SESSION['message_class'] = "alert-success";
        header('Location: ../arrange_meeting_notification.php');
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
