<?php
session_start();
require_once 'config.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate the token
    if (!isset($_POST['token']) || empty($_POST['token'])) {
        $_SESSION['reset_error'] = "Invalid or expired reset link.";
        header("Location: forgot_password.php");
        exit();
    }

    $token = htmlspecialchars($_POST['token']);

    // Validate token and expiry (within 30 minutes)
    $stmt = $conn->prepare("SELECT email, created_at FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['reset_error'] = "Invalid or expired reset link.";
        header("Location: forgot_password.php");
        exit();
    }

    $stmt->bind_result($email, $created_at);
    $stmt->fetch();
    $stmt->close();

    // Check if token expired (older than 30 minutes)
    $created_time = strtotime($created_at);
    $current_time = time();
    $diff_minutes = ($current_time - $created_time) / 60;

    if ($diff_minutes > 30) {
        $_SESSION['reset_error'] = "Reset link has expired. Please request a new one.";
        // Optionally delete old token
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();

        header("Location: forgot_password.php");
        exit();
    }

    // Get the new password
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Validate passwords
    if (strlen($password) < 6) {
        $_SESSION['reset_error'] = "Password must be at least 6 characters.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    } elseif ($password !== $confirmPassword) {
        $_SESSION['reset_error'] = "Passwords do not match.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);
    $stmt->execute();
    $stmt->close();

    // Delete the reset token after successful password change
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();

    $_SESSION['reset_msg'] = "Your password has been reset successfully.";
    header("Location: login.php");
    exit();
}
?>
