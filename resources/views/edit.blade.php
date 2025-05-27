<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Redaguoti įrašą
        </h2>
    </x-slot>

    <div class="container mt-4 p-4">
        <form action="{{ route('irasai.update', $irasas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="suma" class="form-label">Suma €</label>
                <input type="number" name="suma" value="{{ $irasas->suma }}" step="0.01" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="tipas_id" class="form-label">Tipas</label>
                <select name="tipas_id" class="form-select" required>
                    @foreach($tipai as $tipas)
                        <option value="{{ $tipas->id }}" @if($irasas->tipas_id == $tipas->id) selected @endif>
                            {{ $tipas->pavadinimas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kategorija_id" class="form-label">Kategorija</label>
                <select name="kategorija_id" class="form-select" required>
                    @foreach($kategorijos as $kategorija)
                        <option value="{{ $kategorija->id }}" @if($irasas->kategorija_id == $kategorija->id) selected @endif>
                            {{ $kategorija->pavadinimas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="aprasymas" class="form-label">Aprašymas</label>
                <input type="text" name="aprasymas" value="{{ $irasas->aprasymas }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" name="data" value="{{ $irasas->data }}" class="form-control" required>
            </div>

            <button class="btn btn-success" type="submit">💾 Atnaujinti</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">⬅️ Atgal</a>
        </form>
    </div>
</x-app-layout>
