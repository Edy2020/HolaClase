<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profesor;
use App\Models\Apoderado;
use App\Models\Estudiante;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\EventoAcademico;
use App\Models\Prueba;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Prueba::truncate();
        EventoAcademico::truncate();
        DB::table('curso_asignatura')->truncate();
        DB::table('curso_estudiante')->truncate();
        Asignatura::truncate();
        Estudiante::truncate();
        Apoderado::truncate();
        Curso::truncate();
        Profesor::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name' => 'Administrador',
            'email' => 'admin@holaclase.cl',
            'password' => \Illuminate\Support\Facades\Hash::make('admin1234'),
            'email_verified_at' => now(),
        ]);

        // Create Profesores (20 teachers)
        $profesores = [];
        $nombresProfesor = [
            ['nombre' => 'María', 'apellido' => 'González'],
            ['nombre' => 'Juan', 'apellido' => 'Pérez'],
            ['nombre' => 'Carmen', 'apellido' => 'Silva'],
            ['nombre' => 'Pedro', 'apellido' => 'Rodríguez'],
            ['nombre' => 'Ana', 'apellido' => 'Martínez'],
            ['nombre' => 'Carlos', 'apellido' => 'López'],
            ['nombre' => 'Isabel', 'apellido' => 'Fernández'],
            ['nombre' => 'Roberto', 'apellido' => 'Muñoz'],
            ['nombre' => 'Patricia', 'apellido' => 'Sánchez'],
            ['nombre' => 'Jorge', 'apellido' => 'Torres'],
            ['nombre' => 'Claudia', 'apellido' => 'Ramírez'],
            ['nombre' => 'Francisco', 'apellido' => 'Flores'],
            ['nombre' => 'Mónica', 'apellido' => 'Vargas'],
            ['nombre' => 'Luis', 'apellido' => 'Herrera'],
            ['nombre' => 'Gabriela', 'apellido' => 'Morales'],
            ['nombre' => 'Ricardo', 'apellido' => 'Castillo'],
            ['nombre' => 'Verónica', 'apellido' => 'Reyes'],
            ['nombre' => 'Andrés', 'apellido' => 'Contreras'],
            ['nombre' => 'Daniela', 'apellido' => 'Rojas'],
            ['nombre' => 'Sergio', 'apellido' => 'Vega'],
        ];

        $nivelesEnsenanza = ['Primer Ciclo', 'Segundo Ciclo', 'Superior'];

        foreach ($nombresProfesor as $index => $nombre) {
            $profesores[] = Profesor::create([
                'rut' => $this->generateRut(15000000 + $index),
                'nombre' => $nombre['nombre'],
                'apellido' => $nombre['apellido'],
                'fecha_nacimiento' => now()->subYears(rand(25, 55))->format('Y-m-d'),
                'email' => strtolower($nombre['nombre'] . '.' . $nombre['apellido'] . '@holaclase.cl'),
                'telefono' => '+569 ' . rand(5000, 9999) . ' ' . rand(1000, 9999),
                'nivel_ensenanza' => $nivelesEnsenanza[array_rand($nivelesEnsenanza)],
                'titulo' => 'Profesor(a) de Educación General Básica',
            ]);
        }

        // Create Cursos (20 courses)
        $cursos = [];
        $niveles = [
            'pre-kinder' => ['grado' => null, 'letras' => ['A', 'B']],
            'kinder' => ['grado' => null, 'letras' => ['A', 'B']],
            'basica' => ['grados' => ['1°', '2°', '3°', '4°', '5°', '6°', '7°', '8°'], 'letras' => ['A', 'B']],
            'media' => ['grados' => ['1°', '2°', '3°', '4°'], 'letras' => ['A', 'B']],
        ];

        $cursoIndex = 0;

        // Pre-kinder and Kinder
        foreach (['pre-kinder', 'kinder'] as $nivel) {
            foreach ($niveles[$nivel]['letras'] as $letra) {
                $nombre = ucfirst($nivel) . ' ' . $letra;
                $cursos[] = Curso::create([
                    'nivel' => $nivel,
                    'grado' => null,
                    'letra' => $letra,
                    'nombre' => $nombre,
                    'profesor_id' => $profesores[$cursoIndex % count($profesores)]->id,
                ]);
                $cursoIndex++;
            }
        }

        // Básica
        foreach ($niveles['basica']['grados'] as $grado) {
            foreach ($niveles['basica']['letras'] as $letra) {
                $nombre = $grado . ' Básico ' . $letra;
                $cursos[] = Curso::create([
                    'nivel' => 'basica',
                    'grado' => $grado,
                    'letra' => $letra,
                    'nombre' => $nombre,
                    'profesor_id' => $profesores[$cursoIndex % count($profesores)]->id,
                ]);
                $cursoIndex++;
                if ($cursoIndex >= 18)
                    break 2; // Limit to 20 total courses
            }
        }

        // Media
        foreach ($niveles['media']['grados'] as $grado) {
            if ($cursoIndex >= 20)
                break;
            $letra = 'A';
            $nombre = $grado . ' Medio ' . $letra;
            $cursos[] = Curso::create([
                'nivel' => 'media',
                'grado' => $grado,
                'letra' => $letra,
                'nombre' => $nombre,
                'profesor_id' => $profesores[$cursoIndex % count($profesores)]->id,
            ]);
            $cursoIndex++;
        }

        // Create Asignaturas (20 subjects)
        $asignaturas = [];
        $asignaturasData = [
            ['nombre' => 'Lenguaje y Comunicación', 'codigo' => 'LEN-001'],
            ['nombre' => 'Matemáticas', 'codigo' => 'MAT-001'],
            ['nombre' => 'Ciencias Naturales', 'codigo' => 'CNA-001'],
            ['nombre' => 'Historia y Geografía', 'codigo' => 'HIS-001'],
            ['nombre' => 'Inglés', 'codigo' => 'ING-001'],
            ['nombre' => 'Educación Física', 'codigo' => 'EFI-001'],
            ['nombre' => 'Artes Visuales', 'codigo' => 'ART-001'],
            ['nombre' => 'Música', 'codigo' => 'MUS-001'],
            ['nombre' => 'Tecnología', 'codigo' => 'TEC-001'],
            ['nombre' => 'Religión', 'codigo' => 'REL-001'],
            ['nombre' => 'Orientación', 'codigo' => 'ORI-001'],
            ['nombre' => 'Física', 'codigo' => 'FIS-001'],
            ['nombre' => 'Química', 'codigo' => 'QUI-001'],
            ['nombre' => 'Biología', 'codigo' => 'BIO-001'],
            ['nombre' => 'Filosofía', 'codigo' => 'FIL-001'],
            ['nombre' => 'Educación Ciudadana', 'codigo' => 'CIU-001'],
            ['nombre' => 'Artes Musicales', 'codigo' => 'ARM-001'],
            ['nombre' => 'Ciencias para la Ciudadanía', 'codigo' => 'CPC-001'],
            ['nombre' => 'Probabilidades y Estadística', 'codigo' => 'PRE-001'],
            ['nombre' => 'Geometría 3D', 'codigo' => 'GEO-001'],
        ];

        foreach ($asignaturasData as $asig) {
            $asignaturas[] = Asignatura::create([
                'nombre' => $asig['nombre'],
                'codigo' => $asig['codigo'],
                'descripcion' => 'Asignatura de ' . $asig['nombre'],
            ]);
        }

        // Assign subjects to courses
        foreach ($cursos as $curso) {
            // Each course gets 6-8 random subjects
            $numAsignaturas = rand(6, 8);
            $asignaturasAleatorias = collect($asignaturas)->random($numAsignaturas);

            foreach ($asignaturasAleatorias as $asignatura) {
                $curso->asignaturas()->attach($asignatura->id, [
                    'profesor_id' => $profesores[array_rand($profesores)]->id,
                ]);
            }
        }

        // Create Apoderados (20 guardians)
        $apoderados = [];
        $nombresApoderado = [
            ['nombre' => 'Roberto', 'apellido' => 'Gómez'],
            ['nombre' => 'Laura', 'apellido' => 'Díaz'],
            ['nombre' => 'Fernando', 'apellido' => 'Castro'],
            ['nombre' => 'Marcela', 'apellido' => 'Pinto'],
            ['nombre' => 'Héctor', 'apellido' => 'Navarro'],
            ['nombre' => 'Paulina', 'apellido' => 'Bravo'],
            ['nombre' => 'Rodrigo', 'apellido' => 'Cortés'],
            ['nombre' => 'Andrea', 'apellido' => 'Medina'],
            ['nombre' => 'Mauricio', 'apellido' => 'Guzmán'],
            ['nombre' => 'Carolina', 'apellido' => 'Aguilar'],
            ['nombre' => 'Gonzalo', 'apellido' => 'Espinoza'],
            ['nombre' => 'Francisca', 'apellido' => 'Valenzuela'],
            ['nombre' => 'Cristián', 'apellido' => 'Campos'],
            ['nombre' => 'Alejandra', 'apellido' => 'Núñez'],
            ['nombre' => 'Claudio', 'apellido' => 'Carrasco'],
            ['nombre' => 'Soledad', 'apellido' => 'Fuentes'],
            ['nombre' => 'Patricio', 'apellido' => 'Alarcón'],
            ['nombre' => 'Cecilia', 'apellido' => 'Sepúlveda'],
            ['nombre' => 'Jaime', 'apellido' => 'Bustos'],
            ['nombre' => 'Lorena', 'apellido' => 'Parra'],
        ];

        $relaciones = ['Padre', 'Madre', 'Abuelo', 'Abuela', 'Tío', 'Tía'];
        $ocupaciones = ['Ingeniero', 'Profesor', 'Médico', 'Comerciante', 'Contador', 'Abogado', 'Enfermera', 'Técnico'];

        foreach ($nombresApoderado as $index => $nombre) {
            $apoderados[] = Apoderado::create([
                'rut' => $this->generateRut(18000000 + $index),
                'nombre' => $nombre['nombre'],
                'apellido' => $nombre['apellido'],
                'relacion' => $relaciones[array_rand($relaciones)],
                'telefono' => '+569 ' . rand(5000, 9999) . ' ' . rand(1000, 9999),
                'email' => strtolower($nombre['nombre'] . '.' . $nombre['apellido'] . '@gmail.com'),
                'direccion' => 'Av. Libertador Bernardo O\'Higgins ' . rand(100, 9999) . ', Santiago',
                'telefono_emergencia' => '+569 ' . rand(5000, 9999) . ' ' . rand(1000, 9999),
                'ocupacion' => $ocupaciones[array_rand($ocupaciones)],
                'lugar_trabajo' => 'Empresa ' . $nombre['apellido'] . ' S.A.',
            ]);
        }

        // Create Estudiantes (30 students)
        $estudiantes = [];
        $nombresEstudiante = [
            ['nombre' => 'Sofía', 'apellido' => 'González'],
            ['nombre' => 'Matías', 'apellido' => 'Pérez'],
            ['nombre' => 'Valentina', 'apellido' => 'Silva'],
            ['nombre' => 'Benjamín', 'apellido' => 'Rodríguez'],
            ['nombre' => 'Martina', 'apellido' => 'Martínez'],
            ['nombre' => 'Joaquín', 'apellido' => 'López'],
            ['nombre' => 'Isidora', 'apellido' => 'Fernández'],
            ['nombre' => 'Agustín', 'apellido' => 'Muñoz'],
            ['nombre' => 'Emilia', 'apellido' => 'Sánchez'],
            ['nombre' => 'Vicente', 'apellido' => 'Torres'],
            ['nombre' => 'Amanda', 'apellido' => 'Ramírez'],
            ['nombre' => 'Tomás', 'apellido' => 'Flores'],
            ['nombre' => 'Catalina', 'apellido' => 'Vargas'],
            ['nombre' => 'Diego', 'apellido' => 'Herrera'],
            ['nombre' => 'Florencia', 'apellido' => 'Morales'],
            ['nombre' => 'Lucas', 'apellido' => 'Castillo'],
            ['nombre' => 'Antonia', 'apellido' => 'Reyes'],
            ['nombre' => 'Sebastián', 'apellido' => 'Contreras'],
            ['nombre' => 'Javiera', 'apellido' => 'Rojas'],
            ['nombre' => 'Nicolás', 'apellido' => 'Vega'],
            ['nombre' => 'Constanza', 'apellido' => 'Pizarro'],
            ['nombre' => 'Gabriel', 'apellido' => 'Mendoza'],
            ['nombre' => 'Maite', 'apellido' => 'Ortiz'],
            ['nombre' => 'Maximiliano', 'apellido' => 'Salazar'],
            ['nombre' => 'Renata', 'apellido' => 'Ibáñez'],
            ['nombre' => 'Cristóbal', 'apellido' => 'Araya'],
            ['nombre' => 'Josefa', 'apellido' => 'Cáceres'],
            ['nombre' => 'Ignacio', 'apellido' => 'Vera'],
            ['nombre' => 'Trinidad', 'apellido' => 'Tapia'],
            ['nombre' => 'Felipe', 'apellido' => 'Molina'],
        ];

        $generos = ['Masculino', 'Femenino'];
        $ciudades = ['Santiago', 'Valparaíso', 'Concepción', 'La Serena', 'Antofagasta'];
        $regiones = ['Metropolitana', 'Valparaíso', 'Biobío', 'Coquimbo', 'Antofagasta'];

        foreach ($nombresEstudiante as $index => $nombre) {
            $genero = in_array($nombre['nombre'], ['Sofía', 'Valentina', 'Martina', 'Isidora', 'Emilia', 'Amanda', 'Catalina', 'Florencia', 'Antonia', 'Javiera', 'Constanza', 'Maite', 'Renata', 'Josefa', 'Trinidad']) ? 'Femenino' : 'Masculino';

            $estudiantes[] = Estudiante::create([
                'rut' => $this->generateRut(20000000 + $index),
                'nombre' => $nombre['nombre'],
                'apellido' => $nombre['apellido'],
                'genero' => $genero,
                'nacionalidad' => 'Chilena',
                'fecha_nacimiento' => now()->subYears(rand(5, 17))->format('Y-m-d'),
                'email' => strtolower($nombre['nombre'] . '.' . $nombre['apellido'] . '@estudiante.holaclase.cl'),
                'telefono' => '+569 ' . rand(5000, 9999) . ' ' . rand(1000, 9999),
                'direccion' => 'Calle ' . $nombre['apellido'] . ' ' . rand(100, 999),
                'ciudad' => $ciudades[array_rand($ciudades)],
                'region' => $regiones[array_rand($regiones)],
                'estado' => 'activo',
                'apoderado_id' => $apoderados[array_rand($apoderados)]->id,
            ]);
        }

        // Assign students to courses (each student to 1 course)
        foreach ($estudiantes as $index => $estudiante) {
            $curso = $cursos[$index % count($cursos)];
            $curso->estudiantes()->attach($estudiante->id, [
                'fecha_inscripcion' => now()->subDays(rand(1, 180))->format('Y-m-d'),
            ]);
        }

        // Create Eventos Académicos (20 events)
        $eventosData = [
            ['titulo' => 'Inicio del Año Escolar', 'tipo' => 'actividad'],
            ['titulo' => 'Reunión de Apoderados 1er Semestre', 'tipo' => 'reunion'],
            ['titulo' => 'Día del Estudiante', 'tipo' => 'actividad'],
            ['titulo' => 'Feria Científica', 'tipo' => 'actividad'],
            ['titulo' => 'Vacaciones de Invierno', 'tipo' => 'vacaciones'],
            ['titulo' => 'Exámenes Finales 1er Semestre', 'tipo' => 'examen'],
            ['titulo' => 'Aniversario del Colegio', 'tipo' => 'actividad'],
            ['titulo' => 'Olimpiadas Deportivas', 'tipo' => 'actividad'],
            ['titulo' => 'Reunión de Apoderados 2do Semestre', 'tipo' => 'reunion'],
            ['titulo' => 'Día de la Familia', 'tipo' => 'actividad'],
            ['titulo' => 'Muestra de Talentos', 'tipo' => 'actividad'],
            ['titulo' => 'Semana de la Ciencia', 'tipo' => 'actividad'],
            ['titulo' => 'Exámenes Finales 2do Semestre', 'tipo' => 'examen'],
            ['titulo' => 'Ceremonia de Graduación', 'tipo' => 'actividad'],
            ['titulo' => 'Vacaciones de Verano', 'tipo' => 'vacaciones'],
            ['titulo' => 'Consejo de Profesores', 'tipo' => 'reunion'],
            ['titulo' => 'Campeonato de Ajedrez', 'tipo' => 'actividad'],
            ['titulo' => 'Feria del Libro', 'tipo' => 'actividad'],
            ['titulo' => 'Día del Profesor', 'tipo' => 'actividad'],
            ['titulo' => 'Acto Cívico Fiestas Patrias', 'tipo' => 'actividad'],
        ];

        foreach ($eventosData as $index => $evento) {
            $curso = $cursos[array_rand($cursos)];
            EventoAcademico::create([
                'curso_id' => $curso->id,
                'titulo' => $evento['titulo'],
                'tipo' => $evento['tipo'],
                'fecha_inicio' => now()->addDays(rand(-30, 180))->format('Y-m-d'),
                'fecha_fin' => rand(0, 1) ? now()->addDays(rand(-30, 185))->format('Y-m-d') : null,
                'descripcion' => 'Descripción del evento: ' . $evento['titulo'],
            ]);
        }

        // Create Pruebas (25 tests)
        $pruebasData = [
            'Prueba de Diagnóstico',
            'Control de Lectura',
            'Evaluación Sumativa',
            'Prueba Coeficiente 2',
            'Examen Parcial',
            'Control de Matemáticas',
            'Evaluación de Ciencias',
            'Prueba de Historia',
            'Test de Inglés',
            'Evaluación de Artes',
        ];

        $pruebaCount = 0;
        foreach ($cursos as $curso) {
            if ($pruebaCount >= 25)
                break;

            // Each course gets 1-2 tests
            $numPruebas = rand(1, 2);
            $asignaturasCurso = $curso->asignaturas;

            if ($asignaturasCurso->isEmpty())
                continue;

            for ($i = 0; $i < $numPruebas && $pruebaCount < 25; $i++) {
                $asignatura = $asignaturasCurso->random();
                Prueba::create([
                    'curso_id' => $curso->id,
                    'asignatura_id' => $asignatura->id,
                    'titulo' => $pruebasData[array_rand($pruebasData)],
                    'fecha' => now()->addDays(rand(1, 60))->format('Y-m-d'),
                    'hora' => rand(8, 16) . ':' . (rand(0, 1) ? '00' : '30'),
                    'ponderacion' => [20, 30, 40, 50][array_rand([20, 30, 40, 50])],
                    'descripcion' => 'Evaluación de ' . $asignatura->nombre,
                ]);
                $pruebaCount++;
            }
        }

        // Create Notas (Grades) - 150 grades distributed across students
        $notas = [];
        $tiposEvaluacion = ['Prueba', 'Trabajo', 'Examen', 'Taller', 'Proyecto', 'Participación', 'Control'];
        $periodos = ['Semestre 1', 'Semestre 2'];
        $notaCount = 0;
        $targetNotas = 150;

        foreach ($cursos as $curso) {
            if ($notaCount >= $targetNotas)
                break;

            $estudiantesCurso = $curso->estudiantes;
            $asignaturasCurso = $curso->asignaturas;

            if ($estudiantesCurso->isEmpty() || $asignaturasCurso->isEmpty())
                continue;

            // Each student in the course gets 2-4 grades
            foreach ($estudiantesCurso as $estudiante) {
                if ($notaCount >= $targetNotas)
                    break;

                $numNotas = rand(2, 4);
                for ($i = 0; $i < $numNotas && $notaCount < $targetNotas; $i++) {
                    $asignatura = $asignaturasCurso->random();

                    // Generate realistic grades (weighted towards passing)
                    $random = rand(1, 100);
                    if ($random <= 60) {
                        // 60% chance of good grade (5.0-7.0)
                        $nota = rand(50, 70) / 10;
                    } elseif ($random <= 85) {
                        // 25% chance of passing grade (4.0-4.9)
                        $nota = rand(40, 49) / 10;
                    } else {
                        // 15% chance of failing grade (2.0-3.9)
                        $nota = rand(20, 39) / 10;
                    }

                    $notas[] = \App\Models\Nota::create([
                        'estudiante_id' => $estudiante->id,
                        'curso_id' => $curso->id,
                        'asignatura_id' => $asignatura->id,
                        'nota' => $nota,
                        'tipo_evaluacion' => $tiposEvaluacion[array_rand($tiposEvaluacion)],
                        'periodo' => $periodos[array_rand($periodos)],
                        'fecha' => now()->subDays(rand(1, 120))->format('Y-m-d'),
                        'ponderacion' => [0.2, 0.3, 0.4, 0.5, 1.0][array_rand([0.2, 0.3, 0.4, 0.5, 1.0])],
                        'observaciones' => rand(1, 10) > 7 ? 'Buen desempeño' : null,
                    ]);
                    $notaCount++;
                }
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📊 Created:');
        $this->command->info('   - ' . count($profesores) . ' Profesores');
        $this->command->info('   - ' . count($cursos) . ' Cursos');
        $this->command->info('   - ' . count($asignaturas) . ' Asignaturas');
        $this->command->info('   - ' . count($apoderados) . ' Apoderados');
        $this->command->info('   - ' . count($estudiantes) . ' Estudiantes');
        $this->command->info('   - 20 Eventos Académicos');
        $this->command->info('   - ' . $pruebaCount . ' Pruebas');
        $this->command->info('   - ' . count($notas) . ' Notas');
    }

    /**
     * Generate a valid Chilean RUT
     */
    private function generateRut($number)
    {
        $dv = $this->calculateDV($number);
        return number_format($number, 0, '', '.') . '-' . $dv;
    }

    /**
     * Calculate RUT verification digit
     */
    private function calculateDV($rut)
    {
        $rutStr = (string) $rut;
        $suma = 0;
        $multiplo = 2;

        for ($i = strlen($rutStr) - 1; $i >= 0; $i--) {
            $suma += $multiplo * intval($rutStr[$i]);
            $multiplo = $multiplo < 7 ? $multiplo + 1 : 2;
        }

        $dv = 11 - ($suma % 11);

        if ($dv == 11)
            return '0';
        if ($dv == 10)
            return 'K';
        return (string) $dv;
    }
}
