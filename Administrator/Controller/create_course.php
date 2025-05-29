<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $section_id = isset($_POST['section_id']) && !empty($_POST['section_id']) ? $_POST['section_id'] : null;

    // Handle video file upload
    $course_video = $_FILES['course_video'];
    $upload_dir = '../../uploads/courses/';
    $new_filename = '';
    
    // Allowed video file extensions
    $allowed_extensions = ['mp4', 'avi', 'mov', 'mkv'];
    
    if ($course_video['error'] == 0) {
        $file_extension = strtolower(pathinfo($course_video['name'], PATHINFO_EXTENSION));

        // Check if the file is a valid video format
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['message'] = "Invalid file format. Only MP4, AVI, MOV, and MKV files are allowed.";
            $_SESSION['message_class'] = "alert-danger";
            header("Location: ../courses.php");
            exit;
        }

        // Generate a new secure filename based on timestamp and sanitize it
        $new_filename = time() . '_Video.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        // Check if the upload directory exists, if not, create it
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
        }

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($course_video['tmp_name'], $target_file)) {
            $_SESSION['message'] = "Video uploaded successfully.";
            $_SESSION['message_class'] = "alert-success";
        } else {
            $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            $_SESSION['message_class'] = "alert-danger";
            header("Location: ../courses.php");
            exit;
        }
    }

    // Insert the course information into the database
    $sql = "INSERT INTO courses (name, description, price, section_id, video_path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $name, $description, $price, $section_id, $new_filename);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Course created successfully.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../courses.php");
    } else {
        $_SESSION['message'] = "Error creating course: " . $stmt->error;
        $_SESSION['message_class'] = "alert-danger";
        header("Location: ../courses.php");
    }

    $stmt->close();
    $conn->close();
}
?>
