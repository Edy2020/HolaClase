<?php

namespace App\Http\Controllers;

use App\Models\Recordatorio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecordatorioController extends Controller
{
    public function index(Request $request)
    {
        $startStr = $request->input('start');
        $endStr = $request->input('end');

        if ($startStr && $endStr) {
            $start = Carbon::parse($startStr)->startOfDay();
            $end = Carbon::parse($endStr)->endOfDay();
        } else {
            $month = $request->input('month', now()->month);
            $year = $request->input('year', now()->year);
            $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
        }

        $recordatorios = Recordatorio::where('user_id', auth()->id())
            ->whereBetween('fecha', [$start->toDateString(), $end->toDateString()])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get()
            ->groupBy(function ($r) {
                return $r->fecha->format('Y-m-d');
            });

        return response()->json($recordatorios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i',
            'importancia' => 'nullable|in:normal,importante,urgente',
        ]);

        $recordatorio = Recordatorio::create([
            'user_id' => auth()->id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'importancia' => $request->importancia ?? 'normal',
            'completado' => false,
        ]);

        return response()->json($recordatorio, 201);
    }

    public function toggle(Recordatorio $recordatorio)
    {
        if ($recordatorio->user_id !== auth()->id()) {
            abort(403);
        }

        $recordatorio->update([
            'completado' => !$recordatorio->completado,
        ]);

        return response()->json($recordatorio);
    }

    public function destroy(Recordatorio $recordatorio)
    {
        if ($recordatorio->user_id !== auth()->id()) {
            abort(403);
        }

        $recordatorio->delete();

        return response()->json(['success' => true]);
    }
}
