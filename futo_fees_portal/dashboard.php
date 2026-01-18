<?php
session_start();

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard">
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

    <div class="cards">
        <a href="pay.php" class="card">
            <span class="icon">💳</span>
            <p>Pay School Fees</p>
        </a>

        <a href="receipt.php" class="card">
            <span class="icon">🧾</span>
            <p>View Latest Receipt</p>
        </a>

        <a href="logout.php" class="card logout-card">
            <span class="icon">🚪</span>
            <p>Logout</p>
        </a>
    </div>
</div>

</body>
</html>
