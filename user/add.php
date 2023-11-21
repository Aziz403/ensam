<?php
require('../top.inc.php');
isAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve other form fields
    $username = get_safe_value($con, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = get_safe_value($con, $_POST['first_name']);
    $last_name = get_safe_value($con, $_POST['last_name']);
    $email = get_safe_value($con, $_POST['email']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // Check if the checkbox is checked

    // Insert the user into the database
    $insert_sql = "INSERT INTO UserAccounts (username, password_hash, first_name, last_name, email, is_admin) VALUES ('$username', '$password', '$first_name', '$last_name', '$email', '$is_admin')";

    if (mysqli_query($con, $insert_sql)) {
        // User added successfully
        header('location:index.php');
        exit();
    } else {
        // Handle the error, e.g., display an error message
        $error = "Error adding the user: " . mysqli_error($con);
    }
}

?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="box-title">Add User</h4>
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
                                    <option value="0">Admin</option>
                                    <option value="1">Sub Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Add User</button>
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
