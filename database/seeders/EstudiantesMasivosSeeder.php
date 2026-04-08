<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\Apoderado;
use App\Models\Curso;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudiantesMasivosSeeder extends Seeder
{
    // Pool de nombres masculinos chilenos
    private $nombresM = [
        'Matías', 'Benjamín', 'Joaquín', 'Agustín', 'Vicente', 'Tomás', 'Diego', 'Lucas',
        'Sebastián', 'Nicolás', 'Gabriel', 'Maximiliano', 'Cristóbal', 'Ignacio', 'Felipe',
        'Rodrigo', 'Andrés', 'Gonzalo', 'Claudio', 'Mauricio', 'Fernando', 'Patricio',
        'Héctor', 'Jaime', 'Cristián', 'Pablo', 'Daniel', 'Alejandro', 'Francisco', 'Marcelo',
        'Camilo', 'Diego', 'Esteban', 'Sergio', 'Alberto', 'Emilio', 'Raúl', 'Eduardo',
        'Iván', 'Fabián', 'Álvaro', 'César', 'Hugo', 'Óscar', 'Ernesto', 'Rafael',
    ];

    // Pool de nombres femeninos chilenos
    private $nombresF = [
        'Sofía', 'Valentina', 'Martina', 'Isidora', 'Emilia', 'Amanda', 'Catalina',
        'Florencia', 'Antonia', 'Javiera', 'Constanza', 'Maite', 'Renata', 'Josefa',
        'Trinidad', 'Daniela', 'Andrea', 'Carolina', 'Paulina', 'Marcela', 'Lorena',
        'Alejandra', 'Francisca', 'Cecilia', 'Soledad', 'Patricia', 'Verónica', 'Mónica',
        'Claudia', 'Isabel', 'Carmen', 'Ana', 'María', 'Gabriela', 'Pilar', 'Rosa',
        'Rocío', 'Ximena', 'Camila', 'Natalia', 'Fernanda', 'Viviana', 'Sandra', 'Yasna',
    ];

    // Pool de apellidos chilenos
    private $apellidos = [
        'González', 'Pérez', 'Silva', 'Rodríguez', 'Martínez', 'López', 'Fernández',
        'Muñoz', 'Sánchez', 'Torres', 'Ramírez', 'Flores', 'Vargas', 'Herrera', 'Morales',
        'Castillo', 'Reyes', 'Contreras', 'Rojas', 'Vega', 'Pizarro', 'Mendoza', 'Ortiz',
        'Salazar', 'Ibáñez', 'Araya', 'Cáceres', 'Vera', 'Tapia', 'Molina', 'Gómez',
        'Díaz', 'Castro', 'Pinto', 'Navarro', 'Bravo', 'Cortés', 'Medina', 'Guzmán',
        'Aguilar', 'Espinoza', 'Valenzuela', 'Campos', 'Núñez', 'Carrasco', 'Fuentes',
        'Alarcón', 'Sepúlveda', 'Bustos', 'Parra', 'Riquelme', 'Palma', 'Álvarez',
        'Garrido', 'Miranda', 'Peña', 'Vidal', 'Araneda', 'Becerra', 'Figueroa',
        'Acuña', 'Donoso', 'Neira', 'Orellana', 'Quijada', 'Ugarte', 'Zamora',
    ];

    private $ciudades = [
        'Santiago', 'Valparaíso', 'Concepción', 'La Serena', 'Antofagasta',
        'Temuco', 'Rancagua', 'Talca', 'Arica', 'Puerto Montt',
    ];

    private $regiones = [
        'Metropolitana', 'Valparaíso', 'Biobío', 'Coquimbo', 'Antofagasta',
        'La Araucanía', "O'Higgins", 'Maule', 'Arica y Parinacota', 'Los Lagos',
    ];

    private $relaciones   = ['Padre', 'Madre', 'Abuelo', 'Abuela', 'Tío', 'Tía'];
    private $ocupaciones  = ['Ingeniero', 'Profesor', 'Médico', 'Comerciante', 'Contador', 'Abogado', 'Enfermera', 'Técnico'];

    /** RUT base global (para unicidad) */
    private int $rutBase = 10_000_000;

    public function run(): void
    {
        // ── 1. Obtener los cursos que necesitamos ─────────────────────────────
        // Básica: 1° a 8°, letras A-D
        // Media : 1° a 4°, letras A-D
        $gradosBasica = ['1°', '2°', '3°', '4°', '5°', '6°', '7°', '8°'];
        $gradosMedia  = ['1°', '2°', '3°', '4°'];
        $letras       = ['A', 'B', 'C', 'D'];

        // Buscar o crear cada curso
        $cursos = [];

        // ── Básica ──
        foreach ($gradosBasica as $grado) {
            foreach ($letras as $letra) {
                $curso = Curso::firstOrCreate(
                    ['nivel' => 'Basica', 'grado' => $grado, 'letra' => $letra],
                    ['nombre' => "{$grado} Básico {$letra}"]
                );
                $cursos[] = $curso;
            }
        }

        // ── Media ──
        foreach ($gradosMedia as $grado) {
            foreach ($letras as $letra) {
                $curso = Curso::firstOrCreate(
                    ['nivel' => 'Media', 'grado' => $grado, 'letra' => $letra],
                    ['nombre' => "{$grado} Medio {$letra}"]
                );
                $cursos[] = $curso;
            }
        }

        $totalCursos     = count($cursos);   // 8×4 + 4×4 = 48
        $estudiantesPorCurso = 15;
        $totalEstudiantes    = $totalCursos * $estudiantesPorCurso;

        $this->command->info("📋 Cursos encontrados/creados: {$totalCursos}");
        $this->command->info("👥 Estudiantes a crear: {$totalEstudiantes}");

        // ── 2. Crear apoderados si no hay suficientes ──────────────────────────
        $apoderadosExistentes = Apoderado::count();
        $apoderadosNecesarios = max(0, 100 - $apoderadosExistentes);

        if ($apoderadosNecesarios > 0) {
            $this->command->info("👨‍👩‍👧 Creando {$apoderadosNecesarios} apoderados adicionales...");
            for ($i = 0; $i < $apoderadosNecesarios; $i++) {
                $esMujer = rand(0, 1);
                $nombre  = $esMujer
                    ? $this->nombresF[array_rand($this->nombresF)]
                    : $this->nombresM[array_rand($this->nombresM)];
                $apellido = $this->apellidos[array_rand($this->apellidos)];

                Apoderado::create([
                    'rut'                => $this->generateRut(18_000_000 + $apoderadosExistentes + $i),
                    'nombre'             => $nombre,
                    'apellido'           => $apellido,
                    'relacion'           => $this->relaciones[array_rand($this->relaciones)],
                    'telefono'           => '+569 ' . rand(5000, 9999) . ' ' . rand(1000, 9999),
                    'email'              => strtolower($nombre . '.' . $apellido . rand(1, 999) . '@gmail.com'),
                    'direccion'          => 'Av. Principal ' . rand(100, 9999) . ', Santiago',
                    'telefono_emergencia' => '+569 ' . rand(5000, 9999) . ' ' . rand(1000, 9999),
                    'ocupacion'          => $this->ocupaciones[array_rand($this->ocupaciones)],
                    'lugar_trabajo'      => 'Empresa S.A.',
                ]);
            }
        }

        $apoderados = Apoderado::pluck('id')->toArray();

        // ── 3. Calcular RUT base para no colisionar ───────────────────────────
        $maxRutExistente = DB::table('estudiantes')
            ->selectRaw("MAX(CAST(REPLACE(REPLACE(rut, '.', ''), '-' || substr(rut, -1), '') AS INTEGER)) as max_rut")
            ->value('max_rut');

        $this->rutBase = max(10_000_000, (int)($maxRutExistente ?? 0) + 1);

        // ── 4. Crear estudiantes y asignarlos ─────────────────────────────────
        $creados   = 0;
        $asignados = 0;
        $barra     = 0;

        foreach ($cursos as $cursoIdx => $curso) {
            // Calcular edad aproximada según nivel y grado
            $edadBase = $this->edadParaCurso($curso->nivel, $curso->grado);

            $estudiantesCreados = [];

            for ($i = 0; $i < $estudiantesPorCurso; $i++) {
                $esMujer  = rand(0, 1);
                $nombre   = $esMujer
                    ? $this->nombresF[array_rand($this->nombresF)]
                    : $this->nombresM[array_rand($this->nombresM)];
                $apellido  = $this->apellidos[array_rand($this->apellidos)];
                $apellido2 = $this->apellidos[array_rand($this->apellidos)];
                $apellidoCompleto = $apellido . ' ' . $apellido2;

                $ciudadIndex = array_rand($this->ciudades);

                $estudiante = Estudiante::create([
                    'rut'             => $this->generateRut($this->rutBase++),
                    'nombre'          => $nombre,
                    'apellido'        => $apellidoCompleto,
                    'genero'          => $esMujer ? 'Femenino' : 'Masculino',
                    'nacionalidad'    => 'Chilena',
                    'fecha_nacimiento' => now()->subYears($edadBase)->subDays(rand(0, 364))->format('Y-m-d'),
                    'email'           => strtolower(
                        iconv('UTF-8', 'ASCII//TRANSLIT', $nombre) . '.' .
                        iconv('UTF-8', 'ASCII//TRANSLIT', $apellido) .
                        rand(10, 99) . '@estudiante.holaclase.cl'
                    ),
                    'telefono'        => '+569 ' . rand(5000, 9999) . ' ' . rand(1000, 9999),
                    'direccion'       => 'Calle Los Aromos ' . rand(100, 999),
                    'ciudad'          => $this->ciudades[$ciudadIndex],
                    'region'          => $this->regiones[$ciudadIndex],
                    'estado'          => 'activo',
                    'apoderado_id'    => $apoderados[array_rand($apoderados)],
                ]);

                $estudiantesCreados[] = $estudiante->id;
                $creados++;
            }

            // Asignar al curso de una vez con fecha de inscripción
            $pivotData = [];
            foreach ($estudiantesCreados as $estudianteId) {
                $pivotData[$estudianteId] = [
                    'fecha_inscripcion' => now()->subDays(rand(30, 200))->format('Y-m-d'),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }
            $curso->estudiantes()->attach($pivotData);
            $asignados += count($estudiantesCreados);

            // Progreso
            $barra++;
            $pct = round($barra / $totalCursos * 100);
            $this->command->info("  [{$pct}%] {$curso->nombre} → {$estudiantesPorCurso} estudiantes asignados");
        }

        $this->command->newLine();
        $this->command->info('✅ ¡Seeder completado exitosamente!');
        $this->command->table(
            ['Métrica', 'Total'],
            [
                ['Cursos procesados',      $totalCursos],
                ['Estudiantes creados',    $creados],
                ['Asignaciones a cursos',  $asignados],
            ]
        );
    }

    /**
     * Estima la edad typical de un estudiante según nivel y grado.
     */
    private function edadParaCurso(string $nivel, ?string $grado): int
    {
        $gradoNum = $grado ? (int) $grado : 1;

        return match (strtolower($nivel)) {
            'basica' => 5 + $gradoNum + rand(-1, 1),   // 1°=6 años, 8°=13 años aprox.
            'media'  => 13 + $gradoNum + rand(-1, 1),  // 1°=14 años, 4°=17 años aprox.
            default  => 5,
        };
    }

    /** Genera un RUT chileno válido con formato XX.XXX.XXX-D */
    private function generateRut(int $number): string
    {
        return number_format($number, 0, '', '.') . '-' . $this->calculateDV($number);
    }

    /** Calcula el dígito verificador del RUT */
    private function calculateDV(int $rut): string
    {
        $suma      = 0;
        $multiplo  = 2;
        $rutStr    = (string) $rut;

        for ($i = strlen($rutStr) - 1; $i >= 0; $i--) {
            $suma     += $multiplo * (int) $rutStr[$i];
            $multiplo  = $multiplo < 7 ? $multiplo + 1 : 2;
        }

        $dv = 11 - ($suma % 11);

        return match ($dv) {
            11      => '0',
            10      => 'K',
            default => (string) $dv,
        };
    }
}
