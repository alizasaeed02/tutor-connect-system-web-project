<?php
session_start();
require '../../Database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $transaction_id = $_POST['id'];

    // Delete the transaction from the database
    $sql = "DELETE FROM salaries WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transaction_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Transaction deleted successfully.";
        $_SESSION['message_class'] = "alert-success";
        header("Location: ../give_salary_to_tutor.php");
    } else {
        $_SESSION['message'] = "Error deleting transaction: " . $stmt->error;
        $_SESSION['message_class'] = "alert-danger";
        header("Location: ../give_salary_to_tutor.php");
    }

    $stmt->close();
    $conn->close();
}
?>
