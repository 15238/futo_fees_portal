<?php
session_start();
include "db/config.php"; 

if (isset($_POST['login'])) {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
        "SELECT * FROM students WHERE matric_no='$matric' AND password='$password'"
    );

    if (mysqli_num_rows($query) == 1) {
        $_SESSION['matric'] = $matric;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h2>Student Login</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" class="login-form">
        <label for="matric">Username</label>
        <input type="text" id="matric" name="matric" placeholder="Enter Matric Number" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="login" class="btn login-btn">Login</button>
    </form>

    <div class="back-home">
        <a href="index.php">Back to Home</a>
    </div>
</div>

</body>
</html>

