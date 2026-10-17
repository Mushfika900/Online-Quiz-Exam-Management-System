<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate");

require_once "../../models/examModel.php";

$exams = getAllExams();

$totalExams = mysqli_num_rows($exams);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Exams</title>

    <link rel="stylesheet" href="../css/manageExam.css?v=2">

</head>
<body>

    <!-- Header -->
    <div class="header">

        <div class="logo">
            QuizExam Admin
        </div>

        <a href="dashboard.php" class="back-btn">
            Back to Dashboard
        </a>

    </div>


    <!-- Main Container -->
    <div class="container">

        <?php
        if(isset($_GET['updated']))
        {
            echo "<p class='success-message'>Exam Updated Successfully!</p>";
        }
        ?>

        <!-- Page Header -->
        <div class="page-header">

            <div>
                <h1>Manage Exams</h1>
                <p>View and manage your online exams.</p>
            </div>

            <a href="createExam.php" class="create-btn">
                + Create Exam
            </a>

        </div>


        <!-- Summary Card -->
        <div class="summary-card">

            <h3>Total Exams</h3>

            <h1><?php echo $totalExams; ?></h1>

            <p>Exams available in the system</p>

        </div>


        <!-- Exam List -->
        <div class="table-container">

            <div class="table-heading">

                <h2>Exam List</h2>

                <p>All created exams are listed below.</p>

            </div>


            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Exam Title</th>
                        <th>Description</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>

                <?php

                if($totalExams > 0)
                {
                    while($exam = mysqli_fetch_assoc($exams))
                    {
                ?>

                    <tr>

                        <td>
                            <?php echo $exam['id']; ?>
                        </td>

                        <td class="exam-title">
                            <?php echo htmlspecialchars($exam['title']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($exam['description'] ?? ''); ?>
                        </td>

                        <td>
                            <?php echo $exam['duration']; ?> Minutes
                        </td>

                        <td>

                            <?php
                            if($exam['status'] == 'active')
                            {
                            ?>
                                <span class="status active">
                                    Active
                                </span>
                            <?php
                            }
                            else
                            {
                            ?>
                                <span class="status inactive">
                                    Inactive
                                </span>
                            <?php
                            }
                            ?>

                        </td>

                        <td>
                            <?php echo htmlspecialchars($exam['created_at']); ?>
                        </td>


                        <!-- Action Column -->
                        <td class="action-buttons">

                            <div class="exam-actions">

                                <!-- Edit -->
                                <a href="editExam.php?id=<?php echo $exam['id']; ?>"
                                   class="edit-btn">
                                    Edit
                                </a>

                                <!-- Delete -->
                                <form action="../../controllers/examControl.php"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this exam?');">

                                    <input type="hidden"
                                           name="id"
                                           value="<?php echo $exam['id']; ?>">

                                    <button type="submit"
                                            name="deleteExam"
                                            class="delete-btn">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                <?php
                    }
                }
                else
                {
                ?>

                    <tr>
                        <td colspan="7" class="empty">
                            No Exams Found
                        </td>
                    </tr>

                <?php
                }
                ?>

                </tbody>

            </table>

        </div>

    </div>

</body>
</html>