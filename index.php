<?php
require('top.inc.php');
isAdmin();

// Fetch data from the database
$sqlStudents = "SELECT COUNT(*) AS totalStudents FROM Students";
$sqlEmployees = "SELECT COUNT(*) AS totalEmployees FROM Employees";
$sqlExamsResults = "SELECT COUNT(*) AS totalExamsResults FROM ExamResults";

$resultStudents = mysqli_query($con, $sqlStudents);
$resultEmployees = mysqli_query($con, $sqlEmployees);
$resultExamsResults = mysqli_query($con, $sqlExamsResults);

$totalStudents = 0;
$totalEmployees = 0;
$totalExamsResults = 0;

if ($resultStudents && mysqli_num_rows($resultStudents) > 0) {
    $rowStudents = mysqli_fetch_assoc($resultStudents);
    $totalStudents = $rowStudents['totalStudents'];
}

if ($resultEmployees && mysqli_num_rows($resultEmployees) > 0) {
    $rowEmployees = mysqli_fetch_assoc($resultEmployees);
    $totalEmployees = $rowEmployees['totalEmployees'];
}

if ($resultExamsResults && mysqli_num_rows($resultExamsResults) > 0) {
    $rowExamsResults = mysqli_fetch_assoc($resultExamsResults);
    $totalExamsResults = $rowExamsResults['totalExamsResults'];
}
?>

<div class="content pb-0">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h2>Total Students</h2>
                    <h1><?php echo $totalStudents; ?></h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h2>Total Employees</h2>
                    <h1><?php echo $totalEmployees; ?></h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h2>Total Exam Results</h2>
                    <h1><?php echo $totalExamsResults; ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <canvas id="studentPieChart" width="200" height="100"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <canvas id="studentBarChart" width="200" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Create a bar chart
    var studentBarChartCanvas = document.getElementById('studentBarChart').getContext('2d');
    var studentBarChart = new Chart(studentBarChartCanvas, {
        type: 'bar',
        data: {
            labels: ['Students'],
            datasets: [{
                label: 'Total Students',
                data: [<?php echo $totalStudents; ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Create a pie chart
    var studentPieChartCanvas = document.getElementById('studentPieChart').getContext('2d');
    var studentPieChart = new Chart(studentPieChartCanvas, {
        type: 'pie',
        data: {
            labels: ['Students', 'Employees', 'Exams'],
            datasets: [{
                data: [
                    <?php echo $totalStudents; ?>,
                    <?php echo $totalEmployees; ?>,
                    <?php echo $totalExamsResults; ?>
                ],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }]
        }
    });
</script>


<?php
require('footer.inc.php');