<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📊 Statistika</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-screen-xl mx-auto space-y-10">

        
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">🕒 Dienos išlaidos (valandomis)</h3>
            <canvas id="dienosChart" height="120"></canvas>
        </div>

        
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">📅 Mėnesio išlaidos (dienomis)</h3>
            <canvas id="menesioChart" height="120"></canvas>
        </div>

        
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">📆 Metų išlaidos (mėnesiais)</h3>
            <canvas id="metuChart" height="120"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        
        const dienosChart = new Chart(document.getElementById('dienosChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($dienosLabels) !!},
                datasets: [{
                    label: 'Išlaidos €',
                    data: {!! json_encode($dienosValues) !!},
                    borderColor: '#f87171',
                    backgroundColor: '#fecaca',
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        
        const menesioChart = new Chart(document.getElementById('menesioChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($menesioLabels) !!},
                datasets: [{
                    label: 'Išlaidos €',
                    data: {!! json_encode($menesioValues) !!},
                    borderColor: '#fb923c',
                    backgroundColor: '#fed7aa',
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        
        const metuChart = new Chart(document.getElementById('metuChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($metuLabels) !!},
                datasets: [{
                    label: 'Išlaidos €',
                    data: {!! json_encode($metuValues) !!},
                    borderColor: '#60a5fa',
                    backgroundColor: '#bfdbfe',
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>
