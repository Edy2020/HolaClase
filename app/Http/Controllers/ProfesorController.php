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
            'especialidad' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'documento_identidad' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('documento_identidad')) {
            $path = $request->file('documento_identidad')->store('documentos_identidad', 'public');
            $data['documento_identidad'] = $path;
        }

        Profesor::create($data);

        return redirect()->route('teachers.index')->with('success', 'Profesor creado exitosamente.');
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
            'especialidad' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'documento_identidad' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('documento_identidad')) {
            $path = $request->file('documento_identidad')->store('documentos_identidad', 'public');
            $data['documento_identidad'] = $path;
        }

        $profesor->update($data);

        return redirect()->route('teachers.index')->with('success', 'Profesor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->delete();

        return redirect()->route('teachers.index')->with('success', 'Profesor eliminado exitosamente.');
    }
}
