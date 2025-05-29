<?php
session_start();
require 'Database/config.php';

// Fetch roles from the database
$roles_result = $conn->query("SELECT * FROM roles WHERE name != 'Administrator'");
$roles = [];
while ($row = $roles_result->fetch_assoc()) {
    $roles[] = $row;
}

$message = '';
$message_class = '';
$students = []; // Array to hold student data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role_id = $_POST['role_id'];
    $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : null; // Get selected student if any
    $isActive = 1;

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($role_id)) {
        $message = 'All fields are required.';
        $message_class = 'alert-danger';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = 'Email is already registered.';
            $message_class = 'alert-danger';
        } else {
            $stmt->close();

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id, parent_student_id, isActive) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiii", $username, $email, $password, $role_id, $student_id, $isActive);
            if ($stmt->execute()) {
                $message = 'Registration successful!';
                $message_class = 'alert-success';
            } else {
                $message = 'Registration failed. Please try again.';
                $message_class = 'alert-danger';
            }
            $stmt->close();
        }
    }
}

// Always fetch students to populate the dropdown
$sql = "SELECT id, username FROM users WHERE role_id = 1"; // 1 is the role_id for Student
$stmt = $conn->prepare($sql);
$stmt->execute();
$students_result = $stmt->get_result();
    
while ($row = $students_result->fetch_assoc()) {
    $students[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registration</title>

    <!-- Meta -->
    <link rel="shortcut icon" href="assets/images/favicon.svg" />
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="assets/css/main.min.css" />
</head>
<body class="bg-white">
    <!-- Container start -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
                <form action="register.php" method="POST" class="my-5" id="registrationForm">
                    <div class="border border-light rounded-2 p-4 mt-5">
                        <div class="login-form">
                            <h2 class="fw-semibold mb-4" style="text-align: center;">Create your account</h2>
                            <?php if ($message): ?>
                                <div class="alert <?php echo $message_class; ?>"><?php echo $message; ?></div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter your email" required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" placeholder="Enter password" required/>
                                    <a href="#" class="input-group-text">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select" id="role_id" name="role_id" onchange="toggleStudentDropdown()" required>
                                    <option value="" disabled selected>Select a role</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="studentDropdown" class="mb-3" style="display:none;">
                                <label class="form-label">Select Child</label>
                                <select class="form-select" name="student_id">
                                    <option value="" disabled selected>Select a child</option>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['username']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" value="1" id="termsConditions" required />
                                    <label class="form-check-label" for="termsConditions">I agree to the terms and conditions</label>
                                </div>
                            </div>
                            <div class="d-grid py-3 mt-2">
                                <button type="submit" class="btn btn-lg btn-primary">Signup</button>
                            </div>
                            <div class="text-center pt-4">
                                <span>Already have an account?</span>
                                <a href="index.php" class="text-blue text-decoration-underline ms-2">Login</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container end -->

    <script>
        function toggleStudentDropdown() {
            const roleId = document.getElementById('role_id').value;
            const studentDropdown = document.getElementById('studentDropdown');
            if (roleId == 4) { // Assuming 4 is the role ID for Parent
                studentDropdown.style.display = 'block'; // Show dropdown for child selection
            } else {
                studentDropdown.style.display = 'none'; // Hide if not a parent
            }
        }
    </script>
</body>
</html>
