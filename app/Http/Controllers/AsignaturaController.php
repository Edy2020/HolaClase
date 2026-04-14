<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    public function index()
    {
        $asignaturas = Asignatura::orderBy('nombre')->get();
        return view('asignaturas.index', compact('asignaturas'));
    }

    public function create()
    {
        return view('asignaturas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:asignaturas,codigo',
            'descripcion' => 'nullable|string',
        ]);

        Asignatura::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Asignatura creada correctamente.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        
        if (($handle = fopen($file->path(), 'r')) !== false) {
            $count = 0;
            $rowNumber = 0;

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                
                if ($rowNumber === 1 && (stripos($data[0], 'nombre') !== false)) {
                    continue;
                }
                if (count($data) < 2) continue;

                $nombre = trim($data[0]);
                $codigo = trim($data[1]);
                $descripcion = isset($data[2]) ? trim($data[2]) : null;

                if (empty($nombre) || empty($codigo)) continue;

                $exists = Asignatura::where('codigo', $codigo)->exists();

                if (!$exists) {
                    Asignatura::create([
                        'nombre' => $nombre,
                        'codigo' => $codigo,
                        'descripcion' => $descripcion,
                    ]);
                    $count++;
                }
            }
            fclose($handle);

            return redirect()->route('subjects.index')->with('success', "Se han importado $count asignaturas exitosamente.");
        }

        return back()->withErrors(['csv_file' => 'Error al leer el archivo CSV.']);
    }

    public function show(Asignatura $asignatura)
    {
        $asignatura->load(['cursos.estudiantes', 'notas']);

        return view('asignaturas.show', compact('asignatura'));
    }

    public function edit(Asignatura $asignatura)
    {
        return view('asignaturas.edit', compact('asignatura'));
    }

    public function update(Request $request, Asignatura $asignatura)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:asignaturas,codigo,' . $asignatura->id,
            'descripcion' => 'nullable|string',
        ]);

        $asignatura->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Asignatura actualizada correctamente.');
    }

    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return redirect()->route('subjects.index')->with('success', 'Asignatura eliminada correctamente.');
    }
}
