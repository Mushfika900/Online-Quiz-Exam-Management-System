<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

require_once "../../models/examModel.php";

if(!isset($_GET['id']) || (int)$_GET['id'] <= 0)
{
    header("Location: manageExams.php");
    exit();
}

$id = (int)$_GET['id'];

$exam = getExamById($id);

if(!$exam)
{
    echo "Exam Not Found";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam</title>

    <link rel="stylesheet" href="../css/createExam.css">
</head>
<body>

    <div class="header">
        <h2>Quiz Exam Admin</h2>
        <a href="manageExam.php">Back to Exams</a>
    </div>

    <div class="container">

        <h1>Edit Exam</h1>
        <p>Update your exam information.</p>

        <form action="../../controllers/examControl.php" method="POST">

            <input type="hidden" name="id"
                   value="<?php echo $exam['id']; ?>">

            <label>Exam Title</label>
            <input type="text" name="title"
                   value="<?php echo htmlspecialchars($exam['title'], ENT_QUOTES); ?>"
                   required>

            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($exam['description'] ?? ''); ?></textarea>

            <label>Duration (Minutes)</label>
            <input type="number" name="duration"
                   value="<?php echo $exam['duration']; ?>"
                   min="1" required>

            <label>Status</label>

            <select name="status">
                <option value="active"
                    <?php if($exam['status'] == 'active') echo 'selected'; ?>>
                    Active
                </option>

                <option value="inactive"
                    <?php if($exam['status'] == 'inactive') echo 'selected'; ?>>
                    Inactive
                </option>
            </select>

            <button type="submit" name="updateExam">
                Update Exam
            </button>

        </form>

    </div>

</body>
</html>