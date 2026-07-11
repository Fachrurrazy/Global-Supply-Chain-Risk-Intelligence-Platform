<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Port;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $cargoCount = Cargo::count();
        $portsCount = Port::count();
        // We will fetch other stats later (articles)
        
        return view('admin.dashboard', compact('usersCount', 'cargoCount', 'portsCount'));
    }
}
