<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $tutor_id = $_POST['tutor_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];

    // Insert the salary transaction into the database
    $sql = "INSERT INTO salaries (tutor_id, amount, payment_status, payment_date) VALUES (?, ?, 'Pending', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $tutor_id, $amount, $payment_date);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Transaction created successfully.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../give_salary_to_tutor.php");
    } else {
        $_SESSION['message'] = "Error creating transaction: " . $stmt->error;
        $_SESSION['message_class'] = "alert-danger";
        header("Location: ../give_salary_to_tutor.php");
    }

    $stmt->close();
    $conn->close();
}
?>
