<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Notas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2563eb;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
        }

        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #2563eb;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .aprobado {
            color: #059669;
            font-weight: bold;
        }

        .reprobado {
            color: #dc2626;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Reporte de Notas</h1>
        <p>HolaClase - Sistema de Gestión Educativa</p>
        <p>Generado el {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Notas</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['promedio'] }}</div>
            <div class="stat-label">Promedio</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['aprobados'] }}</div>
            <div class="stat-label">Aprobados</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['reprobados'] }}</div>
            <div class="stat-label">Reprobados</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Asignatura</th>
                <th>Nota</th>
                <th>Tipo</th>
                <th>Período</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notas as $nota)
                <tr>
                    <td>{{ $nota->id }}</td>
                    <td>{{ $nota->estudiante->nombre }} {{ $nota->estudiante->apellido }}</td>
                    <td>{{ $nota->curso->nombre }}</td>
                    <td>{{ $nota->asignatura->nombre }}</td>
                    <td style="font-weight: bold;">{{ number_format($nota->nota, 1) }}</td>
                    <td>{{ $nota->tipo_evaluacion }}</td>
                    <td>{{ $nota->periodo }}</td>
                    <td>{{ $nota->fecha->format('d/m/Y') }}</td>
                    <td class="{{ $nota->nota >= 4.0 ? 'aprobado' : 'reprobado' }}">
                        {{ $nota->nota >= 4.0 ? 'Aprobado' : 'Reprobado' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} HolaClase. Todos los derechos reservados.</p>
    </div>
</body>

</html>