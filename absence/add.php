<?php
require('../top.inc.php');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $employee_id = get_safe_value($con, $_POST['employee_id']);
        $module_id = get_safe_value($con, $_POST['module_id']);
        $student_id = get_safe_value($con, $_POST['student_id']);
        $raison = get_safe_value($con, $_POST['raison']);
        $date_absence = get_safe_value($con, $_POST['date_absence']);

        $insertSql = "INSERT INTO Attendance (employee_id, module_id, student_id, raison, date_absence)
                     VALUES ('$employee_id', '$module_id', '$student_id', '$raison', '$date_absence')";
        mysqli_query($con, $insertSql);

        header('location:index.php');
        exit();
    }
}

// Fetch employee, module, and student data
$employee_sql = "SELECT employee_id, first_name_emp, last_name_emp FROM Employees";
$employee_res = mysqli_query($con, $employee_sql);

$module_sql = "SELECT module_id, module_name FROM Modules";
$module_res = mysqli_query($con, $module_sql);

$student_sql = "SELECT student_id, first_name, last_name FROM Students";
$student_res = mysqli_query($con, $student_sql);
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">ADD ATTENDANCE</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="employee_id">Employee</label>
                                <select class="form-control" name="employee_id" id="employee_id" required>
                                    <option value="">Select Employee</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($employee_res)) {
                                        echo "<option value='" . $row['employee_id'] . "'>" . $row['first_name_emp'] . ' ' . $row['last_name_emp'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="module_id">Module</label>
                                <select class="form-control" name="module_id" id="module_id" required>
                                    <option value="">Select Module</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($module_res)) {
                                        echo "<option value='" . $row['module_id'] . "'>" . $row['module_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="student_id">Student</label>
                                <select class="form-control" name="student_id" id="student_id" required>
                                    <option value="">Select Student</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($student_res)) {
                                        echo "<option value='" . $row['student_id'] . "'>" . $row['first_name'] . ' ' . $row['last_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="raison">Raison</label>
                                <input type="text" class="form-control" name="raison" id="raison" required>
                            </div>
                            <div class="form-group">
                                <label for="date_absence">Date Absence</label>
                                <input type="date" class="form-control" name="date_absence" id="date_absence" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Add Attendance</button>
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
