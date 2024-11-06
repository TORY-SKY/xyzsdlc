<?php
// login.php
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Load the users.txt file and search for a matching username/password
    $file = 'users.txt'; // Example user data file
    $userFound = false;

    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        
        foreach ($lines as $line) {
            list($storedUsername, $storedPassword) = explode(',', trim($line));
            
            // Check if user credentials match
            if ($username === $storedUsername && $password === $storedPassword) {
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit;
            }
        }
    }

    $errorMessage = "Invalid username or password. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to XYZ Inc.</h2>
        <?php if (isset($errorMessage)) : ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
            <a href="#" class="forgot-password">Forgot Password?</a>
        </form>
    </div>
</body>
</html>
