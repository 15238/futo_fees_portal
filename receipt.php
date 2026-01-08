<?php
session_start();
include "db/config.php";

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$matric = $_SESSION['matric'];

// Get the most recent payment
$query = mysqli_query($conn, "SELECT * FROM payments WHERE matric_no='$matric' ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h2>Payment Receipt</h2>

    <?php if ($data): ?>
        <p><strong>Matric Number:</strong> <?php echo $matric; ?></p>
        <p><strong>Amount Paid:</strong> ₦<?php echo $data['amount']; ?></p>
        <p><strong>Reference:</strong> <?php echo $data['reference']; ?></p>
        <p><strong>Date:</strong> <?php echo $data['date']; ?></p>
    <?php else: ?>
        <p>No payment record found.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>

</body>
</html>
