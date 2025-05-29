<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Finansiniai įrašai</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .center { text-align: center; }
        .logo { width: 50px; margin: 0 auto 10px; display: block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 6px; border: 2px solid #000000; }
        th { background-color: #f3f3f3; }
    </style>
</head>
<body>

    
    <div class="center">
        <img src="{{ public_path('budget.png') }}" class="logo">
        <h2>Finansiniai įrašai</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Suma</th>
                <th>Tipas</th>
                <th>Kategorija</th>
                <th>Aprašymas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($irasai as $irasas)
                <tr>
                    <td>{{ $irasas->data }}</td>
                    <td>{{ number_format($irasas->suma, 2) }} €</td>
                    <td>{{ $irasas->tipas->pavadinimas ?? '-' }}</td>
                    <td>{{ $irasas->kategorija->pavadinimas ?? '-' }}</td>
                    <td>{{ $irasas->aprasymas ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
