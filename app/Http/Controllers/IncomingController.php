<?php
namespace App\Http\Controllers;

use App\Models\Incoming;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncomingController extends Controller
{
    public function index()
    {
        $incomings = Incoming::all();
        return Inertia::render('BarangMasuk', [
            'incomings' => $incomings,
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
        ]);
        Incoming::create($validated);
        return redirect()->route('incomings.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'material_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
        ]);
        $incoming = Incoming::findOrFail($id);
        $incoming->update($validated);
        return redirect()->route('incomings.index');
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No IDs provided'], 400);
        }
        Incoming::whereIn('id', $ids)->delete();
        return redirect()->route('incomings.index');
    }
}
