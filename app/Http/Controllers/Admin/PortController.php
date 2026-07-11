<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Port;

class PortController extends Controller
{
    public function index()
    {
        $ports = Port::latest()->paginate(10);
        return view('admin.ports', compact('ports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        Port::create($validated);

        return redirect()->back()->with('success', 'Pelabuhan berhasil ditambahkan!');
    }
}
