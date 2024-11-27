<?php
session_start();
// Verify admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== '1') {
    header('Location: /dashboard');
    exit();
}

// Dummy data
$totalUsers = 156;
$activeUsers = 142;
$avgHealthScore = 73.5;
$avgBMI = 23.2;

$weeklyTrend = [
    ['week' => 'Week 1', 'avg_score' => 71.2, 'active_users' => 130],
    ['week' => 'Week 2', 'avg_score' => 72.8, 'active_users' => 135],
    ['week' => 'Week 3', 'avg_score' => 73.5, 'active_users' => 142],
    ['week' => 'Week 4', 'avg_score' => 74.1, 'active_users' => 138]
];

$bmiDistribution = [
    ['range' => 'Underweight', 'count' => 12],
    ['range' => 'Normal', 'count' => 98],
    ['range' => 'Overweight', 'count' => 34],
    ['range' => 'Obese', 'count' => 12]
];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gezondheidsmeter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-blue-50">
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-md z-10">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center w-4/5">
            <div class="text-2xl font-bold text-blue-600">Admin Dashboard</div>
            <div class="flex items-center space-x-4">
                <form action="/logout" method="POST" class="inline">
                    <button type="submit" class="bg-white text-blue-600 border border-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50">
                        Uitloggen
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 pt-24 pb-12 w-4/5">
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600 mb-2">Totaal Gebruikers</h3>
                <p class="text-3xl font-bold text-blue-600"><?= $totalUsers ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600 mb-2">Actieve Gebruikers</h3>
                <p class="text-3xl font-bold text-blue-600"><?= $activeUsers ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600 mb-2">Gemiddelde Score</h3>
                <p class="text-3xl font-bold text-blue-600"><?= number_format($avgHealthScore, 1) ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600 mb-2">Gemiddelde BMI</h3>
                <p class="text-3xl font-bold text-blue-600"><?= number_format($avgBMI, 1) ?></p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-blue-800 mb-4">Wekelijkse Trend</h2>
                <canvas id="trendChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-blue-800 mb-4">BMI Verdeling</h2>
                <canvas id="bmiChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Weekly Trend Chart
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($weeklyTrend, 'week')) ?>,
                datasets: [{
                    label: 'Gemiddelde Score',
                    data: <?= json_encode(array_column($weeklyTrend, 'avg_score')) ?>,
                    borderColor: '#2563EB'
                }]
            }
        });

        // BMI Distribution Chart
        new Chart(document.getElementById('bmiChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($bmiDistribution, 'range')) ?>,
                datasets: [{
                    label: 'Aantal Gebruikers',
                    data: <?= json_encode(array_column($bmiDistribution, 'count')) ?>,
                    backgroundColor: '#2563EB'
                }]
            }
        });
    </script>
</body>
</html>