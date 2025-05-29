<?php
session_start();
require '../../Database/config.php';

if (isset($_POST['instructor_id'])) {
    $instructor_id = $_POST['instructor_id'];

    // Fetch messages between student and the selected instructor
    $student_id = $_SESSION['user_id']; // Student ID from session
    $sql = "SELECT * FROM messages 
            WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
            ORDER BY timestamp ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $student_id, $instructor_id, $instructor_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = '';
    while ($row = $result->fetch_assoc()) {
        $messages .= '<div><strong>' . htmlspecialchars($row['sender_id'] == $student_id ? 'Student' : 'Instructor') . ':</strong> ' . htmlspecialchars($row['message']) . ' <small>(' . $row['timestamp'] . ')</small></div>';
    }

    echo $messages ? $messages : '<div>No chat history found.</div>';
}

$conn->close();
?>
