<?php
require('../top.inc.php');
isAdmin();

if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        // Retrieve the file name to delete from the database
        $file_sql = "SELECT file_name FROM Files WHERE file_id='$id'";
        $file_result = mysqli_query($con, $file_sql);
        $file_row = mysqli_fetch_assoc($file_result);
        $file_name = $file_row['file_name'];
        
        // Remove the physical file from the directory
        $file_path = '../uploads/' . $file_name;
        if (file_exists($file_path)) {
            unlink($file_path); // Delete the file
        }
        
        $delete_sql = "DELETE FROM Files WHERE file_id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

// Get distinct file types for the dropdown
$fileTypesSql = "SELECT DISTINCT file_type FROM Files";
$fileTypesResult = mysqli_query($con, $fileTypesSql);

$sql = "SELECT * FROM Files";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">FILES</h4>
                        <h4 class="box-link"><a href="add.php">ADD FILE</a></h4>
                    </div>
                    <div class="card-body--">
                        <form method="get">
                            <div class="form-group">
                                <label for="file_type">Filter by File Type:</label>
                                <select class="form-control" name="file_type" id="file_type">
                                    <option value="">All</option>
                                    <?php
                                    while ($typeRow = mysqli_fetch_assoc($fileTypesResult)) {
                                        echo '<option value="' . $typeRow['file_type'] . '">' . $typeRow['file_type'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>File Name</th>
                                        <th>Description</th>
                                        <th>Upload Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;

                                    $where = ""; // Initialize filter query
                                    if (isset($_GET['file_type']) && $_GET['file_type'] !== '') {
                                        $selectedFileType = get_safe_value($con, $_GET['file_type']);
                                        $where = "WHERE file_type = '$selectedFileType'";
                                    }

                                    $sql = "SELECT * FROM Files $where";
                                    $res = mysqli_query($con, $sql);
                                    
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                        <tr>
                                            <td class="serial"><?php echo $i ?></td>
                                            <td><?php echo $row['file_id'] ?></td>
                                            <td><?php echo $row['file_name'] ?></td>
                                            <td><?php echo $row['description'] ?></td>
                                            <td><?php echo $row['upload_date'] ?></td>
                                            <td>
                                                <?php
                                                echo "<span class='badge badge-edit'><a href='edit.php?id=" . $row['file_id'] . "'>Edit</a></span>&nbsp;";
                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['file_id'] . "'>Delete</a></span>";
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
