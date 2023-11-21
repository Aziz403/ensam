<?php
require('../top.inc.php');
isAdmin();

$id = '';
$first_name = '';
$last_name = '';
$birth_date = '';
$msg = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM students WHERE student_id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $birth_date = $row['birth_date'];
    } else {
        header('location:etudiant/index.php');
        die();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission for updating the student
    $first_name = get_safe_value($con, $_POST['first_name']);
    $last_name = get_safe_value($con, $_POST['last_name']);
    $birth_date = get_safe_value($con, $_POST['birth_date']);

    // Perform database update
    $update_sql = "UPDATE students SET first_name='$first_name', last_name='$last_name', birth_date='$birth_date' WHERE student_id='$id'";
    $result = mysqli_query($con, $update_sql);

    if ($result) {
        echo "Student updated successfully";
    } else {
        echo "Error updating student: " . mysqli_error($con);
    }
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>STUDENT FORM</strong> </div>
                    <form method="post">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="first_name" class="form-control-label">First Name</label>
                                <input type="text" name="first_name" placeholder="Enter First Name" class="form-control" required value="<?php echo $first_name ?>">
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-control-label">Last Name</label>
                                <input type="text" name="last_name" placeholder="Enter Last Name" class="form-control" required value="<?php echo $last_name ?>">
                            </div>
                            <div class="form-group">
                                <label for="birth_date" class="form-control-label">Birth Date</label>
                                <input type="date" name="birth_date" class="form-control" required value="<?php echo $birth_date ?>">
                            </div>
                            <button id="submit-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                                <span id="submit-button-text">UPDATE</span>
                            </button>
                            <div class="field_error"><?php echo $msg ?></div>
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
