<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Fetch the current profile photo filename
    $stmt = $conn->prepare("SELECT profile_photo FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    $current_profile_photo = $user['profile_photo'];

    $profile_photo = null;
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile_photo']['tmp_name'];
        $file_name = $_FILES['profile_photo']['name'];
        $file_name = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_name);
        $profile_photo = time() . "_" . $file_name;
        move_uploaded_file($file_tmp_path, "../../assets/uploads/" . $profile_photo);

        // Delete the old profile photo if it exists
        if ($current_profile_photo && file_exists("../../assets/uploads/" . $current_profile_photo)) {
            unlink("../../assets/uploads/" . $current_profile_photo);
        }
    }

    if ($profile_photo) {
        $sql = "UPDATE users SET username=?, email=?, address=?, phone=?, profile_photo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $email, $address, $phone, $profile_photo, $id);
    } else {
        $sql = "UPDATE users SET username=?, email=?, address=?, phone=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $email, $address, $phone, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: ../user.php");
    exit;
}
?>
