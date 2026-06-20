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
    <h1>Reporte de Ventas</h1>
    <p>Fecha de generación: {{ $generatedAt }}</p>
    <table>
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Cantidad</th>
                <th>ID Cliente</th>
                <th>ID Empleado</th>
            </tr>
        </thead>
        <tbody>
            @if($ventas->count() > 0)
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id_venta }}</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                        <td>{{ $venta->cantidad }}</td>
                        <td>{{ $venta->fk_id_cliente }}</td>
                        <td>{{ $venta->fk_id_empleado ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="center" colspan="6">No hay registros de ventas para mostrar.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
