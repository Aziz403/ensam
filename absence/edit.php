<?php
require('../top.inc.php');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $attendance_id = get_safe_value($con, $_POST['attendance_id']);
        $employee_id = get_safe_value($con, $_POST['employee_id']);
        $module_id = get_safe_value($con, $_POST['module_id']);
        $student_id = get_safe_value($con, $_POST['student_id']);
        $raison = get_safe_value($con, $_POST['raison']);
        $date_absence = get_safe_value($con, $_POST['date_absence']);

        $updateSql = "UPDATE Attendance SET 
                     employee_id = '$employee_id', module_id = '$module_id', student_id = '$student_id',
                     raison = '$raison', date_absence = '$date_absence'
                     WHERE attendance_id = '$attendance_id'";
        mysqli_query($con, $updateSql);

        header('location:index.php');
        exit();
    }
}

$attendance_id = get_safe_value($con, $_GET['id']);
$attendance_sql = "SELECT * FROM Attendance WHERE attendance_id = '$attendance_id'";
$attendance_res = mysqli_query($con, $attendance_sql);
$attendance_data = mysqli_fetch_assoc($attendance_res);

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
                        <h4 class="box-title">EDIT ATTENDANCE</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="attendance_id" value="<?php echo $attendance_data['attendance_id']; ?>">
                            <div class="form-group">
                                <label for="employee_id">Employee</label>
                                <select class="form-control" name="employee_id" id="employee_id" required>
                                    <option value="">Select Employee</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($employee_res)) {
                                        $selected = ($row['employee_id'] == $attendance_data['employee_id']) ? 'selected' : '';
                                        echo "<option value='" . $row['employee_id'] . "' $selected>" . $row['first_name_emp'] . ' ' . $row['last_name_emp'] . "</option>";
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
                                        $selected = ($row['module_id'] == $attendance_data['module_id']) ? 'selected' : '';
                                        echo "<option value='" . $row['module_id'] . "' $selected>" . $row['module_name'] . "</option>";
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
                                        $selected = ($row['student_id'] == $attendance_data['student_id']) ? 'selected' : '';
                                        echo "<option value='" . $row['student_id'] . "' $selected>" . $row['first_name'] . ' ' . $row['last_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="raison">Raison</label>
                                <input type="text" class="form-control" name="raison" id="raison" value="<?php echo $attendance_data['raison']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="date_absence">Date Absence</label>
                                <input type="date" class="form-control" name="date_absence" id="date_absence" value="<?php echo $attendance_data['date_absence']; ?>" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Update Attendance</button>
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
