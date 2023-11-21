<?php
require('../top.inc.php');
isAdmin();

if (isset($_POST['submit'])) {
    if (isset($_FILES['excel_file'])) {
        $file = $_FILES['excel_file']['tmp_name'];

        if (empty($file)) {
            $error = "Please select an Excel file to upload.";
        } else {
            require '../vendor/autoload.php';

            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();

                $insertSql = "INSERT INTO ExamResults (employee_id, module_id, student_id, exam_date, exam_note) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertSql);

                for ($row = 2; $row <= $highestRow; $row++) {
                    $employee_id = get_safe_value($con, $worksheet->getCell('A' . $row)->getValue());
                    $module_id = get_safe_value($con, $worksheet->getCell('B' . $row)->getValue());
                    $student_id = get_safe_value($con, $worksheet->getCell('C' . $row)->getValue());
                    $exam_date = get_safe_value($con, $worksheet->getCell('D' . $row)->getFormattedValue());
                    $exam_note = get_safe_value($con, $worksheet->getCell('E' . $row)->getValue());

                    if (!empty($employee_id) && !empty($module_id) && !empty($student_id)) {
                        $stmt->bind_param("sssss", $employee_id, $module_id, $student_id, $exam_date, $exam_note);
                        $stmt->execute();
                    } else {
                        break;
                    }
                }

                header('location:/admin/examResults/index.php');
                exit();
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $error = "Error reading the Excel file: " . $e->getMessage();
            }
        }
    }
}
?>

<!-- Include your top.inc.php content here -->

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><strong>IMPORT EXAM RESULTS</strong></div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="excel_file">Select Excel File:</label>
                                <input type="file" class="form-control-file" name="excel_file" id="excel_file" accept=".xls, .xlsx">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                            <?php
                            if (isset($error)) {
                                echo "<p class='text-danger'>$error</p>";
                            }
                            ?>
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
