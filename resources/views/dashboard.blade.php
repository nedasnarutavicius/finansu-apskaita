<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard – Asmeninių finansų apskaita 💸
        </h2>
    </x-slot>

    <div class="container mt-4 p-4">

        {{-- ✅ Sėkmės žinutė --}}
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- 💰 Finansų balansas --}}
        <div class="alert alert-info">
            <strong>💸 Pajamos:</strong> {{ number_format($pajamos, 2) }} €
            &nbsp;&nbsp;&nbsp;
            <strong>💸 Išlaidos:</strong> {{ number_format($islaidos, 2) }} €
            &nbsp;&nbsp;&nbsp;
            <strong>📊 Balansas:</strong>
            <span class="{{ $balansas < 0 ? 'text-danger' : 'text-success' }}">
                {{ number_format($balansas, 2) }} €
            </span>
        </div>

        <h3>Pridėti naują įrašą</h3>

        {{-- 🔽 Forma įrašui sukurti --}}
        <form action="{{ route('irasai.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="suma" class="form-label">Suma €</label>
                <input type="number" name="suma" step="0.01" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="tipas_id" class="form-label">Tipas</label>
                <select name="tipas_id" class="form-select" required>
                    <option value="">Pasirinkti</option>
                    @foreach($tipai as $tipas)
                        <option value="{{ $tipas->id }}">{{ $tipas->pavadinimas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kategorija_id" class="form-label">Kategorija</label>
                <select name="kategorija_id" class="form-select" required>
                    <option value="">Pasirinkti</option>
                    @foreach($kategorijos as $kategorija)
                        <option value="{{ $kategorija->id }}">{{ $kategorija->pavadinimas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="aprasymas" class="form-label">Aprašymas</label>
                <input type="text" name="aprasymas" class="form-control">
            </div>

            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" name="data" class="form-control" required>
            </div>

            <button class="btn btn-primary" type="submit">💾 Išsaugoti</button>
        </form>

        {{-- 📋 Lentelė su įrašais --}}
        <hr class="my-4">

        <h3>Visi įrašai</h3>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Suma (€)</th>
                    <th>Tipas</th>
                    <th>Kategorija</th>
                    <th>Aprašymas</th>
                    <th>Data</th>
                    <th>Veiksmai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($irasai as $irasas)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $irasas->suma }}</td>
                        <td>{{ $irasas->tipas->pavadinimas ?? 'Nenurodyta' }}</td>
                        <td>{{ $irasas->kategorija->pavadinimas ?? 'Nenurodyta' }}</td>
                        <td>{{ $irasas->aprasymas }}</td>
                        <td>{{ $irasas->data }}</td>
                        <td>
                            {{-- ✏️ Redagavimo mygtukas --}}
                            <a href="{{ route('irasai.edit', $irasas->id) }}" class="btn btn-sm btn-warning mb-1">✏️ Redaguoti</a>

                            {{-- 🗑️ Ištrynimo forma --}}
                            <form action="{{ route('irasai.destroy', $irasas->id) }}" method="POST" onsubmit="return confirm('Ar tikrai trinti?');" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Trinti</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Nėra įrašų 👀</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
