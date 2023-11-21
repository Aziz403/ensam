<?php
require('../top.inc.php');
isAdmin();

$first_name = '';
$last_name = '';
$birth_date = '';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission
    $first_name = get_safe_value($con, $_POST['first_name']);
    $last_name = get_safe_value($con, $_POST['last_name']);
    $birth_date = get_safe_value($con, $_POST['birth_date']);

    // Perform database insertion
    $insert_sql = "INSERT INTO students (first_name, last_name, birth_date) VALUES ('$first_name', '$last_name', '$birth_date')";
    $result = mysqli_query($con, $insert_sql);

    if ($result) {
        echo "Student added successfully";
    } else {
        echo "Error adding student: " . mysqli_error($con);
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
                                <span id="submit-button-text">SUBMIT</span>
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
