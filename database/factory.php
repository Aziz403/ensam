<?php
require('../connection.inc.php');
require('../functions.inc.php');

// Function to insert a student record
function insertStudent($con, $firstName, $lastName, $birthDate, $phone, $email, $photo_url, $cin_copy_url, $bac_copy_url, $transcript_copy_url) {
    $sql = "INSERT INTO Students (first_name, last_name, birth_date, phone, email, photo_url, cin_copy_url, bac_copy_url, transcript_copy_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssssss", $firstName, $lastName, $birthDate, $phone, $email, $photo_url, $cin_copy_url, $bac_copy_url, $transcript_copy_url);
    $stmt->execute();
}

// Function to insert a department record
function insertDepartment($con, $department_name) {
    $sql = "INSERT INTO Departments (department_name) VALUES (?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
}

// Function to insert a module record
function insertModule($con, $module_name, $department_id) {
    $sql = "INSERT INTO Modules (module_name, department_id) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $module_name, $department_id);
    $stmt->execute();
}

// Function to insert an employee record
function insertEmployee($con, $first_name_emp, $last_name_emp, $birth_date_emp, $phone_emp, $email_emp, $photo_url, $cv_url, $role) {
    $sql = "INSERT INTO Employees (first_name_emp, last_name_emp, birth_date_emp, phone_emp, email_emp, photo_url, cv_url, role) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssss", $first_name_emp, $last_name_emp, $birth_date_emp, $phone_emp, $email_emp, $photo_url, $cv_url, $role);
    $stmt->execute();
}

// Function to insert an attendance record
function insertAttendance($con, $employee_id, $module_id, $student_id) {
    $sql = "INSERT INTO Attendance (employee_id, module_id, student_id) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iii", $employee_id, $module_id, $student_id);
    $stmt->execute();
}

// Function to insert an exam result record
function insertExamResult($con, $employee_id, $module_id, $student_id, $exam_date, $exam_note) {
    $sql = "INSERT INTO ExamResults (employee_id, module_id, student_id, exam_date, exam_note) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iiiss", $employee_id, $module_id, $student_id, $exam_date, $exam_note);
    $stmt->execute();
}

// Function to insert a file record
function insertFile($con, $file_name, $file_type, $description) {
    $sql = "INSERT INTO Files (file_name, file_type, description) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $file_name, $file_type, $description);
    $stmt->execute();
}

// Function to insert a user account
function insertUserAccount($con, $username, $password_hash, $first_name, $last_name, $email, $is_admin) {
    $sql = "INSERT INTO UserAccounts (username, password_hash, first_name, last_name, email, is_admin) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssi", $username, $password_hash, $first_name, $last_name, $email, $is_admin);
    $stmt->execute();
}

// Function to insert a permission record
function insertPermission($con, $permission_method, $permission_route, $permission_name) {
    $sql = "INSERT INTO Permissions (permission_method, permission_route, permission_name) 
            VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $permission_method, $permission_route, $permission_name);
    $stmt->execute();
}

// Function to link a permission to a user
function linkPermissionToUser($con, $user_id, $permission_id) {
    $sql = "INSERT INTO UserPermissions (user_id, permission_id) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $user_id, $permission_id);
    $stmt->execute();
}

// Insert sample data into the Students table
insertStudent($con, 'John', 'Doe', '1990-01-15', '1234567890', 'john@example.com', 'path_to_photo1.jpg', 'path_to_cin_copy1.jpg', 'path_to_bac_copy1.jpg', 'path_to_transcript_copy1.jpg');
insertStudent($con, 'Jane', 'Smith', '1992-05-20', '9876543210', 'jane@example.com', 'path_to_photo2.jpg', 'path_to_cin_copy2.jpg', 'path_to_bac_copy2.jpg', 'path_to_transcript_copy2.jpg');

// Insert sample data into the Departments table
insertDepartment($con, 'Department A');
insertDepartment($con, 'Department B');
insertDepartment($con, 'Department C');

// Insert sample data into the Modules table
insertModule($con, 'Module 1', 1);
insertModule($con, 'Module 2', 1);
insertModule($con, 'Module 3', 2);

// Insert sample data into the Employees table
insertEmployee($con, 'John', 'Employee', '1985-08-10', '5555555555', 'employee@example.com', 'path_to_photo1.jpg', 'path_to_cv1.pdf', 'Professor');
insertEmployee($con, 'Jane', 'Manager', '1980-12-03', '6666666666', 'manager@example.com', 'path_to_photo2.jpg', 'path_to_cv2.pdf', 'Staff');

// Insert sample data into the Attendance table
insertAttendance($con, 1, 1, 1);
insertAttendance($con, 2, 2, 2);

// Insert sample data into the ExamResults table
insertExamResult($con, 1, 1, 1, '2023-01-10', 'Pass');
insertExamResult($con, 2, 2, 2, '2023-01-15', 'Fail');

// Insert sample data into the Files table
insertFile($con, 'file1.pdf', 'pdf', 'Description for file 1');
insertFile($con, 'file2.jpg', 'image', 'Description for file 2');

// Insert sample data into the UserAccounts table
insertUserAccount($con, 'admin', password_hash('123', PASSWORD_BCRYPT), 'Admin', 'User', 'admin@example.com', 1);

// Insert sample data into the Permissions table
insertPermission($con, 'GET', '/admin/dashboard.php', 'Dashboard Access');
insertPermission($con, 'POST', '/admin/save.php', 'Data Save');
insertPermission($con, 'GET', '/admin/users.php', 'User Access');
insertPermission($con, 'POST', '/admin/users.php', 'User Management');
insertPermission($con, 'POST', '/admin/settings.php', 'Settings Management');

// Link sample permissions to the user account
linkPermissionToUser($con, 1, 1);
linkPermissionToUser($con, 1, 2);
linkPermissionToUser($con, 1, 3);
linkPermissionToUser($con, 1, 4);
linkPermissionToUser($con, 1, 5);

echo "Factory data inserted successfully.";
?>
