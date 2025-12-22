<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find and remove duplicate cursos, keeping only the first one
        $duplicates = DB::table('cursos')
            ->select('nivel', 'grado', 'letra', DB::raw('MIN(id) as keep_id'))
            ->groupBy('nivel', 'grado', 'letra')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            // Delete all records except the one we want to keep
            DB::table('cursos')
                ->where('nivel', $duplicate->nivel)
                ->where('grado', $duplicate->grado)
                ->where('letra', $duplicate->letra)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this operation
    }
};
