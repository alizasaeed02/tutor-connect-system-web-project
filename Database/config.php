<?php
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tutor_connect_system_db";

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function getUserData($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Function to fetch author name
    function getAuthorName($author_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $author_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['username'];
    }

    // Function to fetch course name
    function getCourseName($course_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT course_name FROM courses WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['course_name'];
    }

    // Function to fetch student name (if needed)
    function getStudentName($student_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['username'];
    }

    // Function to fetch all announcements
    function getAnnouncements() {
        global $conn;
        $result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Function to fetch deadlines based on role
    function getDeadlines($user_id, $role_id) {
        global $conn;
        if ($role_id == 1) { // Student
            $stmt = $conn->prepare("SELECT d.* FROM deadlines d JOIN course_enrollments ce ON d.course_id = ce.course_id WHERE ce.student_id = ? ORDER BY d.deadline_date ASC");
            $stmt->bind_param("i", $user_id);
        } else if ($role_id == 2) { // Instructor
            $stmt = $conn->prepare("SELECT * FROM deadlines WHERE created_by = ? ORDER BY deadline_date ASC"); // Assuming 'created_by' is the column
            $stmt->bind_param("i", $user_id);
        } else {
            $stmt = $conn->prepare("SELECT * FROM deadlines ORDER BY deadline_date ASC");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Function to fetch grades for students
    function getGrades($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM grades WHERE student_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
?>
