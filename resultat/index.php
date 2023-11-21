<?php
require('../top.inc.php');
isAdmin();

// Fetch exam results data from the database and display it in a table.
$sql = "SELECT er.exam_results_id, e.first_name_emp, m.module_name, s.first_name, er.exam_date, er.exam_note
        FROM ExamResults er
        INNER JOIN Employees e ON er.employee_id = e.employee_id
        INNER JOIN Modules m ON er.module_id = m.module_id
        INNER JOIN Students s ON er.student_id = s.student_id
        ORDER BY er.exam_results_id DESC";
$res = mysqli_query($con, $sql);
?>

<!-- HTML for displaying exam results in a table -->
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">EXAM RESULTS</h4>
                        <h4 class="box-link"><a href="add.php">ADD EXAM RESULT</a></h4>
                        <h4 class="box-link"><a href="import.php">IMPORT EXAM RESULT</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>Employee</th>
                                        <th>Module</th>
                                        <th>Student</th>
                                        <th>Exam Date</th>
                                        <th>Exam Note</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                        <tr>
                                            <td class="serial"><?php echo $i ?></td>
                                            <td><?php echo $row['first_name_emp'] ?></td>
                                            <td><?php echo $row['module_name'] ?></td>
                                            <td><?php echo $row['first_name'] ?></td>
                                            <td><?php echo $row['exam_date'] ?></td>
                                            <td><?php echo $row['exam_note'] ?></td>
                                            <td>
                                                <?php
                                                echo "<span class='badge badge-edit'><a href='edit.php?id=" . $row['exam_results_id'] . "'>Edit</a></span>&nbsp;";
                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['exam_results_id'] . "'>Delete</a></span>";
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
