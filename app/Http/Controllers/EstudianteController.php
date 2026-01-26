<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Apoderado;
use App\Models\Curso;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index()
    {
        $estudiantes = Estudiante::with(['cursos', 'apoderado', 'notas'])
            ->paginate(10);

        return view('estudiantes.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $cursos = Curso::all();
        return view('estudiantes.create', compact('cursos'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Student information
            'rut' => 'required|string|unique:estudiantes|max:12',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'genero' => 'nullable|string|in:Masculino,Femenino,Otro',
            'nacionalidad' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'email' => 'nullable|email|max:255|unique:estudiantes',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',

            // Guardian information
            'apoderado_rut' => 'required|string|max:12',
            'apoderado_nombre' => 'required|string|max:255',
            'apoderado_apellido' => 'required|string|max:255',
            'apoderado_relacion' => 'required|string|max:255',
            'apoderado_telefono' => 'nullable|string|max:20',
            'apoderado_email' => 'nullable|email|max:255',
            'apoderado_direccion' => 'nullable|string',
            'apoderado_telefono_emergencia' => 'nullable|string|max:20',
            'apoderado_ocupacion' => 'nullable|string|max:255',
            'apoderado_lugar_trabajo' => 'nullable|string|max:255',

            // Documents
            'documentos' => 'nullable|array',
            'documentos.*.tipo' => 'required|string',
            'documentos.*.archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Course enrollment
            'curso_id' => 'nullable|exists:cursos,id',
        ]);

        // Validate RUT
        if (!$this->validarRut($validated['rut'])) {
            return back()->withErrors(['rut' => 'El RUT ingresado no es válido.'])->withInput();
        }

        if (!$this->validarRut($validated['apoderado_rut'])) {
            return back()->withErrors(['apoderado_rut' => 'El RUT del apoderado no es válido.'])->withInput();
        }

        // Create or find apoderado
        $apoderado = Apoderado::firstOrCreate(
            ['rut' => $validated['apoderado_rut']],
            [
                'nombre' => $validated['apoderado_nombre'],
                'apellido' => $validated['apoderado_apellido'],
                'relacion' => $validated['apoderado_relacion'],
                'telefono' => $validated['apoderado_telefono'] ?? null,
                'email' => $validated['apoderado_email'] ?? null,
                'direccion' => $validated['apoderado_direccion'] ?? null,
                'telefono_emergencia' => $validated['apoderado_telefono_emergencia'] ?? null,
                'ocupacion' => $validated['apoderado_ocupacion'] ?? null,
                'lugar_trabajo' => $validated['apoderado_lugar_trabajo'] ?? null,
            ]
        );

        // Create student
        $estudiante = Estudiante::create([
            'rut' => $validated['rut'],
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'genero' => $validated['genero'] ?? null,
            'nacionalidad' => $validated['nacionalidad'] ?? 'Chilena',
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'email' => $validated['email'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'ciudad' => $validated['ciudad'] ?? null,
            'region' => $validated['region'] ?? null,
            'estado' => 'activo',
            'apoderado_id' => $apoderado->id,
        ]);

        // Handle document uploads
        if ($request->has('documentos')) {
            foreach ($request->documentos as $documento) {
                if (isset($documento['archivo'])) {
                    $path = $documento['archivo']->store('documentos_estudiantes', 'public');
                    $estudiante->documentos()->create([
                        'tipo' => $documento['tipo'],
                        'ruta_archivo' => $path,
                        'nombre_original' => $documento['archivo']->getClientOriginalName(),
                        'fecha_subida' => now(),
                    ]);
                }
            }
        }

        // Enroll in course if selected
        if ($request->filled('curso_id')) {
            $estudiante->cursos()->attach($request->curso_id, [
                'fecha_inscripcion' => now(),
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Estudiante creado exitosamente.');
    }

    /**
     * Display the specified student.
     */
    public function show($id)
    {
        $estudiante = Estudiante::with([
            'apoderado',
            'cursos.profesor',
            'cursos.asignaturas',
            'documentos',
            'notas.asignatura',
        ])->findOrFail($id);

        // Get unique asignaturas from all courses
        $asignaturas = $estudiante->cursos->flatMap->asignaturas->unique('id');

        // Calculate average per subject
        $promediosPorAsignatura = [];
        foreach ($asignaturas as $asignatura) {
            $promediosPorAsignatura[$asignatura->id] = [
                'asignatura' => $asignatura,
                'promedio' => $estudiante->getPromedioAsignatura($asignatura->id),
            ];
        }

        return view('estudiantes.show', compact('estudiante', 'promediosPorAsignatura'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit($id)
    {
        $estudiante = Estudiante::with(['apoderado', 'documentos', 'cursos'])->findOrFail($id);
        $cursos = Curso::all();

        return view('estudiantes.edit', compact('estudiante', 'cursos'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $validated = $request->validate([
            // Student information
            'rut' => 'required|string|max:12|unique:estudiantes,rut,' . $estudiante->id,
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'genero' => 'nullable|string|in:Masculino,Femenino,Otro',
            'nacionalidad' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'email' => 'nullable|email|max:255|unique:estudiantes,email,' . $estudiante->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo,retirado',

            // Guardian information
            'apoderado_rut' => 'required|string|max:12',
            'apoderado_nombre' => 'required|string|max:255',
            'apoderado_apellido' => 'required|string|max:255',
            'apoderado_relacion' => 'required|string|max:255',
            'apoderado_telefono' => 'nullable|string|max:20',
            'apoderado_email' => 'nullable|email|max:255',
            'apoderado_direccion' => 'nullable|string',
            'apoderado_telefono_emergencia' => 'nullable|string|max:20',
            'apoderado_ocupacion' => 'nullable|string|max:255',
            'apoderado_lugar_trabajo' => 'nullable|string|max:255',

            // New documents
            'nuevos_documentos' => 'nullable|array',
            'nuevos_documentos.*.tipo' => 'required|string',
            'nuevos_documentos.*.archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Validate RUT
        if (!$this->validarRut($validated['rut'])) {
            return back()->withErrors(['rut' => 'El RUT ingresado no es válido.'])->withInput();
        }

        // Update or create apoderado
        if ($estudiante->apoderado && $estudiante->apoderado->rut === $validated['apoderado_rut']) {
            $estudiante->apoderado->update([
                'nombre' => $validated['apoderado_nombre'],
                'apellido' => $validated['apoderado_apellido'],
                'relacion' => $validated['apoderado_relacion'],
                'telefono' => $validated['apoderado_telefono'] ?? null,
                'email' => $validated['apoderado_email'] ?? null,
                'direccion' => $validated['apoderado_direccion'] ?? null,
                'telefono_emergencia' => $validated['apoderado_telefono_emergencia'] ?? null,
                'ocupacion' => $validated['apoderado_ocupacion'] ?? null,
                'lugar_trabajo' => $validated['apoderado_lugar_trabajo'] ?? null,
            ]);
        } else {
            $apoderado = Apoderado::firstOrCreate(
                ['rut' => $validated['apoderado_rut']],
                [
                    'nombre' => $validated['apoderado_nombre'],
                    'apellido' => $validated['apoderado_apellido'],
                    'relacion' => $validated['apoderado_relacion'],
                    'telefono' => $validated['apoderado_telefono'] ?? null,
                    'email' => $validated['apoderado_email'] ?? null,
                    'direccion' => $validated['apoderado_direccion'] ?? null,
                    'telefono_emergencia' => $validated['apoderado_telefono_emergencia'] ?? null,
                    'ocupacion' => $validated['apoderado_ocupacion'] ?? null,
                    'lugar_trabajo' => $validated['apoderado_lugar_trabajo'] ?? null,
                ]
            );
            $estudiante->apoderado_id = $apoderado->id;
        }

        // Update student
        $estudiante->update([
            'rut' => $validated['rut'],
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'genero' => $validated['genero'] ?? null,
            'nacionalidad' => $validated['nacionalidad'] ?? 'Chilena',
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'email' => $validated['email'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'ciudad' => $validated['ciudad'] ?? null,
            'region' => $validated['region'] ?? null,
            'estado' => $validated['estado'],
        ]);

        // Handle new document uploads
        if ($request->has('nuevos_documentos')) {
            foreach ($request->nuevos_documentos as $documento) {
                if (isset($documento['archivo'])) {
                    $path = $documento['archivo']->store('documentos_estudiantes', 'public');
                    $estudiante->documentos()->create([
                        'tipo' => $documento['tipo'],
                        'ruta_archivo' => $path,
                        'nombre_original' => $documento['archivo']->getClientOriginalName(),
                        'fecha_subida' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('students.show', $estudiante->id)->with('success', 'Estudiante actualizado exitosamente.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();

        return redirect()->route('students.index')->with('success', 'Estudiante eliminado exitosamente.');
    }

    /**
     * Update student status only (for quick status changes).
     */
    public function updateStatus(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $validated = $request->validate([
            'estado' => 'required|in:activo,inactivo,retirado',
        ]);

        $estudiante->update([
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado exitosamente',
            'estado' => $estudiante->estado,
        ]);
    }

    /**
     * Validate Chilean RUT.
     */
    private function validarRut($rut)
    {
        // Remove dots and hyphens
        $rut = preg_replace('/[^0-9kK]/', '', $rut);

        if (strlen($rut) < 2) {
            return false;
        }

        // Separate number and verification digit
        $rutNum = substr($rut, 0, -1);
        $dv = strtoupper(substr($rut, -1));

        // Calculate verification digit
        $suma = 0;
        $multiplo = 2;

        for ($i = strlen($rutNum) - 1; $i >= 0; $i--) {
            $suma += $rutNum[$i] * $multiplo;
            $multiplo = $multiplo < 7 ? $multiplo + 1 : 2;
        }

        $dvCalculado = 11 - ($suma % 11);

        if ($dvCalculado == 11) {
            $dvCalculado = '0';
        } elseif ($dvCalculado == 10) {
            $dvCalculado = 'K';
        } else {
            $dvCalculado = (string) $dvCalculado;
        }

        return $dv === $dvCalculado;
    }
}
