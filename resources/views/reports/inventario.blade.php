<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; color: #222; margin: 20px; }
        h1 { margin-bottom: 8px; font-size: 24px; }
        p { margin: 0 0 12px; font-size: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { padding: 10px 12px; border: 1px solid #ddd; text-align: left; font-size: 12px; }
        th { background: #f4f4f4; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h1>Reporte de Catálogo / Inventario</h1>
    <p>Fecha de generación: {{ $generatedAt }}</p>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Género</th>
                <th>Código de Barras</th>
                <th>Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            @if($prendas->count() > 0)
                @foreach($prendas as $prenda)
                    <tr>
                        <td>{{ $prenda->nombre_prend }}</td>
                        <td>{{ $prenda->tipo_genero }}</td>
                        <td>{{ $prenda->codigo_barras }}</td>
                        <td>{{ $prenda->stock }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="center" colspan="4">No hay prendas registradas en el inventario.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
