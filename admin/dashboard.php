<?php
// Start or resume the session
session_start();

// Check if the user clicked the logout button
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or any other page you want to redirect unauthorized users to
    header("Location: login.php");
    exit;
}

// If the user is logged in, continue with the dashboard page

// Start or resume the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or any other page you want to redirect unauthorized users to
    header("Location: /book_buddy/admin/dashboard.php");
    exit;
}

// Include your database connection file
include_once "../database/conn.php";

// Check if form is submitted
$sql = "SELECT * from contact_forms";
$result = $conn->query($sql);

// Initialize an empty array to store contact form data
$contactForms = [];

// Fetch contact form data and store it in the array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contactForms[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include any necessary CSS and JavaScript files -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,₹500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body style="height: 100vh;">
    <!-- Your dashboard content goes here -->
    <div class="container-fluid bg-primary text-light">
        <div class="py-2 px-3 d-flex justify-content-between">
            <h1>Welcome to the Dashboard, <span class="text-danger"><?php echo $_SESSION['user_name']; ?> </span>! </h1>
            <!-- Logout form -->
            <form method="post">
                <button class="btn btn-danger" type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container-fluid h-100">
        <div class="row h-100 ">
            <div class="col-3 h-100 bg-dark m-0 p-0">
                <div class="px-5 bg-black py-2 text-center">
                    <span class="text-light fw-medium fs-2">Admin Actions</span>
                </div>

                <!-- button for dashboard options -->
                <div class="nav nav-tabs d-flex flex-column gap-0">
                    <button class="btn btn-dark fw-bold shadow-lg py-5 active" data-bs-toggle="tab" data-bs-target="#dashboard-panel" type="button">Dashboard</button>
                    <button class="btn btn-dark fw-bold shadow-lg py-5" data-bs-toggle="tab" data-bs-target="#form-entries-panel" type="button">Form Entries</button>
                    <button class="btn btn-dark fw-bold shadow-lg py-5" data-bs-toggle="tab" data-bs-target="#feedback-forms-panel" type="button">Feedback Forms</button>
                </div>

                <div class="text-light">
                    <?php
                    if ($_SESSION['success']) {
                        echo $_SESSION['success'];
                    } else {
                        echo $_SESSION['error'];
                    }
                    ?>
                </div>

            </div>
            <div class="col h-100">
                <div class="tab-content" id="myTabContent">
                    <!-- admin data -->
                    <div class="tab-pane fade show active" id="dashboard-panel">

                        <div class="container-fluid p-5">
                            <h1>Dashboard</h1>
                            <div class="container shadow-lg">
                                <form method="POST" action="../database/updateAdmin.php" enctype="multipart/form-data">
                                    <div class="row p-5">
                                        <div class="col-3 d-flex flex-column gap-3">
                                            <img class="img-fluid" src="./media/<?php echo $_SESSION['user_profile'] ?>" style="width: 250px; height:250px;" alt="admin profile pic">
                                            <span class="fw-bold">Change Profile Pic: </span><input name="file" type="file" src="" alt="">
                                        </div>
                                        <div class="col">
                                            <h4 class="mb-5 bg-dark p-2 text-light">Admin Profile Data</h4>
                                            <div class="row p-2">
                                                <div class="col-2">
                                                    <p class="fw-semibold fs-4">Id: </p>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control" type="text" placeholder="Admin Id" name="name" value="<?php echo $_SESSION['user_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-2">
                                                    <p class="fw-semibold fs-4">Password: </p>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control" type="password" name="password" name="password" id="admin-login-password" placeholder="Admin Password" value="<?php echo $_SESSION['user_password']; ?>">
                                                </div>
                                            </div>
                                            <div class="d-flex gap-3 flex-row justify-content-end">
                                                <button type="button" class="btn btn-primary" id="show-hide-admin-password">Show Password</button>
                                                <button class="btn btn-success" type="submit">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- contact forms -->
                    <div class="tab-pane fade" id="form-entries-panel">
                        <div class="container-fluid p-5">
                            <h1>From Entries</h1>
                            <div class="container shadow-lg">
                                <!-- fetch table data from database -->
                                <div class="container mt-5 py-5">
                                    <h2>Contact Forms</h2>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-dark">
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Time Stamp</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($contactForms as $form) : ?>
                                                <tr>
                                                    <td><?php echo $form['id']; ?></td>
                                                    <td><?php echo $form['name']; ?></td>
                                                    <td><?php echo $form['email']; ?></td>
                                                    <td><?php echo $form['message']; ?></td>
                                                    <td><?php echo $form['created_at']; ?></td>
                                                    <td>
                                                        <!-- Delete button with onclick event -->
                                                        <button class="btn btn-danger" onclick="deleteContactForm(<?php echo $form['id']; ?>)">Delete</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class=" tab-pane fade" id="feedback-forms-panel">
                                Feedback forms
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Add more content as needed-->
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="../lib/easing/easing.min.js"></script>
<script src="../lib/waypoints/waypoints.min.js"></script>
<script src="../lib/counterup/counterup.min.js"></script>
<script src="../lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../lib/tempusdominus/js/moment.min.js"></script>
<script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../js/admin.js"></script>

<script>
    // Function to handle contact form deletion
    function deleteContactForm(id) {
        // Send an AJAX request to delete the contact form with the given ID
        $.ajax({
            url: '../database/deleteContact.php', // Replace with your PHP script to handle deletion
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                // Refresh the page or update the table based on your requirement
                alert("Deleted Successfully !")
                window.location.reload(); // Refresh the page
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error deleting contact form. Please try again.');
            }
        });
    }
</script>

</html>