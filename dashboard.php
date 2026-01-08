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

<div class="container">
    <h2>Welcome, <?php echo $_SESSION['matric']; ?></h2>

    <a href="pay.php" class="btn">Pay School Fees</a>
    <a href="receipt.php" class="btn">View Latest Receipt</a>
    <a href="logout.php" class="btn" style="background-color:red;">Logout</a>
</div>

</body>
</html>
