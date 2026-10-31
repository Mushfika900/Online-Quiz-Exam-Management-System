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
require_once __DIR__. "/../../models/resultModel.php";

$user_id = $_SESSION['user_id'];

$result = getStudentResult($user_id, $exam_id);

if ($result) {
    header("Location: result.php?exam_id=" . $exam_id);
    exit();
}
require_once __DIR__. "/../../models/questionModel.php";

$questions = getQuestionsByExamId($exam_id);
require_once __DIR__. "/../../models/examModel.php";

$exam = getExamById($exam_id);

if (!$exam || $exam['status'] != 'active') {
    die("Exam not available");
}

$duration = (int)$exam['duration'];

if ($duration <= 0) {
    die("Invalid Exam Duration");
}
if (!isset($_SESSION['exam_end_times'][$exam_id])) {

    $_SESSION['exam_end_times'][$exam_id] = time() + ($duration * 60);

}

$endTime = $_SESSION['exam_end_times'][$exam_id];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Exam</title>
    <link rel="stylesheet" href="../css/startExam.css?v=3">
    
</head>
<body>

    <h1>Start Exam</h1>

    <h2>Exam ID: <?php echo $exam_id; ?></h2>
    <h3>Duration: <?php echo $duration; ?> Minutes</h3>
    <h3>Time Remaining: <span id="timer"></span></h3>

    <h2>Exam Questions</h2>
    <form id="examForm" action="../../controllers/studentExamControl.php" method="POST">
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
    <button type="submit" name="submitExam" value="1">Submit Exam</button>
    </form>

    <a href="availableExams.php">Back to Available Exams</a>
<script>
let endTime = <?php echo (int)$endTime; ?> * 1000;

function updateTimer() {

    let currentTime = Date.now();

    let timeLeft = Math.max(
        0,
        Math.ceil((endTime - currentTime) / 1000)
    );

    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    minutes = String(minutes).padStart(2, '0');
    seconds = String(seconds).padStart(2, '0');

    document.getElementById('timer').innerText =
        minutes + ":" + seconds;

    if (timeLeft <= 0) {
    clearInterval(timerInterval);

    let form = document.getElementById('examForm');
    let submitButton = form.querySelector('button[name="submitExam"]');

    form.requestSubmit(submitButton);
}
}

let timerInterval = setInterval(updateTimer, 1000);

updateTimer();
</script>
</body>
</html>