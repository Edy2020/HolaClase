<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesores = Profesor::paginate(10);
        return view('profesores.index', compact('profesores'));
    }

    public function create()
    {
        return view('profesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|string|unique:profesores|max:20',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'email' => 'required|string|email|max:255|unique:profesores',
            'telefono' => 'nullable|string|max:20',
            'nivel_ensenanza' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'documento_archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_tipo' => 'nullable|string|required_with:documento_archivo',
        ]);

        $profesor = Profesor::create($request->only([
            'rut',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            'email',
            'telefono',
            'nivel_ensenanza',
            'titulo'
        ]));

        if ($request->hasFile('documento_archivo')) {
            $path = $request->file('documento_archivo')->store('documentos_profesores', 'public');
            $profesor->documentos()->create([
                'tipo' => $request->documento_tipo,
                'ruta_archivo' => $path,
            ]);
        }

        return redirect()->route('teachers.index')->with('success', 'Profesor creado exitosamente.');
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
                
                if ($rowNumber === 1 && (stripos($data[0], 'rut') !== false || stripos($data[0], 'nombre') !== false)) {
                    continue;
                }

                if (count($data) < 4) continue;

                $rut = trim($data[0]);
                $nombre = trim($data[1]);
                $apellido = trim($data[2]);
                $email = trim($data[3]);

                if (empty($rut) || empty($nombre) || empty($apellido) || empty($email)) continue;

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                $exists = Profesor::where('rut', $rut)->orWhere('email', $email)->exists();

                if (!$exists) {
                    Profesor::create([
                        'rut' => $rut,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'email' => $email,
                    ]);
                    $count++;
                }
            }
            fclose($handle);

            return redirect()->route('teachers.index')->with('success', "Se han importado $count profesores exitosamente.");
        }

        return back()->withErrors(['csv_file' => 'Error al leer el archivo CSV.']);
    }

    public function show($id)
    {
        $profesor = Profesor::with(['cursos.asignaturas', 'documentos'])->findOrFail($id);

        return view('profesores.show', compact('profesor'));
    }

    public function edit($id)
    {
        $profesor = Profesor::findOrFail($id);
        return view('profesores.edit', compact('profesor'));
    }

    public function update(Request $request, $id)
    {
        $profesor = Profesor::findOrFail($id);

        $request->validate([
            'rut' => 'required|string|max:20|unique:profesores,rut,' . $profesor->id,
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'email' => 'required|string|email|max:255|unique:profesores,email,' . $profesor->id,
            'telefono' => 'nullable|string|max:20',
            'nivel_ensenanza' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'documento_archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_tipo' => 'nullable|string|required_with:documento_archivo',
        ]);

        $profesor->update($request->only([
            'rut',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            'email',
            'telefono',
            'nivel_ensenanza',
            'titulo'
        ]));

        if ($request->hasFile('documento_archivo')) {
            $path = $request->file('documento_archivo')->store('documentos_profesores', 'public');
            $profesor->documentos()->create([
                'tipo' => $request->documento_tipo,
                'ruta_archivo' => $path,
            ]);
        }

        return redirect()->route('teachers.index')->with('success', 'Profesor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->delete();

        return redirect()->route('teachers.index')->with('success', 'Profesor eliminado exitosamente.');
    }
}
