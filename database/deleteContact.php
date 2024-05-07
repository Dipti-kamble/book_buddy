<?php
// Include your database connection file
include_once "./conn.php";

// Check if ID is provided via POST
if(isset($_POST['id'])) {
    // Sanitize the ID
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Construct the DELETE query
    $sql = "DELETE FROM contact_forms WHERE id = $id";

    // Execute the DELETE query
    if ($conn->query($sql) === TRUE) {
        // If deletion is successful, return a success message
        echo "Contact form deleted successfully.";
    } else {
        // If an error occurs during deletion, return an error message
        echo "Error deleting contact form: " . $conn->error;
    }
} else {
    // If no ID is provided, return an error message
    echo "No contact form ID provided.";
}
?>
