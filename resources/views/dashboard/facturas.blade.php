<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas - Pague Menos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Facturas solicitadas</h1>
                    <p class="mt-2 text-sm text-slate-500">Aquí aparecen las facturas que los clientes han solicitado.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard.staff') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition">Volver al Dashboard</a>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-10">
            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-700">{{ session('error') }}</div>
            @endif

            <div class="overflow-x-auto rounded-[2rem] border border-pink-100 bg-white shadow-sm">
                <table class="min-w-full table-auto text-left">
                    <thead class="bg-pink-50 text-slate-500 text-xs uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-6 py-4">Factura</th>
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Empleado</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-100 text-sm text-slate-600">
                        @forelse($facturas as $factura)
                        <tr class="hover:bg-pink-50/80 transition">
                            <td class="px-6 py-4 font-semibold text-slate-900">#{{ $factura->id_factura }}</td>
                            <td class="px-6 py-4">{{ $factura->nombre_cliente }}<br><span class="text-xs text-slate-400">{{ $factura->correo_cliente }}</span></td>
                            <td class="px-6 py-4">{{ $factura->fk_id_empleado }}</td>
                            <td class="px-6 py-4 text-pink-600 font-bold">${{ number_format($factura->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $factura->estado === 'aceptada' ? 'bg-emerald-100 text-emerald-700' : 'bg-pink-100 text-pink-700' }}">
                                    {{ ucfirst($factura->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('dashboard.facturas.show', $factura->id_factura) }}" class="inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-4 py-2 text-white text-sm font-semibold hover:bg-pink-700 transition">Ver</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                No hay facturas solicitadas aún.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
