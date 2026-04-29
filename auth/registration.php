<?php
session_start();
include "../db.php";

// Initialize variables
$name = $email = $role = $password = $confirm_pass = "";
$email_error = $name_error = $role_error = $password_error = $confirm_pass_error = "";
$error = false;

if (isset($_GET['role']) && in_array($_GET['role'], ['farmer', 'investor'])) {
    $role = $_GET['role'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $role = trim($_POST["user_role"]);
    $password = trim($_POST["password"]);
    $confirm_pass = trim($_POST["confirm_password"]);

    // Validate Full Name
    if (empty($name)) {
        $name_error = "Full Name is required!";
        $error = true;
    }

    // Validate Email
    if (empty($email)) {
        $email_error = "Email is required!";
        $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format!";
        $error = true;
    }

    // Validate Role Selection
    if (empty($role)) {
        $role_error = "Please select a role!";
        $error = true;
    }

    // Validate Password
    if (empty($password)) {
        $password_error = "Password is required!";
        $error = true;
    } elseif (strlen($password) < 6) {
        $password_error = "Password must be at least 6 characters!";
        $error = true;
    }

    // Validate Confirm Password
    if (empty($confirm_pass)) {
        $confirm_pass_error = "Please confirm your password!";
        $error = true;
    } elseif ($password !== $confirm_pass) {
        $confirm_pass_error = "Passwords do not match!";
        $error = true;
    }

    // Check if email already exists in the database
    if (!$error) {
        $db_connection = databaseconnect();
        $statement = $db_connection->prepare("SELECT id FROM users WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $email_error = "Email is already used!";
            $error = true;
        }
        $statement->close();
    }

    // Insert Data if No Error
    if (!$error) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date("Y-m-d H:i:s");

        $statement = $db_connection->prepare(
            "INSERT INTO users (full_name, email, role, password, created_at) VALUES (?, ?, ?, ?, ?)"
        );
        $statement->bind_param("sssss", $name, $email, $role, $hashed_password, $created_at);
        $statement->execute();

        $_SESSION['id'] = $statement->insert_id;
        $_SESSION['fullname'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['created_at'] = $created_at;

        $statement->close();
        $db_connection->close();

        // Redirect based on role
        // if ($role == 'farmer') {
        //     header("Location: /login.php");
        // } else {
        //     header("Location: ../investor/dashboard.php");
        // }
        // exit;

        header("Location: ../auth/login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Fintech Agriculture</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow p-4" style="width: 450px;">
            <h4 class="text-center mb-3">Create an Account</h4>

            <!-- Form Starts -->
            <form id="signupForm" method="POST">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($name) ?>" required>
                    <span class="text-danger"><?= $name_error ?></span>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                    <span class="text-danger"><?= $email_error ?></span>
                </div>

                <div class="mb-3">
                    <label for="user_role" class="form-label">Register As</label>
                    <select class="form-select" id="user_role" name="user_role" required>
                        <option value="" disabled <?= empty($role) ? 'selected' : '' ?>>-- Select Role --</option>
                        <option value="farmer" <?= ($role == 'farmer') ? 'selected' : '' ?>>Farmer</option>
                        <option value="investor" <?= ($role == 'investor') ? 'selected' : '' ?>>Investor</option>
                    </select>
                    <span class="text-danger"><?= $role_error ?></span>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <span class="text-danger"><?= $password_error ?></span>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <span class="text-danger"><?= $confirm_pass_error ?></span>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-2">Sign Up</button>
            </form>

            <p class="text-center mt-3">
                Already have an account? <a href="login.php">Login</a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById("signupForm").addEventListener("submit", function(event) {
            let fullname = document.getElementById("fullname").value.trim();
            let email = document.getElementById("email").value.trim();
            let userRole = document.getElementById("user_role").value;
            let password = document.getElementById("password").value.trim();
            let confirmPassword = document.getElementById("confirm_password").value.trim();

            if (!fullname || !email || !userRole || !password || !confirmPassword) {
                event.preventDefault();
                alert("All fields are required!");
            } else if (password.length < 6) {
                event.preventDefault();
                alert("Password must be at least 6 characters!");
            } else if (password !== confirmPassword) {
                event.preventDefault();
                alert("Passwords do not match!");
            }
        });
    </script>
</body>

</html>