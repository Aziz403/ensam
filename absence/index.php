<?php
require('../top.inc.php');
isAdmin();

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM Attendance WHERE attendance_id='$id'";
        mysqli_query($con, $delete_sql);
    }
    // Handle other types of operations (e.g., Edit, View) if needed.
}

$sql = "SELECT A.attendance_id, E.first_name_emp, E.last_name_emp, M.module_name, S.first_name, S.last_name, A.raison, A.date_absence
        FROM Attendance A
        INNER JOIN Employees E ON A.employee_id = E.employee_id
        INNER JOIN Modules M ON A.module_id = M.module_id
        INNER JOIN Students S ON A.student_id = S.student_id";
$res = mysqli_query($con, $sql);
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">ATTENDANCE</h4>
                        <h4 class="box-link"><a href="add.php">ADD ATTENDANCE</a></h4>
                        <h4 class="box-link"><a href="import.php">IMPORT ATTENDANCE</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>Employee Name</th>
                                        <th>Module Name</th>
                                        <th>Student Name</th>
                                        <th>Raison</th>
                                        <th>Date Absence</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <tr>
                                            <td class="serial"><?php echo $i ?></td>
                                            <td><?php echo $row['first_name_emp'] . ' ' . $row['last_name_emp'] ?></td>
                                            <td><?php echo $row['module_name'] ?></td>
                                            <td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                            <td><?php echo $row['raison'] ?></td>
                                            <td><?php echo $row['date_absence'] ?></td>
                                            <td>
                                                <?php
                                                echo "<span class='badge badge-edit'><a href='edit.php?id=" . $row['attendance_id'] . "'>Edit</a></span>&nbsp;";
                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['attendance_id'] . "'>Delete</a></span>";
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
