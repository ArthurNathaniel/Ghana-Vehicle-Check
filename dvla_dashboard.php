<?php
include 'db.php';
session_start();
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['dvla_personnel'])) {
    header("Location: dvla_login.php");
    exit();
}
// Fetch total number of drivers
$sql_total_drivers = "SELECT COUNT(*) as total_drivers FROM driver_license_applications";
$result_total_drivers = $conn->query($sql_total_drivers);
$total_drivers = $result_total_drivers->fetch_assoc()['total_drivers'];

// Fetch total number of male and female drivers
$sql_gender_count = "SELECT gender, COUNT(*) as count FROM driver_license_applications GROUP BY gender";
$result_gender_count = $conn->query($sql_gender_count);
$gender_data = [];
while ($row = $result_gender_count->fetch_assoc()) {
    $gender_data[$row['gender']] = $row['count'];
}

// Fetch number of each license category
$sql_category_count = "SELECT license_category, COUNT(*) as count FROM driver_license_applications GROUP BY license_category";
$result_category_count = $conn->query($sql_category_count);
$category_data = [];
while ($row = $result_category_count->fetch_assoc()) {
    $category_data[$row['license_category']] = $row['count'];
}

// Fetch number of each purpose of license
$sql_purpose_count = "SELECT purpose_of_license, COUNT(*) as count FROM driver_license_applications GROUP BY purpose_of_license";
$result_purpose_count = $conn->query($sql_purpose_count);
$purpose_data = [];
while ($row = $result_purpose_count->fetch_assoc()) {
    $purpose_data[$row['purpose_of_license']] = $row['count'];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="dashboard">
        <h2>DVLA Stats</h2>
        <!-- <div class="charts">
            <div class="card">
                <p>Total Drivers: </p>
                <h1><?php echo $total_drivers; ?></h1>
            </div>
           <div class="card">
            <p>Gender</p>
           <div class="card_grid">
           <p>Male Drivers: </p>
         
           <h1><p>Male Drivers:</p><?php echo isset($gender_data['male']) ? $gender_data['male'] : 0; ?></h1>
           <p>Female Drivers: </p>
           <h1><?php echo isset($gender_data['female']) ? $gender_data['female'] : 0; ?></h1>
           </div>
           </div>
            <div class="card">
            <p class="chart-title">License Categories</p>
            <p><?php foreach ($category_data as $category => $count) {
                    echo htmlspecialchars($category) . ": " . $count . "<br>";
                } ?></p>
            </div>
           <div class="card">
           <p class="chart-title">Purpose of Licenses</p>
            <p><?php foreach ($purpose_data as $purpose => $count) {
                    echo htmlspecialchars($purpose) . ": " . $count . "<br>";
                } ?></p>
           </div>
        </div> -->

        <div class="charts">
            <div class="stats">
                <canvas id="totalDriversChart"></canvas>
            </div>
            <div class="stats">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="stats">
                <p>License Categories</p>
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="stats">
                <p>Purpose of Licenses</p>
                <canvas id="purposeChart"></canvas>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Total Drivers Chart
            var ctxTotalDrivers = document.getElementById('totalDriversChart').getContext('2d');
            var totalDriversChart = new Chart(ctxTotalDrivers, {
                type: 'doughnut',
                data: {
                    labels: ['Total Drivers'],
                    datasets: [{
                        data: [<?php echo $total_drivers; ?>],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 159, 64)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Total Drivers'
                        }
                    }
                }
            });

            // Gender Distribution Chart
            var ctxGender = document.getElementById('genderChart').getContext('2d');
            var genderChart = new Chart(ctxGender, {
                type: 'pie',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [
                            <?php echo isset($gender_data['male']) ? $gender_data['male'] : 0; ?>,
                            <?php echo isset($gender_data['female']) ? $gender_data['female'] : 0; ?>
                        ],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 159, 64)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Gender Distribution'
                        }
                    }
                }
            });

            // License Category Chart
            var ctxCategory = document.getElementById('categoryChart').getContext('2d');
            var categoryChart = new Chart(ctxCategory, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_keys($category_data)); ?>,
                    datasets: [{
                        label: '# of Licenses',
                        data: <?php echo json_encode(array_values($category_data)); ?>,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 159, 64)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'License Categories'
                        }
                    }
                }
            });

            // Purpose of License Chart
            var ctxPurpose = document.getElementById('purposeChart').getContext('2d');
            var purposeChart = new Chart(ctxPurpose, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_keys($purpose_data)); ?>,
                    datasets: [{
                        data: <?php echo json_encode(array_values($purpose_data)); ?>,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 159, 64)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Purpose of Licenses'
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>