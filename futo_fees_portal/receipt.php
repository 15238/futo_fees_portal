<?php
session_start();

$lhost = "sql110.infinityfree.com";
$dbuser = "if0_40877842";   
$pass = "6fZk1bQKbU";       
$db = "if0_40877842_futo_fees_portal_main";

$connection = mysqli_connect($lhost, $dbuser, $pass, $db);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$matric = $_SESSION['matric'];

// Get the most recent payment
$query = mysqli_query($connection, "SELECT * FROM payments WHERE matric_no='$matric' ORDER BY id DESC LIMIT 1");
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
