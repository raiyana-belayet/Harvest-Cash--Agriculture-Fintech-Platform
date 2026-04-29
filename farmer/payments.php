<?php
session_start();
include "../db.php";

$db_connection = databaseconnect();


$farmer_id = $_SESSION['id'];  // Assuming the farmer is logged in
$sql_projects = "SELECT p.id, p.title, p.target_amount, p.roi, p.status 
                 FROM projects p 
                 WHERE p.status = 'finished' AND p.farmer_id = ?";
$stmt_projects = $db_connection->prepare($sql_projects);
$stmt_projects->bind_param("i", $farmer_id);
$stmt_projects->execute();
$result_projects = $stmt_projects->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_amount']) && isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];
    $payment_amount = $_POST['payment_amount'];

    // Fetch the farmer's balance
    $farmer_id = $_SESSION['id'];
    $sql_farmer_balance = "SELECT balance FROM users WHERE id = ?";
    $stmt_balance = $db_connection->prepare($sql_farmer_balance);
    $stmt_balance->bind_param("i", $farmer_id);
    $stmt_balance->execute();
    $result_balance = $stmt_balance->get_result();
    $farmer = $result_balance->fetch_assoc();
    $farmer_balance = $farmer['balance'];

    // If sufficient balance, proceed with payment
    if ($farmer_balance >= $payment_amount) {
        // Reduce balance from the farmer
        $new_farmer_balance = $farmer_balance - $payment_amount;
        $update_farmer_balance = "UPDATE users SET balance = ? WHERE id = ?";
        $stmt_update_farmer = $db_connection->prepare($update_farmer_balance);
        $stmt_update_farmer->bind_param("di", $new_farmer_balance, $farmer_id);
        $stmt_update_farmer->execute();

        // Get the investor of the project
        $sql_investor = "SELECT investor_id FROM investments WHERE project_id = ? LIMIT 1";
        $stmt_investor = $db_connection->prepare($sql_investor);
        $stmt_investor->bind_param("i", $project_id);
        $stmt_investor->execute();
        $result_investor = $stmt_investor->get_result();
        $investor = $result_investor->fetch_assoc();
        $investor_id = $investor['investor_id'];

        // Fetch the investor's balance
        $sql_investor_balance = "SELECT balance FROM users WHERE id = ?";
        $stmt_investor_balance = $db_connection->prepare($sql_investor_balance);
        $stmt_investor_balance->bind_param("i", $investor_id);
        $stmt_investor_balance->execute();
        $result_investor_balance = $stmt_investor_balance->get_result();
        $investor_data = $result_investor_balance->fetch_assoc();
        $investor_balance = $investor_data['balance'];

        // Add payment to investor's balance
        $new_investor_balance = $investor_balance + $payment_amount;
        $update_investor_balance = "UPDATE users SET balance = ? WHERE id = ?";
        $stmt_update_investor = $db_connection->prepare($update_investor_balance);
        $stmt_update_investor->bind_param("di", $new_investor_balance, $investor_id);
        $stmt_update_investor->execute();


        // Update project status to 'paid'
        $update_project_status = "UPDATE projects SET status = 'paid' WHERE id = ?";
        $stmt_update_project = $db_connection->prepare($update_project_status);
        $stmt_update_project->bind_param("i", $project_id);
        $stmt_update_project->execute();

        // Close the database connections
        $stmt_update_farmer->close();
        $stmt_update_investor->close();
        $stmt_update_project->close();

        // Redirect after success
        header("Location: payments.php?success=true");
        exit();
    } else {
        $error = "Insufficient balance for the payment.";
    }
}

$db_connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - AgriFinConnect</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Sidebar full height */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #198754;
            color: white;
            padding-top: 60px;
        }

        .sidebar .nav-link {
            color: white;
            padding: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        @media (max-width: 992px) {
            .sidebar {
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
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar col-md-3 col-lg-2 d-md-block">
        <div class="position-sticky">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="create_project.php"><i class="fas fa-plus-circle me-2"></i> Create Project</a></li>
                <li class="nav-item"><a class="nav-link" href="my_projects.php"><i class="fas fa-folder-open me-2"></i> My Projects</a></li>
                <li class="nav-item"><a class="nav-link active" href="payments.php"><i class="fas fa-wallet me-2"></i> Payments</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="h3 mb-4">Payment Records</h1>

        <!-- Payments Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Project Name</th>
                        <th>Investment (৳)</th>
                        <th>Amount to Return (৳)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_projects->num_rows > 0) {
                        while ($project = $result_projects->fetch_assoc()) {
                            // Calculate the amount to return
                            $amount_to_return = $project['target_amount'] + ($project['target_amount'] * $project['roi'] / 100);
                    ?>
                            <tr>
                                <td><?= $project['id'] ?></td>
                                <td><?= $project['title'] ?></td>
                                <td><?= number_format($project['target_amount'], 2) ?></td>
                                <td><?= number_format($amount_to_return, 2) ?></td>
                                <td><span class="badge bg-warning">Finished</span></td>
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#makePaymentModal<?= $project['id'] ?>"><i class="fas fa-money-bill-wave"></i> Make Payment</button>
                                </td>
                            </tr>

                            <!-- Make Payment Modal -->
                            <div class="modal fade" id="makePaymentModal<?= $project['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Make Payment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Amount to Pay (৳): </strong> <?= number_format($amount_to_return, 2) ?></p>
                                            
                                            <!-- Show insufficient balance if needed -->
                                            <?php if (isset($error)) { ?>
                                                <p class="text-danger"><?= $error ?></p>
                                            <?php } ?>

                                            <form action="payments.php" method="POST">
                                                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                                <input type="hidden" name="payment_amount" value="<?= $amount_to_return ?>">

                                                <button type="submit" class="btn btn-success">Confirm Payment</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No finished projects available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
