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
    <h1>Reporte de Usuarios</h1>
    <p>Fecha de generación: {{ $generatedAt }}</p>
    <table>
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @if($usuarios->count() > 0)
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id_usuario }}</td>
                        <td>{{ trim($usuario->primer_nom . ' ' . ($usuario->segund_nom ?? '') . ' ' . $usuario->primer_apelli . ' ' . ($usuario->segund_apelli ?? '')) }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>{{ $usuario->role ?? 'Cliente' }}</td>
                        <td>{{ $usuario->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="center" colspan="5">No hay usuarios registrados.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
