<?php
require('../top.inc.php');
isAdmin();

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM Employees WHERE employee_id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

$sql = "SELECT * FROM Employees";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">EMPLOYEES</h4>
                        <h4 class="box-link"><a href="add.php">ADD EMPLOYEE</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Birth Date</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Photo</th>
                                        <th>CV</th>
                                        <th>Role</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                        <tr>
                                            <td class="serial"><?php echo $i ?></td>
                                            <td><?php echo $row['employee_id'] ?></td>
                                            <td><?php echo $row['first_name_emp'] ?></td>
                                            <td><?php echo $row['last_name_emp'] ?></td>
                                            <td><?php echo $row['birth_date_emp'] ?></td>
                                            <td><?php echo $row['phone_emp'] ?></td>
                                            <td><?php echo $row['email_emp'] ?></td>
                                            <td>
                                                <img src="<?php echo BASE_URL ?>uploads/images/<?php echo $row['photo_url'] ?>" alt="Employee Photo" width="100">
                                            </td>
                                            <td>
                                                <?php
                                                echo "<a href='" .BASE_URL.'/uploads/documents/'. $row['cv_url'] . "' target='_blank'>Download CV</a>";
                                                ?>
                                            </td>
                                            <td><?php echo $row['role'] ?></td>
                                            <td>
                                                <?php
                                                echo "<span class='badge badge-edit'><a href='edit.php?id=" . $row['employee_id'] . "'>Edit</a></span>&nbsp;";
                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['employee_id'] . "'>Delete</a></span>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('../footer.inc.php');
?>
