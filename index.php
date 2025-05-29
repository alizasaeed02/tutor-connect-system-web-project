<?php
session_start();
require 'Database/config.php';

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect based on role_id
    switch ($_SESSION['role_id']) {
        case 1:
            header("Location: Student/student_dashboard.php");
            break;
        case 2:
            header("Location: Tutor/instructor_dashboard.php");
            break;
        case 3:
            header("Location: Administrator/admin_dashboard.php");
            break;
        case 4:
            header("Location: Parent/parent_dashboard.php");
            break;
        default:
            header("Location: logout.php");
            break;
    }
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); // Check if "Remember Me" is checked

    // Prepare and execute the statement to fetch user data
    $stmt = $conn->prepare("SELECT id, username, password, role_id, isActive FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password and check if user is active
    if ($user && password_verify($password, $user['password'])) {
        if ($user['isActive'] == 1) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['profile_photo'] = $user['profile_photo'];

            // Set a cookie if "Remember Me" is checked
            if ($remember) {
                setcookie('user_id', $user['id'], time() + (86400 * 30), "/"); // 86400 = 1 day
            }

            // Redirect based on role_id
            switch ($user['role_id']) {
                case 1:
                    header("Location: Student/student_dashboard.php");
                    break;
                case 2:
                    header("Location: Tutor/instructor_dashboard.php");
                    break;
                case 3:
                    header("Location: Administrator/admin_dashboard.php");
                    break;
                case 4:
                    header("Location: Parent/parent_dashboard.php");
                    break;
                default:
                    header("Location: logout.php");
                    break;
            }
            exit;
        } else {
            $error = 'Please contact the Administrator for account approval.';
        }
    } else {
        $error = 'Invalid email or password';
    }
}

// Check if the user ID is set in the cookie and not in the session
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
    $stmt = $conn->prepare("SELECT id, username, role_id FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['profile_photo'] = $user['profile_photo'];

        // Redirect based on role_id
        switch ($user['role_id']) {
            case 1:
                header("Location: Student/student_dashboard.php");
                break;
            case 2:
                header("Location: Tutor/instructor_dashboard.php");
                break;
            case 3:
                header("Location: Administrator/admin_dashboard.php");
                break;
            case 4:
                header("Location: Parent/parent_dashboard.php");
                break;
            default:
                header("Location: logout.php");
                break;
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Tutor Management System</title>

    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="assets/css/main.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .login-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .input-group {
            position: relative;
        }

        .input-group .eye-button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 20px;
            transition: color 0.3s;
        }

        .input-group .eye-button:hover {
            color: #007bff; /* Change color on hover */
        }

        /* Animation for input fields */
        .form-control {
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .alert {
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .alert.show {
            opacity: 1;
        }

        /* Animation for eye button */
        .eye-button.animate {
            animation: blink 0.5s forwards;
        }

        @keyframes blink {
            0% {
                transform: translateY(-50%) scale(1);
            }
            50% {
                transform: translateY(-50%) scale(1.2);
            }
            100% {
                transform: translateY(-50%) scale(1);
            }
        }

        .bi-eye {
            transition: transform 0.3s;
        }

        .bi-eye-slash {
            transition: transform 0.3s;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
                <form action="index.php" method="POST" class="my-5">
                    <div class="border border-light rounded-2 p-4 mt-5 login-form">
                        <h2 class="fw-semibold mb-4 text-center">Login</h2>
                        <?php if ($error): ?>
                            <div class="alert alert-danger show"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required autocomplete="email" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required autocomplete="current-password" />
                                <button type="button" class="eye-button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberPassword" />
                                <label class="form-check-label" for="rememberPassword">Remember</label>
                            </div>
                        </div>
                        <div class="d-grid py-3 mt-2">
                            <button type="submit" class="btn btn-lg btn-primary">Login</button>
                        </div>
                        <div class="text-center pt-4">
                            <span>Not registered?</span>
                            <a href="register.php" class="text-blue text-decoration-underline ms-2">SignUp</a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Add animation class
            this.classList.add('animate');
            setTimeout(() => {
                this.classList.remove('animate');
            }, 500);

            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        // Show alert message with animation
        if (document.querySelector('.alert')) {
            document.querySelector('.alert').classList.add('show');
        }
    </script>
</body>

</html>
