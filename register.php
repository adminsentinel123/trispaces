<?php
session_start();

// Include Discord OAuth library
require 'discord_oauth.php';

// Handle Discord OAuth callback
if(isset($_GET['code'])) {
    $discordOAuth = new DiscordOAuth();
    $user = $discordOAuth->getUser($_GET['code']); // Get user details from Discord
    
    // Save user details in session
    $_SESSION['discord_user'] = $user;
    
    // Redirect to dashboard if logged in
    header("Location: dashboard.php");
    exit;
}

// Handle registration form submission
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Perform your registration logic here (e.g., inserting data into a database)
    // If registration succeeds, save user data in session and redirect to dashboard
    // Example:
    // $_SESSION['user'] = $user;
    // header("Location: dashboard.php");
    // exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="register">Register</button>
        </form>

        <!-- Discord OAuth login button -->
        <a href="<?php echo $discordOAuth->getAuthUrl(); ?>">Login with Discord</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
