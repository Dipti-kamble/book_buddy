<?php
// Start or resume the session
session_start();

// Include database connection file
include 'conn.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $userId = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    echo "name " . $userId;
    echo "password " . $password;
    // Fetch user record from the database
    $sql = "SELECT * FROM admin_users WHERE userId='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        // Debugging: Echo out fetched user record
        echo "Fetched user record: ";
        print_r($row);
        echo "<br>";

        if ($password === $row['password']) {
            // Password is correct, set session variables for authentication
            $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the primary key column in your admin_users table
            $_SESSION['user_name'] = $row['userId'];
            $_SESSION['user_password'] = $row['password'];
            $_SESSION['user_profile'] = $row['profile_image'];
            $_SESSION['message'] = "Login Successful!";
            echo "Login successful!";
        } else {
            // Password is incorrect
            $_SESSION['message'] = "Incorrect password!";
            echo "Incorrect password!";
        }
    } else {
        // User not found
        $_SESSION['message'] = "User not found!";
        echo "User not found!";
    }

    // Redirect to the same page
    header("Location: /book_buddy/admin/dashboard.php");
    exit;
}

// Close connection
$conn->close();
