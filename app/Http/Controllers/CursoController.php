<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::orderBy('nivel')->orderBy('grado')->orderBy('letra')->paginate(12);
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel' => 'required|string',
            'grado' => 'nullable|string',
            'letra' => 'required|string|max:5',
        ]);

        // Check for duplicate curso
        $exists = Curso::where('nivel', $request->nivel)
            ->where('grado', $request->grado)
            ->where('letra', $request->letra)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'letra' => 'Ya existe un curso con esta combinación de nivel, grado y letra.'
            ])->withInput();
        }

        $nivel = $request->nivel;
        $grado = $request->grado;
        $letra = $request->letra;

        // Nombres completos de grados
        $nombresGrados = [
            '1°' => 'Primero',
            '2°' => 'Segundo',
            '3°' => 'Tercero',
            '4°' => 'Cuarto',
            '5°' => 'Quinto',
            '6°' => 'Sexto',
            '7°' => 'Séptimo',
            '8°' => 'Octavo',
        ];

        $nombre = '';

        // Generate Name Logic
        if ($nivel === 'Pre-Kinder' || $nivel === 'Kinder') {
            $nombre = "{$nivel} {$letra}";
            $grado = null; // Ensure grade is null for these levels
        } elseif ($nivel === 'Basica') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Básico {$letra}";
        } elseif ($nivel === 'Media') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Medio {$letra}";
        }

        Curso::create([
            'nivel' => $nivel,
            'grado' => $grado,
            'letra' => $letra,
            'nombre' => $nombre,
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nivel' => 'required|string',
            'grado' => 'nullable|string',
            'letra' => 'required|string|max:5',
        ]);

        // Check for duplicate curso (excluding current record)
        $exists = Curso::where('nivel', $request->nivel)
            ->where('grado', $request->grado)
            ->where('letra', $request->letra)
            ->where('id', '!=', $curso->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'letra' => 'Ya existe un curso con esta combinación de nivel, grado y letra.'
            ])->withInput();
        }

        $nivel = $request->nivel;
        $grado = $request->grado;
        $letra = $request->letra;

        // Nombres completos de grados
        $nombresGrados = [
            '1°' => 'Primero',
            '2°' => 'Segundo',
            '3°' => 'Tercero',
            '4°' => 'Cuarto',
            '5°' => 'Quinto',
            '6°' => 'Sexto',
            '7°' => 'Séptimo',
            '8°' => 'Octavo',
        ];

        $nombre = '';

        // Generate Name Logic
        if ($nivel === 'Pre-Kinder' || $nivel === 'Kinder') {
            $nombre = "{$nivel} {$letra}";
            $grado = null; // Ensure grade is null for these levels
        } elseif ($nivel === 'Basica') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Básico {$letra}";
        } elseif ($nivel === 'Media') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Medio {$letra}";
        }

        $curso->update([
            'nivel' => $nivel,
            'grado' => $grado,
            'letra' => $letra,
            'nombre' => $nombre,
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado correctamente.');
    }
}
