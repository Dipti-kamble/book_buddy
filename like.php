<?php
include './database/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answer_id'])) {
        $answer_id = $_POST['answer_id'];
        $question_id = $_POST['question_id'];
        echo "answer id ".$answer_id; 
        echo "question id ".$question_id; 
        // Update the like count for the answer
        $sql = "UPDATE answers SET like_count = like_count + 1 WHERE id = $answer_id";
        if (mysqli_query($conn, $sql)) {
            // Redirect back to view_question.php after liking the answer
            header("Location: /book_buddy/view_question.php?id=$question_id");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>