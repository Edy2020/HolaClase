<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\Apoderado;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Asignatura;
use App\Models\Nota;
use App\Models\Prueba;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompletarCursosSeeder extends Seeder
{
    // ─── Pools de nombres ────────────────────────────────────────────────────
    private array $nombresM = [
        'Matías','Benjamín','Joaquín','Agustín','Vicente','Tomás','Diego','Lucas',
        'Sebastián','Nicolás','Gabriel','Maximiliano','Cristóbal','Ignacio','Felipe',
        'Rodrigo','Andrés','Gonzalo','Claudio','Mauricio','Fernando','Patricio',
        'Héctor','Jaime','Pablo','Daniel','Alejandro','Francisco','Marcelo','Camilo',
        'Esteban','Sergio','Alberto','Emilio','Raúl','Eduardo','Iván','Fabián',
        'Álvaro','César','Hugo','Óscar','Ernesto','Rafael','Cristián','Richard',
    ];

    private array $nombresF = [
        'Sofía','Valentina','Martina','Isidora','Emilia','Amanda','Catalina',
        'Florencia','Antonia','Javiera','Constanza','Maite','Renata','Josefa',
        'Trinidad','Daniela','Andrea','Carolina','Paulina','Marcela','Lorena',
        'Alejandra','Francisca','Cecilia','Soledad','Patricia','Verónica','Mónica',
        'Claudia','Isabel','Carmen','Ana','María','Gabriela','Pilar','Rosa',
        'Rocío','Ximena','Camila','Natalia','Fernanda','Viviana','Sandra','Yasna',
        'Karla','Pamela','Bárbara','Valeria','Nicole','Paola',
    ];

    private array $apellidos = [
        'González','Pérez','Silva','Rodríguez','Martínez','López','Fernández',
        'Muñoz','Sánchez','Torres','Ramírez','Flores','Vargas','Herrera','Morales',
        'Castillo','Reyes','Contreras','Rojas','Vega','Pizarro','Mendoza','Ortiz',
        'Salazar','Ibáñez','Araya','Cáceres','Vera','Tapia','Molina','Gómez',
        'Díaz','Castro','Pinto','Navarro','Bravo','Cortés','Medina','Guzmán',
        'Aguilar','Espinoza','Valenzuela','Campos','Núñez','Carrasco','Fuentes',
        'Alarcón','Sepúlveda','Bustos','Parra','Riquelme','Palma','Álvarez',
        'Garrido','Miranda','Peña','Vidal','Araneda','Becerra','Figueroa',
        'Acuña','Donoso','Neira','Orellana','Quijada','Ugarte','Zamora','Leiva',
    ];

    private array $ciudades = [
        'Santiago','Valparaíso','Concepción','La Serena','Antofagasta',
        'Temuco','Rancagua','Talca','Arica','Puerto Montt',
    ];

    private array $regiones = [
        'Metropolitana','Valparaíso','Biobío','Coquimbo','Antofagasta',
        'La Araucanía',"O'Higgins",'Maule','Arica y Parinacota','Los Lagos',
    ];

    private array $relaciones  = ['Padre','Madre','Abuelo','Abuela','Tío','Tía'];
    private array $ocupaciones = ['Ingeniero','Profesor','Médico','Comerciante','Contador','Abogado','Enfermera','Técnico'];

    private int $rutBase      = 10_000_000;
    private int $rutBaseApod  = 29_000_000;

    // ─── Asignaturas por nivel ───────────────────────────────────────────────
    private array $asignaturasBasicaCiclo1 = [
        'Lenguaje y Comunicación','Matemáticas','Ciencias Naturales',
        'Historia y Geografía','Inglés','Educación Física','Artes Visuales','Música',
    ];
    private array $asignaturasBasicaCiclo2 = [
        'Lenguaje y Comunicación','Matemáticas','Ciencias Naturales','Historia y Geografía',
        'Inglés','Educación Física','Artes Visuales','Tecnología','Orientación',
    ];
    private array $asignaturasMedia = [
        'Lenguaje y Comunicación','Matemáticas','Física','Química','Biología',
        'Historia y Geografía','Inglés','Educación Física','Filosofía','Educación Ciudadana',
    ];

    private array $tiposEvaluacion = ['Prueba','Trabajo','Examen','Taller','Proyecto','Participación','Control'];
    private array $periodos        = ['Semestre 1','Semestre 2'];
    private array $nombresPruebas  = [
        'Prueba de Diagnóstico','Control de Lectura','Evaluación Sumativa',
        'Prueba Coeficiente 2','Prueba Coeficiente 1','Control de Matemáticas',
        'Evaluación de Ciencias','Prueba de Historia','Test de Inglés',
        'Evaluación Formativa','Prueba Parcial','Examen de Semestre',
    ];

    public function run(): void
    {
        $this->command->info('🔧 PASO 1: Eliminando cursos duplicados (nivel con mayúscula)...');
        $this->eliminarDuplicados();

        $this->command->info('📚 PASO 2: Creando cursos faltantes (4°-8° básico y 3°-4° medio) A-D...');
        $cursosNuevos = $this->crearCursosFaltantes();

        $this->command->info('👨‍🏫 PASO 3: Asignando profesores a TODOS los cursos sin profesor...');
        $this->asignarProfesores();

        $this->command->info('📖 PASO 4: Asignando asignaturas a TODOS los cursos sin asignaturas...');
        $this->asignarAsignaturas();

        $this->command->info('👥 PASO 5: Creando y asignando 15 estudiantes a los cursos nuevos...');
        $this->crearEstudiantesParaCursos($cursosNuevos);

        $this->command->info('📝 PASO 6: Generando notas para todos los cursos...');
        $this->generarNotas();

        $this->command->info('📅 PASO 7: Generando pruebas futuras...');
        $this->generarPruebas();

        $this->resumen();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PASO 1: Eliminar cursos con nivel en mayúscula (duplicados)
    // ─────────────────────────────────────────────────────────────────────────
    private function eliminarDuplicados(): void
    {
        // Los cursos con nivel en mayúscula (Basica/Media) son los malos
        $duplicados = DB::table('cursos')
            ->whereIn('nivel', ['Basica','Media'])
            ->pluck('id');

        if ($duplicados->isEmpty()) {
            $this->command->line('  → No hay duplicados que eliminar.');
            return;
        }

        // Eliminar relaciones primero
        DB::table('curso_estudiante')->whereIn('curso_id', $duplicados)->delete();
        DB::table('curso_asignatura')->whereIn('curso_id', $duplicados)->delete();
        DB::table('notas')->whereIn('curso_id', $duplicados)->delete();
        DB::table('pruebas')->whereIn('curso_id', $duplicados)->delete();
        DB::table('eventos_academicos')->whereIn('curso_id', $duplicados)->delete();
        DB::table('asistencias')->whereIn('curso_id', $duplicados)->delete();
        DB::table('cursos')->whereIn('id', $duplicados)->delete();

        $this->command->line("  → {$duplicados->count()} cursos duplicados eliminados.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PASO 2: Crear cursos faltantes
    // ─────────────────────────────────────────────────────────────────────────
    private function crearCursosFaltantes(): array
    {
        $gradosBasica = ['1°','2°','3°','4°','5°','6°','7°','8°'];
        $gradosMedia  = ['1°','2°','3°','4°'];
        $letras       = ['A','B','C','D'];

        $cursosNuevos = [];
        $profesores   = Profesor::pluck('id')->toArray();
        $profIdx      = 0;

        // Básica
        foreach ($gradosBasica as $grado) {
            foreach ($letras as $letra) {
                $existe = Curso::where('nivel','basica')
                               ->where('grado',$grado)
                               ->where('letra',$letra)
                               ->first();
                if (!$existe) {
                    $curso = Curso::create([
                        'nivel'       => 'basica',
                        'grado'       => $grado,
                        'letra'       => $letra,
                        'nombre'      => "{$grado} Básico {$letra}",
                        'profesor_id' => $profesores[$profIdx % count($profesores)],
                    ]);
                    $cursosNuevos[] = $curso;
                    $this->command->line("  + Creado: {$curso->nombre}");
                    $profIdx++;
                }
            }
        }

        // Media
        foreach ($gradosMedia as $grado) {
            foreach ($letras as $letra) {
                $existe = Curso::where('nivel','media')
                               ->where('grado',$grado)
                               ->where('letra',$letra)
                               ->first();
                if (!$existe) {
                    $curso = Curso::create([
                        'nivel'       => 'media',
                        'grado'       => $grado,
                        'letra'       => $letra,
                        'nombre'      => "{$grado} Medio {$letra}",
                        'profesor_id' => $profesores[$profIdx % count($profesores)],
                    ]);
                    $cursosNuevos[] = $curso;
                    $this->command->line("  + Creado: {$curso->nombre}");
                    $profIdx++;
                }
            }
        }

        $count = count($cursosNuevos);
        $this->command->line("  → {$count} cursos nuevos creados.");
        return $cursosNuevos;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PASO 3: Asignar profesor a cursos que no tienen
    // ─────────────────────────────────────────────────────────────────────────
    private function asignarProfesores(): void
    {
        $profesores = Profesor::pluck('id')->toArray();
        if (empty($profesores)) {
            $this->command->warn('  ⚠ No hay profesores en la BD.');
            return;
        }

        $sinProfesor = Curso::whereNull('profesor_id')->orWhere('profesor_id', '')->get();
        $idx = 0;
        foreach ($sinProfesor as $curso) {
            $curso->update(['profesor_id' => $profesores[$idx % count($profesores)]]);
            $idx++;
        }
        $this->command->line("  → {$idx} cursos actualizados con profesor.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PASO 4: Asignar asignaturas a cursos sin ellas
    // ─────────────────────────────────────────────────────────────────────────
    private function asignarAsignaturas(): void
    {
        $profesores   = Profesor::pluck('id')->toArray();
        $asignaturas  = Asignatura::all()->keyBy('nombre');

        // Asegurar que existen todas las asignaturas necesarias
        $todasAsig = array_merge(
            $this->asignaturasBasicaCiclo1,
            $this->asignaturasBasicaCiclo2,
            $this->asignaturasMedia
        );
        $codigosMap = [
            'Lenguaje y Comunicación' => 'LEN-001', 'Matemáticas' => 'MAT-001',
            'Ciencias Naturales' => 'CNA-001',       'Historia y Geografía' => 'HIS-001',
            'Inglés' => 'ING-001',                   'Educación Física' => 'EFI-001',
            'Artes Visuales' => 'ART-001',           'Música' => 'MUS-001',
            'Tecnología' => 'TEC-001',               'Orientación' => 'ORI-001',
            'Física' => 'FIS-001',                   'Química' => 'QUI-001',
            'Biología' => 'BIO-001',                 'Filosofía' => 'FIL-001',
            'Educación Ciudadana' => 'CIU-001',
        ];

        foreach (array_unique($todasAsig) as $nombreAsig) {
            if (!$asignaturas->has($nombreAsig)) {
                $codigo = $codigosMap[$nombreAsig] ?? strtoupper(substr($nombreAsig, 0, 3)) . '-001';
                $nueva = Asignatura::create([
                    'nombre'      => $nombreAsig,
                    'codigo'      => $codigo,
                    'descripcion' => "Asignatura de {$nombreAsig}",
                ]);
                $asignaturas->put($nombreAsig, $nueva);
            }
        }

        // Asignar a cursos que no tienen asignaturas
        $actualizados = 0;
        $cursos = Curso::whereIn('nivel', ['basica','media'])->get();

        foreach ($cursos as $curso) {
            // Si ya tiene asignaturas, saltar
            if (DB::table('curso_asignatura')->where('curso_id', $curso->id)->count() > 0) {
                continue;
            }

            $gradoNum = (int) $curso->grado;
            $pool = match(true) {
                $curso->nivel === 'media'          => $this->asignaturasMedia,
                $curso->nivel === 'basica' && $gradoNum >= 5 => $this->asignaturasBasicaCiclo2,
                default                            => $this->asignaturasBasicaCiclo1,
            };

            foreach ($pool as $nombreAsig) {
                $asig = $asignaturas->get($nombreAsig);
                if (!$asig) continue;
                DB::table('curso_asignatura')->insertOrIgnore([
                    'curso_id'      => $curso->id,
                    'asignatura_id' => $asig->id,
                    'profesor_id'   => $profesores[array_rand($profesores)],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
            $actualizados++;
        }
        $this->command->line("  → {$actualizados} cursos con asignaturas nuevas asignadas.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PASO 5: Crear y asignar estudiantes a cursos nuevos
    // ─────────────────────────────────────────────────────────────────────────
    private function crearEstudiantesParaCursos(array $cursosNuevos): void
    {
        if (empty($cursosNuevos)) {
            $this->command->line('  → No hay cursos nuevos, saltando creación de estudiantes.');
            return;
        }

        // RUT base: justo sobre el máximo existente
        $maxRut = DB::table('estudiantes')
            ->selectRaw("MAX(CAST(REPLACE(REPLACE(rut, '.', ''), SUBSTR(rut, -2), '') AS INTEGER)) as max_rut")
            ->value('max_rut');
        $this->rutBase = max(10_500_000, (int)($maxRut ?? 0) + 100);

        // Apoderados disponibles
        $maxRutApod = DB::table('apoderados')
            ->selectRaw("MAX(CAST(REPLACE(REPLACE(rut, '.', ''), SUBSTR(rut, -2), '') AS INTEGER)) as max_rut")
            ->value('max_rut');
        $this->rutBaseApod = max(29_000_000, (int)($maxRutApod ?? 0) + 100);

        // Crear apoderados adicionales si hacen falta
        $apoderadosCount = Apoderado::count();
        if ($apoderadosCount < 50) {
            $this->command->line('  → Creando apoderados adicionales...');
            for ($i = 0; $i < 50; $i++) {
                $esMujer = rand(0, 1);
                $nombre  = $esMujer ? $this->nombresF[array_rand($this->nombresF)]
                                    : $this->nombresM[array_rand($this->nombresM)];
                $apell   = $this->apellidos[array_rand($this->apellidos)];
                Apoderado::create([
                    'rut'                 => $this->generateRut($this->rutBaseApod++),
                    'nombre'              => $nombre,
                    'apellido'            => $apell,
                    'relacion'            => $this->relaciones[array_rand($this->relaciones)],
                    'telefono'            => '+569 ' . rand(5000,9999) . ' ' . rand(1000,9999),
                    'email'               => strtolower($nombre . '.' . $apell . rand(1,999) . '@gmail.com'),
                    'direccion'           => 'Av. Las Condes ' . rand(100,9999),
                    'telefono_emergencia' => '+569 ' . rand(5000,9999) . ' ' . rand(1000,9999),
                    'ocupacion'           => $this->ocupaciones[array_rand($this->ocupaciones)],
                    'lugar_trabajo'       => 'Empresa Ltda.',
                ]);
            }
        }

        $apoderados = Apoderado::pluck('id')->toArray();
        $totalCreados = 0;

        foreach ($cursosNuevos as $curso) {
            $edadBase = $this->edadParaCurso($curso->nivel, $curso->grado);
            $ids = [];

            for ($i = 0; $i < 15; $i++) {
                $esMujer  = rand(0, 1);
                $nombre   = $esMujer ? $this->nombresF[array_rand($this->nombresF)]
                                     : $this->nombresM[array_rand($this->nombresM)];
                $apell1   = $this->apellidos[array_rand($this->apellidos)];
                $apell2   = $this->apellidos[array_rand($this->apellidos)];
                $ci       = array_rand($this->ciudades);

                // Normalizar email (quitar tildes)
                $emailNombre = $this->normalizeStr($nombre);
                $emailApell  = $this->normalizeStr($apell1);

                $est = Estudiante::create([
                    'rut'              => $this->generateRut($this->rutBase++),
                    'nombre'           => $nombre,
                    'apellido'         => $apell1 . ' ' . $apell2,
                    'genero'           => $esMujer ? 'Femenino' : 'Masculino',
                    'nacionalidad'     => 'Chilena',
                    'fecha_nacimiento' => now()->subYears($edadBase)->subDays(rand(0,364))->format('Y-m-d'),
                    'email'            => strtolower($emailNombre . '.' . $emailApell . rand(10,99) . '@estudiante.holaclase.cl'),
                    'telefono'         => '+569 ' . rand(5000,9999) . ' ' . rand(1000,9999),
                    'direccion'        => 'Calle Los Aromos ' . rand(100,999),
                    'ciudad'           => $this->ciudades[$ci],
                    'region'           => $this->regiones[$ci],
                    'estado'           => 'activo',
                    'apoderado_id'     => $apoderados[array_rand($apoderados)],
                ]);
                $ids[$est->id] = [
                    'fecha_inscripcion' => now()->subDays(rand(30,200))->format('Y-m-d'),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }

            $curso->estudiantes()->attach($ids);
            $totalCreados += count($ids);
            $this->command->line("  ✓ {$curso->nombre} → 15 estudiantes asignados");
        }

        $this->command->line("  → Total estudiantes creados: {$totalCreados}");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PASO 6: Generar notas
    // ─────────────────────────────────────────────────────────────────────────
    private function generarNotas(): void
    {
        $cursos = Curso::whereIn('nivel', ['basica','media'])
                       ->with(['estudiantes','asignaturas'])
                       ->get();

        $totalNotas = 0;

        foreach ($cursos as $curso) {
            $estudiantes = $curso->estudiantes;
            $asignaturas = $curso->asignaturas;

            if ($estudiantes->isEmpty() || $asignaturas->isEmpty()) continue;

            foreach ($estudiantes as $estudiante) {
                // Dar 3-5 notas por asignatura en cada semestre
                foreach ($asignaturas->random(min(4, $asignaturas->count())) as $asig) {
                    foreach ($this->periodos as $periodo) {
                        $numNotas = rand(2, 4);
                        for ($k = 0; $k < $numNotas; $k++) {
                            // Verificar que no existe la misma nota exacta
                            Nota::create([
                                'estudiante_id'   => $estudiante->id,
                                'curso_id'        => $curso->id,
                                'asignatura_id'   => $asig->id,
                                'nota'            => $this->generarNota(),
                                'tipo_evaluacion' => $this->tiposEvaluacion[array_rand($this->tiposEvaluacion)],
                                'periodo'         => $periodo,
                                'fecha'           => now()->subDays(rand(1, 150))->format('Y-m-d'),
                                'ponderacion'     => [0.2, 0.3, 0.4, 0.5, 1.0][array_rand([0.2, 0.3, 0.4, 0.5, 1.0])],
                                'observaciones'   => rand(1,10) > 7 ? 'Buen desempeño' : null,
                            ]);
                            $totalNotas++;
                        }
                    }
                }
            }
            $this->command->line("  ✓ {$curso->nombre}: " . ($totalNotas) . " notas acumuladas");
        }

        $this->command->line("  → Total notas generadas: {$totalNotas}");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PASO 7: Generar pruebas futuras
    // ─────────────────────────────────────────────────────────────────────────
    private function generarPruebas(): void
    {
        $cursos = Curso::whereIn('nivel', ['basica','media'])
                       ->with('asignaturas')
                       ->get();

        $ponderaciones = [20, 30, 40, 50, 60];
        $total = 0;

        foreach ($cursos as $curso) {
            $asignaturas = $curso->asignaturas;
            if ($asignaturas->isEmpty()) continue;

            // 3-5 pruebas futuras por curso
            $numPruebas = rand(3, 5);
            for ($i = 0; $i < $numPruebas; $i++) {
                $asig = $asignaturas->random();
                Prueba::create([
                    'curso_id'      => $curso->id,
                    'asignatura_id' => $asig->id,
                    'titulo'        => $this->nombresPruebas[array_rand($this->nombresPruebas)],
                    'fecha'         => now()->addDays(rand(7, 90))->format('Y-m-d'),  // futuras
                    'hora'          => rand(8,16) . ':' . (rand(0,1) ? '00' : '30'),
                    'ponderacion'   => $ponderaciones[array_rand($ponderaciones)],
                    'descripcion'   => "Evaluación de {$asig->nombre} - {$curso->nombre}",
                ]);
                $total++;
            }
        }

        $this->command->line("  → {$total} pruebas futuras generadas.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Resumen final
    // ─────────────────────────────────────────────────────────────────────────
    private function resumen(): void
    {
        $this->command->newLine();
        $this->command->info('✅ ¡Todo listo!');
        $this->command->table(
            ['Tabla','Total'],
            [
                ['Cursos',              DB::table('cursos')->count()],
                ['Profesores',          DB::table('profesores')->count()],
                ['Asignaturas',         DB::table('asignaturas')->count()],
                ['Estudiantes',         DB::table('estudiantes')->count()],
                ['Asig. curso↔asig',    DB::table('curso_asignatura')->count()],
                ['Asig. curso↔estud',   DB::table('curso_estudiante')->count()],
                ['Notas',               DB::table('notas')->count()],
                ['Pruebas',             DB::table('pruebas')->count()],
            ]
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────
    private function edadParaCurso(string $nivel, ?string $grado): int
    {
        $g = $grado ? (int) $grado : 1;
        return match($nivel) {
            'basica' => 5 + $g + rand(-1,1),
            'media'  => 13 + $g + rand(-1,1),
            default  => 6,
        };
    }

    private function generarNota(): float
    {
        $r = rand(1, 100);
        if ($r <= 60)  return rand(50, 70) / 10;  // buena (5.0-7.0)
        if ($r <= 85)  return rand(40, 49) / 10;  // suficiente (4.0-4.9)
        return rand(20, 39) / 10;                  // insuficiente (2.0-3.9)
    }

    private function generateRut(int $n): string
    {
        return number_format($n, 0, '', '.') . '-' . $this->calculateDV($n);
    }

    private function calculateDV(int $rut): string
    {
        $suma = 0; $mult = 2; $s = (string) $rut;
        for ($i = strlen($s) - 1; $i >= 0; $i--) {
            $suma += $mult * (int)$s[$i];
            $mult  = $mult < 7 ? $mult + 1 : 2;
        }
        $dv = 11 - ($suma % 11);
        return match($dv) { 11 => '0', 10 => 'K', default => (string)$dv };
    }

    private function normalizeStr(string $s): string
    {
        $from = ['á','é','í','ó','ú','ü','ñ','Á','É','Í','Ó','Ú','Ü','Ñ'];
        $to   = ['a','e','i','o','u','u','n','A','E','I','O','U','U','N'];
        return str_replace($from, $to, $s);
    }
}
