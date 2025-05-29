<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Irasas;
use App\Models\Tipas;
use App\Models\Kategorija;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FinansaiController extends Controller
{
    
    public function index(Request $request)
    {
        $naudotojo_id = auth()->id();

        $filtruotasTipas = $request->input('tipas');
        $filtruotaKategorija = $request->input('kategorija');

        $query = Irasas::where('user_id', $naudotojo_id)->with(['kategorija', 'tipas']);

        if ($filtruotasTipas) {
            $query->where('tipas_id', $filtruotasTipas);
        }

        if ($filtruotaKategorija) {
            $query->where('kategorija_id', $filtruotaKategorija);
        }

        $irasai = $query->get();
        $kategorijos = Kategorija::all();
        $tipai = Tipas::all();

        $pajamos = Irasas::where('user_id', $naudotojo_id)->where('tipas_id', 1)->sum('suma');
        $islaidos = Irasas::where('user_id', $naudotojo_id)->where('tipas_id', 2)->sum('suma');
        $balansas = $pajamos - $islaidos;

        return view('dashboard', compact(
            'irasai', 'kategorijos', 'tipai',
            'pajamos', 'islaidos', 'balansas',
            'filtruotasTipas', 'filtruotaKategorija'
        ));
    }


    public function statistika()
    {
        $naudotojo_id = auth()->id();

        
        $dienosIslaidos = Irasas::where('user_id', $naudotojo_id)
            ->where('tipas_id', 2)
            ->whereDate('created_at', Carbon::today())
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->created_at)->format('H'))
            ->map(fn($group) => $group->sum('suma'));

        $dienosLabels = [];
        $dienosValues = [];
        for ($i = 0; $i < 24; $i++) {
            $val = str_pad($i, 2, '0', STR_PAD_LEFT);
            $dienosLabels[] = $val . ':00';
            $dienosValues[] = $dienosIslaidos[$val] ?? 0;
        }

        
        $menesioIslaidos = Irasas::where('user_id', $naudotojo_id)
            ->where('tipas_id', 2)
            ->whereMonth('data', Carbon::now()->month)
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->data)->format('d'))
            ->map(fn($group) => $group->sum('suma'));

        $menesioLabels = [];
        $menesioValues = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $diena = str_pad($i, 2, '0', STR_PAD_LEFT);
            $menesioLabels[] = $diena;
            $menesioValues[] = $menesioIslaidos[$diena] ?? 0;
        }

        
        $metuIslaidos = Irasas::where('user_id', $naudotojo_id)
            ->where('tipas_id', 2)
            ->whereYear('data', Carbon::now()->year)
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->data)->format('m'))
            ->map(fn($group) => $group->sum('suma'));

        $metuLabels = [
            'Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegužė', 'Birželis',
            'Liepa', 'Rugpjūtis', 'Rugsėjis', 'Spalis', 'Lapkritis', 'Gruodis'
        ];
        $metuValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $key = str_pad($i, 2, '0', STR_PAD_LEFT);
            $metuValues[] = $metuIslaidos[$key] ?? 0;
        }

        return view('statistika', compact(
            'dienosLabels', 'dienosValues',
            'menesioLabels', 'menesioValues',
            'metuLabels', 'metuValues'
        ));
    }

    public function eksportuotiPDF()
    {
        $naudotojo_id = auth()->id();

        $irasai = Irasas::where('user_id', $naudotojo_id)->with(['tipas', 'kategorija'])->get();

        $pdf = Pdf::loadView('pdf.irasai', compact('irasai'));

        return $pdf->download('irasai.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'suma' => 'required|numeric',
            'tipas_id' => 'required|exists:tipai,id',
            'kategorija_id' => 'required|exists:kategorijos,id',
            'aprasymas' => 'nullable|string|max:255',
            'data' => 'required|date',
        ]);

        Irasas::create([
            'user_id' => auth()->id(),
            'suma' => $request->suma,
            'tipas_id' => $request->tipas_id,
            'kategorija_id' => $request->kategorija_id,
            'aprasymas' => $request->aprasymas,
            'data' => $request->data,
        ]);

        return redirect()->route('dashboard')->with('success', '✅ Įrašas pridėtas sėkmingai!');
    }

    public function edit($id)
    {
        $irasas = Irasas::where('user_id', auth()->id())->findOrFail($id);
        $kategorijos = Kategorija::all();
        $tipai = Tipas::all();

        return view('edit', compact('irasas', 'kategorijos', 'tipai'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'suma' => 'required|numeric',
            'tipas_id' => 'required|exists:tipai,id',
            'kategorija_id' => 'required|exists:kategorijos,id',
            'aprasymas' => 'nullable|string|max:255',
            'data' => 'required|date',
        ]);

        $irasas = Irasas::where('user_id', auth()->id())->findOrFail($id);

        $irasas->update([
            'suma' => $request->suma,
            'tipas_id' => $request->tipas_id,
            'kategorija_id' => $request->kategorija_id,
            'aprasymas' => $request->aprasymas,
            'data' => $request->data,
        ]);

        return redirect()->route('dashboard')->with('success', '✏️ Įrašas atnaujintas sėkmingai!');
    }


    public function destroy($id)
    {
        $irasas = Irasas::where('user_id', auth()->id())->findOrFail($id);
        $irasas->delete();

        return redirect()->route('dashboard')->with('success', '🗑️ Įrašas sėkmingai ištrintas!');
    }
}
