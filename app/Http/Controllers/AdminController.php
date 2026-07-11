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
        $articlesCount = \App\Models\Article::count();
        
        return view('admin.dashboard', compact('usersCount', 'cargoCount', 'portsCount', 'articlesCount'));
    }
}
