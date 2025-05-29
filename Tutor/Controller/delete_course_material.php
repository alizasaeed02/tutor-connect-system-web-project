<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    // Fetch the file path of the material to be deleted
    $stmt = $conn->prepare("SELECT file_path FROM course_materials WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    // Delete the file from the directory
    if ($file_path) {
        $file_full_path = '../../assets/uploads/' . $file_path;
        if (file_exists($file_full_path)) {
            unlink($file_full_path);
        }
    }

    // Delete the record from the database
    $stmt = $conn->prepare("DELETE FROM course_materials WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../course_materials.php");
    exit;
}
?>
