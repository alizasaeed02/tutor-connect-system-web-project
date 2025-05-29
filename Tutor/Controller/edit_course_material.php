<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $existing_file_path = $_POST['existing_file_path'];
    $file_path = $existing_file_path; // Use existing file path by default

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Get file extension
        $upload_dir = '../../assets/uploads/';
        
        // Generate unique random number for file name
        $unique_number = mt_rand(1000000000, 9999999999); // Generates a random number with 10 digits
        $new_filename = $_SESSION['user_id'] . '_' . $unique_number . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        // Move new file to uploads directory
        if (move_uploaded_file($file_tmp_path, $target_file)) {
            $file_path = $new_filename; // Save the new file path to the database

            // Delete old file if exists
            if ($existing_file_path && file_exists($upload_dir . $existing_file_path)) {
                unlink($upload_dir . $existing_file_path);
            }
        } else {
            // Handle error
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    $sql = "UPDATE course_materials SET course_id = ?, title = ?, content = ?, file_path = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $course_id, $title, $content, $file_path, $id);

    if ($stmt->execute()) {
        // Redirect or display success message
        $_SESSION['message'] = "Materials Successfully Updated.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../course_materials.php");
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
