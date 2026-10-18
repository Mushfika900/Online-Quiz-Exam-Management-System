<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

require_once "../../models/examModel.php";

$exams = getAllExams();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>

    <link rel="stylesheet" href="../css/addQuestion.css">
</head>
<body>

    <div class="header">
        <h2>Quiz Exam Admin</h2>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>

    <div class="container">

        <h1>Add MCQ Question</h1>
        <p>Create questions for your online exams.</p>
        <?php
        if(isset($_GET['success'])){
            echo "<p class='success-message'>Question Added Successfully!</p>";
        }
        ?>

        <form action="../../controllers/questionControl.php" method="POST">

            <label>Select Exam</label>

            <select name="exam_id" required>
                <option value="">Select Exam</option>

                <?php
                while($exam = mysqli_fetch_assoc($exams))
                {
                    if($exam['status'] == 'active')
                    {
                ?>
                    <option value="<?php echo $exam['id']; ?>">
                        <?php echo htmlspecialchars($exam['title']); ?>
                    </option>
                <?php
                    }
                }
                ?>

            </select>

            <label>Question</label>
            <textarea name="question"
                      placeholder="Enter your question"
                      required></textarea>

            <label>Option A</label>
            <input type="text" name="option_a"
                   placeholder="Enter Option A" required>

            <label>Option B</label>
            <input type="text" name="option_b"
                   placeholder="Enter Option B" required>

            <label>Option C</label>
            <input type="text" name="option_c"
                   placeholder="Enter Option C" required>

            <label>Option D</label>
            <input type="text" name="option_d"
                   placeholder="Enter Option D" required>

            <label>Correct Answer</label>

            <select name="correct_answer" required>
                <option value="">Select Correct Answer</option>
                <option value="A">Option A</option>
                <option value="B">Option B</option>
                <option value="C">Option C</option>
                <option value="D">Option D</option>
            </select>

            <button type="submit" name="addQuestion">
                Add Question
            </button>

        </form>

    </div>

</body>
</html>