<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Asmeninių finansų apskaita
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-screen-xl mx-auto">

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 text-white">
            <div class="bg-green-500 p-6 rounded-xl shadow-md">
                <h2 class="text-lg font-bold">💸 Pajamos</h2>
                <p class="text-2xl font-semibold">{{ $pajamos ?? 0 }} €</p>
            </div>
            <div class="bg-red-500 p-6 rounded-xl shadow-md">
                <h2 class="text-lg font-bold">🪙 Išlaidos</h2>
                <p class="text-2xl font-semibold">{{ $islaidos ?? 0 }} €</p>
            </div>
            <div class="bg-blue-500 p-6 rounded-xl shadow-md">
                <h2 class="text-lg font-bold">📊 Balansas</h2>
                <p class="text-2xl font-semibold">{{ $balansas ?? 0 }} €</p>
            </div>
        </div>

        
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4">➕ Pridėti naują įrašą</h3>
            <form action="{{ route('irasai.store') }}" method="POST" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <input type="number" name="suma" placeholder="Suma €" required class="border border-gray-300 rounded p-2 w-full">
                <select name="tipas_id" required class="border border-gray-300 rounded p-2 w-full">
                    <option value="">Pasirinkti tipą</option>
                    @foreach ($tipai as $tipas)
                        <option value="{{ $tipas->id }}">{{ $tipas->pavadinimas }}</option>
                    @endforeach
                </select>
                <select name="kategorija_id" required class="border border-gray-300 rounded p-2 w-full">
                    <option value="">Pasirinkti kategoriją</option>
                    @foreach ($kategorijos as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->pavadinimas }}</option>
                    @endforeach
                </select>
                <input type="text" name="aprasymas" placeholder="Aprašymas" class="border border-gray-300 rounded p-2 w-full">
                <input type="date" name="data" class="border border-gray-300 rounded p-2 w-full">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white rounded p-2">Išsaugoti</button>
            </form>
        </div>

        
        <div class="bg-white rounded-lg shadow p-4 mb-4">
            <form method="GET" action="{{ route('dashboard') }}" class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <select name="tipas" class="border border-gray-300 rounded p-2 w-full">
                    <option value="">Visi tipai</option>
                    @foreach ($tipai as $tipas)
                        <option value="{{ $tipas->id }}" @if(request('tipas') == $tipas->id) selected @endif>{{ $tipas->pavadinimas }}</option>
                    @endforeach
                </select>
                <select name="kategorija" class="border border-gray-300 rounded p-2 w-full">
                    <option value="">Visos kategorijos</option>
                    @foreach ($kategorijos as $kat)
                        <option value="{{ $kat->id }}" @if(request('kategorija') == $kat->id) selected @endif>{{ $kat->pavadinimas }}</option>
                    @endforeach
                </select>
                <input type="date" name="nuo" value="{{ request('nuo') }}" class="border border-gray-300 rounded p-2 w-full" placeholder="Nuo">
                <input type="date" name="iki" value="{{ request('iki') }}" class="border border-gray-300 rounded p-2 w-full" placeholder="Iki">
                <div class="lg:col-span-4 text-right">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded p-2">🔍 Filtruoti</button>
                    <a href="{{ route('dashboard') }}" class="ml-2 text-sm underline text-gray-500">Išvalyti filtrus</a>
                </div>
            </form>
        </div>

        
        <div class="bg-white rounded shadow p-4 overflow-x-auto">
            <h3 class="text-lg font-semibold mb-4">📄 Visi įrašai</h3>
            <table class="min-w-full table-auto w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4">#</th>
                        <th class="py-2 px-4">Suma (€)</th>
                        <th class="py-2 px-4">Tipas</th>
                        <th class="py-2 px-4">Kategorija</th>
                        <th class="py-2 px-4">Aprašymas</th>
                        <th class="py-2 px-4">Data</th>
                        <th class="py-2 px-4">Veiksmai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($irasai as $irasas)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4">{{ $irasas->suma }} €</td>
                            <td class="py-2 px-4">{{ $irasas->tipas->pavadinimas ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $irasas->kategorija->pavadinimas ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $irasas->aprasymas }}</td>
                            <td class="py-2 px-4">{{ $irasas->data }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">
                                <a href="{{ route('irasai.edit', $irasas->id) }}" class="text-blue-500 hover:underline">✏️</a>
                                <form action="{{ route('irasai.destroy', $irasas->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-2">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
