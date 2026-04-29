<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: ../admin/dashboard.php"); // Ensure this path is correct
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access | Restricted</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Custom Styles -->
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: 'Courier New', monospace;
        }
        .login-container {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid #0f0;
            box-shadow: 0 0 10px #0f0;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
            text-align: center;
        }
        .login-container h3 {
            color: #0f0;
        }
        .form-control {
            background: #111;
            border: 1px solid #0f0;
            color: #0f0;
        }
        .form-control::placeholder {
            color: rgba(0, 255, 0, 0.5);
        }
        .btn-custom {
            background: #0f0;
            color: #000;
            font-weight: bold;
        }
        .btn-custom:hover {
            background: #090;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="login-container">
    <h3>Admin Access Only</h3>
    <p>Unauthorized access will be logged.</p>

    <!-- Error Messages -->
    <?php if (isset($_SESSION['admin_login_error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['admin_login_error']; unset($_SESSION['admin_login_error']); ?>
        </div>
    <?php endif; ?>

    <form action="process_admin_login.php" method="POST">
        <div class="mb-3">
            <input type="text" class="form-control" name="admin_username" placeholder="Admin Username" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="admin_password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-custom w-100">Enter</button>
    </form>
</div>

</body>
</html>
