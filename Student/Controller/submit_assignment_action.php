<?php
session_start();
require '../../Database/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deadline_material_id = $_POST['deadline_material_id'];
    $user_id = $_SESSION['user_id'];

    // Validate if deadline_material_id exists in the deadline_materials table
    $stmt_check = $conn->prepare("SELECT id FROM deadline_materials WHERE id = ?");
    $stmt_check->bind_param("i", $deadline_material_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
        $_SESSION['message'] = "Invalid assignment deadline." . $deadline_material_id;
        $_SESSION['message_class'] = "alert-danger";
        $stmt_check->close();
        header("Location: ../submit_assignment.php");
        exit;
    }

    $stmt_check->close();

    // Check if a submission with the same deadline_material_id and user_id already exists
    $stmt_duplicate_check = $conn->prepare("SELECT id FROM assignment_submissions WHERE deadline_material_id = ? AND user_id = ?");
    $stmt_duplicate_check->bind_param("ii", $deadline_material_id, $user_id);
    $stmt_duplicate_check->execute();
    $stmt_duplicate_check->store_result();

    if ($stmt_duplicate_check->num_rows > 0) {
        $_SESSION['message'] = "You have already submitted this assignment.";
        $_SESSION['message_class'] = "alert-danger";
        $stmt_duplicate_check->close();
        header("Location: ../submit_assignment.php");
        exit;
    }

    $stmt_duplicate_check->close();

    // Handle file upload
    if (isset($_FILES['assignmentFile']) && $_FILES['assignmentFile']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['assignmentFile']['tmp_name'];
        $file_name = $_FILES['assignmentFile']['name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Get file extension
        $upload_dir = '../../assets/uploads/';
        
        // Generate unique random number for file name
        $unique_number = mt_rand(1000000000, 9999999999); // Generates a random number with 10 digits
        $new_filename = $user_id . '_' . $unique_number . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        // Move new file to uploads directory
        if (move_uploaded_file($file_tmp_path, $target_file)) {
            $file_path = $new_filename; // Save the relative path to the database
            
            // Insert the submission record into the database
            $stmt = $conn->prepare("INSERT INTO assignment_submissions (deadline_material_id, user_id, file_path, submitted_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iis", $deadline_material_id, $user_id, $file_path);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Assignment submitted successfully.";
                $_SESSION['message_class'] = "alert-success";
            } else {
                $_SESSION['message'] = "There was an error submitting your assignment.";
                $_SESSION['message_class'] = "alert-danger";
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            $_SESSION['message_class'] = "alert-danger";
        }
    } else {
        $_SESSION['message'] = "No file uploaded or there was an error uploading the file.";
        $_SESSION['message_class'] = "alert-danger";
    }
}

$conn->close();
header("Location: ../submit_assignment.php");
exit;
?>
