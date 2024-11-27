<?php
if (!isset($userData)) {
    header('Location: /login');
    exit();
}
$needsOnboarding = !isset($userData['onboarding_complete']) || !$userData['onboarding_complete'];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gezondheidsmeter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-blue-50 font-sans">
    <!-- Navbar -->

    <nav class="fixed top-0 left-0 right-0 bg-white shadow-md z-10">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center w-4/5 max-w-screen-xl">
            <div class="text-2xl font-bold text-blue-600">Gezondheidsmeter</div>
            <div class="flex items-center space-x-4">
                <div class="relative inline-block text-left">
                    <div>
                        <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-5 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                            <?php echo htmlspecialchars($userData['full_name']); ?>
                            <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div id="menu" class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none divide-y divide-gray-200" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <div class="px-4 py-3 text-sm text-gray-900">
                                <div><?php echo htmlspecialchars($userData['full_name']); ?></div>
                                <div class="font-medium truncate"><?php  echo htmlspecialchars($userData['email']); ?></div>
                            </div>
                        </div>
                        <div class="py-1" role="none">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-0">Update Stats</a>
                            <a href="#" id="resetAccountLink" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Reset Account</a>
                            <form method="POST" action="/logout" role="none">
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-3">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </nav>

    <?php if ($needsOnboarding): ?>
    <div class="container mx-auto px-4 pt-24 pb-6 w-4/5 max-w-screen-xl">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-600">
            <h2 class="text-xl font-bold text-blue-800 mb-2">Laten we beginnen!</h2>
            <p class="text-gray-600 mb-4">Om je gezondheid beter te kunnen monitoren, hebben we wat informatie van je nodig.</p>
            <a href="/onboarding" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 inline-block">
            Start vragenlijst
            </a>
        </div>
    </div>
    <?php endif; ?>
    <div class="container mx-auto px-4 <?= $needsOnboarding ? 'pt-6' : 'pt-24' ?> pb-12 w-4/5 max-w-screen-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="col-span-2 md:col-span-1 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-blue-800 mb-4">Gezondheids Score</h2>
                <div class="relative w-full h-40">
                    <canvas id="healthScoreGauge"></canvas>
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-3xl font-bold text-blue-600">
                        <?php echo $userData['health_score']; ?>
                    </div>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1 grid grid-cols-2 gap-6">
                <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-gray-600 mb-2">BMI</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        <?= isset($userData['bmi']) ? number_format($userData['bmi'], 1) : '-' ?>
                    </p>
                </div>
                <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-gray-600 mb-2">Gewicht</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        <?= isset($userData['weight']) ? $userData['weight'] . ' kg' : '-' ?>
                    </p>
                </div>
                <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-gray-600 mb-2">Lengte</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        <?= isset($userData['length']) ? $userData['length'] . ' cm' : '-' ?>
                    </p>
                </div>
                <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-gray-600 mb-2">Placeholder</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        -
                    </p>
                </div>
            </div>
            <div class="col-span-1 bg-white p-6 rounded-lg shadow-md">
                <div class="h-full flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-blue-800">Dagelijkse Check</h2>
                        <p class="text-gray-600 mt-1">Vul je dagelijkse vragenlijst in voor een betere gezondheidsscore</p>
                    </div>
                    <a href="/daily-questions" class="mt-4 <?php echo $needsOnboarding ? 'bg-gray-500' : 'bg-blue-600' ?> text-white px-6 py-3 rounded-lg <?php echo $needsOnboarding ? 'hover:bg-gray-600' : 'hover:hbg-blue-500' ?> transition text-center">
                        Start Vragenlijst
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Geschiedenis</h2>
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-50">
                        <th class="p-3 text-left">Datum</th>
                        <th class="p-3 text-left">Gezondheids Score</th>
                        <th class="p-3 text-left">BMI</th>
                        <th class="p-3 text-left">Gewicht</th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        Nog geen geschiedenis beschikbaar
                    </td>
                </tbody>
            </table>
        </div>
    </div>

    <div id="confirmResetPopup" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto text-center">
            <h3 class="text-xl font-medium text-gray-900 mb-4">Account Reset</h3>
            <p class="text-base text-gray-500 mb-4">
                Weet je het zeker dat je je account wilt resetten? Dit zal alle gegevens, waaronder je gezondheidshistorie en vooruitgang, permanent verwijderen.
            </p>
            <p class="text-base text-gray-500 mb-6">
                Na het resetten moet je opnieuw beginnen met het invoeren van je gegevens en het voltooien van de vragenlijsten.
            </p>
            <div class="flex justify-center space-x-4">
                <button id="confirmResetYes" type="button" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2">Ja, reset mijn account</button>
                <button id="confirmResetNo" type="button" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">Nee, annuleren</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('menu-button');
            const dropdownMenu = document.getElementById('menu');
            const confirmResetPopup = document.getElementById('confirmResetPopup');
            const confirmResetYes = document.getElementById('confirmResetYes');
            const confirmResetNo = document.getElementById('confirmResetNo');

            dropdownButton.addEventListener('click', function () {
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!dropdownButton.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            document.getElementById('resetAccountLink').addEventListener('click', function(e) {
                e.preventDefault();
                confirmResetPopup.classList.remove('hidden');
            });

            confirmResetYes.addEventListener('click', function() {
    // Show loading state
    confirmResetYes.disabled = true;
    confirmResetYes.textContent = 'Bezig met resetten...';
    
    fetch('/reset-account', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.error || 'Er is een fout opgetreden');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Je account is succesvol gereset. De pagina wordt nu herladen.');
            window.location.reload();
        } else {
            throw new Error('Reset failed');
        }
    })
    .catch(error => {
        window.location.reload();
    })
    .finally(() => {
        confirmResetPopup.classList.add('hidden');
        confirmResetYes.disabled = false;
        confirmResetYes.textContent = 'Ja, reset mijn account';
    });
});

            confirmResetNo.addEventListener('click', function() {
                confirmResetPopup.classList.add('hidden');
            });
        });

        const ctx = document.getElementById('healthScoreGauge').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [<?php echo $userData['health_score']; ?>, <?php echo 100 - $userData['health_score']; ?>],
                    backgroundColor: ['#2563EB', '#E5E7EB'],
                    borderWidth: 0
                }]
            },
            options: {
                circumference: 180,
                rotation: -90,
                cutout: '80%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });
    </script>
</body>
</html>