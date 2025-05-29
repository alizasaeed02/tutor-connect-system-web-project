<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'], $_POST['course_id'], $_POST['transaction_no'], $_FILES['receipt_file'])) {
        $user_id = $_SESSION['user_id'];
        $course_id = $_POST['course_id'];
        $course_price = $_POST['course_price'];
        $transaction_no = $_POST['transaction_no'];
        $receipt_file = $_FILES['receipt_file'];

        // Check if the user has already registered for the same course
        $check_sql = "SELECT id FROM course_registration WHERE course_id = ? AND user_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $course_id, $user_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $_SESSION['message'] = "You have already registered for this course.";
            $_SESSION['message_class'] = "alert-danger";
            $check_stmt->close();
            header('Location: ../course_registration_fee.php');
            exit;
        }
        $check_stmt->close();

        // Handle file upload
        if (isset($_FILES['receipt_file']) && $_FILES['receipt_file']['error'] == UPLOAD_ERR_OK) {
            $file_tmp_path = $_FILES['receipt_file']['tmp_name'];
            $file_name = $_FILES['receipt_file']['name'];
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Get file extension
            $upload_dir = '../../assets/uploads/receipts/';
            
            // Generate unique random number for file name
            $unique_number = mt_rand(1000000000, 9999999999); // Generates a random number with 10 digits
            $new_filename = $user_id . '_' . $unique_number . '.' . $file_extension;
            $target_file = $upload_dir . $new_filename;

            // Move new file to uploads directory
            if (move_uploaded_file($file_tmp_path, $target_file)) {
                $receipt_path = $new_filename; // Save the relative path to the database
            } else {
                // Handle error
                $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                $_SESSION['message_class'] = "alert-danger";
                header('Location: ../course_registration_fee.php');
                exit;
            }
        }

        // Insert course registration into database
        $sql = "INSERT INTO course_registration (course_id, user_id, transaction_no, receipt_path, price, payment_status) VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $_SESSION['message'] = "Prepare failed: " . htmlspecialchars($conn->error);
            $_SESSION['message_class'] = "alert-danger";
        } else {
            $stmt->bind_param("iissd", $course_id, $user_id, $transaction_no, $receipt_path, $course_price);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Course registration created successfully.";
                $_SESSION['message_class'] = "alert-success";
            } else {
                $_SESSION['message'] = "Database error: " . htmlspecialchars($stmt->error);
                $_SESSION['message_class'] = "alert-danger";
            }
            $stmt->close();
        }
    } else {
        $_SESSION['message'] = "Required fields are missing.";
        $_SESSION['message_class'] = "alert-danger";
    }
} else {
    $_SESSION['message'] = "Invalid request method.";
    $_SESSION['message_class'] = "alert-danger";
}

$conn->close();
header('Location: ../course_registration_fee.php'); // Redirect after processing
?>
