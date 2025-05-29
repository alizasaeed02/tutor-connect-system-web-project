<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $section_id = isset($_POST['section_id']) ? $_POST['section_id'] : null;

    // Handle video file upload
    $course_video = $_FILES['course_video'];
    $upload_dir = __DIR__ . '/../../uploads/courses/';

    // Check if the directory exists, if not create it
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist with write permissions
    }

    if ($course_video['error'] == 0) {
        // Generate a new filename with a timestamp and "Video" suffix
        $extension = pathinfo($course_video['name'], PATHINFO_EXTENSION); // Get the file extension
        $new_filename = time() . '_Video.' . $extension; // Rename the file to timestamp_Video.extension
        $target_file = $upload_dir . $new_filename;

        // Debugging: print the full path to verify it is correct
        echo "Target File Path: " . $target_file;

        // Fetch the old video file path from the database
        $stmt = $conn->prepare("SELECT video_path FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($old_video);
        $stmt->fetch();
        $stmt->close();

        // Delete the old video file if it exists
        if ($old_video && file_exists($upload_dir . $old_video)) {
            unlink($upload_dir . $old_video);
        }

        // Move the new file to the uploads directory
        if (move_uploaded_file($course_video['tmp_name'], $target_file)) {
            $_SESSION['message'] = "Video uploaded successfully.";
            $_SESSION['message_class'] = "alert-success";
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Update the course with or without a new video file
    if (!empty($new_filename)) {
        $sql = "UPDATE courses SET name = ?, description = ?, price = ?, section_id = ?, video_path = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssi", $name, $description, $price, $section_id, $new_filename, $id);
    } else {
        $sql = "UPDATE courses SET name = ?, description = ?, price = ?, section_id = ? WHERE id = ?";
        $stmt->prepare($sql);
        $stmt->bind_param("ssdsi", $name, $description, $price, $section_id, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Course updated successfully.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../courses.php");
    } else {
        $_SESSION['message'] = "Error updating course.";
        $_SESSION['message_class'] = "alert-danger";
    }

    $stmt->close();
    $conn->close();
}
?>
