<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::latest()->paginate(10);
        return view('admin.cargo', compact('cargos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resi_number' => 'required|string|max:255',
            'item' => 'required|string|max:255',
            'vessel' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'current_lat' => 'required|numeric',
            'current_lng' => 'required|numeric',
            'standard_eta' => 'required|string|max:255',
        ]);

        Cargo::create($validated);

        return redirect()->back()->with('success', 'Cargo berhasil ditambahkan!');
    }
}
