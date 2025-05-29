<?php
session_start();
require '../../Database/config.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Fetch messages between admin and the selected user
    $admin_id = $_SESSION['user_id']; // Admin ID from session
    $sql = "SELECT * FROM messages 
            WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
            ORDER BY timestamp ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $admin_id, $user_id, $user_id, $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = '';
    while ($row = $result->fetch_assoc()) {
        $messages .= '<div><strong>' . htmlspecialchars($row['sender_id'] == $admin_id ? 'Admin' : 'User') . ':</strong> ' . htmlspecialchars($row['message']) . ' <small>(' . $row['timestamp'] . ')</small></div>';
    }

    echo $messages ? $messages : '<div>No chat history found.</div>';
}

$conn->close();
?>
