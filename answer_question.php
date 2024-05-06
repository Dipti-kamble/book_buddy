<?php
include './database/conn.php';

// If form is submitted, insert the new answer into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = $_POST['question_id'];
    $body = $_POST['body'];

    $sql = "INSERT INTO answers (question_id, body) VALUES ('$question_id', '$body')";
    if (mysqli_query($conn, $sql)) {
        header("Location: view_question.php?id=$question_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
