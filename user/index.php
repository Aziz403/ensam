<?php
require('../top.inc.php');
isAdmin();

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM useraccounts WHERE user_id='$id'";
        mysqli_query($con, $delete_sql);
    }

    // Handle other types of operations (e.g., Activate, Deactivate) if needed.
}

$sql = "SELECT * FROM useraccounts";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">USERS</h4>
                        <h4 class="box-link"><a href="add.php">ADD USER</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
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
                                            <td><?php echo $row['user_id'] ?></td>
                                            <td><?php echo $row['username'] ?></td>
                                            <td><?php echo $row['first_name'] ?></td>
                                            <td><?php echo $row['last_name'] ?></td>
                                            <td><?php echo $row['email'] ?></td>
                                            <td><?php echo ($row['is_admin'] == 0) ? 'Admin' : 'Sub Admin'; ?></td>
                                            <td>
                                                <?php
                                                if($row['is_admin']!=0){
                                                    echo "<span class='badge badge-info'><a href='show.php?id=" . $row['user_id'] . "'>Permissions</a></span>&nbsp;";
                                                }
                                                echo "<span class='badge badge-edit'><a href='edit.php?id=" . $row['user_id'] . "'>Edit</a></span>&nbsp;";

                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['user_id'] . "'>Delete</a></span>";
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
