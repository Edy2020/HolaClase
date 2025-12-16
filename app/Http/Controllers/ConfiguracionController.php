<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('configuracion.index');
    }

    /**
     * Update theme settings.
     */
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:blue,green,purple,red,orange,indigo'
        ]);

        // Store theme preference in session or database
        session(['theme' => $request->theme]);

        return response()->json([
            'success' => true,
            'message' => 'Tema actualizado correctamente'
        ]);
    }
}
