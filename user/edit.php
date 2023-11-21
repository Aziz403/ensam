<?php
require('../top.inc.php');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve other form fields
    $user_id = get_safe_value($con, $_GET['id']);
    $username = get_safe_value($con, $_POST['username']);
    $first_name = get_safe_value($con, $_POST['first_name']);
    $last_name = get_safe_value($con, $_POST['last_name']);
    $email = get_safe_value($con, $_POST['email']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // Check if the checkbox is checked

    // Update the user in the database
    $update_sql = "UPDATE UserAccounts SET username = '$username', first_name = '$first_name', last_name = '$last_name', email = '$email', is_admin = '$is_admin' WHERE user_id = '$user_id'";

    if (mysqli_query($con, $update_sql)) {
        // User updated successfully
        header('location:index.php');
        exit();
    } else {
        // Handle the error, e.g., display an error message
        $error = "Error updating the user: " . mysqli_error($con);
    }
}


if (isset($_GET['id']) && $_GET['id'] != '') {
    $user_id = get_safe_value($con, $_GET['id']);
    $edit_sql = "SELECT * FROM UserAccounts WHERE user_id = '$user_id'";
    $edit_res = mysqli_query($con, $edit_sql);
    $user_data = mysqli_fetch_assoc($edit_res);
} else {
    header('location:user/index.php');
    exit();
}
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="box-title">Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="is_admin">Is Admin:</label>
                                <select class="form-control" name="is_admin" id="is_admin">
                                    <option value="0" <?php echo ($is_admin == 0) ? 'selected' : ''; ?>>Admin</option>
                                    <option value="1" <?php echo ($is_admin == 1) ? 'selected' : ''; ?>>Sub Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Update User</button>
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