<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or any other page you want to redirect unauthorized users to
    header("Location: /book_buddy/admin/dashboard.php");
    exit;
}

// Include your database connection file
include_once "./conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle name update
    if (!empty($_POST['name'])) {
        $new_name = $_POST['name'];
        $user_id = $_SESSION['user_id'];

        // Update the name in the database
        $sql = "UPDATE admin_users SET userId = '$new_name' WHERE id = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_name'] = $new_name; // Update session variable
            echo "name set success";
        } else {
            echo "name set not success";
            $_SESSION['error'] = "Error updating name: " . $conn->error;
            header("Location: /book_buddy/admin/dashboard.php");
            exit;
        }
    }

    // Handle password update
    if (!empty($_POST['password'])) {
        $new_password = $_POST['password'];
        $user_id = $_SESSION['user_id'];

        // Update the password in the database
        $sql = "UPDATE admin_users SET password = '$new_password' WHERE id = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_password'] = $new_password; // Update session variable
            echo "password set success";
        } else {
            echo "password set not success";
            $_SESSION['error'] = "Error updating password: " . $conn->error;
            header("Location: /book_buddy/admin/dashboard.php");
            exit;
        }
    }

    echo "file data " . $_FILES['file']['name'];

    // Handle file upload
    if (!empty($_FILES['file']['name'])) {
        $file_name = $_FILES['file']['name'];
        $file_temp = $_FILES['file']['tmp_name'];
        $file_destination = "../admin/media/" . $file_name;

        echo "file data " . $_FILES['file']['name'];

        echo $file_name;
        echo $file_destination;
        echo $file_temp;

        // Move uploaded file to destination folder
        if (move_uploaded_file($file_temp, $file_destination)) {
            // Update file name in the database
            $sql = "UPDATE admin_users SET profile_image = '$file_name' WHERE id = '$user_id'";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "File uploaded successfully.";
                $_SESSION['user_profile'] = $file_name;
                echo "file set success";
                header("Location: /book_buddy/admin/dashboard.php");
                exit;
            } else {
                $_SESSION['error'] = "Error updating file name: " . $conn->error;
                echo "file set not success";
                header("Location: /book_buddy/admin/dashboard.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Error uploading file.";
            echo "file set not success";
            header("Location: /book_buddy/admin/dashboard.php");
            exit;
        }
    }
}

?>