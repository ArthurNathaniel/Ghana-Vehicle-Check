<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch total number of police personnel
$total_police_sql = "SELECT COUNT(*) as total FROM police";
$total_police_result = $conn->query($total_police_sql);
$total_police = $total_police_result->fetch_assoc()['total'];

// Fetch total number of DVLA personnel
$total_dvla_sql = "SELECT COUNT(*) as total FROM dvla_personnel";
$total_dvla_result = $conn->query($total_dvla_sql);
$total_dvla = $total_dvla_result->fetch_assoc()['total'];


// Fetch data for MTTD ranks
$rank_sql = "SELECT mttd_rank, COUNT(*) as count FROM police GROUP BY mttd_rank";
$rank_result = $conn->query($rank_sql);
$rank_data = [];
$rank_labels = [];
while ($row = $rank_result->fetch_assoc()) {
    $rank_labels[] = $row['mttd_rank'];
    $rank_data[] = $row['count'];
}

// Fetch data for police stations
$station_sql = "SELECT police_station, COUNT(*) as count FROM police GROUP BY police_station";
$station_result = $conn->query($station_sql);
$station_data = [];
$station_labels = [];
while ($row = $station_result->fetch_assoc()) {
    $station_labels[] = $row['police_station'];
    $station_data[] = $row['count'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="title">
    <h2> Statistics of Ghana Vechicle Check</h2>
    </div>
    <div class="containers">
    <div class="chartx">
        <canvas id="totalPoliceChart"></canvas>
    </div>
    <div class="chartx">
        <canvas id="totalDVLAPersonnelChart"></canvas>
    </div>
    <div class="chartx">
        <canvas id="rankChart"></canvas>
    </div>
    <div class="chartx">
        <canvas id="stationChart"></canvas>
    </div>
</div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Total Police Chart
        var totalPoliceCtx = document.getElementById('totalPoliceChart').getContext('2d');
        var totalPoliceChart = new Chart(totalPoliceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Total Police Personnel'],
                datasets: [{
                    data: [<?php echo $total_police; ?>],
                    backgroundColor: ['#36A2EB']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });


        // Total DVLA Personnel Chart
var totalDVLACtx = document.getElementById('totalDVLAPersonnelChart').getContext('2d');
var totalDVLAPersonnelChart = new Chart(totalDVLACtx, {
    type: 'doughnut',
    data: {
        labels: ['Total DVLA Personnel'],
        datasets: [{
            data: [<?php echo $total_dvla; ?>],
            backgroundColor: ['#FF6384']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});


        // Rank Chart
        var rankCtx = document.getElementById('rankChart').getContext('2d');
        var rankChart = new Chart(rankCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($rank_labels); ?>,
                datasets: [{
                    label: 'Number of Personnel (Rank)',
                    data: <?php echo json_encode($rank_data); ?>,
                    backgroundColor: [
                        'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)', 'rgb(255, 159, 64)', 'rgb(255, 99, 71)', 'rgb(144, 238, 144)', 'rgb(173, 216, 230)',
                        'rgb(250, 128, 114)', 'rgb(255, 69, 0)', 'rgb(255, 20, 147)', 'rgb(138, 43, 226)', 'rgb(139, 69, 19)',
                        'rgb(47, 79, 79)', 'rgb(112, 128, 144)', 'rgb(119, 136, 153)', 'rgb(0, 255, 255)', 'rgb(0, 128, 128)',
                        'rgb(123, 104, 238)', 'rgb(72, 61, 139)', 'rgb(106, 90, 205)', 'rgb(240, 230, 140)', 'rgb(255, 140, 0)',
                        'rgb(255, 215, 0)', 'rgb(255, 248, 220)', 'rgb(240, 255, 255)', 'rgb(70, 130, 180)', 'rgb(176, 196, 222)',
                        'rgb(220, 20, 60)', 'rgb(255, 182, 193)', 'rgb(255, 160, 122)', 'rgb(250, 250, 210)', 'rgb(127, 255, 0)',
                        'rgb(173, 255, 47)', 'rgb(0, 250, 154)', 'rgb(144, 238, 144)', 'rgb(32, 178, 170)', 'rgb(0, 255, 127)',
                        'rgb(50, 205, 50)', 'rgb(255, 127, 80)', 'rgb(222, 184, 135)', 'rgb(255, 228, 196)', 'rgb(255, 218, 185)',
                        'rgb(218, 112, 214)', 'rgb(186, 85, 211)', 'rgb(148, 0, 211)', 'rgb(153, 50, 204)', 'rgb(147, 112, 219)'
                    ],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Station Chart
        var stationCtx = document.getElementById('stationChart').getContext('2d');
        var stationChart = new Chart(stationCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($station_labels); ?>,
                datasets: [{
                    label: 'Number of Personnel (Police Station)',
                    data: <?php echo json_encode($station_data); ?>,
                    backgroundColor: [
                        'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)', 'rgb(255, 159, 64)', 'rgb(255, 99, 71)', 'rgb(144, 238, 144)', 'rgb(173, 216, 230)',
                        'rgb(250, 128, 114)', 'rgb(255, 69, 0)', 'rgb(255, 20, 147)', 'rgb(138, 43, 226)', 'rgb(139, 69, 19)',
                        'rgb(47, 79, 79)', 'rgb(112, 128, 144)', 'rgb(119, 136, 153)', 'rgb(0, 255, 255)', 'rgb(0, 128, 128)',
                        'rgb(123, 104, 238)', 'rgb(72, 61, 139)', 'rgb(106, 90, 205)', 'rgb(240, 230, 140)', 'rgb(255, 140, 0)',
                        'rgb(255, 215, 0)', 'rgb(255, 248, 220)', 'rgb(240, 255, 255)', 'rgb(70, 130, 180)', 'rgb(176, 196, 222)',
                        'rgb(220, 20, 60)', 'rgb(255, 182, 193)', 'rgb(255, 160, 122)', 'rgb(250, 250, 210)', 'rgb(127, 255, 0)',
                        'rgb(173, 255, 47)', 'rgb(0, 250, 154)', 'rgb(144, 238, 144)', 'rgb(32, 178, 170)', 'rgb(0, 255, 127)',
                        'rgb(50, 205, 50)', 'rgb(255, 127, 80)', 'rgb(222, 184, 135)', 'rgb(255, 228, 196)', 'rgb(255, 218, 185)',
                        'rgb(218, 112, 214)', 'rgb(186, 85, 211)', 'rgb(148, 0, 211)', 'rgb(153, 50, 204)', 'rgb(147, 112, 219)'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <style>
 
    </style>
</body>

</html>