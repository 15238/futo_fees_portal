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

if (isset($_POST['pay'])) {
    $matric = $_SESSION['matric'];
    $amount = $_POST['amount'];
    $ref = "FUTO" . rand(10000, 99999);

    mysqli_query($connection, "INSERT INTO payments (matric_no, amount, reference) 
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
