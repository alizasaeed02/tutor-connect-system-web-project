<?php
    session_start();

    // Unset all session variables
    $_SESSION = array();

    // If a session cookie exists, delete it
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // If the "Remember Me" cookie exists, delete it
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', time() - 3600, '/');
    }

    // Redirect to login page
    header("Location: index.php");
    exit;
?>
