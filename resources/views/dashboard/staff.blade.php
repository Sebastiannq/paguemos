@extends('layouts.app')

@section('title', 'Dashboard - Pague Menos Staff')

@section('content')
@php
    $activeSection = session('active_section', request('section', 'resumen'));
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Ocultar icono nativo de revelar contraseña en navegadores que lo muestren */
    #createUserModal input#new_user_password::-ms-reveal,
    #createUserModal input#new_user_password::-ms-clear,
    #createUserModal input#new_user_password::-webkit-textfield-decoration-button {
        display: none !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    <a href="#resumen" data-section="resumen" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ $activeSection == 'resumen' ? 'active-link bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm' : 'text-slate-600 hover:bg-pink-100 hover:text-pink-600' }}">
                        <i class="fa-solid fa-chart-line w-6 text-pink-500"></i>
                        <span class="font-semibold">Resumen</span>
                    </a>
                    <a href="#ventas" data-section="ventas" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ $activeSection == 'ventas' ? 'active-link bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm' : 'text-slate-600 hover:bg-pink-100 hover:text-pink-600' }}">
                        <i class="fa-solid fa-cart-shopping w-6 text-pink-400"></i>
                        Ventas
                    </a>
                    <a href="#inventario" data-section="inventario" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ $activeSection == 'inventario' ? 'active-link bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm' : 'text-slate-600 hover:bg-pink-100 hover:text-pink-600' }}">
                        <i class="fa-solid fa-box-open w-6 text-pink-400"></i>
                        Catálogo / Inventario
                    </a>
                    <!-- <a href="#facturas" data-section="facturas" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ $activeSection == 'facturas' ? 'active-link bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm' : 'text-slate-600 hover:bg-pink-100 hover:text-pink-600' }}">
                        <i class="fa-solid fa-file-invoice-dollar w-6 text-pink-400"></i>
                        Facturas
                    </a>
                    <a href="#movimientos" data-section="movimientos" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ $activeSection == 'movimientos' ? 'active-link bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm' : 'text-slate-600 hover:bg-pink-100 hover:text-pink-600' }}">
                        <i class="fa-solid fa-arrow-right-arrow-left w-6 text-pink-400"></i>
                        Movimientos
                    </a> -->
                    <a href="#usuarios" data-section="usuarios" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ $activeSection == 'usuarios' ? 'active-link bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm' : 'text-slate-600 hover:bg-pink-100 hover:text-pink-600' }}">
                        <i class="fa-solid fa-users w-6 text-pink-400"></i>
                        Usuarios
                    </a>
                </nav>
            </div>

            <div class="p-6 border-t border-pink-100 space-y-4">
                <div class="rounded-3xl bg-white border border-pink-100 p-4">
                    <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Atención</p>
                    <p class="text-slate-600 text-sm mt-2">Mantén actualizado el inventario para evitar rupturas de stock.</p>

                <!-- MODAL: EDITAR USUARIO -->
                <div id="userModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
                    <div class="bg-white rounded-[1rem] shadow-2xl w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">
                        <button onclick="toggleModal('userModal')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition text-xl"><i class="fa-solid fa-xmark"></i></button>
                        <h3 class="text-lg font-bold mb-2">Editar Usuario</h3>
                        <form id="userEditForm" action="" method="POST" class="space-y-3">
                            @csrf @method('PUT')
                            <input type="hidden" id="user_id_input" name="id_usuario" />
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <input type="text" id="primer_nom" name="primer_nom" placeholder="Primer Nombre" required class="w-full rounded-xl border px-3 py-2" />
                                <input type="text" id="segund_nom" name="segund_nom" placeholder="Segundo Nombre" class="w-full rounded-xl border px-3 py-2" />
                                <input type="text" id="primer_apelli" name="primer_apelli" placeholder="Primer Apellido" required class="w-full rounded-xl border px-3 py-2" />
                                <input type="text" id="segund_apelli" name="segund_apelli" placeholder="Segundo Apellido" class="w-full rounded-xl border px-3 py-2" />
                            </div>
                            <div>
                                <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required class="w-full rounded-xl border px-3 py-2" />
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <select id="role" name="role" class="rounded-xl border px-3 py-2 w-1/2">
                                    <option value="">- Rol (opcional) -</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="empleado">Empleado</option>
                                    <option value="cliente">Cliente</option>
                                </select>
                                <select id="estado_select" name="estado" class="rounded-xl border px-3 py-2 w-1/2">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" onclick="toggleUserEstado()" id="toggleEstadoBtn" class="px-4 py-2 rounded-xl bg-amber-100 text-amber-700">Inactivar</button>
                                <button type="submit" class="px-4 py-2 rounded-xl bg-pink-500 text-white">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
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

                

                {{-- ===== SECCIÓN: RESUMEN ===== --}}
                <section id="resumen" class="mb-8 {{ $activeSection !== 'resumen' ? 'hidden' : '' }}">
                    <div class="grid gap-6 lg:grid-cols-3 mb-6">
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Ventas Totales</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">${{ number_format($totalVentas ?? 0, 0, ',', '.') }}</p>
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
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Prendas más vendidas</p>
                                <p class="mt-1 text-sm text-slate-500">Top productos vendidos en 2026.</p>
                            </div>
                            <span class="text-xs font-semibold text-slate-400">Último lapso 2026</span>
                        </div>
                        <div class="relative">
                            <canvas id="topPrendasDonut" height="320"></canvas>
                        </div>
                    </div>
                </section>

                {{-- ===== SECCIÓN: VENTAS ===== --}}
                <section id="ventas" class="mb-8 {{ $activeSection !== 'ventas' ? 'hidden' : '' }}">
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
                                <input type="hidden" name="carrito_items" id="carrito_items_hidden" value="[]">

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
                                    <input type="text" id="codigo_barras_venta" autocomplete="off"
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
                                        <input type="number" id="precio_unitario_venta" readonly placeholder="0"
                                            class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-mono font-bold text-slate-800 outline-none" />
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-400">Stock Actual en Sistema</label>
                                        <input type="text" id="stock_disponible_venta" readonly placeholder="0 uds"
                                            class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-600 outline-none" />
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-semibold text-slate-600 flex items-center gap-1"><i class="fa-solid fa-arrow-up-9-0 text-pink-500"></i> Cantidad</label>
                                        <input type="number" id="cantidad_vendida_venta" min="1" disabled value="1"
                                            class="w-full rounded-xl border border-pink-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-800 outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-50 transition" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                                    <div></div>
                                    <div class="flex justify-end">
                                        <button type="button" id="btnAgregarAlCarrito" disabled class="w-full sm:w-auto bg-slate-200 text-slate-400 font-bold text-sm px-8 py-3.5 rounded-2xl transition flex items-center justify-center gap-2 cursor-not-allowed">
                                            <i class="fa-solid fa-cart-plus"></i> Agregar al carrito
                                        </button>
                                    </div>
                                </div>

                                <div class="border border-pink-100 rounded-3xl overflow-hidden">
                                    <table class="w-full text-left border-collapse">
                                        <thead class="bg-pink-50 text-slate-500 text-xs uppercase tracking-wider">
                                            <tr>
                                                <th class="p-4 font-semibold">Prenda</th>
                                                <th class="p-4 font-semibold text-center">Cant.</th>
                                                <th class="p-4 font-semibold text-right">Precio</th>
                                                <th class="p-4 font-semibold text-right">Subtotal</th>
                                                <th class="p-4 font-semibold text-center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ventaCarritoBody" class="text-sm divide-y divide-pink-50">
                                            <tr id="ventaCarritoVacio">
                                                <td colspan="5" class="p-8 text-center text-slate-400 font-medium">No hay prendas agregadas al carrito.</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
<section id="inventario" class="mb-8 {{ $activeSection !== 'inventario' ? 'hidden' : '' }}">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Catálogo / Inventario</h2>
        </div>
        {{-- CORRECCIÓN: el id del modal debe existir en el DOM --}}
        <button onclick="toggleModal('createModal')" class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-5 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
            <i class="fa-solid fa-plus"></i> Agregar Prenda
        </button>
    </div>
    <div class="grid gap-4 lg:grid-cols-[1fr_auto] items-end mb-6">
        <div class="space-y-2">
            <label for="inventoryBarcodeSearch" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Buscar por código de barras</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input id="inventoryBarcodeSearch" type="search" placeholder="Ej: 7701234567890" class="w-full rounded-2xl border border-pink-100 bg-white px-12 py-3 text-sm text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
            </div>
        </div>
        <div class="space-y-2">
            <label for="inventoryGeneroFilter" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Filtrar por género</label>
            <select id="inventoryGeneroFilter" class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                <option value="">Todos los géneros</option>
                @foreach($generos as $g)
                    <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <p id="inventoryNoResults" class="mb-6 hidden rounded-2xl bg-rose-50 border border-rose-100 p-4 text-sm font-semibold text-rose-700">No se encontró ninguna prenda con esos criterios.</p>
    <div class="grid gap-5 lg:grid-cols-2">
        @foreach($prendas as $p)
        <div class="product-card rounded-3xl bg-white border border-pink-100 p-6 shadow-sm hover:shadow-md transition" data-genero="{{ $p->fk_id_genero }}" data-codigo="{{ strtolower($p->codigo_barras) }}">
            <div class="flex items-start gap-4">
                
                @if($p->imagen_url)
    <img src="{{ $p->imagen_url }}" alt="{{ $p->nombre_prend }}" class="w-24 h-24 object-cover rounded-2xl border border-slate-100">
@else
    <img src="{{ asset('images/default.png') }}" alt="Sin imagen" class="w-24 h-24 object-cover rounded-2xl border border-slate-100">
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
                <section id="facturas" class="mb-8 {{ $activeSection !== 'facturas' ? 'hidden' : '' }}">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Facturas</h2>
                        <p class="text-sm text-slate-400">Módulo de facturas en construcción.</p>
                    </div>
                </section>

                <!-- {{-- ===== SECCIÓN: MOVIMIENTOS ===== --}}
                <section id="movimientos" class="mb-8 {{ $activeSection !== 'movimientos' ? 'hidden' : '' }}">
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
                </section> -->

                {{-- ===== SECCIÓN: USUARIOS ===== --}}
                <section id="usuarios" class="mb-8 {{ $activeSection !== 'usuarios' ? 'hidden' : '' }}">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">Cuentas y Usuarios</h2>
                                <p class="text-xs text-slate-400 mt-1">Lista completa de personal administrador, staff y clientes registrados.</p>
                            </div>
                            <button onclick="toggleModal('createUserModal')" class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-4 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
                                <i class="fa-solid fa-user-plus"></i> Registrar Usuario
                            </button>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                            <div class="space-y-2 w-full sm:w-auto">
                                <label for="userRoleFilter" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Filtrar por rol</label>
                                <select id="userRoleFilter" class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition">
                                    <option value="">Todos los roles</option>
                                    @foreach($roles as $role)
                                        <option value="{{ strtolower($role->nom_rol) }}">{{ ucfirst($role->nom_rol) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="userNoResults" class="hidden rounded-2xl bg-rose-50 border border-rose-100 p-4 text-sm font-semibold text-rose-700">No se encontró ningún usuario con ese rol.</div>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                            @foreach($usuarios as $user)
                            <div id="user-card-{{ $user->id_usuario }}" data-role="{{ strtolower($user->role ?? 'cliente') }}" onclick="if (event.target.closest('button')) return; abrirUsuarioModal({{ $user->id_usuario }})" class="p-5 border border-pink-100 rounded-3xl bg-white shadow-sm flex flex-col justify-between cursor-pointer hover:shadow-lg hover:-translate-y-1 transition-transform">
                                <div>
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr(($user->primer_nom ?? '') . ($user->primer_apelli ?? ''), 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-base leading-tight">{{ trim($user->primer_nom . ' ' . ($user->segund_nom ?? '') . ' ' . $user->primer_apelli . ' ' . ($user->segund_apelli ?? '')) }}</h4>
                                            <p class="text-xs text-slate-400">{{ $user->correo }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-block text-[11px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full bg-pink-50 text-pink-600">
                                            {{ $user->role ?? 'Cliente' }}
                                        </span>
                                        <span id="status-{{ $user->id_usuario }}" class="inline-block text-[11px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $user->estado == 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $user->estado == 1 ? 'Activo' : 'Inactivo' }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-pink-50 flex justify-end gap-2">
                                    <button
                                        type="button"
                                        data-delete-name="{{ trim($user->primer_nom . ' ' . ($user->segund_nom ?? '') . ' ' . $user->primer_apelli . ' ' . ($user->segund_apelli ?? '')) }}"
                                        data-delete-email="{{ $user->correo }}"
                                        data-delete-url="{{ route('usuario.destroy', $user->id_usuario) }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); openDeleteUserConfirmFromBtn(this)"
                                        class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition"
                                    >Eliminar</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>

<!-- MODAL: CREAR USUARIO (ADMIN) -->
<div id="createUserModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[1rem] shadow-2xl w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">
        <button onclick="toggleModal('createUserModal')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition text-xl"><i class="fa-solid fa-xmark"></i></button>
        <h3 class="text-lg font-bold mb-2">Registrar Nuevo Usuario</h3>
        <form action="{{ route('usuario.store') }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input type="text" name="primer_nom" placeholder="Primer Nombre" required class="w-full rounded-xl border px-3 py-2" />
                <input type="text" name="segund_nom" placeholder="Segundo Nombre" class="w-full rounded-xl border px-3 py-2" />
                <input type="text" name="primer_apelli" placeholder="Primer Apellido" required class="w-full rounded-xl border px-3 py-2" />
                <input type="text" name="segund_apelli" placeholder="Segundo Apellido" class="w-full rounded-xl border px-3 py-2" />
            </div>
            <div>
                <input type="email" name="correo" placeholder="Correo electrónico" required class="w-full rounded-xl border px-3 py-2" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="relative">
                    <input type="password" id="new_user_password" name="contrasena" placeholder="Contraseña" required class="w-full rounded-xl border px-3 py-2 pr-20" />
                    <button type="button" id="toggleNewUserPwd" aria-pressed="false" class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-slate-600 bg-white/0 px-2 py-1 rounded">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <div id="createUserError" class="hidden absolute left-0 top-full mt-2 w-full text-xs text-rose-700 bg-rose-50 border border-rose-100 rounded-md px-3 py-2">
                        La contraseña debe tener más de 6 caracteres.
                    </div>
                </div>
                <div class="relative">
                    <select id="new_user_role" name="role" required class="rounded-xl border px-3 py-2 w-full">
                        <option value="">Rol (Obligatorio)</option>
                        <option value="administrador">Administrador</option>
                        <option value="empleado">Empleado</option>
                        <option value="cliente">Cliente</option>
                    </select>
                    <div id="createUserRoleError" class="hidden absolute left-0 top-full mt-2 w-full text-xs text-rose-700 bg-rose-50 border border-rose-100 rounded-md px-3 py-2">
                        Selecciona un rol antes de crear el usuario.
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="toggleModal('createUserModal')" class="px-4 py-2 rounded-xl border">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-pink-500 text-white">Crear usuario</button>
            </div>
        </form>
    </div>
</div>

            </div>
        </main>
    </div>
</div>

<div id="deleteUserModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[1rem] shadow-2xl w-full max-w-md p-6 relative max-h-[90vh] overflow-y-auto">
        <button onclick="toggleModal('deleteUserModal')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition text-xl"><i class="fa-solid fa-xmark"></i></button>
        <h3 class="text-lg font-bold mb-2">Confirmar eliminación</h3>
        <p class="text-sm text-slate-500 mb-4">¿Confirmas eliminar este usuario? Revisa el nombre y correo antes de continuar.</p>
        <div class="mb-5 rounded-3xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs text-slate-500 uppercase tracking-[0.3em] mb-1">Nombre</p>
            <p id="deleteUserName" class="text-base font-semibold text-slate-900"></p>
            <p class="text-xs text-slate-500 uppercase tracking-[0.3em] mt-4 mb-1">Correo</p>
            <p id="deleteUserEmail" class="text-base text-slate-900"></p>
        </div>
        <form id="deleteUserForm" action="" method="POST" class="flex justify-end gap-2">
            @csrf @method('DELETE')
            <button type="button" onclick="toggleModal('deleteUserModal')" class="px-4 py-2 rounded-xl border text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">Cancelar</button>
            <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700 transition">Eliminar usuario</button>
        </form>
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
                    <input type="number" name="precio" required min="10000" placeholder="10000"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Inicial *</label>
                    <input type="number" name="stock" required min="10" max="85" placeholder="10" oninput="validarStockMaximo()"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Mínimo *</label>
                    <input type="number" name="min_stock" required min="15" max="85" placeholder="15" oninput="validarStockMaximo()"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Máximo *</label>
                    <input type="number" name="max_stock" required min="20" max="85" placeholder="20" oninput="validarStockMaximo()"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>
            <div id="stockLimitError" class="hidden mt-2 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">
                El límite de stock es 85 en inicial, mínimo y máximo.
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
                    <input type="number" id="edit_precio" name="precio" required min="10000"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock *</label>
                    <input type="number" id="edit_stock" name="stock" required min="10" max="85" oninput="validarStockMaximoEditar()"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Mínimo *</label>
                    <input type="number" id="edit_min_stock" name="min_stock" required min="15" max="85" oninput="validarStockMaximoEditar()"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Stock Máximo *</label>
                    <input type="number" id="edit_max_stock" name="max_stock" required min="20" max="85" oninput="validarStockMaximoEditar()"
                        class="w-full rounded-2xl border border-pink-100 bg-white px-4 py-3 text-sm font-mono text-slate-800 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100 transition" />
                </div>
            </div>
            <div id="stockLimitErrorEdit" class="hidden mt-2 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">
                El límite de stock es 85 en inicial, mínimo y máximo.
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

    function openDeleteUserConfirmFromBtn(button) {
        const name = button.dataset.deleteName || '';
        const email = button.dataset.deleteEmail || '';
        const actionUrl = button.dataset.deleteUrl || '';
        openDeleteUserConfirm(name, email, actionUrl);
    }

    function openDeleteUserConfirm(name, email, actionUrl) {
        document.getElementById('deleteUserName').innerText = name;
        document.getElementById('deleteUserEmail').innerText = email;
        document.getElementById('deleteUserForm').action = actionUrl;
        toggleModal('deleteUserModal');
    }

    function filtrarUsuariosPorRol() {
        const roleFilter = document.getElementById('userRoleFilter');
        const noResults = document.getElementById('userNoResults');
        const roleValue = roleFilter ? roleFilter.value.toLowerCase() : '';
        const cards = document.querySelectorAll('#usuarios [data-role]');
        let visible = 0;

        cards.forEach((card) => {
            const cardRole = card.dataset.role || '';
            const matches = !roleValue || cardRole === roleValue;
            card.classList.toggle('hidden', !matches);
            if (matches) visible += 1;
        });

        if (noResults) {
            noResults.classList.toggle('hidden', visible > 0);
        }
    }

    const userRoleFilterEl = document.getElementById('userRoleFilter');
    if (userRoleFilterEl) {
        userRoleFilterEl.addEventListener('change', filtrarUsuariosPorRol);
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
    let carritoVenta = [];
    let prendaVentaTemporal = null;

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
                        prendaVentaTemporal = prenda;

                        document.getElementById('nombre_prend_venta').value      = prenda.nombre_prend;
                        document.getElementById('detalles_prend_venta').value    = `Talla: ${prenda.talla_prend ?? 'N/A'} | Color: ${prenda.nom_color ?? 'N/A'}`;
                        document.getElementById('precio_unitario_venta').value   = prenda.precio;
                        document.getElementById('stock_disponible_venta').value  = `${prenda.stock} unidades`;

                        const cantidadInput = document.getElementById('cantidad_vendida_venta');
                        cantidadInput.disabled = false;
                        const tipoProceso = document.getElementById('tipo_proceso').value;
                        if (tipoProceso === 'venta' || tipoProceso === 'apartado') {
                            cantidadInput.max = prenda.stock;
                        } else {
                            cantidadInput.removeAttribute('max');
                        }
                        cantidadInput.value = 1;

                        const btnAdd = document.getElementById('btnAgregarAlCarrito');
                        if (btnAdd) {
                            btnAdd.disabled = false;
                            btnAdd.className = "w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition shadow-lg shadow-pink-500/20 flex items-center justify-center gap-2 cursor-pointer";
                        }

                        calcularTotalesVenta();
                        showFeedbackVentas('Prenda lista para agregar al carrito.', 'emerald');
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
        actualizarTotalesCarritoVenta();
    });

    const btnAgregarCarrito = document.getElementById('btnAgregarAlCarrito');
    if (btnAgregarCarrito) {
        btnAgregarCarrito.addEventListener('click', function() {
            if (!prendaVentaTemporal) return;
            const cantidadInput = document.getElementById('cantidad_vendida_venta');
            let cantidad = parseInt(cantidadInput.value, 10) || 1;
            if (cantidad < 1) cantidad = 1;

            const tipoProceso = document.getElementById('tipo_proceso').value;
            const stock = prendaVentaTemporal.stock;
            const existente = carritoVenta.find(item => item.codigo_barras === prendaVentaTemporal.codigo_barras);
            if (tipoProceso !== 'devolucion' && existente) {
                if (existente.cantidad + cantidad > stock) {
                    showFeedbackVentas('No puedes añadir más unidades que las disponibles en stock.', 'amber');
                    return;
                }
            }

            if (tipoProceso !== 'devolucion' && cantidad > stock) {
                showFeedbackVentas('La cantidad excede el stock disponible.', 'amber');
                return;
            }

            if (existente) {
                existente.cantidad += cantidad;
            } else {
                carritoVenta.push({
                    codigo_barras: prendaVentaTemporal.codigo_barras,
                    nombre_prend: prendaVentaTemporal.nombre_prend,
                    precio: parseInt(prendaVentaTemporal.precio, 10) || 0,
                    cantidad: cantidad,
                    max: tipoProceso === 'devolucion' ? null : prendaVentaTemporal.stock
                });
            }

            renderizarCarritoVenta();
            resetFormularioVenta();
            validarFormularioVenta();
            showFeedbackVentas('Prenda agregada al carrito correctamente.', 'emerald');
        });
    }

    function renderizarCarritoVenta() {
        const tbody = document.getElementById('ventaCarritoBody');
        const cartEmptyRow = document.getElementById('ventaCarritoVacio');
        tbody.innerHTML = '';

        if (carritoVenta.length === 0) {
            tbody.innerHTML = `
                <tr id="ventaCarritoVacio">
                    <td colspan="5" class="p-8 text-center text-slate-400 font-medium">No hay prendas agregadas al carrito.</td>
                </tr>`;
            actualizarTotalesCarritoVenta();
            return;
        }

        carritoVenta.forEach((item, index) => {
            const subtotal = item.precio * item.cantidad;
            const row = document.createElement('tr');
            row.className = 'hover:bg-pink-50/50 transition';
            row.innerHTML = `
                <td class="p-4 font-medium text-slate-800">
                    <div>${item.nombre_prend}</div>
                    <div class="text-xs text-slate-400 font-mono">${item.codigo_barras}</div>
                </td>
                <td class="p-4 text-center">
                    <input type="number" min="1" value="${item.cantidad}" ${item.max ? `max="${item.max}"` : ''} onchange="actualizarCantidadCarrito(${index}, this.value)" class="w-20 rounded-xl border border-slate-200 text-center text-sm text-slate-800" />
                </td>
                <td class="p-4 text-right font-mono text-slate-500">${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(item.precio)}</td>
                <td class="p-4 text-right font-mono font-bold text-slate-900">${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(subtotal)}</td>
                <td class="p-4 text-center">
                    <button type="button" onclick="eliminarDelCarritoVenta(${index})" class="text-rose-500 hover:text-rose-700 p-2 transition">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>`;
            tbody.appendChild(row);
        });

        actualizarTotalesCarritoVenta();
    }

    function actualizarCantidadCarrito(index, newQty) {
        newQty = parseInt(newQty, 10) || 1;
        const item = carritoVenta[index];
        if (!item) return;
        if (item.max && newQty > item.max) {
            newQty = item.max;
        }
        if (newQty < 1) newQty = 1;
        item.cantidad = newQty;
        renderizarCarritoVenta();
    }

    function eliminarDelCarritoVenta(index) {
        carritoVenta.splice(index, 1);
        renderizarCarritoVenta();
    }

    function actualizarTotalesCarritoVenta() {
        const tipoProceso = document.getElementById('tipo_proceso').value;
        let total = carritoVenta.reduce((sum, item) => sum + item.precio * item.cantidad, 0);
        if (tipoProceso === 'devolucion') {
            total = total * -1;
        }

        const formatter = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        });

        document.getElementById('resumen_subtotal_venta').innerText = formatter.format(Math.abs(total));
        document.getElementById('resumen_total_venta').innerText = formatter.format(total);
        document.getElementById('carrito_items_hidden').value = JSON.stringify(carritoVenta);
        validarFormularioVenta();
    }

    function validarFormularioVenta() {
        const btn = document.getElementById('btnSubmitVenta');
        if (!btn) return;
        if (carritoVenta.length > 0) {
            btn.disabled = false;
            btn.className = "w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm px-8 py-3.5 rounded-2xl transition flex items-center justify-center gap-2 cursor-pointer";
        } else {
            btn.disabled = true;
            btn.className = "w-full sm:w-auto bg-slate-200 text-slate-400 font-bold text-sm px-8 py-3.5 rounded-2xl transition flex items-center justify-center gap-2 cursor-not-allowed";
        }
    }

    function resetFormularioVenta() {
        prendaVentaTemporal = null;
        document.getElementById('codigo_barras_venta').value = '';
        document.getElementById('nombre_prend_venta').value     = '';
        document.getElementById('detalles_prend_venta').value   = '';
        document.getElementById('precio_unitario_venta').value  = '';
        document.getElementById('stock_disponible_venta').value = '';

        const cantidadInput = document.getElementById('cantidad_vendida_venta');
        cantidadInput.disabled = true;
        cantidadInput.value = 1;
        cantidadInput.removeAttribute('max');

        const btn = document.getElementById('btnAgregarAlCarrito');
        if (btn) {
            btn.disabled = true;
            btn.className = "w-full sm:w-auto bg-slate-200 text-slate-400 font-bold text-sm px-8 py-3.5 rounded-2xl transition flex items-center justify-center gap-2 cursor-not-allowed";
        }

        document.getElementById('resumen_subtotal_venta').innerText = '$0';
        document.getElementById('resumen_total_venta').innerText    = '$0';
    }

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

        const btn = document.getElementById('btnAgregarAlCarrito');
        if (btn) {
            btn.disabled = true;
            btn.className = "w-full sm:w-auto bg-slate-200 text-slate-400 font-bold text-sm px-8 py-3.5 rounded-2xl transition flex items-center justify-center gap-2 cursor-not-allowed";
        }
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

    // Limpiar carrito después de enviar el formulario de ventas
    const formTransaccion = document.getElementById('formTransaccion');
    if (formTransaccion) {
        formTransaccion.addEventListener('submit', function(e) {
            // Permitir el submit normal
            // Después de que se envíe, limpiar el carrito para la siguiente operación
            setTimeout(() => {
                carritoVenta = [];
                renderizarCarritoVenta();
                actualizarTotalesCarritoVenta();
            }, 500);
        });
    }

    const codigoCrearEl = document.getElementById('codigo_barras_crear');
    if (codigoCrearEl) {
        codigoCrearEl.addEventListener('input', function() {
            const codigo = this.value.trim();
            const errorMsg = document.getElementById('error_codigo_existente');
            const submitBtn = this.closest('form').querySelector('button[type="submit"]');

            if (codigo.length < 2) {
                if (errorMsg) errorMsg.classList.add('hidden');
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
                        if (errorMsg) errorMsg.classList.remove('hidden'); // Muestra la alerta de "Ya registrado"
                        if(submitBtn) {
                            submitBtn.disabled = true; // Bloquea el guardado
                            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    } else {
                        if (errorMsg) errorMsg.classList.add('hidden'); // Oculta el error si está libre
                        if(submitBtn) {
                            submitBtn.disabled = false; // Desbloquea el botón
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                })
                .catch(err => console.error("Error al validar código:", err));
        });
    }

    const inventoryBarcodeSearch = document.getElementById('inventoryBarcodeSearch');
    const inventoryGeneroFilter = document.getElementById('inventoryGeneroFilter');
    const inventoryNoResults = document.getElementById('inventoryNoResults');
    const inventoryCards = document.querySelectorAll('#inventario .product-card');

    function filtrarInventario() {
        const query = inventoryBarcodeSearch ? inventoryBarcodeSearch.value.trim().toLowerCase() : '';
        const genero = inventoryGeneroFilter ? inventoryGeneroFilter.value : '';
        let visibleCount = 0;

        inventoryCards.forEach((card) => {
            const cardGenero = card.dataset.genero || '';
            const cardCodigo = card.dataset.codigo || '';
            const matchesGenero = !genero || cardGenero === genero;
            const matchesCodigo = !query || cardCodigo.includes(query);

            if (matchesGenero && matchesCodigo) {
                card.classList.remove('hidden');
                visibleCount += 1;
            } else {
                card.classList.add('hidden');
            }
        });

        if (inventoryNoResults) {
            inventoryNoResults.classList.toggle('hidden', visibleCount > 0);
        }
    }

    if (inventoryBarcodeSearch) {
        inventoryBarcodeSearch.addEventListener('input', filtrarInventario);
    }
    if (inventoryGeneroFilter) {
        inventoryGeneroFilter.addEventListener('change', filtrarInventario);
    }

// ===================== Usuarios: abrir modal y actualizar =====================
const csrfToken = '{{ csrf_token() }}';
let currentEditingUserId = null;

function abrirUsuarioModal(id) {
    fetch(`/dashboard/usuario/${id}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Usuario no encontrado');
                return;
            }
            const u = data.user;
            currentEditingUserId = u.id_usuario;
            document.getElementById('user_id_input').value = u.id_usuario;
            document.getElementById('primer_nom').value = u.primer_nom || '';
            document.getElementById('segund_nom').value = u.segund_nom || '';
            document.getElementById('primer_apelli').value = u.primer_apelli || '';
            document.getElementById('segund_apelli').value = u.segund_apelli || '';
            document.getElementById('correo').value = u.correo || '';
            document.getElementById('role').value = (u.role || '').toLowerCase();
            document.getElementById('estado_select').value = u.estado;
            document.getElementById('userEditForm').action = '/dashboard/usuario/' + encodeURIComponent(u.id_usuario);
            document.getElementById('toggleEstadoBtn').innerText = u.estado == 1 ? 'Inactivar' : 'Activar';
            toggleModal('userModal');
        })
        .catch(err => { console.error(err); alert('Error al cargar usuario.'); });
}

function toggleUserEstado() {
    if (!currentEditingUserId) return;
    const select = document.getElementById('estado_select');
    const newEstado = select.value == '1' ? 0 : 1;

    fetch('/dashboard/usuario/' + encodeURIComponent(currentEditingUserId), {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ estado: newEstado })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert(data.message || 'No fue posible actualizar el estado');
            return;
        }
        // Actualizar UI local
        select.value = newEstado;
        document.getElementById('toggleEstadoBtn').innerText = newEstado == 1 ? 'Inactivar' : 'Activar';
        const statusEl = document.getElementById('status-' + currentEditingUserId);
        if (statusEl) {
            statusEl.innerText = newEstado == 1 ? 'Activo' : 'Inactivo';
            if (newEstado == 1) {
                statusEl.classList.remove('bg-slate-100','text-slate-500');
                statusEl.classList.add('bg-emerald-100','text-emerald-700');
            } else {
                statusEl.classList.remove('bg-emerald-100','text-emerald-700');
                statusEl.classList.add('bg-slate-100','text-slate-500');
            }
        }
        showFeedbackVentas('Estado actualizado', 'emerald');
    })
    .catch(err => { console.error(err); alert('Error al cambiar estado'); });
}

// Validación cliente para el modal de crear usuario: evitar cerrar si contraseña < 6
document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.querySelector('#createUserModal form');
    if (!createForm) return;

    const pwdInput = document.getElementById('new_user_password');
    const errorBox = document.getElementById('createUserError');

    createForm.addEventListener('submit', function(e) {
        if (!pwdInput) return;
        const val = (pwdInput.value || '').trim();
        const roleSelect = document.getElementById('new_user_role');
        const roleError = document.getElementById('createUserRoleError');

        let blocked = false;

        if (val.length < 6) {
            blocked = true;
            if (errorBox) errorBox.classList.remove('hidden');
            pwdInput.focus();
        }

        if (roleSelect) {
            if (!roleSelect.value) {
                blocked = true;
                if (roleError) roleError.classList.remove('hidden');
                roleSelect.focus();
            }
        }

        if (blocked) {
            e.preventDefault();
            return false;
        }
        // permitir submit
    });

    if (pwdInput && errorBox) {
        pwdInput.addEventListener('input', function() {
            if ((pwdInput.value || '').trim().length >= 6) {
                errorBox.classList.add('hidden');
            }
        });
    }

    const roleSelect = document.getElementById('new_user_role');
    const roleError = document.getElementById('createUserRoleError');
    if (roleSelect && roleError) {
        roleSelect.addEventListener('change', function() {
            if (this.value) roleError.classList.add('hidden');
        });
    }

    const toggleBtn = document.getElementById('toggleNewUserPwd');
    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function() {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                toggleBtn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                toggleBtn.setAttribute('aria-pressed', 'true');
            } else {
                pwdInput.type = 'password';
                toggleBtn.innerHTML = '<i class="fa-solid fa-eye"></i>';
                toggleBtn.setAttribute('aria-pressed', 'false');
            }
        });
    }

    function validarStockMaximo() {
        const maxAllowed = 85;
        const inputs = [
            document.querySelector('input[name="stock"]'),
            document.querySelector('input[name="min_stock"]'),
            document.querySelector('input[name="max_stock"]')
        ];
        const errorBox = document.getElementById('stockLimitError');
        let invalid = false;

        inputs.forEach(input => {
            if (input) {
                const value = parseInt(input.value, 10);
                if (!Number.isNaN(value) && value > maxAllowed) {
                    invalid = true;
                }
            }
        });

        if (errorBox) {
            errorBox.classList.toggle('hidden', !invalid);
        }
    }

    function validarStockMaximoEditar() {
        const maxAllowed = 85;
        const inputs = [
            document.getElementById('edit_stock'),
            document.getElementById('edit_min_stock'),
            document.getElementById('edit_max_stock')
        ];
        const errorBox = document.getElementById('stockLimitErrorEdit');
        let invalid = false;

        inputs.forEach(input => {
            if (input) {
                const value = parseInt(input.value, 10);
                if (!Number.isNaN(value) && value > maxAllowed) {
                    invalid = true;
                }
            }
        });

        if (errorBox) {
            errorBox.classList.toggle('hidden', !invalid);
        }
    }

    function inicializarGraficoTopPrendas() {
        const ctx = document.getElementById('topPrendasDonut');
        if (!ctx) return;

        const labels = @json($topPrendasVendidas->pluck('nombre_prend'));
        const data = @json($topPrendasVendidas->pluck('total_vendida'));
        const colors = [
            '#EC4899', '#F97316', '#14B8A6', '#6366F1', '#EAB308', '#A855F7'
        ];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#334155',
                            usePointStyle: true,
                            padding: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value} prendas`; 
                            }
                        }
                    }
                }
            }
        });
    }

    // Activar la sección correcta basada en el parámetro URL al cargar
    const urlParams = new URLSearchParams(window.location.search);
    const sectionParam = urlParams.get('section');
    if (sectionParam) {
        activateDashboardTab(sectionParam);
        // Actualizar el sidebar para mostrar la sección activa
        document.querySelectorAll('.sidebar-link').forEach((link) => {
            if (link.dataset.section === sectionParam) {
                link.classList.remove('text-slate-600');
                link.classList.add('active-link', 'bg-pink-500/10', 'border', 'border-pink-100', 'text-pink-600', 'shadow-sm');
            } else {
                link.classList.remove('active-link', 'bg-pink-500/10', 'border-pink-100', 'text-pink-600', 'shadow-sm');
                link.classList.add('text-slate-600');
            }
        });
    }

    inicializarGraficoTopPrendas();
});
</script>
@endsection