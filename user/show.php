<?php
require('../top.inc.php');
isAdmin();

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM UserAccounts WHERE user_id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

$user_id = get_safe_value($con, $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_permissions'])) {
        // Add permissions to the user
        $selected_permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
        //die($selected_permissions);
        
        $delete_user_permission_query = "DELETE FROM UserPermissions WHERE user_id='$user_id'";
        mysqli_query($con, $delete_user_permission_query);

        foreach ($selected_permissions as $permission_id) {
            // Insert records into UserPermissions table to link user to selected permissions
            $insert_user_permission_query = "INSERT INTO UserPermissions (user_id, permission_id) VALUES ('$user_id', '$permission_id')";
            mysqli_query($con, $insert_user_permission_query);
        }
    }
}


// Fetch user data and current permissions
$user_query = "SELECT * FROM UserAccounts WHERE user_id = '$user_id'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

$permissions_query = "SELECT p.permission_id, p.permission_name, 
                     IF(up.user_permission_id IS NOT NULL, 1, 0) AS has_permission 
                     FROM Permissions p
                     LEFT JOIN UserPermissions up ON p.permission_id = up.permission_id AND up.user_id = '$user_id'";
$permissions_result = mysqli_query($con, $permissions_query);

?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">USER PERMISSIONS</h4>
                        <h4 class="box-title">
                            <?php
                                echo $user_data['username'];
                            ?>
                        </h4>
                    </div>
                    <div class="card-body--">
                        <form method="post">
                            <div class="table-stats order-table ov-h">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="serial">#</th>
                                            <th>ID</th>
                                            <th>Permission Name</th>
                                            <th>Has Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($permissions_result)) { ?>
                                            <tr>
                                                <td class="serial"><?php echo $i ?></td>
                                                <td><?php echo $row['permission_id'] ?></td>
                                                <td><?php echo $row['permission_name'] ?></td>
                                                <td>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="<?php echo $row['permission_id'] ?>"
                                                        <?php echo ($row['has_permission'] == 1) ? 'checked' : ''; ?>>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <button type="submit" name="update_permissions" class="btn btn-primary">Update Permissions</button>
                            </div>
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
