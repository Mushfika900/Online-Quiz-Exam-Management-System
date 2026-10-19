<?php

require_once "../../models/questionModel.php";

$questions = getAllQuestions();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Questions</title>
    <link rel="stylesheet" href="../css/manageQuestion.css?v=3">
</head>
<body>

    <h1>Manage Questions</h1>

    <p>View and manage all exam questions.</p>

    <a href="dashboard.php">Back to Dashboard</a>

    <h2>Question List</h2>
    <table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Exam Name</th>
            <th>Question</th>
            <th>Option A</th>
            <th>Option B</th>
            <th>Option C</th>
            <th>Option D</th>
            <th>Correct Answer</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = mysqli_fetch_assoc($questions)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['exam_name']) ?></td>
                <td><?= htmlspecialchars($row['question']) ?></td>
                <td><?= htmlspecialchars($row['option_a']) ?></td>
                <td><?= htmlspecialchars($row['option_b']) ?></td>
                <td><?= htmlspecialchars($row['option_c']) ?></td>
                <td><?= htmlspecialchars($row['option_d']) ?></td>
                <td><?= htmlspecialchars($row['correct_answer']) ?></td>
                <td>
    <a href="editQuestion.php?id=<?= (int)$row['id'] ?>">
        Edit
    </a>

    <form action="../../controllers/questionControl.php"
          method="POST"
          style="display:inline;"
          onsubmit="return confirm('Are you sure you want to delete this question?');">

        <input type="hidden" name="id"
               value="<?= (int)$row['id'] ?>">

        <button type="submit" name="deleteQuestion" value="1">
            Delete
        </button>
    </form>
</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>