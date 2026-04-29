<?php
session_start();
require_once 'config.php'; // DB connection

if (!isset($_GET['token']) || empty($_GET['token'])) {
    $_SESSION['reset_error'] = "Invalid or expired reset link.";
    header("Location: forgot_password.php");
    exit();
}

$token = htmlspecialchars($_GET['token']);

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password | Fintech Agriculture</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow p-4" style="width: 400px;">
            <h4 class="text-center mb-3">Reset Your Password</h4>

            <?php if (isset($_SESSION['reset_error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['reset_error'];
                                                unset($_SESSION['reset_error']); ?></div>
            <?php endif; ?>

            <form id="resetPasswordForm" action="process_password_reset.php" method="POST">
                <input type="hidden" name="token" value="<?php echo $token; ?>">

                <!-- Password fields -->
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>


            <p class="text-center mt-3">
                <a href="login.php">Back to Login</a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById("resetPasswordForm").addEventListener("submit", function(event) {
            let password = document.getElementById("password").value.trim();
            let confirmPassword = document.getElementById("confirm_password").value.trim();

            if (password.length < 6) {
                event.preventDefault();
                alert("Password must be at least 6 characters.");
            } else if (password !== confirmPassword) {
                event.preventDefault();
                alert("Passwords do not match.");
            }
        });
    </script>

</body>

</html>