<?php
// Start or resume the session
session_start();

// Display session message if it exists
if (isset($_SESSION['user_message'])) {
    echo '<div class="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['user_message']); // Clear the message after displaying it
}

// Include database connection file
include 'conn.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert form data into database table
    $sql = "INSERT INTO contact_forms (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_message'] = "We Got Your Request !";
    } else {
        // $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
        $_SESSION['user_message'] = "Unable to take your request !";
    }
    // Redirect to the same page
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}

// Close connection
$conn->close();
?>
