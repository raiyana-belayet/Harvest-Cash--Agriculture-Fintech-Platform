<?php
session_start();
include('../db.php');

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$farmer_id = $_SESSION['id'];

$db_connection = databaseconnect();

// Fetch farmer's name and balance for the specific farmer
$nameBalancequery = "SELECT full_name, balance FROM users WHERE id = ?";
$stmt = $db_connection->prepare($nameBalancequery);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();
$farmerData = $result->fetch_assoc();
$farmerName = $farmerData['full_name'] ?? 'Farmer';
$balance = $farmerData['balance'] ?? 0; 
$stmt->close();
$db_connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Dashboard - AgriFinConnect</title>

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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <!-- <li><span class="text-light btn btn-secondary me-2">Balance: ৳<?php echo number_format($balance, 2); ?></span></li> -->
                    <!-- <li><a class="text-light btn btn-secondary me-2sme-2" href="../payment/withdraw_money.php">Withdraw Money</a></li> -->
                    <li><a class="text-light btn btn-danger me-2" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="fas fa-home me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="my_investments.php"><i class="fas fa-money-bill-wave me-2"></i> My Investments</a></li>
            <li class="nav-item"><a class="nav-link" href="browse_projects.php"><i class="fas fa-seedling me-2"></i> Available Projects</a></li>
            
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Dashboard Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary">Investor Dashboard</h3>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h6 class="text-uppercase">Balance</h6>
                            <h2>৳<?php echo number_format($balance, 2); ?></h2>
                            <small>+5% this month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h2><a class="text-light btn btn-warning me-2 me-2 fs-3" href="../payment/add_money.php">Add Money</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h2><a class="text-light btn btn-warning me-2 me-2 fs-3" href="../payment/withdraw_money.php">Withdraw Money</a></h2>
                        </div>
                    </div>
                </div>>
            </div>

            <!-- Recent Investments & Transactions
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Recent Investments</div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Organic Farming</td>
                                        <td>৳50,000</td>
                                        <td>Mar 12, 2024</td>
                                    </tr>
                                    <tr>
                                        <td>Fishery Expansion</td>
                                        <td>৳75,000</td>
                                        <td>Mar 5, 2024</td>
                                    </tr>
                                    <tr>
                                        <td>Dairy Farm</td>
                                        <td>৳25,000</td>
                                        <td>Feb 28, 2024</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">Recent Transactions</div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Investment</td>
                                        <td>৳50,000</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Profit Payout</td>
                                        <td>৳5,000</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>Withdrawal</td>
                                        <td>৳20,000</td>
                                        <td><span class="badge bg-danger">Failed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
