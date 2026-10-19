<?php
require_once __DIR__. "/../../models/questionModel.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$question = $id > 0 ? getQuestionById($id) : null;

if (!$question) {
    die("Question not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
</head>
<body>

    <h1>Edit Question</h1>

    <p>Update an existing MCQ question.</p>

    <a href="manageQuestion.php">Back to Manage Questions</a>

    <h2>Question Edit Form</h2>
    <form action="../../controllers/questionControl.php" method="POST">

    <input type="hidden" name="id"
           value="<?= (int)$question['id'] ?>">

    <label>Question:</label>
    <input type="text" name="question"
           value="<?= htmlspecialchars($question['question']) ?>"
           required>

    <br><br>

    <label>Option A:</label>
    <input type="text" name="option_a"
           value="<?= htmlspecialchars($question['option_a']) ?>"
           required>

    <br><br>

    <label>Option B:</label>
    <input type="text" name="option_b"
           value="<?= htmlspecialchars($question['option_b']) ?>"
           required>

    <br><br>

    <label>Option C:</label>
    <input type="text" name="option_c"
           value="<?= htmlspecialchars($question['option_c']) ?>"
           required>

    <br><br>

    <label>Option D:</label>
    <input type="text" name="option_d"
           value="<?= htmlspecialchars($question['option_d']) ?>"
           required>

    <br><br>

    <label>Correct Answer:</label>
    <select name="correct_answer" required>
        <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
            <option value="<?= $option ?>"
                <?= strtoupper($question['correct_answer']) == $option ? 'selected' : '' ?>>
                <?= $option ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <button type="submit" name="updateQuestion" value="1">Update Question</button>

</form>
</body>
</html>