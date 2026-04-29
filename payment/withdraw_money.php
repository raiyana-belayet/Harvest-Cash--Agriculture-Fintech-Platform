<?php
session_start();
include('../db.php');

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'] ?? 0;
    $password = $_POST['password'] ?? '';

    $farmer_id = $_SESSION['id'];

    $db_connection = databaseconnect();

    // Fetch farmer's actual password and current balance for verification and update
    $query = "SELECT password, balance FROM users WHERE id = ?";
    $stmt = $db_connection->prepare($query);
    $stmt->bind_param("i", $farmer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $farmer = $result->fetch_assoc();

    if ($farmer && password_verify($password, $farmer['password'])) {
        // Password correct: Proceed to withdraw money
        $current_balance = $farmer['balance'];

        // Check if the amount to withdraw is less than or equal to the balance
        if ($amount <= $current_balance) {
            // Calculate the new balance
            $new_balance = $current_balance - $amount;

            // Update the balance in the database
            $update_query = "UPDATE users SET balance = ? WHERE id = ?";
            $update_stmt = $db_connection->prepare($update_query);
            $update_stmt->bind_param("di", $new_balance, $farmer_id);
            $update_stmt->execute();
            $update_stmt->close();

            $success = true; // Operation successful
        } else {
            $error = 'Insufficient balance!';
        }
    } else {
        $error = 'Invalid password!';
    }

    $stmt->close();
    $db_connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Withdraw Money - AgriFinConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="mb-4 text-center">Withdraw Money</h3>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (৳)</label>
                        <input type="number" name="amount" id="amount" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Confirm Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="successModalLabel">Success</h5>
      </div>
      <div class="modal-body">
        Withdrawal completed successfully!
      </div>
      <div class="modal-footer">
        <a href="../<?php echo $_SESSION['role']; ?>/dashboard.php" class="btn btn-success">Go to Dashboard</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and Modal Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if ($success): ?>
<script>
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
</script>
<?php endif; ?>

</body>
</html>
