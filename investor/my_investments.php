<?php
session_start();
include "../db.php";

$db_connection = databaseconnect();

$investor_id = $_SESSION['id'];
$sql_investments = "SELECT i.id, p.title AS project_name, i.amount, p.roi, p.status 
                    FROM investments i
                    JOIN projects p ON i.project_id = p.id
                    WHERE i.investor_id = ?";
$stmt_investments = $db_connection->prepare($sql_investments);
$stmt_investments->bind_param("i", $investor_id);
$stmt_investments->execute();
$result_investments = $stmt_investments->get_result();

$db_connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Investments - AgriFinConnect</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 56px; /* Below navbar */
            left: 0;
            background-color: #0d6efd;
            padding-top: 20px;
            color: white;
        }
        .sidebar .nav-link {
            color: white;
            padding: 12px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px; /* Prevent overlap with navbar */
        }

        /* Responsive */
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-chart-line me-2"></i> AgriFinConnect Investor</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="my_investments.php"><i class="fas fa-money-bill-wave me-2"></i> My Investments</a></li>
            <li class="nav-item"><a class="nav-link" href="browse_projects.php"><i class="fas fa-seedling me-2"></i> Available Projects</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary">My Investments</h3>
            </div>

            <!-- Investment Table -->
            <div class="card">
                <div class="card-header bg-success text-white">Investment Records</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Amount Invested</th>
                                <th>ROI</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_investments->num_rows > 0) {
                                while ($investment = $result_investments->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $investment['project_name'] ?></td>
                                    <td>৳<?= number_format($investment['amount'], 2) ?></td>
                                    <td><?= $investment['roi'] ?>%</td>
                                    <td><span class="badge bg-<?= $investment['status'] == 'approved' ? 'success' : 'warning' ?>"><?= ucfirst($investment['status']) ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewInvestmentModal<?= $investment['id'] ?>"><i class="fas fa-eye"></i></button>
                                
                                    </td>
                                </tr>

                                <!-- View Investment Modal -->
                                <div class="modal fade" id="viewInvestmentModal<?= $investment['id'] ?>" tabindex="-1" aria-labelledby="viewInvestmentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="viewInvestmentModalLabel">Investment Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Project:</strong> <?= $investment['project_name'] ?></p>
                                                <p><strong>Amount Invested:</strong> ৳<?= number_format($investment['amount'], 2) ?></p>
                                                <p><strong>ROI:</strong> <?= $investment['roi'] ?>%</p>
                                                <p><strong>Status:</strong> <?= ucfirst($investment['status']) ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No investments found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
