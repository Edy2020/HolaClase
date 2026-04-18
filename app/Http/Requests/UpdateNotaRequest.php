<?php

namespace App\Http\Requests;

use App\Models\Curso;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        // Solo usuarios autenticados pueden editar notas
        if (!$user) {
            return false;
        }

        // Los administradores siempre tienen acceso
        if ($user->isAdmin()) {
            return true;
        }

        // Los profesores solo pueden editar notas de sus propios cursos
        if ($user->profesor_id) {
            $nota = $this->route('nota');
            return Curso::where('id', $nota->curso_id)
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
            'nota' => 'required|numeric|min:1.0|max:7.0',
            'tipo_evaluacion' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'ponderacion' => 'required|numeric|min:0.01|max:1',
            'observaciones' => 'nullable|string|max:500',
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
            'nota.required' => 'La nota es obligatoria.',
            'nota.min' => 'La nota mínima es 1.0.',
            'nota.max' => 'La nota máxima es 7.0.',
            'tipo_evaluacion.required' => 'El tipo de evaluación es obligatorio.',
            'periodo.required' => 'El período es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior a hoy.',
            'ponderacion.required' => 'La ponderación es obligatoria.',
            'ponderacion.min' => 'La ponderación debe ser al menos 0.01.',
            'ponderacion.max' => 'La ponderación no puede superar 1.',
            'observaciones.max' => 'Las observaciones no pueden superar los 500 caracteres.',
        ];
    }
}
