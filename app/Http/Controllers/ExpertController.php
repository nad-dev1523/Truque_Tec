<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index()
    {
        // Buscamos solo a los usuarios que son expertos (id_rol = 2)
        $expertos = User::where('id_rol', 2)->get();
        
        return view('expertos.index', compact('expertos'));
    }
}