<?php
require('../top.inc.php');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission when data is posted
    $exam_results_id = get_safe_value($con, $_POST['exam_results_id']);
    $employee_id = get_safe_value($con, $_POST['employee_id']);
    $module_id = get_safe_value($con, $_POST['module_id']);
    $student_id = get_safe_value($con, $_POST['student_id']);
    $exam_date = get_safe_value($con, $_POST['exam_date']);
    $exam_note = get_safe_value($con, $_POST['exam_note']);

    // Update the exam result in the database
    $updateSql = "UPDATE ExamResults SET employee_id='$employee_id', module_id='$module_id', student_id='$student_id', exam_date='$exam_date', exam_note='$exam_note' WHERE exam_results_id='$exam_results_id'";
    mysqli_query($con, $updateSql);

    // Redirect to the exam results list page or display a success message
    header('location:/admin/examResults/index.php');
    exit();
}

$exam_results_id = get_safe_value($con, $_GET['id']);

// Fetch the existing exam result data from the database
$examResultQuery = "SELECT * FROM ExamResults WHERE exam_results_id = '$exam_results_id'";
$examResultResult = mysqli_query($con, $examResultQuery);
$examResultData = mysqli_fetch_assoc($examResultResult);

// Fetch options for employees from the database
$employeeOptions = [];
$employeeQuery = "SELECT employee_id, first_name_emp, last_name_emp FROM Employees";
$employeeResult = mysqli_query($con, $employeeQuery);
while ($row = mysqli_fetch_assoc($employeeResult)) {
    $employeeOptions[$row['employee_id']] = $row['first_name_emp'] . ' ' . $row['last_name_emp'];
}

// Fetch options for modules from the database
$moduleOptions = [];
$moduleQuery = "SELECT module_id, module_name FROM Modules";
$moduleResult = mysqli_query($con, $moduleQuery);
while ($row = mysqli_fetch_assoc($moduleResult)) {
    $moduleOptions[$row['module_id']] = $row['module_name'];
}

// Fetch options for students from the database
$studentOptions = [];
$studentQuery = "SELECT student_id, first_name, last_name FROM Students";
$studentResult = mysqli_query($con, $studentQuery);
while ($row = mysqli_fetch_assoc($studentResult)) {
    $studentOptions[$row['student_id']] = $row['first_name'] . ' ' . $row['last_name'];
}

?>

<!-- Include your top.inc.php content here -->

<!-- HTML form for editing an exam result -->
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">EDIT EXAM RESULT</h4>
                    </div>
                    <div class="card-body--">
                        <form method="post">
                            <input type="hidden" name="exam_results_id" value="<?php echo $exam_results_id; ?>">
                            <div class="form-group">
                                <label for="employee_id">Employee:</label>
                                <select class="form-control" name="employee_id" id="employee_id" required>
                                    <?php
                                    foreach ($employeeOptions as $id => $name) {
                                        $selected = ($id == $examResultData['employee_id']) ? 'selected' : '';
                                        echo "<option value='$id' $selected>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="module_id">Module:</label>
                                <select class="form-control" name="module_id" id="module_id" required>
                                    <?php
                                    foreach ($moduleOptions as $id => $name) {
                                        $selected = ($id == $examResultData['module_id']) ? 'selected' : '';
                                        echo "<option value='$id' $selected>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="student_id">Student:</label>
                                <select class="form-control" name="student_id" id="student_id" required>
                                    <?php
                                    foreach ($studentOptions as $id => $name) {
                                        $selected = ($id == $examResultData['student_id']) ? 'selected' : '';
                                        echo "<option value='$id' $selected>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exam_date">Exam Date:</label>
                                <input type="date" class="form-control" name="exam_date" id="exam_date" value="<?php echo $examResultData['exam_date']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exam_note">Exam Note:</label>
                                <input type="text" class="form-control" name="exam_note" id="exam_note" value="<?php echo $examResultData['exam_note']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('../footer.inc.php');
?>
