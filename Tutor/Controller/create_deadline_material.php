<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'create') {
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $type = $_POST['type'];
    $content = $_POST['content'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $file_path = null;

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Get file extension
        $upload_dir = '../../assets/uploads/';
        
        // Generate unique random number for file name
        $unique_number = mt_rand(1000000000, 9999999999); // Generates a random number with 10 digits
        $new_filename = $user_id . '_' . $unique_number . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        // Move new file to uploads directory
        if (move_uploaded_file($file_tmp_path, $target_file)) {
            $file_path = $new_filename; // Save the relative path to the database
        } else {
            // Handle error
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    $sql = "INSERT INTO deadline_materials (course_id, user_id, title, type, content, from_date, to_date, file_path, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssss", $course_id, $user_id, $title, $type, $content, $from_date, $to_date, $file_path);

    if ($stmt->execute()) {
        // Redirect or display success message
        $_SESSION['message'] = "Materials Successfully Uploaded.";
        $_SESSION['message_class'] = "alert-success";
        header('Location: ../deadline_materials.php');
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
