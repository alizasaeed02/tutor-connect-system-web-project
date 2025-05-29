<?php
session_start();
require '../../Database/config.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Fetch messages between the tutor and the selected user (Student, Parent, or Admin)
    $tutor_id = $_SESSION['user_id']; // Tutor ID from session
    $sql = "SELECT * FROM messages 
            WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
            ORDER BY timestamp ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $tutor_id, $user_id, $user_id, $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = '';
    while ($row = $result->fetch_assoc()) {
        $sender = $row['sender_id'];
        if ($sender == $tutor_id) {
            $sender_role = 'Tutor';
        } elseif ($sender == 3) { // Assuming 3 is the role ID for Admin
            $sender_role = 'Admin';
        } elseif ($sender == 1) { // Assuming 1 is the role ID for Student
            $sender_role = 'Student';
        } else { // Otherwise, treat as Parent
            $sender_role = 'Parent';
        }

        // Format the message with the sender's role
        $messages .= '<div><strong>' . htmlspecialchars($sender_role) . ':</strong> ' . htmlspecialchars($row['message']) . ' <small>(' . htmlspecialchars($row['timestamp']) . ')</small></div>';
    }

    // Output messages or a default message if none found
    echo $messages ? $messages : '<div>No chat history found.</div>';
}

$conn->close();
?>
