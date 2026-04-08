<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\Apoderado;
use App\Models\Curso;
use App\Models\Nota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompletarEstudiantesSeeder extends Seeder
{
    private array $nombresM = [
        'Matías','Benjamín','Joaquín','Agustín','Vicente','Tomás','Diego','Lucas',
        'Sebastián','Nicolás','Gabriel','Maximiliano','Cristóbal','Ignacio','Felipe',
        'Rodrigo','Andrés','Gonzalo','Claudio','Mauricio','Fernando','Patricio',
        'Héctor','Jaime','Pablo','Daniel','Alejandro','Francisco','Marcelo','Camilo',
        'Esteban','Sergio','Alberto','Emilio','Raúl','Eduardo','Iván','Fabián',
    ];
    private array $nombresF = [
        'Sofía','Valentina','Martina','Isidora','Emilia','Amanda','Catalina',
        'Florencia','Antonia','Javiera','Constanza','Maite','Renata','Josefa',
        'Trinidad','Daniela','Andrea','Carolina','Paulina','Marcela','Lorena',
        'Alejandra','Francisca','Cecilia','Soledad','Patricia','Verónica','Mónica',
        'Claudia','Isabel','Carmen','Ana','María','Gabriela','Pilar','Rosa',
    ];
    private array $apellidos = [
        'González','Pérez','Silva','Rodríguez','Martínez','López','Fernández',
        'Muñoz','Sánchez','Torres','Ramírez','Flores','Vargas','Herrera','Morales',
        'Castillo','Reyes','Contreras','Rojas','Vega','Pizarro','Mendoza','Ortiz',
        'Salazar','Ibáñez','Araya','Cáceres','Vera','Tapia','Molina','Gómez',
        'Díaz','Castro','Pinto','Navarro','Bravo','Cortés','Medina','Guzmán',
        'Aguilar','Espinoza','Valenzuela','Campos','Núñez','Carrasco','Fuentes',
    ];
    private array $ciudades = [
        'Santiago','Valparaíso','Concepción','La Serena','Antofagasta',
        'Temuco','Rancagua','Talca','Arica','Puerto Montt',
    ];
    private array $regiones = [
        'Metropolitana','Valparaíso','Biobío','Coquimbo','Antofagasta',
        'La Araucanía',"O'Higgins",'Maule','Arica y Parinacota','Los Lagos',
    ];
    private array $tiposEvaluacion = ['Prueba','Trabajo','Examen','Taller','Proyecto','Participación','Control'];
    private array $periodos = ['Semestre 1','Semestre 2'];

    public function run(): void
    {
        $meta = 15;

        // Obtener el RUT máximo actual
        $maxRut = (int) DB::table('estudiantes')
            ->selectRaw("MAX(CAST(REPLACE(rut, '.', '') AS INTEGER)) as m")
            ->value('m');
        $rutBase = max(11_000_000, $maxRut + 1);

        $apoderados = Apoderado::pluck('id')->toArray();

        // Cursos básica y media con menos de $meta estudiantes
        $cursos = Curso::whereIn('nivel', ['basica','media'])
                       ->with(['estudiantes','asignaturas'])
                       ->get()
                       ->filter(fn($c) => $c->estudiantes->count() < $meta);

        $totalCreados = 0;
        $totalNotas   = 0;

        $this->command->info("📋 Cursos a completar: {$cursos->count()}");

        foreach ($cursos as $curso) {
            $faltantes = $meta - $curso->estudiantes->count();
            $edadBase  = $this->edadParaCurso($curso->nivel, $curso->grado);
            $ids = [];

            for ($i = 0; $i < $faltantes; $i++) {
                $esMujer = rand(0, 1);
                $nombre  = $esMujer ? $this->nombresF[array_rand($this->nombresF)]
                                    : $this->nombresM[array_rand($this->nombresM)];
                $a1 = $this->apellidos[array_rand($this->apellidos)];
                $a2 = $this->apellidos[array_rand($this->apellidos)];
                $ci = array_rand($this->ciudades);

                $est = Estudiante::create([
                    'rut'              => $this->generateRut($rutBase++),
                    'nombre'           => $nombre,
                    'apellido'         => "{$a1} {$a2}",
                    'genero'           => $esMujer ? 'Femenino' : 'Masculino',
                    'nacionalidad'     => 'Chilena',
                    'fecha_nacimiento' => now()->subYears($edadBase)->subDays(rand(0,364))->format('Y-m-d'),
                    'email'            => strtolower($this->norm($nombre) . '.' . $this->norm($a1) . rand(10,99) . '@estudiante.holaclase.cl'),
                    'telefono'         => '+569 ' . rand(5000,9999) . ' ' . rand(1000,9999),
                    'direccion'        => 'Calle Los Pinos ' . rand(100,999),
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
                $totalCreados++;
            }

            $curso->estudiantes()->attach($ids);

            // Generar notas para los nuevos estudiantes
            $asignaturas = $curso->asignaturas;
            if ($asignaturas->isNotEmpty()) {
                foreach (array_keys($ids) as $estudianteId) {
                    $asigSel = $asignaturas->random(min(3, $asignaturas->count()));
                    foreach ($asigSel as $asig) {
                        foreach ($this->periodos as $periodo) {
                            $n = rand(2, 3);
                            for ($k = 0; $k < $n; $k++) {
                                Nota::create([
                                    'estudiante_id'   => $estudianteId,
                                    'curso_id'        => $curso->id,
                                    'asignatura_id'   => $asig->id,
                                    'nota'            => $this->generarNota(),
                                    'tipo_evaluacion' => $this->tiposEvaluacion[array_rand($this->tiposEvaluacion)],
                                    'periodo'         => $periodo,
                                    'fecha'           => now()->subDays(rand(1,150))->format('Y-m-d'),
                                    'ponderacion'     => [0.2,0.3,0.4,0.5,1.0][array_rand([0.2,0.3,0.4,0.5,1.0])],
                                    'observaciones'   => rand(1,10) > 7 ? 'Buen desempeño' : null,
                                ]);
                                $totalNotas++;
                            }
                        }
                    }
                }
            }

            $total = $curso->estudiantes->count() + $faltantes;
            $this->command->line("  ✓ {$curso->nombre}: +{$faltantes} alumnos → total {$total}");
        }

        $this->command->newLine();
        $this->command->info('✅ Completado');
        $this->command->table(
            ['Métrica','Total'],
            [
                ['Cursos completados',     $cursos->count()],
                ['Estudiantes creados',    $totalCreados],
                ['Notas generadas',        $totalNotas],
                ['Total estudiantes BD',   DB::table('estudiantes')->count()],
                ['Total asignaciones',     DB::table('curso_estudiante')->count()],
                ['Total notas BD',         DB::table('notas')->count()],
            ]
        );
    }

    private function edadParaCurso(string $nivel, ?string $grado): int
    {
        $g = $grado ? (int)$grado : 1;
        return match($nivel) {
            'basica' => 5 + $g + rand(-1,1),
            'media'  => 13 + $g + rand(-1,1),
            default  => 6,
        };
    }

    private function generarNota(): float
    {
        $r = rand(1, 100);
        if ($r <= 60) return rand(50,70)/10;
        if ($r <= 85) return rand(40,49)/10;
        return rand(20,39)/10;
    }

    private function generateRut(int $n): string
    {
        return number_format($n, 0, '', '.') . '-' . $this->calculateDV($n);
    }

    private function calculateDV(int $rut): string
    {
        $suma = 0; $mult = 2; $s = (string)$rut;
        for ($i = strlen($s)-1; $i >= 0; $i--) {
            $suma += $mult * (int)$s[$i];
            $mult = $mult < 7 ? $mult+1 : 2;
        }
        $dv = 11 - ($suma % 11);
        return match($dv) { 11 => '0', 10 => 'K', default => (string)$dv };
    }

    private function norm(string $s): string
    {
        return str_replace(
            ['á','é','í','ó','ú','ü','ñ','Á','É','Í','Ó','Ú','Ü','Ñ'],
            ['a','e','i','o','u','u','n','A','E','I','O','U','U','N'],
            $s
        );
    }
}
