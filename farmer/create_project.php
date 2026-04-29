<?php
session_start();

include "../db.php";

$title = $amount_needed = $duration = $return_rate = $description = "";
$title_error = $amount_needed_error = $duration_error = $return_rate_error = $description_error = "";
$error = false;


if (!isset($_SESSION['id'])) {
    header("Location: /auth/login.php");
    exit;
}

$farmer_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $amount_needed = trim($_POST['amount_needed']);
    $duration = trim($_POST['duration']);
    $return_rate = trim($_POST['return_rate']);
    $description = trim($_POST['description']);

    if (empty($title)) {
        $title_error = "Project name is required!";
        $error = true;
    }
    if (empty($amount_needed) || !is_numeric($amount_needed)) {
        $amount_needed_error = "Valid amount needed is required!";
        $error = true;
    }
    if (empty($duration) || !is_numeric($duration)) {
        $duration_error = "Valid duration is required!";
        $error = true;
    }
    if (empty($return_rate) || !is_numeric($return_rate)) {
        $return_rate_error = "Valid return rate is required!";
        $error = true;
    }
    if (empty($description)) {
        $description_error = "Project description is required!";
        $error = true;
    }

    if (!$error) {
        $db_connection = databaseconnect();

        $statement = $db_connection->prepare("INSERT INTO projects (farmer_id, title, description, category, target_amount, raised_amount, start_date, end_date, status, created_at, roi) VALUES (?, ?, ?, ?, ?, 0, NOW(), DATE_ADD(NOW(), INTERVAL ? MONTH), 'pending', NOW(), ?)");
        $statement->bind_param("isssdds", $farmer_id, $title, $description, $category, $amount_needed, $duration, $return_rate);

        $category = "Agriculture";

        $statement->execute();
        $statement->close();
        $db_connection->close();

        echo "<script>alert('Project created successfully'); window.location = 'my_projects.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project - Farmer Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            /* Full height */
            width: 250px;
            position: fixed;
            top: 56px;
            /* Push below navbar */
            left: 0;
            background-color: #198754;
            padding-top: 20px;
            color: white;
        }

        .sidebar .nav-link {
            color: white;
            padding: 12px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px;
            /* Prevent overlap with navbar */
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-seedling me-2"></i> AgriFinConnect Farmer</a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> Farmer
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div> -->
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="create_project.php"><i class="fas fa-plus-circle me-2"></i> Create Project</a></li>
            <li class="nav-item"><a class="nav-link" href="my_projects.php"><i class="fas fa-folder-open me-2"></i> My Projects</a></li>
            <li class="nav-item"><a class="nav-link" href="payments.php"><i class="fas fa-hand-holding-usd me-2"></i> Payments</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="card shadow-sm p-4">
                <h3 class="text-success">Create New Project</h3>
                <form method="POST" action="create_project.php">
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($title) ?>" required>
                        <span class="text-danger"><?= $title_error ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount Needed (৳)</label>
                        <input type="number" class="form-control" name="amount_needed" value="<?= htmlspecialchars($amount_needed) ?>" required>
                        <span class="text-danger"><?= $amount_needed_error ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duration (months)</label>
                        <input type="number" class="form-control" name="duration" value="<?= htmlspecialchars($duration) ?>" required>
                        <span class="text-danger"><?= $duration_error ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expected Return (%)</label>
                        <input type="number" class="form-control" name="return_rate" value="<?= htmlspecialchars($return_rate) ?>" required>
                        <span class="text-danger"><?= $return_rate_error ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project Description</label>
                        <textarea class="form-control" name="description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
                        <span class="text-danger"><?= $description_error ?></span>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Create Project</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>