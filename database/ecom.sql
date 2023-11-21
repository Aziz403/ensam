CREATE TABLE Students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    birth_date DATE,
    phone VARCHAR(50),
    email VARCHAR(50),
    photo_url VARCHAR(255),
    cin_copy_url VARCHAR(255),
    bac_copy_url VARCHAR(255),
    transcript_copy_url VARCHAR(255)
);

CREATE TABLE Departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

CREATE TABLE Modules (
    module_id INT AUTO_INCREMENT PRIMARY KEY,
    module_name VARCHAR(50),
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES Departments(department_id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE Employees (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name_emp VARCHAR(50),
    last_name_emp VARCHAR(50),r
    birth_date_emp DATE,
    phone_emp INT,
    email_emp VARCHAR(50),
    photo_url VARCHAR(255),
    cv_url VARCHAR(255),
    role ENUM('Professor', 'Staff') DEFAULT 'Staff'
);

CREATE TABLE Attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    module_id INT,
    student_id INT,
    raison TEXT NULL,
    date_absence DATE NULL,
    FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES Modules(module_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE
);

CREATE TABLE ExamResults (
    exam_results_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    module_id INT,
    student_id INT,
    exam_date DATE,
    exam_note VARCHAR(50),
    FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES Modules(module_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE
);

CREATE TABLE Files (
    file_id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_type VARCHAR(255) NOT NULL,
    description TEXT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE UserAccounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    is_admin BIT DEFAULT 0
);

CREATE TABLE Permissions (
    permission_id INT AUTO_INCREMENT PRIMARY KEY,
    permission_method VARCHAR(255) NOT NULL,
    permission_route VARCHAR(255) NOT NULL,
    permission_name VARCHAR(255) NOT NULL
);

CREATE TABLE UserPermissions (
    user_permission_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    permission_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES UserAccounts (user_id),
    FOREIGN KEY (permission_id) REFERENCES Permissions (permission_id)
);

