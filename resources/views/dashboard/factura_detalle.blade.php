<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Factura - Pague Menos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Factura #{{ $factura->id_factura }}</h1>
                    <p class="mt-2 text-sm text-slate-500">Revise los datos y acepte la factura para continuar al módulo de ventas.</p>
                </div>
                <a href="{{ route('dashboard.facturas') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition">Volver a facturas</a>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-10 space-y-8">
            <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="rounded-[2rem] bg-white p-8 shadow-sm border border-pink-100">
                    <div class="mb-6 flex items-center justify-between gap-4">
                        <span class="text-sm uppercase tracking-[0.35em] text-pink-500">Factura solicitada</span>
                        <span class="rounded-full bg-pink-100 px-4 py-2 text-sm font-semibold text-pink-700">{{ ucfirst($factura->estado) }}</span>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-3xl bg-pink-50 p-5">
                            <h2 class="text-sm uppercase tracking-[0.35em] text-pink-500">Cliente</h2>
                            <p class="mt-3 font-semibold text-slate-900">{{ $factura->nombre_cliente }}</p>
                            <p class="text-sm text-slate-500">{{ $factura->correo_cliente }}</p>
                            <p class="text-sm text-slate-500">Cédula: {{ $factura->cedula ?? 'No registrada' }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-100 p-5">
                            <h2 class="text-sm uppercase tracking-[0.35em] text-slate-500">Empleado asignado</h2>
                            <p class="mt-3 text-lg font-semibold text-slate-900">#{{ $factura->fk_id_empleado }}</p>
                        </div>
                    </div>
                    <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-6">
                        <h3 class="text-lg font-semibold text-slate-900">Productos solicitados</h3>
                        <div class="mt-4 space-y-4">
                            @foreach($items as $item)
                                <div class="flex flex-col gap-3 rounded-3xl border border-pink-100 p-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $item->nombre_prend }}</p>
                                        <p class="text-sm text-slate-500">Talla: {{ $item->talla_prend }} · Color: {{ $item->nom_color }}</p>
                                        <p class="text-sm text-slate-500">Código: {{ $item->fkpk_codigo_barras }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-pink-600">${{ number_format($item->precio_unitario * $item->cantidad, 0, ',', '.') }}</p>
                                        <p class="text-sm text-slate-500">Cantidad: {{ $item->cantidad }}</p>
                                        <p class="text-sm text-slate-500">Unitario: ${{ number_format($item->precio_unitario, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="rounded-[2rem] bg-white p-8 shadow-sm border border-pink-100">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm uppercase tracking-[0.35em] text-pink-500">Totales</h3>
                            <p class="mt-2 text-3xl font-bold text-slate-900">${{ number_format($factura->total, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-3xl bg-pink-50 p-5 text-sm text-slate-600">
                            <p class="font-semibold text-pink-700">Subtotal</p>
                            <p>${{ number_format($factura->subtotal, 0, ',', '.') }}</p>
                        </div>
                        <form action="{{ route('dashboard.facturas.accept', $factura->id_factura) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full rounded-3xl bg-pink-600 px-5 py-3 text-white font-bold hover:bg-pink-700 transition">Aceptar factura y continuar a ventas</button>
                        </form>
                    </div>
                </aside>
            </section>
        </main>
    </div>
</body>
</html>
