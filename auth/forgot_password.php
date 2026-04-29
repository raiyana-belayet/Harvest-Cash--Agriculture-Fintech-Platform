<?php
session_start();
require_once 'config.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['reset_error'] = "Invalid email address.";
        header("Location: forgot_password.php");
        exit();
    }

    // Check if email exists in users table
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['reset_error'] = "Email not found.";
        header("Location: forgot_password.php");
        exit();
    }

    // Generate token
    $token = bin2hex(random_bytes(32));

    // Remove old token if any
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Store new token with created_at only
    $stmt = $conn->prepare("INSERT INTO password_resets (email, token, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();

    // Send reset email
    require 'send_reset_email.php';
    sendResetEmail($email, $token);

    $_SESSION['reset_msg'] = "Password reset link sent to your email.";
    header("Location: forgot_password.php");
    exit();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Fintech Agriculture</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 400px;">
        <h4 class="text-center mb-3">Forgot Password</h4>

        <?php if (isset($_SESSION['reset_error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['reset_msg'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['reset_msg']; unset($_SESSION['reset_msg']); ?></div>
        <?php endif; ?>

        <form action="forgot_password.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Enter your email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>

        <p class="text-center mt-3">
            <a href="login.php">Back to Login</a>
        </p>
    </div>
</div>

</body>
</html>