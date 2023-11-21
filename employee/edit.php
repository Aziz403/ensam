<?php
require('../top.inc.php');
require('../functions.inc.php');
isAdmin();

$first_name_emp = $last_name_emp = $birth_date_emp = $phone_emp = $email_emp = $role = '';
$photo_url = $cv_url = '';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = get_safe_value($con, $_GET['id']);
    $first_name_emp = get_safe_value($con, $_POST['first_name_emp']);
    $last_name_emp = get_safe_value($con, $_POST['last_name_emp']);
    $birth_date_emp = get_safe_value($con, $_POST['birth_date_emp']);
    $phone_emp = get_safe_value($con, $_POST['phone_emp']);
    $email_emp = get_safe_value($con, $_POST['email_emp']);
    $role = get_safe_value($con, $_POST['role']);
    
    // File Upload for Photo
    if ($_FILES['photo_url']['name']) {
        $photo_url = uploadFile('photo_url', 'images');
        $user_data['photo_url'] = $photo_url;
    }
    
    // File Upload for CV
    if ($_FILES['cv_url']['name']) {
        $cv_url = uploadFile('cv_url', 'documents');
        $user_data['cv_url'] = $cv_url;
    }

    $update_sql = "UPDATE Employees SET first_name_emp = '$first_name_emp', last_name_emp = '$last_name_emp', 
                  birth_date_emp = '$birth_date_emp', phone_emp = '$phone_emp', email_emp = '$email_emp',
                  role = '$role', photo_url = '$photo_url', cv_url = '$cv_url' WHERE employee_id = '$user_id'";
    mysqli_query($con, $update_sql);

    //header('location:/admin/employee/index.php');
    //exit();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    $user_id = get_safe_value($con, $_GET['id']);
    $edit_sql = "SELECT * FROM Employees WHERE employee_id = '$user_id'";
    $edit_res = mysqli_query($con, $edit_sql);
    $user_data = mysqli_fetch_assoc($edit_res);
    $first_name_emp = $user_data['first_name_emp'];
    $last_name_emp = $user_data['last_name_emp'];
    $birth_date_emp = $user_data['birth_date_emp'];
    $phone_emp = $user_data['phone_emp'];
    $email_emp = $user_data['email_emp'];
    $photo_url = $user_data['photo_url'];
    $cv_url = $user_data['cv_url'];
    $role = $user_data['role'];
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>EMPLOYEE FORM</strong></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="first_name_emp" class="form-control-label">First Name</label>
                                <input type="text" name="first_name_emp" placeholder="Enter First Name" class="form-control" required value="<?php echo $first_name_emp; ?>">
                            </div>
                            <div class="form-group">
                                <label for="last_name_emp" class="form-control-label">Last Name</label>
                                <input type="text" name="last_name_emp" placeholder="Enter Last Name" class="form-control" required value="<?php echo $last_name_emp; ?>">
                            </div>
                            <div class="form-group">
                                <label for="birth_date_emp" class="form-control-label">Birth Date</label>
                                <input type="date" name="birth_date_emp" class="form-control" required value="<?php echo $birth_date_emp; ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone_emp" class="form-control-label">Phone</label>
                                <input type="text" name="phone_emp" placeholder="Enter Phone" class="form-control" required value="<?php echo $phone_emp; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email_emp" class="form-control-label">Email</label>
                                <input type="email" name="email_emp" placeholder="Enter Email" class="form-control" required value="<?php echo $email_emp; ?>">
                            </div>
                            <div class="form-group">
                                <label for="role" class="form-control-label">Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="Staff" <?php echo ($role == 'Staff') ? 'selected' : ''; ?>>Staff</option>
                                    <option value="Professor" <?php echo ($role == 'Professor') ? 'selected' : ''; ?>>Professor</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="photo_url" class="form-control-label">Photo</label>
                                <input type="file" name="photo_url" class="form-control-file" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="cv_url" class="form-control-label">CV</label>
                                <input type="file" name="cv_url" class="form-control-file" accept=".pdf, .doc, .docx">
                            </div>
                            <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">UPDATE</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('../footer.inc.php'); ?>
