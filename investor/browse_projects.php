<?php
session_start();
include "../db.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$db_connection = databaseconnect();

$sql_approved_projects = "SELECT p.id, p.title, p.category, p.target_amount, p.start_date, p.end_date, p.description, p.farmer_id, p.roi FROM projects p WHERE p.status = 'approved'";
$result_approved_projects = $db_connection->query($sql_approved_projects);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invest_amount']) && isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];
    $invest_amount = $_POST['invest_amount'];

    $investor_id = $_SESSION['id'];

    // Fetch the investor's balance
    $sql_investor_balance = "SELECT balance FROM users WHERE id = ?";
    $stmt_balance = $db_connection->prepare($sql_investor_balance);
    $stmt_balance->bind_param("i", $investor_id);
    $stmt_balance->execute();
    $result_balance = $stmt_balance->get_result();
    $investor = $result_balance->fetch_assoc();
    $investor_balance = $investor['balance'];

    // Fetch the project details
    $sql_project = "SELECT * FROM projects WHERE id = ?";
    $stmt_project = $db_connection->prepare($sql_project);
    $stmt_project->bind_param("i", $project_id);
    $stmt_project->execute();
    $result_project = $stmt_project->get_result();
    $project = $result_project->fetch_assoc();

    if ($investor_balance >= $invest_amount) {
        // If the investor has enough balance, proceed with the investment

        // Reduce balance from investor
        $new_investor_balance = $investor_balance - $invest_amount;
        $update_investor_balance = "UPDATE users SET balance = ? WHERE id = ?";
        $stmt_update_investor = $db_connection->prepare($update_investor_balance);
        $stmt_update_investor->bind_param("di", $new_investor_balance, $investor_id);
        $stmt_update_investor->execute();

        // Add the investment to the project creator's balance
        $project_creator_id = $project['farmer_id'];
        $sql_farmer_balance = "SELECT balance FROM users WHERE id = ?";
        $stmt_farmer_balance = $db_connection->prepare($sql_farmer_balance);
        $stmt_farmer_balance->bind_param("i", $project_creator_id);
        $stmt_farmer_balance->execute();
        $result_farmer_balance = $stmt_farmer_balance->get_result();
        $farmer = $result_farmer_balance->fetch_assoc();
        $farmer_balance = $farmer['balance'];
        $new_farmer_balance = $farmer_balance + $invest_amount;

        // Update the project creator's balance
        $update_farmer_balance = "UPDATE users SET balance = ? WHERE id = ?";
        $stmt_update_farmer = $db_connection->prepare($update_farmer_balance);
        $stmt_update_farmer->bind_param("di", $new_farmer_balance, $project_creator_id);
        $stmt_update_farmer->execute();

        // Add the investment record to the investments table
        $sql_investment = "INSERT INTO investments (investor_id, project_id, amount, investment_date, status) VALUES (?, ?, ?, NOW(), 'pending')";
        $stmt_investment = $db_connection->prepare($sql_investment);
        $stmt_investment->bind_param("iid", $investor_id, $project_id, $invest_amount);
        $stmt_investment->execute();

        // Update project status to closed
        $update_project_status = "UPDATE projects SET status = 'closed' WHERE id = ?";
        $stmt_update_project = $db_connection->prepare($update_project_status);
        $stmt_update_project->bind_param("i", $project_id);
        $stmt_update_project->execute();

        // Close the database connections
        $stmt_update_investor->close();
        $stmt_update_farmer->close();
        $stmt_investment->close();
        $stmt_update_project->close();

        // Redirect after success
        header("Location: browse_projects.php?success=true");
        exit();
    } else {
        // Insufficient balance
        $error = "Insufficient balance to make the investment.";
    }
}

$db_connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Projects - AgriFinConnect</title>

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
            top: 56px;
            left: 0;
            background-color: #0d6efd;
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
            <li class="nav-item"><a class="nav-link" href="my_investments.php"><i class="fas fa-money-bill-wave me-2"></i> My Investments</a></li>
            <li class="nav-item"><a class="nav-link active" href="browse_projects.php"><i class="fas fa-seedling me-2"></i> Browse Projects</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary">Available Projects</h3>
                <input type="text" class="form-control w-25" placeholder="Search Projects">
            </div>

            <!-- Projects List -->
            <div class="row">
                <?php
                if ($result_approved_projects->num_rows > 0) {
                    while ($project = $result_approved_projects->fetch_assoc()) {
                        // Calculate the duration in months
                        $start_date = new DateTime($project['start_date']);
                        $end_date = new DateTime($project['end_date']);
                        $duration = $start_date->diff($end_date)->format('%m months');
                ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-success text-white"><?= $project['title'] ?></div>
                                <div class="card-body">
                                    <p><strong>Category:</strong> <?= $project['category'] ?></p>
                                    <p><strong>Amount Needed:</strong> ৳<?= number_format($project['target_amount'], 2) ?></p>
                                    <p><strong>Expected ROI:</strong> 15%</p>
                                    <p><strong>Duration:</strong> <?= $duration ?></p>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewProjectModal<?= $project['id'] ?>">View Details</button>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#investModal<?= $project['id'] ?>">Invest</button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="viewProjectModal<?= $project['id'] ?>" tabindex="-1" aria-labelledby="viewProjectModalLabel<?= $project['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="viewProjectModalLabel<?= $project['id'] ?>">Project Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Project Name:</strong> <?= $project['title'] ?></p>
                                        <p><strong>Category:</strong> <?= $project['category'] ?></p>
                                        <p><strong>Amount Needed:</strong> ৳<?= number_format($project['target_amount'], 2) ?></p>
                                        <p><strong>Expected ROI:</strong> 15%</p>
                                        <p><strong>Duration:</strong> <?= $duration ?></p>
                                        <p><strong>Description:</strong> <?= $project['description'] ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#investModal<?= $project['id'] ?>">Invest Now</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Invest Modal -->
                        <div class="modal fade" id="investModal<?= $project['id'] ?>" tabindex="-1" aria-labelledby="investModalLabel<?= $project['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="investModalLabel<?= $project['id'] ?>">Confirm Investment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="browse_projects.php" method="POST">
                                        <div class="modal-body">
                                            <p><strong>Project:</strong> <?= $project['title'] ?></p>
                                            <p><strong>Amount Needed:</strong> ৳<?= number_format($project['target_amount'], 2) ?></p>
                                            <?php
                                            if (isset($error)) {
                                                echo "<p class='text-danger'>$error</p>";
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <?php if (isset($error)) { ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <?php } else { ?>
                                                <button type="submit" class="btn btn-success">Confirm Investment</button>
                                            <?php } ?>
                                        </div>
                                        <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                        <input type="hidden" name="invest_amount" value="<?= $project['target_amount'] ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<div class='col-12'><p>No approved projects available.</p></div>";
                }
                ?>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
