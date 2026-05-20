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
                                <p class="text-xs uppercase tracking-[0.35em] text-pink-500">Total Usuarios</p>
                                <p class="mt-3 text-3xl font-bold text-slate-900">{{ count($usuarios) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

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

                <section id="ventas" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <h2 class="text-2xl font-bold text-slate-900">Historial de Ventas / Apartados</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-3xl border border-pink-100 bg-white p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-slate-900 font-semibold">#0001 — Camiseta Oversize (Cod: 770123456)</p>
                                        <p class="text-xs text-slate-400 mt-1">Registrado por: Admin Staff • Apartado para: Cliente Juan</p>
                                    </div>
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Apartado</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="inventario" class="mb-8 hidden">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Catálogo / Inventario</h2>
                        </div>
                        <button onclick="toggleModal('createModal')" class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-5 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
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
                                            <p class="text-xs text-slate-400">Código Único: {{ $p->codigo_barras ?? 'No asignado' }}</p>
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
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $p->estado == 1 ? 'Activo' : 'Inactivo' }}</span>
                                <div class="flex gap-2">
                                    <button onclick="openEditModal({{ json_encode($p) }})" class="rounded-2xl bg-pink-100 px-4 py-2 text-xs font-semibold text-pink-600 hover:bg-pink-200 transition">Editar</button>
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
                                        <td class="py-3 font-medium text-slate-900">Chaqueta Cargo Y2K</td>
                                        <td class="py-3"><span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full font-medium">Apartado</span></td>
                                        <td class="py-3 text-slate-600">1 unidad</td>
                                        <td class="py-3 text-slate-500">Staff Admin</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 text-slate-500">2026-05-19 09:12</td>
                                        <td class="py-3 font-medium text-slate-900">Pantalón Denim Amplio</td>
                                        <td class="py-3"><span class="bg-rose-100 text-rose-800 text-xs px-2.5 py-1 rounded-full font-medium">Devuelto</span></td>
                                        <td class="py-3 text-slate-600">2 unidades</td>
                                        <td class="py-3 text-slate-500">Staff Auxiliar</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="usuarios" class="mb-8 hidden">
                    <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">Cuentas y Usuarios</h2>
                                <p class="text-xs text-slate-400 mt-1">Lista completa de personal administrador, staff y clientes registrados.</p>
                            </div>
                            <button onclick="toggleModal('userModal')" class="inline-flex items-center gap-2 rounded-3xl bg-pink-500 px-4 py-3 text-sm font-semibold text-white hover:bg-pink-600 transition">
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

<script>
    function toggleModal(modalId) {
        document.getElementById(modalId).classList.toggle('hidden');
    }

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
</script>
@endsection