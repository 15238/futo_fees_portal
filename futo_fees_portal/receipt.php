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

<div class="receipt-container">
    <div class="receipt-card">
        <h2>Payment Receipt</h2>
        <hr>

        <p><strong>Student Name:</strong> <?php echo $_SESSION['username']; ?></p>
        <p><strong>Matric Number:</strong> <?php echo $_SESSION['matric']; ?></p>
        <p><strong>Amount Paid:</strong> ₦<?php echo $amount; ?></p>
        <p><strong>Payment Date:</strong> <?php echo $date; ?></p>
        <p><strong>Reference ID:</strong> <?php echo $reference; ?></p>

        <button onclick="window.print()" class="print-btn">Print Receipt</button>
    </div>
</div>

</body>
</html>
