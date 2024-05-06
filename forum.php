<?php
include './database/conn.php';

// Function to sanitize user input
function sanitize_input($input)
{
    return htmlspecialchars(strip_tags($input));
}

// Fetch questions from the database
$sql = "SELECT * FROM questions ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// If form is submitted, insert the new question into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST['title']);
    $body = sanitize_input($_POST['body']);

    $sql = "INSERT INTO questions (title, body) VALUES ('$title', '$body')";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Search and filter functionality
if (isset($_GET['search'])) {
    $search = sanitize_input($_GET['search']);
    $sql = "SELECT * FROM questions WHERE title LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Forum</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
    <div class="bg-dark p-3 text-light ">
        <h1>Discussion Forum</h1>
    </div>
    <div class="container-fluid">
        <div class="container py-5">
            <h2>Ask a Question</h2>

            <div class="p-3 bg-dark text-light">
                <form method="post" action="">
                    <label class="fw-bold fs-4" for="title">Title:</label><br>
                    <input class="form-control" type="text" id="title" name="title"><br>
                    <label class="fw-bold fs-4" for="body">Question:</label><br>
                    <textarea class="form-control" id="body" name="body"></textarea><br>
                    <input class="btn btn-light" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid position-sticky top-0">
        <div class="container shadow-lg py-2">
            <h2 class="">Search Questions</h2>
            <form class="d-flex gap-2" method="get" action="">
                <input class="form-control" type="text" name="search" placeholder="Search by title">
                <input class="btn btn-success mt-2" type="submit" value="Search">
            </form>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container py-5">
            <div class="container py-3">

                <div class="my-5 shadow-lg p-3">
                    <h2 class="bg-dark p-2 text-light">Questions</h2>
                    <?php foreach ($questions as $question) : ?>
                        <div class="py-4">
                            <h3><?= $question['title'] ?></h3>
                            <p><?= $question['body'] ?></p>
                            <a href="view_question.php?id=<?= $question['id'] ?>">View Dicussions</a>
                            <form method="post" action="answer_question.php">
                                <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                                <label for="answer">Your Answer:</label><br>
                                <textarea class="form-control" id="answer" name="body"></textarea><br>
                                <input class="btn btn-success" type="submit" value="Submit Answer">
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>