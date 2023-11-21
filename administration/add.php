<?php
require('../top.inc.php');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_type = get_safe_value($con, $_POST['file_type']);
    $file_name = $_FILES['file']['name'];
    $upload_date = date('Y-m-d');

    $target_directory = '../uploads/';
    $target_file = $target_directory . basename($_FILES['file']['name']);
    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

    // Check for allowed file types
    $allowed_extensions = array("jpg", "jpeg", "png", "pdf", "doc", "docx", "txt");
    if (!in_array($file_extension, $allowed_extensions)) {
        $msg = "Invalid file format. Please upload a valid file.";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $insert_sql = "INSERT INTO Files (file_type, file_name, upload_date) 
                           VALUES ('$file_type', '$file_name', '$upload_date')";
            mysqli_query($con, $insert_sql);

            header('location:administration/index.php');
            exit();
        } else {
            $msg = "File upload failed. Please try again.";
        }
    }
}

?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>UPLOAD FILE</strong></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="file_type" class="form-control-label">File Type</label>
                                <input type="text" name="file_type" placeholder="Enter file type" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="file" class="form-control-label">Upload File</label>
                                <input type="file" name="file" class="form-control-file" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">UPLOAD</span>
                            </button>
                            <div class="field_error"><?php echo isset($msg) ? $msg : ''; ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('../footer.inc.php');
?>
