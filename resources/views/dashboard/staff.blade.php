@extends('layouts.app')

@section('title', 'Dashboard - Pague Menos Staff')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="min-h-screen bg-white text-slate-900">
    <div class="flex h-screen overflow-hidden">

        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="w-72 bg-white border-r border-pink-100 text-slate-900 flex flex-col justify-between shrink-0">
            <div class="p-6 space-y-8">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-pink-500 text-white rounded-2xl p-3 shadow-lg shadow-pink-500/20 font-bold">PM</div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-pink-500">PAGUE</p>
                            <p class="text-2xl font-bold tracking-tight text-slate-900">MENOS</p>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-pink-100 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.35em] text-pink-500 mb-2">{{ session('user_role') ?? 'Staff' }}</p>
                        <p class="text-lg font-semibold text-slate-900 leading-tight">{{ session('user_name') ?? 'Usuario' }}</p>
                        <p class="mt-3 text-slate-600 text-sm">Administrador activo</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <a href="#resumen" data-section="resumen" class="sidebar-link active-link flex items-center gap-3 px-4 py-3 rounded-2xl bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm transition">
                        <i class="fa-solid fa-chart-line w-6 text-pink-500"></i>
                        <span class="font-semibold">Resumen</span>
                    </a>
                    <a href="#ventas" data-section="ventas" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-pink-100 hover:text-pink-600 transition">
                        <i class="fa-solid fa-cart-shopping w-6 text-pink-400"></i>
                        Ventas
                    </a>
                    <a href="#inventario" data-section="inventario" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-pink-100 hover:text-pink-600 transition">
                        <i class="fa-solid fa-box-open w-6 text-pink-400"></i>
                        Catálogo / Inventario
                    </a>
                    <a href="#facturas" data-section="facturas" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-pink-100 hover:text-pink-600 transition">
                        <i class="fa-solid fa-file-invoice-dollar w-6 text-pink-400"></i>
                        Facturas
                    </a>
                    <a href="#movimientos" data-section="movimientos" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-pink-100 hover:text-pink-600 transition">
                        <i class="fa-solid fa-arrow-right-arrow-left w-6 text-pink-400"></i>
                        Movimientos
                    </a>
                    <a href="#usuarios" data-section="usuarios" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-pink-100 hover:text-pink-600 transition">
                        <i class="fa-solid fa-users w-6 text-pink-400"></i>
                        Usuarios
                    </a>
                </nav>
            </div>

            <div class="p-6 border-t border-pink-100 space-y-4">
                <div class="rounded-3xl bg-white border border-pink-100 p-4">
                    <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Atención</p>
                    <p class="text-slate-600 text-sm mt-2">Mantén actualizado el inventario para evitar rupturas de stock.</p>
                </div>
                <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl bg-pink-500 text-white font-semibold hover:bg-pink-600 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Cerrar Sesión
                </a>
            </div>
        </aside>

        {{-- ===================== MAIN ===================== --}}
        <main class="flex-1 overflow-y-auto bg-white">
            <div class="px-6 py-6 lg:px-10 lg:py-8">

                {{-- Mensajes de éxito/error --}}
                @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl text-sm font-semibold bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl text-sm font-semibold bg-rose-50 border border-rose-100 text-rose-700 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
                </div>
                @endif

                {{-- Header --}}
                <div class="rounded-[2rem] bg-white p-6 shadow-sm shadow-pink-200/50 border border-pink-100 mb-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-pink-500 mb-2">Panel</p>
                            <h1 class="text-4xl font-extrabold text-slate-900">Dashboard</h1>
                            <p class="text-slate-500 mt-3">Controla tus productos, ventas y movimientos desde un panel limpio en rosado.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full sm:w-auto">
                            <div class="rounded-3xl border border-pink-100 bg-white p-5 shadow-sm">
                                <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Total Productos</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">{{ count($prendas) }}</p>
                            </div>
                            <div class="rounded-3xl border border-pink-100 bg-white p-5 shadow-sm">
                                <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Productos Activos</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $prendas->where('estado',1)->count() }}</p>
                            </div>
                            <div class="rounded-3xl border border-pink-100 bg-white p-5 shadow-sm">
                                <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Total Usuarios</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">{{ count($usuarios) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buscador global --}}
                <div class="rounded-3xl bg-white border border-pink-100 p-5 shadow-sm shadow-pink-200/40 mb-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Buscador Inteligente</p>
                            <p class="text-xs text-slate-400">Escanea un código de barras o escribe para filtrar al instante.</p>
                        </div>
                        <div class="relative w-full lg:w-1/2">
                            <i class="fa-solid fa-barcode absolute left-4 top-1/2 -translate-y-1/2 text-pink-400 text-lg"></i>
                            <input type="text" placeholder="Escribe o escanea el código de barras único..." class="w-full rounded-3xl border border-pink-100 bg-white py-3 pl-12 pr-4 text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100" />
                        </div>
                    </div>
                </div>

                {{-- ===== SECCIÓN: RESUMEN ===== --}}
                <section id="resumen" class="mb-8">
                    <div class="grid gap-6 lg:grid-cols-3 mb-6">
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Ventas Totales</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">$0</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Personal del Sistema</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $usuarios->count() }}</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Prendas Activas</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $prendas->where('estado',1)->count() }}</p>
                        </div>
                    </div>
                </section>

                {{-- ===== SECCIÓN: VENTAS ===== --}}
                <section id="ventas" class="mb-8 hidden">
                    <div id="alertBoxVentas" class="hidden mb-6 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in"></div>

                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                        <div class="xl:col-span-2 bg-white border border-pink-100 p-8 rounded-[2rem] shadow-sm space-y-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-pink-50 pb-4">
                                <div class="flex items-center gap-3 text-pink-500">
                                    <i class="fa-solid fa-cash-register text-2xl"></i>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-900">Registrar Venta u Operación</h2>
                                        <p class="text-xs text-slate-400 font-medium">Facturación fluida para prendas y calzado.</p>
                                    </div>
                                </div>
                                <button type="button" id="btnAlertaStock" class="inline-flex items-center gap-2 text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200 px-4 py-2 rounded-2xl hover:bg-amber-100 transition">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Avisar Admin sobre Bajo Stock
                                </button>
                            </div>

                            <form action="{{ route('venta.store') }}" method="POST" id="formTransaccion" class="space-y-6">
                                @csrf
                                {{-- Campo oculto para pasar el código escaneado al backend --}}
                                <input type="hidden" name="codigo_barras" id="hidden_codigo_barras">
                                <input type="hidden" name="precio_unitario" id="hidden_precio_unitario">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Tipo de Transacción</label>
                                        <select name="tipo_proceso" id="tipo_proceso" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-bold text-pink-600 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                                            <option value="venta">🛒 Registrar Venta Inmediata</option>
                                            <option value="apartado">📌 Apartar Prenda / Separado</option>
                                            <option value="cambio">🔄 Realizar Cambio de Prenda</option>
                                            <option value="devolucion">↩️ Procesar Devolución (Kardex)</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Asignar Cliente</label>
                                        <select name="fk_id_cliente" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                                            <option value="1">Cliente General / Ocasional</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="bg-pink-50/40 border border-pink-100/70 p-5 rounded-2xl space-y-2">
                                    <label class="block text-xs uppercase tracking-wider font-bold text-pink-600 flex items-center justify-between">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-barcode text-sm"></i> Escanear Código de Barras Único</span>
                                        <span id="searchStatusVentas" class="text-[10px] font-bold text-pink-500 bg-white border border-pink-200 px-2 py-0.5 rounded-md hidden">Buscando...</span>
                                    </label>
                                    <input type="text" id="codigo_barras_venta" name="codigo_barras" required autocomplete="off"
                                        placeholder="Pasa el lector láser o digita el código de barras..."
                                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3.5 text-base text-slate-800 font-mono font-bold focus:border-pink-400 focus:ring-4 focus:ring-pink-50 outline-none transition" />
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-400">Prenda Identificada</label>
                                        <input type="text" id="nombre_prend_venta" readonly placeholder="Esperando escaneo..."
                                            class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700 outline-none" />
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-400">Variación (Talla / Color)</label>
                                        <input type="text" id="detalles_prend_venta" readonly placeholder="—"
                                            class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-500 outline-none" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-400">Precio Base ($)</label>
                                        <input type="number" id="precio_unitario_venta" name="precio_unitario" readonly placeholder="0"
                                            class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-mono font-bold text-slate-800 outline-none" />
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-400">Stock Actual en Sistema</label>
                                        <input type="text" id="stock_disponible_venta" readonly placeholder="0 uds"
                                            class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-600 outline-none" />
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-600 flex items-center gap-1"><i class="fa-solid fa-arrow-up-9-0 text-pink-500"></i> Cantidad</label>
                                        <input type="number" id="cantidad_vendida_venta" name="cantidad_vendida" required min="1" disabled value="1"
                                            class="w-full rounded-xl border border-pink-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-800 outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-50 transition" />
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-pink-50 flex justify-end">
                                    <button type="submit" id="btnSubmitVenta" disabled class="w-full sm:w-auto bg-slate-200 text-slate-400 font-bold text-sm px-8 py-3.5 rounded-2xl transition flex items-center justify-center gap-2 cursor-not-allowed">
                                        <i class="fa-solid fa-check"></i> Procesar Registro
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="bg-slate-900 text-white p-8 rounded-[2rem] shadow-xl space-y-6 sticky top-6">
                            <span class="text-xs font-black uppercase tracking-widest text-pink-400">Resumen en Caja</span>
                            <div class="space-y-4 border-b border-slate-800 pb-6">
                                <div class="flex justify-between text-xs font-medium text-slate-400">
                                    <span>Subtotal Operación:</span>
                                    <span id="resumen_subtotal_venta">$0</span>
                                </div>
                                <div class="flex justify-between text-xs font-medium text-slate-400">
                                    <span>Impuestos incluidos:</span>
                                    <span>$0</span>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Transacción</p>
                                <h2 class="text-4xl font-black text-white tracking-tight" id="resumen_total_venta">$0</h2>
                            </div>
                            <div class="bg-slate-800/70 p-4 rounded-2xl border border-slate-800 text-xs text-slate-400 leading-relaxed">
                                <i class="fa-solid fa-circle-info text-pink-400 mr-1"></i> El sistema ingresará o retirará las prendas del inventario de forma automática según la operación elegida.
                            </div>
                        </div>
                    </div>

                    {{-- ===== HISTORIAL DE VENTAS DENTRO DE LA PESTAÑA VENTAS ===== --}}
                    <div class="mt-8 bg-white border border-pink-100 p-8 rounded-[2rem] shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-slate-900">
                                <i class="fa-solid fa-clock-rotate-left text-pink-500 mr-2"></i> Historial de Operaciones
                            </h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-pink-100 text-slate-400 text-xs uppercase tracking-wider">
                                        <th class="pb-3 font-semibold">ID Transacción</th>
                                        <th class="pb-3 font-semibold">Fecha</th>
                                        <th class="pb-3 font-semibold">Total</th>
                                        <th class="pb-3 font-semibold">Cant. Prendas</th>
                                        <th class="pb-3 font-semibold">ID Cliente</th>
                                        <th class="pb-3 font-semibold">ID Empleado</th> {{-- NUEVA COLUMNA --}}
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-pink-50">
                                    @if(isset($ventas) && count($ventas) > 0)
                                        @foreach($ventas as $v)
                                        <tr class="hover:bg-pink-50/50 transition">
                                            <td class="py-4 font-bold text-slate-700">#{{ $v->id_venta }}</td>
                                            <td class="py-4 text-slate-500">{{ $v->fecha_venta }}</td>
                                            <td class="py-4 font-black text-pink-600">${{ number_format($v->total, 0, ',', '.') }}</td>
                                            <td class="py-4 text-slate-600 font-medium">{{ $v->cantidad }}</td>
                                            <td class="py-4 text-slate-500">
                                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded-lg text-xs">{{ $v->fk_id_cliente }}</span>
                                            </td>
                                            {{-- DATO DEL EMPLEADO QUE PEDISTE --}}
                                            <td class="py-4 text-slate-500">
                                                <span class="bg-pink-100 text-pink-700 font-bold px-2 py-1 rounded-lg text-xs">
                                                    {{ $v->fk_id_empleado ?? 'Admin' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="py-8 text-center">
                                                <div class="inline-flex flex-col items-center justify-center p-6 bg-pink-50/50 rounded-2xl border border-dashed border-pink-200">
                                                    <i class="fa-solid fa-receipt text-3xl text-pink-200 mb-2"></i>
                                                    <span class="text-slate-400 font-medium">No hay ventas registradas en la base de datos en este momento.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>

                {{-- ===== SECCIÓN: INVENTARIO ===== --}}
                <section id="inventario" class="mb-8 hidden">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Catálogo / Inventario</h2>
                        </div>
                        {{-- CORRECCIÓN: el id del modal debe existir en el DOM --}}
                        <button onclick="toggleModal('createModal')" class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-5 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
                            <i class="fa-solid fa-plus"></i> Agregar Prenda
                        </button>
                    </div>
                    <div class="grid gap-5 lg:grid-cols-2">
                        @foreach($prendas as $p)
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-start gap-4">
                                @if($p->imagen_prend)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($p->imagen_prend) }}"
                                         alt="{{ $p->nombre_prend }}"
                                         class="h-20 w-20 rounded-3xl object-cover shrink-0" />
                                @else
                                    <div class="h-20 w-20 rounded-3xl bg-pink-100 flex items-center justify-center text-pink-500 text-3xl font-bold shrink-0">
                                        {{ strtoupper(substr($p->nombre_prend, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $p->nombre_prend }}</h3>
                                            <p class="text-xs text-slate-400">Código: {{ $p->codigo_barras ?? 'No asignado' }}</p>
                                        </div>
                                        <span class="text-lg font-bold text-pink-500">${{ number_format($p->precio, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="mt-4 grid grid-cols-2 gap-2">
                                        <div class="rounded-2xl bg-pink-50/60 p-2 text-xs text-center text-slate-700">Stock: {{ $p->stock }}</div>
                                        <div class="rounded-2xl bg-pink-50/60 p-2 text-xs text-center text-slate-700">Talla: {{ $p->talla_prend }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 flex items-center justify-between">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $p->estado == 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $p->estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                                <div class="flex gap-2">
                                    <button
                                        onclick="abrirModalEditar(
                                            '{{ $p->codigo_barras }}',
                                            '{{ addslashes($p->nombre_prend) }}',
                                            '{{ addslashes($p->descripcion_prend) }}',
                                            {{ $p->precio }},
                                            {{ $p->stock }},
                                            {{ $p->min_stock }},
                                            {{ $p->max_stock }},
                                            {{ $p->fk_id_genero }},
                                            {{ $p->fk_idt_prendas }},
                                            {{ $p->fk_id_color }},
                                            {{ $p->estado }}
                                        )"
                                        class="rounded-2xl bg-pink-100 px-4 py-2 text-xs font-semibold text-pink-600 hover:bg-pink-200 transition">
                                        Editar
                                    </button>
                                    <form action="{{ route('prenda.destroy', $p->codigo_barras) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar prenda?')" class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200 transition">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                {{-- ===== SECCIÓN: FACTURAS ===== --}}
                <section id="facturas" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Facturas</h2>
                        <p class="text-sm text-slate-400">Módulo de facturas en construcción.</p>
                    </div>
                </section>

                {{-- ===== SECCIÓN: MOVIMIENTOS ===== --}}
                <section id="movimientos" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-slate-900">Kardex / Movimientos de Inventario</h2>
                            <p class="text-xs text-slate-400 mt-1">Historial detallado de entradas, salidas, apartados y devoluciones con fecha.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-pink-100 text-slate-400 text-xs uppercase tracking-wider">
                                        <th class="pb-3 font-semibold">Fecha y Hora</th>
                                        <th class="pb-3 font-semibold">Prenda</th>
                                        <th class="pb-3 font-semibold">Tipo Movimiento</th>
                                        <th class="pb-3 font-semibold">Cantidad</th>
                                        <th class="pb-3 font-semibold">Responsable</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-pink-50">
                                    <tr>
                                        <td class="py-3 text-slate-500">2026-05-20 14:35</td>
                                        <td class="py-3 font-medium text-slate-900">Ejemplo 1 sin funcionamiento xd</td>
                                        <td class="py-3"><span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full font-medium">Apartado</span></td>
                                        <td class="py-3 text-slate-600">1 unidad</td>
                                        <td class="py-3 text-slate-500">Staff Admin</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- ===== SECCIÓN: USUARIOS ===== --}}
                <section id="usuarios" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">Cuentas y Usuarios</h2>
                                <p class="text-xs text-slate-400 mt-1">Lista completa de personal administrador, staff y clientes registrados.</p>
                            </div>
                            <button class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-4 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
                                <i class="fa-solid fa-user-plus"></i> Registrar Usuario
                            </button>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                            @foreach($usuarios as $user)
                            <div class="p-5 border border-pink-100 rounded-3xl bg-white shadow-sm flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-base leading-tight">{{ $user->name }}</h4>
                                            <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-block text-[11px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full bg-pink-50 text-pink-600">
                                        {{ $user->role ?? 'Cliente' }}
                                    </span>
                                </div>
                                <div class="mt-4 pt-3 border-t border-pink-50 flex justify-end gap-2">
                                    <button class="text-xs font-semibold text-pink-500 hover:underline">Editar</button>
                                    <form action="{{ route('usuario.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar acceso de usuario?')" class="text-xs font-semibold text-slate-400 hover:text-rose-500 transition">Remover</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>
</div>

{{-- =====================================================================
     MODAL: CREAR PRENDA
     FIX: Este modal faltaba en el HTML original, causando que el botón
     "Agregar Prenda" no hiciera nada al llamar toggleModal('createModal').
======================================================================= --}}
<div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl p-8 relative max-h-[90vh] overflow-y-auto">
        <button onclick="toggleModal('createModal')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 transition text-xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-pink-500 text-white rounded-2xl p-3 shadow-lg shadow-pink-500/20">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Agregar Nueva Prenda</h2>
                <p class="text-xs text-slate-400">Completa todos los campos para registrar en el inventario.</p>
            </div>
        </div>

        <form action="{{ route('prenda.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Código de Barras *</label>
                    <input type="text" name="codigo_barras" required maxlength="50" placeholder="Ej: 7701234567890"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Nombre *</label>
                    <input type="text" name="nombre_prend" required maxlength="25" placeholder="Ej: Camiseta Básica"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Descripción *</label>
                <input type="text" name="descripcion_prend" required maxlength="35" placeholder="Ej: Camiseta de algodón manga corta"
                    class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Precio (COP) *</label>
                    <input type="number" name="precio" required min="0" placeholder="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Inicial *</label>
                    <input type="number" name="stock" required min="0" placeholder="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Mínimo *</label>
                    <input type="number" name="min_stock" required min="0" placeholder="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Máximo *</label>
                    <input type="number" name="max_stock" required min="0" placeholder="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Género *</label>
                    <select name="fk_id_genero" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                        <option value="">— Selecciona —</option>
                        @foreach($generos as $g)
                            <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Talla *</label>
                    <select name="fk_idt_prendas" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                        <option value="">— Selecciona —</option>
                        @foreach($tallas as $t)
                            <option value="{{ $t->idt_prendas }}">{{ $t->talla_prend }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Color *</label>
                    <select name="fk_id_color" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                        <option value="">— Selecciona —</option>
                        @foreach($colores as $c)
                            <option value="{{ $c->id_color }}">{{ $c->nom_color }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Imagen (opcional)</label>
                <input type="file" name="imagen_prend" accept="image/*"
                    class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 transition file:mr-3 file:py-1 file:px-3 file:rounded-xl file:border-0 file:bg-pink-50 file:text-pink-600 file:font-semibold file:text-xs" />
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-pink-50">
                <button type="button" onclick="toggleModal('createModal')" class="px-6 py-3 rounded-2xl border border-pink-100 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Cancelar
                </button>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-pink-500 text-white text-sm font-bold hover:bg-pink-600 transition shadow-lg shadow-pink-500/20">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Prenda
                </button>
            </div>
        </form>
    </div>
</div>

{{-- =====================================================================
     MODAL: EDITAR PRENDA
======================================================================= --}}
<div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl p-8 relative max-h-[90vh] overflow-y-auto">
        <button onclick="toggleModal('editModal')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 transition text-xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-pink-100 text-pink-600 rounded-2xl p-3">
                <i class="fa-solid fa-pen"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Editar Prenda</h2>
                <p class="text-xs text-slate-400">Modifica los datos y guarda los cambios.</p>
            </div>
        </div>

        <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Código de Barras *</label>
                    <input type="text" id="edit_codigo_barras" name="codigo_barras" required maxlength="50"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Nombre *</label>
                    <input type="text" id="edit_nombre_prend" name="nombre_prend" required maxlength="25"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Descripción *</label>
                <input type="text" id="edit_descripcion_prend" name="descripcion_prend" required maxlength="35"
                    class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Precio (COP) *</label>
                    <input type="number" id="edit_precio" name="precio" required min="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock *</label>
                    <input type="number" id="edit_stock" name="stock" required min="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Mínimo *</label>
                    <input type="number" id="edit_min_stock" name="min_stock" required min="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Máximo *</label>
                    <input type="number" id="edit_max_stock" name="max_stock" required min="0"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Género *</label>
                    <select id="edit_fk_id_genero" name="fk_id_genero" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                        @foreach($generos as $g)
                            <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Talla *</label>
                    <select id="edit_fk_idt_prendas" name="fk_idt_prendas" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                        @foreach($tallas as $t)
                            <option value="{{ $t->idt_prendas }}">{{ $t->talla_prend }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Color *</label>
                    <select id="edit_fk_id_color" name="fk_id_color" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                        @foreach($colores as $c)
                            <option value="{{ $c->id_color }}">{{ $c->nom_color }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Estado *</label>
                    <select id="edit_estado" name="estado" required class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Nueva Imagen (opcional)</label>
                <input type="file" name="imagen_prend" accept="image/*"
                    class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 transition file:mr-3 file:py-1 file:px-3 file:rounded-xl file:border-0 file:bg-pink-50 file:text-pink-600 file:font-semibold file:text-xs" />
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-pink-50">
                <button type="button" onclick="toggleModal('editModal')" class="px-6 py-3 rounded-2xl border border-pink-100 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Cancelar
                </button>
                <button type="submit" class="px-8 py-3 rounded-2xl bg-pink-500 text-white text-sm font-bold hover:bg-pink-600 transition shadow-lg shadow-pink-500/20">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Actualizar Prenda
                </button>
            </div>
        </form>
    </div>
</div>

{{-- =====================================================================
     SCRIPTS
======================================================================= --}}
<script>
    // ── Helpers de modal ──────────────────────────────────────────────────
    function toggleModal(modalId) {
        document.getElementById(modalId).classList.toggle('hidden');
    }

    // Rellenar y abrir modal de edición
    function abrirModalEditar(codigo, nombre, descripcion, precio, stock, min_stock, max_stock, genero, talla, color, estado) {
        document.getElementById('edit_codigo_barras').value    = codigo;
        document.getElementById('edit_nombre_prend').value     = nombre;
        document.getElementById('edit_descripcion_prend').value = descripcion;
        document.getElementById('edit_precio').value           = precio;
        document.getElementById('edit_stock').value            = stock;
        document.getElementById('edit_min_stock').value        = min_stock;
        document.getElementById('edit_max_stock').value        = max_stock;
        document.getElementById('edit_fk_id_genero').value     = genero;
        document.getElementById('edit_fk_idt_prendas').value   = talla;
        document.getElementById('edit_fk_id_color').value      = color;
        document.getElementById('edit_estado').value           = estado;
        // Ajustar la acción del formulario con el código de barras correcto
        document.getElementById('editForm').action = '/dashboard/prenda/' + encodeURIComponent(codigo);
        toggleModal('editModal');
    }

    // ── Navegación SPA (pestañas sidebar) ────────────────────────────────
    function activateDashboardTab(sectionId) {
        const sections = ['resumen','ventas','inventario','facturas','movimientos','usuarios'];
        sections.forEach((id) => {
            const section = document.getElementById(id);
            if (section) section.classList.toggle('hidden', id !== sectionId);
        });
    }

    document.querySelectorAll('.sidebar-link').forEach((link) => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSection = this.dataset.section;
            if (!targetSection) return;

            activateDashboardTab(targetSection);

            document.querySelectorAll('.sidebar-link').forEach((l) => {
                l.classList.remove('bg-pink-500/10', 'border-pink-100', 'text-pink-600', 'shadow-sm', 'active-link');
                l.classList.add('text-slate-600');
            });

            this.classList.add('bg-pink-500/10', 'border-pink-100', 'text-pink-600', 'shadow-sm', 'active-link');
        });
    });
    // ── Escáner de código de barras con DEBOUNCE ─────────────────────────
    // FIX: Se añadió debounce de 400ms para evitar que peticiones parciales
    // (carácter por carácter del escáner) pisen la respuesta del código completo.
    // FIX: Se lee data.message del JSON en vez de mostrar un mensaje genérico.
    // FIX: encodeURIComponent() protege códigos con caracteres especiales en la URL.
    let debounceTimer = null;
    document.getElementById('codigo_barras_venta').addEventListener('input', function(e) {
        const codigo = e.target.value.trim();
        const statusLabel = document.getElementById('searchStatusVentas');

        clearTimeout(debounceTimer);

        if (codigo.length < 3) {
            resetFormularioVenta();
            return;
        }

        statusLabel.classList.remove('hidden');

        debounceTimer = setTimeout(() => {
            const codigoCodificado = encodeURIComponent(codigo);

            fetch(`/dashboard/prenda/buscar/${codigoCodificado}`)
                .then(response => response.json())
                .then(data => {
                    statusLabel.classList.add('hidden');

                    if (data.success) {
                        const prenda = data.prenda;

                        document.getElementById('nombre_prend_venta').value      = prenda.nombre_prend;
                        document.getElementById('detalles_prend_venta').value    = `Talla: ${prenda.talla_prend ?? 'N/A'} | Color: ${prenda.nom_color ?? 'N/A'}`;
                        document.getElementById('precio_unitario_venta').value   = prenda.precio;
                        document.getElementById('stock_disponible_venta').value  = `${prenda.stock} unidades`;
                        // Campos ocultos que se envían al backend
                        document.getElementById('hidden_codigo_barras').value   = prenda.codigo_barras;
                        document.getElementById('hidden_precio_unitario').value = prenda.precio;

                        const cantidadInput = document.getElementById('cantidad_vendida_venta');
                        cantidadInput.disabled = false;

                        const tipoProceso = document.getElementById('tipo_proceso').value;
                        if (tipoProceso === 'venta' || tipoProceso === 'apartado') {
                            cantidadInput.max = prenda.stock;
                        } else {
                            cantidadInput.removeAttribute('max');
                        }
                        cantidadInput.value = 1;
                        const btn = document.getElementById('btnSubmitVenta');
                        btn.disabled = false;
                        btn.className = "w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition shadow-lg shadow-pink-500/20 flex items-center justify-center gap-2 cursor-pointer";
                        calcularTotalesVenta();
                        showFeedbackVentas('Prenda cargada con éxito.', 'emerald');
                    } else {
                        resetFormularioVenta();
                        showFeedbackVentas(data.message || 'Código no registrado o inactivo.', 'rose');
                    }
                })
                .catch(() => {
                    statusLabel.classList.add('hidden');
                    resetFormularioVenta();
                    showFeedbackVentas('Error de conexión al consultar el código.', 'rose');
                });
        }, 400);
    });

    document.getElementById('cantidad_vendida_venta').addEventListener('input', calcularTotalesVenta);
    document.getElementById('tipo_proceso').addEventListener('change', function() {
        if (document.getElementById('nombre_prend_venta').value !== '') {
            calcularTotalesVenta();
        }
    });
    function calcularTotalesVenta() {
        const precio    = parseFloat(document.getElementById('precio_unitario_venta').value) || 0;
        const cantidad  = parseInt(document.getElementById('cantidad_vendida_venta').value) || 1;
        const tipoProceso = document.getElementById('tipo_proceso').value;

        let total = precio * cantidad;
        if (tipoProceso === 'devolucion') total = total * -1;

        const formatter = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        });
        document.getElementById('resumen_subtotal_venta').innerText = formatter.format(total);
        document.getElementById('resumen_total_venta').innerText    = formatter.format(total);
    }

    function resetFormularioVenta() {
        document.getElementById('nombre_prend_venta').value     = '';
        document.getElementById('detalles_prend_venta').value   = '';
        document.getElementById('precio_unitario_venta').value  = '';
        document.getElementById('stock_disponible_venta').value = '';

        const cantidadInput = document.getElementById('cantidad_vendida_venta');
        cantidadInput.disabled = true;
        cantidadInput.value = 1;

        const btn = document.getElementById('btnSubmitVenta');
        btn.disabled = true;
        btn.className = "w-full sm:w-auto bg-slate-200 text-slate-400 font-bold text-sm px-8 py-3.5 rounded-2xl transition flex items-center justify-center gap-2 cursor-not-allowed";

        document.getElementById('resumen_subtotal_venta').innerText = '$0';
        document.getElementById('resumen_total_venta').innerText    = '$0';
    }

    function showFeedbackVentas(msg, color) {
        const alertBox = document.getElementById('alertBoxVentas');
        alertBox.innerText = msg;
        alertBox.className = `mb-6 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm bg-${color}-50 border border-${color}-100 text-${color}-700`;
        alertBox.classList.remove('hidden');
        setTimeout(() => { alertBox.classList.add('hidden'); }, 4000);
    }

    document.getElementById('btnAlertaStock').addEventListener('click', function() {
        alert('📢 Notificación de stock crítico enviada de forma interna al perfil del Administrador.');
    });
    document.getElementById('codigo_barras_crear').addEventListener('input', function() {
    const codigo = this.value.trim();
    const errorMsg = document.getElementById('error_codigo_existente');
    const submitBtn = this.closest('form').querySelector('button[type="submit"]');

    if (codigo.length < 2) {
        errorMsg.classList.add('hidden');
        if(submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        return;
    }

    // Llama directamente a la nueva ruta que mapeamos en web.php
    fetch(`/dashboard/prenda/verificar-codigo?codigo=${encodeURIComponent(codigo)}`)
        .then(response => response.json())
        .then(data => {
            if (data.existe) {
                errorMsg.classList.remove('hidden'); // Muestra la alerta de "Ya registrado"
                if(submitBtn) {
                    submitBtn.disabled = true; // Bloquea el guardado
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                errorMsg.classList.add('hidden'); // Oculta el error si está libre
                if(submitBtn) {
                    submitBtn.disabled = false; // Desbloquea el botón
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        })
        .catch(err => console.error("Error al validar código:", err));
});
</script>
@endsection