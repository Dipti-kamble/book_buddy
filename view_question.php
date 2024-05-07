<?php
include './database/conn.php';

// Fetch question details
if (isset($_GET['id'])) {
    $question_id = $_GET['id'];
    $sql = "SELECT * FROM questions WHERE id = $question_id";
    $result = mysqli_query($conn, $sql);
    $question = mysqli_fetch_assoc($result);

    // Fetch answers for the question
    $sql = "SELECT * FROM answers WHERE question_id = $question_id ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    $answers = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Question ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question - <?= $question['title'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container-fluid p-5 position-sticky top-0 bg-dark text-light">
        <div class="container">
            <h1><?= $question['title'] ?></h1>
            <p><?= $question['body'] ?></p>
            <a class="btn btn-warning" href="/book_buddy/forum.php">back to forum</a>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container">
            <h2>Answers</h2>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container py-5">
            <?php foreach ($answers as $answer) : ?>
                <div class="shadow-lg my-3">
                    <div class="fw-medium p-3 fs-4">

                       <div class="d-flex justify-content-between">
                            <?= $answer['body'] ?>
    
                            <div class="d-flex align-items-center gap-3">
                                <form method="post" action="like.php">
                                    <input type="hidden" name="answer_id" value="<?= $answer['id'] ?>">
                                    <input type="hidden" name="question_id" value="<?= $answer['question_id'] ?>">
                                    <button type="submit" class="btn btn-danger fa-solid fa-heart"></button>
                                </form>
                                <?= $answer['like_count'] ?>
                            </div>
                       </div>

                        <div class="border border-dark"></div>
                        <div class="fs-6 fw-light py-2">
                            Created at: <?= $answer['created_at'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>