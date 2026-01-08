<?php
session_start();
include "db/config.php";

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['pay'])) {
    $matric = $_SESSION['matric'];
    $amount = $_POST['amount'];
    $ref = "FUTO" . rand(10000, 99999);

    mysqli_query($conn, "INSERT INTO payments (matric_no, amount, reference) 
                        VALUES ('$matric', '$amount', '$ref')");

    header("Location: receipt.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pay School Fees</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h2>Pay Your School Fees</h2>

    <form method="POST">
        <input type="number" name="amount" placeholder="Enter Amount (₦)" required>
        <button type="submit" name="pay">Pay Now</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>

</body>
</html>
