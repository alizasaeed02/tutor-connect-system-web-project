<?php
    session_start();
    require '../../Database/config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
        $id = $_POST['id'];
        $company_name = htmlspecialchars($_POST['company_name']);
        $job_title = htmlspecialchars($_POST['job_title']);
        $start_date = htmlspecialchars($_POST['start_date']);
        $end_date = htmlspecialchars($_POST['end_date']);
        $description = htmlspecialchars($_POST['description']);

        $sql = "UPDATE experiences SET company_name = ?, job_title = ?, start_date = ?, end_date = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $company_name, $job_title, $start_date, $end_date, $description, $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Experience Successfully Updated.";
            $_SESSION['message_class'] = "alert-success";
            header("Location: ../profile.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
?>