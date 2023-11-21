<?php
require('../top.inc.php');
isAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_id = get_safe_value($con, $_GET['id']);
    $file_type = get_safe_value($con, $_POST['file_type']);

    if ($_FILES['file']['name'] !== '') {
        $file_name = $_FILES['file']['name'];
        $target_directory = '../uploads/';
        $target_file = $target_directory . basename($_FILES['file']['name']);
        $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

        $allowed_extensions = array("jpg", "jpeg", "png", "pdf", "doc", "docx", "txt");
        if (!in_array($file_extension, $allowed_extensions)) {
            $msg = "Invalid file format. Please upload a valid file.";
        } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                $update_sql = "UPDATE Files SET file_type = '$file_type', file_name = '$file_name' WHERE file_id = '$file_id'";
                mysqli_query($con, $update_sql);

                header('location:administration/index.php');
                exit();
            } else {
                $msg = "File upload failed. Please try again.";
            }
        }
    } else {
        $update_sql = "UPDATE Files SET file_type = '$file_type' WHERE file_id = '$file_id'";
        mysqli_query($con, $update_sql);

        header('location:administration/index.php');
        exit();
    }
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    $file_id = get_safe_value($con, $_GET['id']);
    $edit_sql = "SELECT * FROM Files WHERE file_id = '$file_id'";
    $edit_res = mysqli_query($con, $edit_sql);
    $file_data = mysqli_fetch_assoc($edit_res);
} else {
    header('location:administration/index.php');
    exit();
}

?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>EDIT FILE</strong></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="file_type" class="form-control-label">File Type</label>
                                <input type="text" name="file_type" placeholder="Enter file type" class="form-control" required value="<?php echo $file_data['file_type']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="file" class="form-control-label">Upload File</label>
                                <input type="file" name="file" class="form-control-file">
                            </div>
                            <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">UPDATE</span>
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
