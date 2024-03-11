<?php
session_start();

// Include Discord OAuth library
require 'discord_oauth.php';

// Initialize DiscordOAuth
$discordOAuth = new DiscordOAuth();

// Handle Discord OAuth callback
if(isset($_GET['code'])) {
    $user = $discordOAuth->getUser($_GET['code']); // Get user details from Discord
    
    // Save user details in session
    $_SESSION['discord_user'] = $user;
    
    // Redirect to dashboard
    header("Location: dashboard.php");
    exit;
}

// Redirect to Discord OAuth login
if(isset($_GET['login'])) {
    $discordOAuth->redirectToAuthorization();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/now-ui-kit.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="get">
            <button type="submit" name="login" class="btn btn-primary">Login with Discord</button>
        </form>
    </div>
</body>
</html>
