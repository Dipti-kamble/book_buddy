<?php
// Start or resume the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or any other page you want to redirect unauthorized users to
    header("Location: login.php");
    exit;
}

// If the user is logged in, continue with the dashboard page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include any necessary CSS and JavaScript files -->
</head>
<body>
    <!-- Your dashboard content goes here -->
    <h1>Welcome to the Dashboard, <?php echo $_SESSION['user_name']; ?>!</h1>
    <!-- Add more content as needed -->
</body>
</html>
