<?php
require('../top.inc.php');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission when data is posted
    $employee_id = get_safe_value($con, $_POST['employee_id']);
    $module_id = get_safe_value($con, $_POST['module_id']);
    $student_id = get_safe_value($con, $_POST['student_id']);
    $exam_date = get_safe_value($con, $_POST['exam_date']);
    $exam_note = get_safe_value($con, $_POST['exam_note']);

    // Insert the exam result into the database
    $insertSql = "INSERT INTO ExamResults (employee_id, module_id, student_id, exam_date, exam_note) 
                  VALUES ('$employee_id', '$module_id', '$student_id', '$exam_date', '$exam_note')";
    mysqli_query($con, $insertSql);

    // Redirect to the exam results list page or display a success message
    header('location:/admin/examResults/index.php');
    exit();
}

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

<!-- HTML form for adding a new exam result -->
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">ADD EXAM RESULT</h4>
                    </div>
                    <div class="card-body--">
                        <form method="post">
                        <div class="form-group">
                                <label for="employee_id">Employee:</label>
                                <select class="form-control" name="employee_id" id="employee_id" required>
                                    <option value="">Select Employee</option>
                                    <?php
                                    foreach ($employeeOptions as $id => $name) {
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="module_id">Module:</label>
                                <select class="form-control" name="module_id" id="module_id" required>
                                    <option value="">Select Module</option>
                                    <?php
                                    foreach ($moduleOptions as $id => $name) {
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="student_id">Student:</label>
                                <select class="form-control" name="student_id" id="student_id" required>
                                    <option value="">Select Student</option>
                                    <?php
                                    foreach ($studentOptions as $id => $name) {
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exam_date">Exam Date:</label>
                                <input type="date" class="form-control" name="exam_date" id="exam_date" required>
                            </div>
                            <div class="form-group">
                                <label for="exam_note">Exam Note:</label>
                                <input type="text" class="form-control" name="exam_note" id="exam_note" required>
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
