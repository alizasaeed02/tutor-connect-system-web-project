<?php
session_start();
require '../../Database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profile_photo = $_FILES['profile_photo'];

    // Handle file upload
    if ($profile_photo['error'] == 0) {
        $upload_dir = '../../assets/uploads/';
        $new_filename = $user_id . '_' . basename($profile_photo['name']);
        $target_file = $upload_dir . $new_filename;

        // Delete old profile photo if exists
        $stmt = $conn->prepare("SELECT profile_photo FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($old_photo);
        $stmt->fetch();
        $stmt->close();

        if ($old_photo && file_exists($upload_dir . $old_photo)) {
            unlink($upload_dir . $old_photo);
        }

        // Move new file to uploads directory
        if (move_uploaded_file($profile_photo['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone = ?, address = ?, profile_photo = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $username, $email, $phone, $address, $new_filename, $user_id);
            $_SESSION['profile_photo'] = $new_filename;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $username, $email, $phone, $address, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: ../profile.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}
?>
