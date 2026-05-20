@extends('layouts.app')

@section('title', 'Dashboard - Pague Menos Staff')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="min-h-screen bg-white text-slate-900">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-72 bg-white border-r border-pink-100 text-slate-900 flex flex-col justify-between">
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

        <main class="flex-1 overflow-y-auto bg-white">
            <div class="px-6 py-6 lg:px-10 lg:py-8">
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
                                <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Inventario</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $prendas->sum('stock') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6 mb-8">
                    <div class="rounded-3xl bg-white border border-pink-100 p-5 shadow-sm shadow-pink-200/40">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Buscar producto</p>
                                <p class="text-xs text-slate-400">Busca por nombre, tipo o color.</p>
                            </div>
                            <div class="relative w-full lg:w-1/2">
                                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-pink-400"></i>
                                <input type="text" placeholder="Search by product name, type, or tag..." class="w-full rounded-3xl border border-pink-100 bg-white py-3 pl-12 pr-4 text-slate-700 outline-none focus:border-pink-300 focus:ring-2 focus:ring-pink-100" />
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 xl:grid-cols-3">
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Resumen</p>
                            <h2 class="mt-4 text-2xl font-bold text-slate-900">Panel principal</h2>
                            <p class="mt-3 text-slate-500">Monitorea inventario, ventas y facturas desde un único panel.</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Ventas recientes</p>
                            <h2 class="mt-4 text-2xl font-bold text-slate-900">1 orden nueva</h2>
                            <p class="mt-3 text-slate-500">Revisa pedidos y filtra por estado para asegurar entregas a tiempo.</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Movimientos</p>
                            <h2 class="mt-4 text-2xl font-bold text-slate-900">Control de stock</h2>
                            <p class="mt-3 text-slate-500">Registra entradas y salidas con total visibilidad del inventario.</p>
                        </div>
                    </div>
                </div>

                <section id="resumen" class="mb-8">
                    <div class="grid gap-6 lg:grid-cols-3 mb-6">
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Ventas Totales</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">$0</p>
                            <p class="mt-2 text-sm text-slate-500">Acumulado en el último mes.</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Clientes</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">0</p>
                            <p class="mt-2 text-sm text-slate-500">Registrados en el sistema.</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Prendas Activas</p>
                            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $prendas->where('estado',1)->count() }}</p>
                            <p class="mt-2 text-sm text-slate-500">Disponibles en tienda.</p>
                        </div>
                    </div>
                </section>

                <section id="ventas" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">Ventas Recientes</h2>
                                <p class="text-slate-500 mt-2">Últimos pedidos registrados.</p>
                            </div>
                            <button class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-4 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
                                <i class="fa-solid fa-filter"></i> Filtrar
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-3xl border border-pink-100 bg-white p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-slate-900 font-semibold">#0001 — Juan Perez</p>
                                        <p class="text-sm text-slate-500">Camiseta Oversize, Pantalón Cargo Negro</p>
                                    </div>
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Pendiente</span>
                                </div>
                                <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                                    <span>Total: $93.000</span>
                                    <span>2026-04-02</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="inventario" class="mb-8 hidden">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Catálogo / Inventario</h2>
                            <p class="text-slate-500">Gestiona tus prendas y revisa existencias actualizadas.</p>
                        </div>
                        <button onclick="toggleModal('createModal')" class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-5 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition shadow-sm shadow-pink-200/40">
                            <i class="fa-solid fa-plus"></i> Agregar Prenda
                        </button>
                    </div>
                    <div class="grid gap-5 lg:grid-cols-2">
                        @foreach($prendas as $p)
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-20 rounded-3xl bg-pink-100 flex items-center justify-center text-pink-500 text-3xl font-bold">P</div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $p->nombre_prend }}</h3>
                                            <p class="text-sm text-slate-500 mt-1">{{ $p->descripcion_prend }}</p>
                                        </div>
                                        <span class="text-lg font-bold text-pink-500">${{ number_format($p->precio, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="mt-4 grid gap-2 sm:grid-cols-2">
                                        <div class="rounded-3xl bg-pink-100 px-4 py-3 text-sm text-pink-600">Stock: {{ $p->stock }}</div>
                                        <div class="rounded-3xl bg-pink-100 px-4 py-3 text-sm text-pink-600">Talla: {{ $p->talla_prend }}</div>
                                        <div class="rounded-3xl bg-pink-100 px-4 py-3 text-sm text-pink-600">Color: {{ $p->nom_color }}</div>
                                        <div class="rounded-3xl bg-pink-100 px-4 py-3 text-sm text-pink-600">Género: {{ $p->tipo_genero }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">{{ $p->estado == 1 ? 'Activo' : 'Inactivo' }}</span>
                                <div class="flex items-center gap-2">
                                    <button onclick="openEditModal({{ json_encode($p) }})" class="rounded-3xl bg-pink-100 px-4 py-2 text-sm font-semibold text-pink-600 hover:bg-pink-200 transition">Editar</button>
                                    <form action="{{ route('prenda.destroy', $p->id_prenda) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Seguro deseas eliminar esta prenda del inventario por completo?')" class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if(count($prendas) == 0)
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 text-center text-slate-500">No hay prendas registradas en el inventario actual.</div>
                    @endif
                </section>

                <section id="facturas" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">Facturas</h2>
                                <p class="text-slate-500 mt-2">Revisa documentos de pago recientes.</p>
                            </div>
                            <button class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-4 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
                                <i class="fa-solid fa-file-arrow-up"></i> Generar Factura
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-3xl border border-pink-100 bg-white p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-slate-900">#F-0001</p>
                                        <p class="text-sm text-slate-500">Andrea López • Pagada</p>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-600">$137.500</span>
                                </div>
                                <p class="mt-3 text-sm text-slate-500">2026-05-12</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="movimientos" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">Movimientos</h2>
                                <p class="text-slate-500 mt-2">Registra entradas y salidas de inventario.</p>
                            </div>
                            <button class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-4 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
                                <i class="fa-solid fa-plus"></i> Nuevo Movimiento
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-3xl border border-pink-100 bg-white p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-slate-900">#M-001 • Chaqueta Urbana</p>
                                        <p class="text-sm text-slate-500">Entrada de stock</p>
                                    </div>
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">+12</span>
                                </div>
                                <p class="mt-3 text-sm text-slate-500">2026-05-16</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div id="createModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl overflow-y-auto max-h-[90vh] border border-gray-100">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold flex items-center gap-2 text-pink-600"><i class="fa-solid fa-shirt"></i> Registrar Nueva Prenda</h2>
            <button onclick="toggleModal('createModal')" class="text-gray-400 hover:text-gray-600 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('prenda.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nombre Prenda</label>
                    <input type="text" name="nombre_prend" max="25" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Descripción Breve</label>
                    <input type="text" name="descripcion_prend" max="35" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Precio ($ COP)</label>
                    <input type="number" name="precio" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Inicial</label>
                    <input type="number" name="stock" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Mínimo</label>
                    <input type="number" name="min_stock" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Máximo</label>
                    <input type="number" name="max_stock" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Género</label>
                    <select name="fk_id_genero" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                        @foreach($generos as $g) <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Talla</label>
                    <select name="fk_idt_prendas" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                        @foreach($tallas as $t) <option value="{{ $t->idt_prendas }}">{{ $t->talla_prend }}</option> @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Color</label>
                    <select name="fk_id_color" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                        @foreach($colores as $c) <option value="{{ $c->id_color }}">{{ $c->nom_color }}</option> @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="toggleModal('createModal')" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition font-medium">Cancelar</button>
                <button type="submit" class="px-5 py-2.5 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-lg transition shadow-sm">Guardar Prenda</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl overflow-y-auto max-h-[90vh] border border-gray-100">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold flex items-center gap-2 text-pink-600"><i class="fa-solid fa-pen-to-square"></i> Editar Características de Prenda</h2>
            <button onclick="toggleModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nombre Prenda</label>
                    <input type="text" name="nombre_prend" id="edit_nombre" max="25" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Descripción Breve</label>
                    <input type="text" name="descripcion_prend" id="edit_descripcion" max="35" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Precio ($ COP)</label>
                    <input type="number" name="precio" id="edit_precio" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Actual</label>
                    <input type="number" name="stock" id="edit_stock" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Mínimo</label>
                    <input type="number" name="min_stock" id="edit_min" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Máximo</label>
                    <input type="number" name="max_stock" id="edit_max" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Género</label>
                    <select name="fk_id_genero" id="edit_genero" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                        @foreach($generos as $g) <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Talla</label>
                    <select name="fk_idt_prendas" id="edit_talla" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                        @foreach($tallas as $t) <option value="{{ $t->idt_prendas }}">{{ $t->talla_prend }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Color</label>
                    <select name="fk_id_color" id="edit_color" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                        @foreach($colores as $c) <option value="{{ $c->id_color }}">{{ $c->nom_color }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Estado de Visibilidad</label>
                    <select name="estado" id="edit_estado" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-pink-500">
                        <option value="1">Activo (Visible en Tienda)</option>
                        <option value="0">Inactivo (Oculto)</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="toggleModal('editModal')" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition font-medium">Cancelar</button>
                <button type="submit" class="px-5 py-2.5 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-lg transition shadow-sm">Actualizar Prenda</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    function openEditModal(prenda) {
        // Enlaza la ruta dinámica de actualización
        document.getElementById('editForm').action = `/dashboard/prenda/${prenda.id_prenda}`;
        
        // Carga dinámicamente el objeto en el modal
        document.getElementById('edit_nombre').value = prenda.nombre_prend;
        document.getElementById('edit_descripcion').value = prenda.descripcion_prend;
        document.getElementById('edit_precio').value = prenda.precio;
        document.getElementById('edit_stock').value = prenda.stock;
        document.getElementById('edit_min').value = prenda.min_stock;
        document.getElementById('edit_max').value = prenda.max_stock;
        document.getElementById('edit_genero').value = prenda.fk_id_genero;
        document.getElementById('edit_talla').value = prenda.fk_idt_prendas;
        document.getElementById('edit_color').value = prenda.fk_id_color;
        document.getElementById('edit_estado').value = prenda.estado;

        toggleModal('editModal');
    }

    function activateDashboardTab(sectionId) {
        const sections = ['resumen','ventas','inventario','facturas','movimientos'];
        sections.forEach((id) => {
            const section = document.getElementById(id);
            if (!section) return;
            section.classList.toggle('hidden', id !== sectionId);
        });

        document.querySelectorAll('.sidebar-link').forEach((link) => {
            const isActive = link.dataset.section === sectionId;
            link.classList.toggle('bg-pink-500/10', isActive);
            link.classList.toggle('border-pink-100', isActive);
            link.classList.toggle('text-pink-600', isActive);
            link.classList.toggle('shadow-sm', isActive);
            link.classList.toggle('shadow-pink-200/40', isActive);
            link.classList.toggle('text-slate-600', !isActive);
        });
    }

    document.querySelectorAll('.sidebar-link').forEach((link) => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            activateDashboardTab(this.dataset.section);
        });
    });

    // Initialize with the default active tab
    activateDashboardTab('resumen');
</script>
@endsection