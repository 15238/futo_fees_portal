<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

$lhost = "sql110.infinityfree.com";
$dbuser = "if0_40877842";   
$pass = "6fZk1bQKbU";       
$db = "if0_40877842_futo_fees_portal_main";

$connection = mysqli_connect($lhost, $dbuser, $pass, $db);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
  $username = trim($_POST['username']);
  $regno = trim($_POST['regno']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];

  // 1️⃣ Validate regno length (must be exactly 11 characters)
  if (!preg_match('/^\d{11}$/', $regno)) {
    $_SESSION['message'] = "❌ Registration number must be exactly 11 digits!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  // 2️⃣ Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "❌ Please enter a valid email address!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  // 3️⃣ Validate password strength (at least one letter and one number, 6+ chars)
  if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
    $_SESSION['message'] = "❌ Password must contain more than 8 values, a character and a number!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  // check if passwords match
  if ($password !== $confirmPassword) {
    $_SESSION['message'] = "❌ Passwords do not match!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO groupseven (username, regno, email, password)
            VALUES ('$username', '$regno', '$email', '$hashedPassword')";

  $insert = mysqli_query($connection, $query);

  if ($insert) {
    $_SESSION['message'] = "✅ Registration successful!";
  } else {
    $_SESSION['message'] = "❌ Registration failed: " . mysqli_error($connection);
    $_SESSION['show_register'] = true;
  }

  header("Location: login.php");
  exit();
}

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM groupseven WHERE username = '$username' LIMIT 1";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
          // ✅ Store user details in session
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['matric'] = $user['regno'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['logged_in'] = true;

          header("Location: dashboard.php");
          exit();
    } else {
      $_SESSION['message'] = "❌ Incorrect password!";
      header("Location: login.php");
      exit();
    }
  } else {
    $_SESSION['message'] = "❌ Username not found!";
    header("Location: login.php");
    exit();
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

    <section class="auth-section">
        <div class="auth-card">
              <div class="auth-icon">🎓</div>
              <h2 class="auth-title">School Fees Payment Portal</h2>
              <p class="auth-subtitle">Pay your school fees from your comfort zone</p>

              <div class="auth-tabs">
                <button id="signInTab" class="tab-btn active">Sign In</button>
                <button id="signUpTab" class="tab-btn">Sign Up</button>
              </div>

              <!-- Sign In Form -->
              <form id="signInForm" class="login-form" method="POST" action="login.php">
                <label>Full Name</label>
                <input type="text" name="username" placeholder="Enter your Full Name" required />

                <label>Password</label>
                <div class="password-container">
                  <input type="password" id="login-password" name="password" placeholder="Enter your password" required />
                  <span class="password-toggle" onclick="togglePassword('login-password', this)">👁️</span>
                </div>

                <button type="submit" name="login">Sign In</button>
              </form>


              <!-- Sign Up Form -->
              <form id="signUpForm" class="login-form" method="POST" action="login.php" style="display:none;">
                <label>Full Name</label>
                <input type="text" name="username" placeholder="Enter your Full Name" required />

                <label>Registration Number</label>
                <input type="text" name="regno" placeholder="Enter your Registration Number" required />

                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required />

                <label>Password</label>
                <div class="password-container">
                  <input type="password" id="signup-password" name="password" placeholder="Create a password" required />
                  <span class="password-toggle" onclick="togglePassword('signup-password', this)">👁️</span>
                </div>

                <label>Confirm Password</label>
                <div class="password-container">
                  <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required />
                  <span class="password-toggle" onclick="togglePassword('confirm-password', this)">👁️</span>
                </div>

                <button type="submit" name="register">Sign Up</button>
              </form>
        </div>
    </section>
    
              <script src="login.js" defer></script>


    <div class="back-home">
        <a href="index.php">Back to Home</a>
    </div>
</div>

</body>
    

<?php if (!empty($_SESSION['show_register'])): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById('signInForm').style.display = 'none';
      document.getElementById('signUpForm').style.display = 'block';
    });
  </script>
  <?php unset($_SESSION['show_register']); ?>
<?php endif; ?>
</html>

