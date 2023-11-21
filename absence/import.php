<?php
require('../top.inc.php');
isAdmin();

if (isset($_POST['submit'])) {
    // Handle file upload
    if (isset($_FILES['excel_file'])) {
        $file = $_FILES['excel_file']['tmp_name'];

        if (empty($file)) {
            $error = "Please select an Excel file to upload.";
        } else {
            // Include PhpSpreadsheet autoload.php
            require '../vendor/autoload.php';

            try {
                // Load the Excel file
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();

                // Prepare a statement for inserting data
                $insertSql = "INSERT INTO Attendance (employee_id, module_id, student_id, raison, date_absence) 
                              VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertSql);

                for ($row = 2; $row <= $highestRow; $row++) {
                    $employee_id = get_safe_value($con, $worksheet->getCell('A' . $row)->getValue());
                    $module_id = get_safe_value($con, $worksheet->getCell('B' . $row)->getValue());
                    $student_id = get_safe_value($con, $worksheet->getCell('C' . $row)->getValue());
                    $raison = get_safe_value($con, $worksheet->getCell('D' . $row)->getValue());
                    $date_absence = get_safe_value($con, $worksheet->getCell('E' . $row)->getValue());

                    if (!empty($employee_id) && !empty($module_id) && !empty($student_id)) {
                        // Bind parameters and execute the statement
                        $stmt->bind_param("iiiis", $employee_id, $module_id, $student_id, $raison, $date_absence);
                        $stmt->execute();
                    } else {
                        break;
                    }
                }

                // Redirect to the attendance list page or display a success message
                header('location:index.php');
                exit();
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $error = "Error reading the Excel file: " . $e->getMessage();
            }
        }
    }
}

// Your HTML form for file upload
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><strong>IMPORT ATTENDANCE DATA</strong></div>
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
