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

    <link rel="stylesheet" href="../css/manageExam.css">
</head>
<body>

    <div class="header">Quiz Exam Admin</div>

        <a href="dashboard.php" class="back-btn">
            Back to Dashboard
        </a>

    </div>


    <div class="container">

        
        <div class="page-header">

            <div>
                <h1>Manage Exams</h1>
                <p>View and manage your online exams.</p>
            </div>

            <a href="createExam.php" class="create-btn">
                + Create Exam
            </a>

        </div>

       
        <div class="summary-card">

            <h3>Total Exams</h3>

            <h1><?php echo $totalExams; ?></h1>

            <p>Exams available in the system</p>

        </div>

        
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

                    if(mysqli_num_rows($exams) > 0)
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
                                    <?php echo htmlspecialchars($exam['status']); ?>
                                </span>

                            <?php
                            }
                            ?>

                        </td>

                        <td>
                            <?php echo htmlspecialchars($exam['created_at']); ?>
                        </td>
                        <td>
                           <a href="editExam.php?id=<?php echo $exam['id']; ?>"
                                 class="edit-btn">
                                 Edit
                            </a>
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