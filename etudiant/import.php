<?php
require('../top.inc.php');
isAdmin();

// Check if a file is uploaded
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
                $insertSql = "INSERT INTO Students (first_name, last_name, birth_date, phone, email, photo_url, cin_copy_url, bac_copy_url, transcript_copy_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertSql);


                for ($row = 2; $row <= $highestRow; $row++) {
                    $firstName = $worksheet->getCell('A' . $row)->getValue();
                    $lastName = $worksheet->getCell('B' . $row)->getValue();
                    $birthDate = $worksheet->getCell('C' . $row)->getFormattedValue();
                    $phone = $worksheet->getCell('D' . $row)->getFormattedValue();
                    $email = $worksheet->getCell('E' . $row)->getValue();
                    $photoUrl = $worksheet->getCell('F' . $row)->getValue();
                    $cinCpy = $worksheet->getCell('J' . $row)->getValue();
                    $bacCpy = $worksheet->getCell('H' . $row)->getValue();
                    $transCpy = $worksheet->getCell('I' . $row)->getValue();

                    // TODO: to try 
                    // Save photo, cinCopy, bacCopy, and transcriptCopy on the server
                    if (!empty($photoUrl) && file_exists($photoUrl)) {
                        $photoFileName = 'photo_' . time() . '_' . basename($photoUrl);
                        $photoPath = 'uploads/photos/' . $photoFileName;
                        copy($photoUrl, $photoPath);
                        $photoUrl = $photoPath;
                    }
                    
                    if (!empty($cinCopy) && file_exists($cinCopy)) {
                        $cinCopyFileName = 'cin_copy_' . time() . '_' . basename($cinCopy);
                        $cinCopyPath = 'uploads/cin_copy/' . $cinCopyFileName;
                        copy($cinCopy, $cinCopyPath);
                        $cinCopy = $cinCopyPath;
                    }
                    
                    if (!empty($bacCopy) && file_exists($bacCopy)) {
                        $bacCopyFileName = 'bac_copy_' . time() . '_' . basename($bacCopy);
                        $bacCopyPath = 'uploads/bac_copy/' . $bacCopyFileName;
                        copy($bacCopy, $bacCopyPath);
                        $bacCopy = $bacCopyPath;
                    }
                    
                    if (!empty($transcriptCopy) && file_exists($transcriptCopy)) {
                        $transcriptCopyFileName = 'transcript_copy_' . time() . '_' . basename($transcriptCopy);
                        $transcriptCopyPath = 'uploads/transcript_copy/' . $transcriptCopyFileName;
                        copy($transcriptCopy, $transcriptCopyPath);
                        $transcriptCopy = $transcriptCopyPath;
                    }

                    if (!empty($firstName)) {
                        // Bind parameters and execute the statement
                        $stmt->bind_param("sssssssss", $firstName, $lastName, $birthDate, $phone, $email, $photoUrl, $cinCpy, $bacCpy, $transCpy);
                        $stmt->execute();
                    } else {
                        break;
                    }
                }

                // Redirect to the student list page or display a success message
                header('location:/admin/etudiant/index.php');
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
                    <div class="card-header"><strong>IMPORT STUDENT DATA</strong></div>
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
