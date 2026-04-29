<?php
session_start();
include "../db.php"; // Include database connection

// Initialize variables
$email = $password = "";
$email_error = $password_error = $login_error = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    // Validate email
    if (empty($email)) {
        $email_error = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format!";
    }

    // Validate password
    if (empty($password)) {
        $password_error = "Password is required!";
    }

    // If no errors, check in database
    if (empty($email_error) && empty($password_error)) {
        $db_connection = databaseconnect();
        
        $stmt = $db_connection->prepare("SELECT id, full_name, email, role, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $full_name, $db_email, $role, $hashed_password);
            $stmt->fetch();
            
            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Start session and store user data
                $_SESSION['id'] = $id;
                $_SESSION['fullname'] = $full_name;
                $_SESSION['email'] = $db_email;
                $_SESSION['role'] = $role;

                // Redirect based on role
                if ($role == 'farmer') {
                    header("Location: ../farmer/dashboard.php");
                } else {
                    header("Location: ../investor/dashboard.php");
                }
                exit;
            } else {
                $login_error = "Incorrect email or password!";
            }
        } else {
            $login_error = "Incorrect email or password!";
        }
        $stmt->close();
        $db_connection->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Fintech Agriculture</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 400px;">
        <h4 class="text-center mb-4">Login to Your Account</h4>

        <form id="loginForm" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                <span class="text-danger"><?= $email_error ?></span>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <span class="text-danger"><?= $password_error ?></span>
            </div>

            <span class="text-danger"><?= $login_error ?></span>

            <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
        </form>

        <div class="text-center mt-3">
            <p>Don't have an account? <a href="registration.php">Sign Up</a></p>
            <p><a href="forgot_password.php">Forgot Password?</a></p>
        </div>
    </div>
</div>

</body>
</html>
