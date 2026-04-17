<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('configuracion.index');
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:blue,green,purple,red,orange,indigo'
        ]);

        session(['theme' => $request->theme]);

        return response()->json([
            'success' => true,
            'message' => 'Tema actualizado correctamente'
        ]);
    }
}
