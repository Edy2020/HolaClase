<?php

namespace App\Http\Requests;

use App\Models\Curso;
use Illuminate\Foundation\Http\FormRequest;

class StoreNotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        // Solo usuarios autenticados pueden registrar notas
        if (!$user) {
            return false;
        }

        // Los administradores siempre tienen acceso
        if ($user->isAdmin()) {
            return true;
        }

        // Los profesores solo pueden registrar notas en sus propios cursos
        if ($user->profesor_id) {
            $cursoId = $this->input('curso_id');
            return Curso::where('id', $cursoId)
                ->where('profesor_id', $user->profesor_id)
                ->exists();
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'curso_id' => 'required|exists:cursos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'tipo_evaluacion' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'ponderacion' => 'required|numeric|min:1|max:100',
            'notas' => 'required|array',
            'notas.*.estudiante_id' => 'required|exists:estudiantes,id',
            'notas.*.nota' => 'required|numeric|min:1.0|max:7.0',
            'notas.*.observaciones' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'curso_id.required' => 'El curso es obligatorio.',
            'curso_id.exists' => 'El curso seleccionado no existe.',
            'asignatura_id.required' => 'La asignatura es obligatoria.',
            'asignatura_id.exists' => 'La asignatura seleccionada no existe.',
            'tipo_evaluacion.required' => 'El tipo de evaluación es obligatorio.',
            'periodo.required' => 'El período es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior a hoy.',
            'ponderacion.required' => 'La ponderación es obligatoria.',
            'ponderacion.min' => 'La ponderación debe ser al menos 1.',
            'ponderacion.max' => 'La ponderación no puede superar 100.',
            'notas.required' => 'Debe ingresar al menos una nota.',
            'notas.*.nota.required' => 'La nota del estudiante es obligatoria.',
            'notas.*.nota.min' => 'La nota mínima es 1.0.',
            'notas.*.nota.max' => 'La nota máxima es 7.0.',
            'notas.*.observaciones.max' => 'Las observaciones no pueden superar los 500 caracteres.',
        ];
    }
}
