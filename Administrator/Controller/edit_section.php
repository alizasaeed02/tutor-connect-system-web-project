<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];  // Section ID
    $name = $_POST['name'];  // Updated Section Name

    $sql = "UPDATE sections SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Section updated successfully.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../manage_section.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
