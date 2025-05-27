<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Irasas;
use App\Models\Tipas;
use App\Models\Kategorija;

class FinansaiController extends Controller
{
    /**
     * Rodo vartotojo įrašų sąrašą (dashboard).
     */
    public function index()
    {
        $naudotojo_id = auth()->id();

        $irasai = Irasas::where('user_id', $naudotojo_id)
            ->with(['kategorija', 'tipas'])
            ->get();

        $kategorijos = Kategorija::all();
        $tipai = Tipas::all();

        $pajamos = Irasas::where('user_id', $naudotojo_id)->where('tipas_id', 1)->sum('suma');
        $islaidos = Irasas::where('user_id', $naudotojo_id)->where('tipas_id', 2)->sum('suma');
        $balansas = $pajamos - $islaidos;

        return view('dashboard', compact(
            'irasai', 'kategorijos', 'tipai',
            'pajamos', 'islaidos', 'balansas'
        ));
    }

    /**
     * Išsaugo naują įrašą į DB.
     */
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

    /**
     * Rodo redagavimo formą.
     */
    public function edit($id)
    {
        $irasas = Irasas::where('user_id', auth()->id())->findOrFail($id);
        $kategorijos = Kategorija::all();
        $tipai = Tipas::all();

        return view('edit', compact('irasas', 'kategorijos', 'tipai'));
    }

    /**
     * Atnaujina redaguotą įrašą.
     */
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

    /**
     * Ištrina įrašą iš DB.
     */
    public function destroy($id)
    {
        $irasas = Irasas::where('user_id', auth()->id())->findOrFail($id);
        $irasas->delete();

        return redirect()->route('dashboard')->with('success', '🗑️ Įrašas sėkmingai ištrintas!');
    }
}
