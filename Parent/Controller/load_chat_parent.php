<?php
session_start();
require '../../Database/config.php';

if (isset($_POST['instructor_id'])) {
    $instructor_id = $_POST['instructor_id'];

    // Fetch messages between Parent and the selected instructor
    $parent_id = $_SESSION['user_id']; // Parent ID from session
    $sql = "SELECT * FROM messages 
            WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
            ORDER BY timestamp ASC";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("iiii", $parent_id, $instructor_id, $instructor_id, $parent_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $messages = '';
        while ($row = $result->fetch_assoc()) {
            $formatted_timestamp = date('Y-m-d H:i', strtotime($row['timestamp']));
            $messages .= '<div><strong>' . htmlspecialchars($row['sender_id'] == $parent_id ? 'Parent' : 'Instructor') . ':</strong> ' . htmlspecialchars($row['message']) . ' <small>(' . $formatted_timestamp . ')</small></div>';
        }

        echo $messages ? $messages : '<div>No chat history found.</div>';
    } else {
        echo '<div>Error fetching messages. Please try again later.</div>';
    }
}

$conn->close();
?>
