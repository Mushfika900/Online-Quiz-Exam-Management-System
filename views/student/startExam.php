<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$exam_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($exam_id <= 0) {
    die("Invalid Exam ID");
}
require_once __DIR__. "/../../models/questionModel.php";

$questions = getQuestionsByExamId($exam_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Exam</title>
</head>
<body>

    <h1>Start Exam</h1>

    <h2>Exam ID: <?php echo $exam_id; ?></h2>

    <h2>Exam Questions</h2>
    <form action="#" method="POST">

    <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">

<?php
if (mysqli_num_rows($questions) > 0) {

    $number = 1;

    while ($row = mysqli_fetch_assoc($questions)) {
?>

    <div>
        <h3>
            <?php echo $number . ". " . htmlspecialchars($row['question']); ?>
        </h3>

        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="A">
            A. <?php echo htmlspecialchars($row['option_a']); ?>
        </label>

        <br>

        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="B">
            B. <?php echo htmlspecialchars($row['option_b']); ?>
        </label>

        <br>

        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="C">
            C. <?php echo htmlspecialchars($row['option_c']); ?>
        </label>

        <br>

        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="D">
            D. <?php echo htmlspecialchars($row['option_d']); ?>
        </label>
    </div>

    <hr>

<?php
        $number++;
    }

} else {
    echo "No questions available for this exam.";
}
?>
      <button type="submit">Submit Exam</button>
    </form>

    <a href="availableExams.php">Back to Available Exams</a>

</body>
</html>