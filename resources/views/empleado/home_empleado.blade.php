@extends('layouts.app')

@section('title', 'Panel Empleado - Pague Menos Staff')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="min-h-screen bg-white text-slate-900">
        <div class="flex h-screen overflow-hidden">

            {{-- ===================== SIDEBAR EMPLEADO ===================== --}}
            <aside class="w-72 bg-white border-r border-pink-100 text-slate-900 flex flex-col justify-between shrink-0">
                <div class="p-6 space-y-8">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-pink-500 text-white rounded-2xl p-3 shadow-lg shadow-pink-500/20 font-bold">PM
                            </div>
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-pink-500">PAGUE</p>
                                <p class="text-2xl font-bold tracking-tight text-slate-900">MENOS</p>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-pink-100 bg-white p-5 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-pink-500 mb-2">
                                {{ session('user_role') ?? 'Empleado' }}</p>
                            <p class="text-lg font-semibold text-slate-900 leading-tight">
                                {{ session('user_name') ?? 'Colaborador' }}</p>
                            <p class="mt-3 text-slate-500 text-sm">Punto de Venta Activo</p>
                        </div>
                    </div>

                    <nav class="space-y-2">
                        <a href="#inventario" data-section="inventario"
                            class="sidebar-link active-link flex items-center gap-3 px-4 py-3 rounded-2xl bg-pink-500/10 border border-pink-100 text-pink-600 shadow-sm transition">
                            <i class="fa-solid fa-box-open w-6 text-pink-500"></i>
                            <span class="font-semibold">Ver Inventario</span>
                        </a>
                        <a href="#apartados" data-section="apartados"
                            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class="fa-solid fa-bookmark w-6 text-pink-400"></i>
                            Registrar Apartados
                        </a>
                        <a href="#consultar_empleados" data-section="consultar_empleados"
                            class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class="fa-solid fa-users w-6 text-pink-400"></i>
                            Consultar Empleados
                        </a>
                    </nav>
                </div>

                <div class="p-6 border-t border-pink-100 space-y-4">
                    <a href="{{ route('logout') }}"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl bg-pink-500 text-white font-semibold hover:bg-pink-600 transition">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </aside>

            {{-- ===================== MAIN CONTENT ===================== --}}
            <main class="flex-1 overflow-y-auto bg-white">
                <div class="px-6 py-6 lg:px-10 lg:py-8">

                    {{-- Mensajes globales --}}
                    <div id="alertBoxEmpleado"
                        class="hidden mb-6 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm"></div>

                    {{-- Header General --}}
                    <div class="rounded-[2rem] bg-white p-6 shadow-sm shadow-pink-200/50 border border-pink-100 mb-8">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-pink-500 mb-2">Punto de Trabajo</p>
                            <h1 class="text-4xl font-extrabold text-slate-900">Panel de Operaciones</h1>
                            <p class="text-slate-500 mt-2">Gestiona el stock de prendas, separa apartados y consulta el
                                personal operativo.</p>
                        </div>
                    </div>

                    {{-- ===== SECCIÓN 1: INVENTARIO (POR DEFECTO) ===== --}}
                    <section id="inventario" class="mb-8 tabs-section">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">Catálogo de Inventario</h2>
                                <p class="text-xs text-slate-400">Consulta las unidades reales y variaciones.</p>
                            </div>

                            <select id="filtroCategoriaEmp" onchange="filtrarInventarioEmpleado()"
                                class="rounded-2xl border border-pink-100 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-pink-300">
                                <option value="">Todas las Categorías</option>
                                @foreach ($generos as $g)
                                    <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid gap-5 lg:grid-cols-2">
                            @foreach ($prendas as $p)
                                <div class="card-prenda-emp rounded-3xl bg-white border {{ $p->stock <= $p->min_stock ? 'border-amber-300 bg-amber-50/20' : 'border-pink-100' }} p-6 shadow-sm transition"
                                    data-genero="{{ $p->fk_id_genero }}">
                                    <div class="flex items-start gap-4">
                                        @if ($p->imagen_prend)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($p->imagen_prend) }}"
                                                alt="{{ $p->nombre_prend }}"
                                                class="h-20 w-20 rounded-3xl object-cover shrink-0" />
                                        @else
                                            <div
                                                class="h-20 w-20 rounded-3xl bg-pink-100 flex items-center justify-center text-pink-500 text-3xl font-bold shrink-0">
                                                {{ strtoupper(substr($p->nombre_prend, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between gap-4">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-slate-900">{{ $p->nombre_prend }}
                                                    </h3>
                                                    <p class="text-xs text-slate-400 font-mono">Código:
                                                        {{ $p->codigo_barras }}</p>
                                                </div>
                                                <span
                                                    class="text-lg font-bold text-pink-500">${{ number_format($p->precio, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="mt-4 grid grid-cols-2 gap-2">
                                                <div
                                                    class="rounded-2xl {{ $p->stock <= $p->min_stock ? 'bg-amber-100 text-amber-800 font-bold' : 'bg-pink-50/60 text-slate-700' }} p-2 text-xs text-center">
                                                    Stock: {{ $p->stock }} uds
                                                </div>
                                                <div
                                                    class="rounded-2xl bg-pink-50/60 p-2 text-xs text-center text-slate-700">
                                                    Talla: {{ $p->talla_prend }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="mt-4 pt-3 border-t border-dashed border-pink-100 flex items-center justify-between">
                                        <div>
                                            @if ($p->stock <= $p->min_stock)
                                                <span class="text-xs font-bold text-amber-600 animate-pulse">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> ¡Bajo Stock!
                                                </span>
                                            @else
                                                <span class="text-xs font-semibold text-emerald-600">Stock Óptimo</span>
                                            @endif
                                        </div>
                                        <button type="button"
                                            onclick="notificarAlertaStock('{{ $p->nombre_prend }}', '{{ $p->codigo_barras }}')"
                                            class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-100 border border-amber-200 px-3 py-1.5 rounded-xl hover:bg-amber-200 transition">
                                            <i class="fa-solid fa-bullhorn"></i> Avisar Bajo Stock
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- ===== SECCIÓN 2: REGISTRAR APARTADOS (CORREGIDA LA CONTENCIÓN) ===== --}}
                    <section id="apartados" class="mb-8 tabs-section hidden">
                        <form action="{{ route('apartados.store') }}" method="POST" id="formApartado"
                            class="space-y-6 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                            @csrf

                            <input type="hidden" id="carrito_items_input" name="carrito_items" value="[]">

                            <button type="button" onclick="toggleModal('modalApartados')"
                                class="inline-flex items-center gap-2 text-sm font-bold text-pink-600 bg-pink-50 border border-pink-100 px-5 py-3 rounded-2xl hover:bg-pink-100 hover:text-pink-700 transition shadow-sm cursor-pointer">
                                <i class="fa-solid fa-clock-history fa-lg"></i>
                                Ver Historial / Quién Apartó
                            </button>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-pink-50/50 border border-pink-100 p-5 rounded-2xl space-y-2">
                                    <label
                                        class="block text-xs uppercase tracking-wider font-bold text-pink-600 flex items-center justify-between">
                                        <span><i class="fa-solid fa-envelope"></i> Correo del Cliente</span>
                                        <span id="clienteStatus"
                                            class="text-[10px] text-slate-400 hidden">Buscando...</span>
                                    </label>
                                    <input type="email" id="correo_cliente_input" name="correo_cliente" required
                                        placeholder="cliente@correo.com"
                                        class="w-full rounded-xl border border-pink-200 p-3" />
                                </div>
                                <div class="self-end pb-2">
                                    <input type="text" id="nombre_cliente" readonly
                                        placeholder="Nombre del cliente..."
                                        class="w-full rounded-xl bg-slate-50 border p-3 font-bold text-slate-700" />
                                </div>
                            </div>

                            <div class="bg-violet-50/50 border border-violet-100 p-5 rounded-2xl space-y-2">
                                <label
                                    class="block text-xs uppercase tracking-wider font-bold text-violet-600 flex items-center justify-between">
                                    <span><i class="fa-solid fa-barcode"></i> Escanear Código de Barras</span>
                                    <span id="searchStatus" class="text-[10px] text-slate-400 hidden">Buscando...</span>
                                </label>
                                <input type="text" id="codigo_barras_input" placeholder="Escanea aquí para buscar..."
                                    class="w-full rounded-xl border border-violet-200 p-3 font-mono font-bold" />
                            </div>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-xl border border-dashed">
                                <div class="sm:col-span-2">
                                    <label class="block text-[10px] uppercase font-bold text-slate-400">Prenda</label>
                                    <input type="text" id="nombre_prend" readonly
                                        class="w-full bg-transparent font-bold outline-none" placeholder="Ninguna">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-slate-400">Precio</label>
                                    <input type="number" id="precio_unitario" readonly
                                        class="w-full bg-transparent font-mono font-bold outline-none" placeholder="0">
                                </div>
                                <div>
                                    <button type="button" id="btn_agregar_carrito" disabled
                                        class="w-full bg-slate-300 text-white font-bold text-xs py-2 rounded-lg cursor-not-allowed transition">
                                        + Añadir
                                    </button>
                                </div>
                            </div>

                            <div class="border border-slate-100 rounded-2xl overflow-hidden mt-6">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-slate-950 text-white text-xs uppercase tracking-wider">
                                        <tr>
                                            <th class="p-4">Prenda / Código</th>
                                            <th class="p-4 text-center">Cant.</th>
                                            <th class="p-4 text-right">Precio</th>
                                            <th class="p-4 text-right">Subtotal</th>
                                            <th class="p-4 text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_carrito_body" class="divide-y divide-slate-100 text-sm">
                                        <tr id="carrito_vacio_row">
                                            <td colspan="5" class="p-8 text-center text-slate-400 font-medium">No hay
                                                productos agregados al apartado.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t">
                                {{-- Columna 1: Anticipo --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2"><i
                                            class="fa-solid fa-hand-holding-dollar"></i> Monto del Anticipo ($ COP)</label>
                                    <input type="number" id="anticipo_apartado" name="anticipo" required min="0"
                                        placeholder="Ej: 20000"
                                        class="w-full rounded-xl border p-3 font-bold text-slate-800 focus:border-pink-300 outline-none" />
                                </div>

                                {{-- Columna 2: Fecha Límite (NUEVO) --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2"><i
                                            class="fa-solid fa-calendar-calendar"></i> Fecha Límite de Retiro</label>
                                    <input type="date" id="fecha_limite_input" name="fecha_limite" required
                                        class="w-full rounded-xl border p-3 font-semibold text-slate-700 focus:border-pink-300 outline-none"
                                        min="{{ date('Y-m-d') }}" />
                                </div>

                                {{-- Columna 3: Total y Botón --}}
                                <div class="bg-slate-900 text-white p-4 rounded-2xl flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-slate-400">Total Acumulado</p>
                                        <h3 class="text-2xl font-black text-pink-400" id="resumen_total">$0</h3>
                                    </div>
                                    <button type="submit" id="btnSubmit" disabled
                                        class="bg-slate-700 text-slate-400 font-bold px-5 py-3 rounded-xl cursor-not-allowed transition">
                                        Confirmar Apartado
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>

                    {{-- ===== SECCIÓN 3: CONSULTAR EMPLEADOS ===== --}}
                    <section id="consultar_empleados" class="mb-8 tabs-section hidden">
                        <div class="rounded-3xl bg-white border border-pink-100 p-6 shadow-sm">
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-slate-900">Directorio de Empleados</h2>
                                <p class="text-xs text-slate-400 mt-1">Lista de consulta del personal y compañeros activos
                                    en el sistema.</p>
                            </div>

                            <div class="mb-6 flex flex-col sm:flex-row gap-4">
                                <div class="relative flex-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                                    </span>
                                    <input type="text" id="searchEmpleado" onkeyup="filtrarEmpleados()"
                                        class="w-full pl-11 pr-4 py-2.5 rounded-2xl border border-pink-100 bg-white text-sm text-slate-700 outline-none focus:border-pink-300 placeholder-slate-400"
                                        placeholder="Buscar por nombre o correo...">
                                </div>
                                <select id="filtroRolEmp" onchange="filtrarEmpleados()"
                                    class="rounded-2xl border border-pink-100 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-pink-300">
                                    <option value="">Todos los Roles</option>
                                </select>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                                @foreach ($usuarios as $user)
                                    <div class="card-usuario-emp"
                                        data-name="{{ strtolower($user->primer_nom . ' ' . $user->primer_apelli) }}"
                                        data-email="{{ strtolower($user->correo) }}"
                                        data-role="{{ strtolower($user->nom_rol ?? ($user->role ?? 'Empleado')) }}">

                                        <div
                                            class="p-5 border border-pink-100 rounded-3xl bg-white shadow-sm flex flex-col justify-between h-full">
                                            <div class="flex items-center gap-3">
                                                <div>
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">
                                                        {{ strtoupper(substr($user->primer_nom, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-base leading-tight">
                                                        {{ $user->primer_nom }} {{ $user->primer_apelli }}
                                                    </h4>
                                                    <p class="text-xs text-slate-400">{{ $user->correo }}</p>

                                                    <span
                                                        class="mt-2 inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 bg-pink-50 text-pink-600 rounded-md">
                                                        {{ $user->nom_rol ?? ($user->role ?? 'Empleado') }}
                                                    </span>
                                                </div>
                                            </div>
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
        // ==========================================
        // VARIABLES GLOBALES DEL CARRITO DE APARTADOS
        // ==========================================
        let carrito = [];
        let prendaTemporal = null;
        let clienteValidado = false;

        const formatterCOP = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        });

        /**
 * Alterna la visibilidad del modal de apartados
 * @param {string} modalId - El ID del elemento modal (ej: 'modalApartados')
 */
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        // Alternamos entre hidden (oculto) y flex (visible y centrado)
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }
}

        document.addEventListener('DOMContentLoaded', function() {

            // ==========================================
            // 1. SISTEMA DE PESTAÑAS Y FILTROS ORIGINALES
            // ==========================================
            const links = document.querySelectorAll('.sidebar-link');
            const sections = document.querySelectorAll('.tabs-section');

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetSection = this.getAttribute('data-section');
                    links.forEach(l => l.classList.remove('active-link', 'bg-pink-500/10',
                        'text-pink-600'));
                    this.classList.add('active-link', 'bg-pink-500/10', 'text-pink-600');
                    sections.forEach(sec => {
                        if (sec.id === targetSection) sec.classList.remove('hidden');
                        else sec.classList.add('hidden');
                    });
                });
            });

            // Rellenar select de roles dinámicamente
            const selectRol = document.getElementById('filtroRolEmp');
            if (selectRol) {
                const cards = document.querySelectorAll('.card-usuario-emp');
                const rolesSet = new Set();
                cards.forEach(card => {
                    const r = card.getAttribute('data-role');
                    if (r) rolesSet.add(r.trim());
                });
                rolesSet.forEach(role => {
                    const option = document.createElement('option');
                    option.value = role;
                    option.textContent = role.charAt(0).toUpperCase() + role.slice(1);
                    selectRol.appendChild(option);
                });
            }

            // ==========================================
            // 2. BUSCADOR EN TIEMPO REAL: CLIENTE por Correo
            // ==========================================
            const correoInput = document.getElementById('correo_cliente_input');
            if (correoInput) {
                correoInput.addEventListener('change', function(e) {
                    const correo = e.target.value.trim();
                    const statusLabel = document.getElementById('clienteStatus');
                    const nombreClienteInput = document.getElementById('nombre_cliente');

                    if (correo.length > 3) {
                        statusLabel.classList.remove('hidden');

                        fetch(`/dashboard/cliente/buscar/${encodeURIComponent(correo)}`)
                            .then(response => {
                                if (!response.ok) throw new Error("No encontrado");
                                return response.json();
                            })
                            .then(data => {
                                statusLabel.classList.add('hidden');
                                if (data.success) {
                                    nombreClienteInput.value =
                                        `${data.cliente.primer_nom} ${data.cliente.primer_apelli}`;
                                    clienteValidado = true;
                                    validarFormularioCompleto();
                                    showAlert('Cliente verificado y vinculado.', 'emerald');
                                }
                            })
                            .catch(error => {
                                statusLabel.classList.add('hidden');
                                nombreClienteInput.value = '';
                                clienteValidado = false;
                                validarFormularioCompleto();
                                showAlert('El correo no coincide con ningún cliente.', 'rose');
                            });
                    } else {
                        nombreClienteInput.value = '';
                        clienteValidado = false;
                        validarFormularioCompleto();
                    }
                });
            }

            // ==========================================
            // 3. BUSCADOR EN TIEMPO REAL: PRENDA por Código de Barras
            // ==========================================
            const codigoInput = document.getElementById('codigo_barras_input');
            if (codigoInput) {
                codigoInput.addEventListener('input', function(e) {
                    const codigo = e.target.value.trim();
                    const statusLabel = document.getElementById('searchStatus');
                    const btnAgregar = document.getElementById('btn_agregar_carrito');

                    if (codigo.length >= 3) {
                        statusLabel.classList.remove('hidden');

                        fetch(`/dashboard/prenda/buscar/${codigo}`)
                            .then(response => {
                                if (!response.ok) throw new Error("Inexistente");
                                return response.json();
                            })
                            .then(data => {
                                statusLabel.classList.add('hidden');
                                if (data.success) {
                                    prendaTemporal = data.prenda;
                                    document.getElementById('nombre_prend').value = prendaTemporal
                                        .nombre_prend;
                                    document.getElementById('precio_unitario').value = prendaTemporal
                                        .precio;

                                    btnAgregar.disabled = false;
                                    btnAgregar.className =
                                        "w-full bg-violet-600 hover:bg-violet-700 text-white font-bold text-xs py-2 rounded-lg cursor-pointer transition";
                                    showAlert('Producto listo para añadir.', 'emerald');
                                }
                            })
                            .catch(error => {
                                statusLabel.classList.add('hidden');
                                limpiarPrevisualizacionPrenda();
                            });
                    } else {
                        limpiarPrevisualizacionPrenda();
                    }
                });
            }

            // ==========================================
            // 4. LOGICA DEL CARRITO (AÑADIR)
            // ==========================================
            const btnAgregarCarrito = document.getElementById('btn_agregar_carrito');
            if (btnAgregarCarrito) {
                btnAgregarCarrito.addEventListener('click', function() {
                    if (!prendaTemporal) return;

                    const indexExistente = carrito.findIndex(item => item.codigo_barras === prendaTemporal
                        .codigo_barras);

                    if (indexExistente !== -1) {
                        if (carrito[indexExistente].cantidad < prendaTemporal.stock) {
                            carrito[indexExistente].cantidad += 1;
                        } else {
                            showAlert('No puedes añadir más, superas el stock disponible.', 'amber');
                            return;
                        }
                    } else {
                        carrito.push({
                            codigo_barras: prendaTemporal.codigo_barras,
                            nombre: prendaTemporal.nombre_prend,
                            precio: parseInt(prendaTemporal.precio),
                            cantidad: 1
                        });
                    }

                    document.getElementById('codigo_barras_input').value = '';
                    document.getElementById('codigo_barras_input').focus();
                    limpiarPrevisualizacionPrenda();
                    renderizarTablaCarrito();
                });
            }
        });

        function limpiarPrevisualizacionPrenda() {
            prendaTemporal = null;
            document.getElementById('nombre_prend').value = '';
            document.getElementById('precio_unitario').value = '';
            const btn = document.getElementById('btn_agregar_carrito');
            if (btn) {
                btn.disabled = true;
                btn.className =
                    "w-full bg-slate-300 text-white font-bold text-xs py-2 rounded-lg cursor-not-allowed transition";
            }
        }

        function renderizarTablaCarrito() {
            const tbody = document.getElementById('tabla_carrito_body');
            tbody.innerHTML = '';

            if (carrito.length === 0) {
                tbody.innerHTML = `
                    <tr id="carrito_vacio_row">
                        <td colspan="5" class="p-8 text-center text-slate-400 font-medium">No hay productos agregados al apartado.</td>
                    </tr>`;
                actualizarTotalesFinales(0);
                return;
            }

            let totalAcumulado = 0;
            carrito.forEach((item, index) => {
                const subtotal = item.precio * item.cantidad;
                totalAcumulado += subtotal;

                const fila = document.createElement('tr');
                fila.className = "hover:bg-slate-50 transition";
                fila.innerHTML = `
                    <td class="p-4 font-medium text-slate-800">
                        <div>${item.nombre}</div>
                        <div class="text-xs text-slate-400 font-mono">${item.codigo_barras}</div>
                    </td>
                    <td class="p-4 text-center font-bold text-slate-700">${item.cantidad} u</td>
                    <td class="p-4 text-right font-mono text-slate-500">${formatterCOP.format(item.precio)}</td>
                    <td class="p-4 text-right font-mono font-bold text-slate-900">${formatterCOP.format(subtotal)}</td>
                    <td class="p-4 text-center">
                        <button type="button" onclick="eliminarDelCarrito(${index})" class="text-rose-500 hover:text-rose-700 p-2 transition">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(fila);
            });

            actualizarTotalesFinales(totalAcumulado);
        }

        function eliminarDelCarrito(index) {
            carrito.splice(index, 1);
            renderizarTablaCarrito();
        }

        function actualizarTotalesFinales(total) {
            document.getElementById('resumen_total').innerText = formatterCOP.format(total);
            document.getElementById('carrito_items_input').value = JSON.stringify(carrito);
            validarFormularioCompleto();
        }

        function validarFormularioCompleto() {
            const btnSubmit = document.getElementById('btnSubmit');
            if (!btnSubmit) return;

            if (clienteValidado && carrito.length > 0) {
                btnSubmit.disabled = false;
                btnSubmit.className =
                    "bg-pink-500 hover:bg-pink-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-pink-500/20 cursor-pointer transition";
            } else {
                btnSubmit.disabled = true;
                btnSubmit.className =
                    "bg-slate-700 text-slate-400 font-bold px-6 py-3 rounded-xl cursor-not-allowed transition";
            }
        }

        function showAlert(msg, color) {
            const alertBox = document.getElementById('alertBoxEmpleado');
            if (!alertBox) return;
            alertBox.innerText = msg;
            alertBox.className =
                `mb-6 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm bg-${color}-50 border border-${color}-100 text-${color}-700`;
            alertBox.classList.remove('hidden');
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 4000);
        }

        function filtrarInventarioEmpleado() {
            const cat = document.getElementById('filtroCategoriaEmp').value;
            const cards = document.querySelectorAll('.card-prenda-emp');
            cards.forEach(card => {
                if (!cat || card.getAttribute('data-genero') === cat) card.classList.remove('hidden');
                else card.classList.add('hidden');
            });
        }

        function filtrarEmpleados() {
            const searchVal = document.getElementById('searchEmpleado').value.toLowerCase();
            const roleVal = document.getElementById('filtroRolEmp').value.toLowerCase();
            const cards = document.querySelectorAll('.card-usuario-emp');

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const email = card.getAttribute('data-email') || '';
                const role = card.getAttribute('data-role') || '';

                const matchesSearch = name.includes(searchVal) || email.includes(searchVal);
                const matchesRole = !roleVal || role === roleVal;

                if (matchesSearch && matchesRole) card.classList.remove('hidden');
                else card.classList.add('hidden');
            });
        }

        function notificarAlertaStock(nombre, codigo) {
            const alertBox = document.getElementById('alertBoxEmpleado');
            if (!alertBox) return;
            alertBox.innerText = `📢 Alerta enviada al administrador para el producto: ${nombre} (${codigo})`;
            alertBox.className =
                "mb-6 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm bg-amber-50 border border-amber-100 text-amber-700";
            alertBox.classList.remove('hidden');
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 5000);
        }

        function filtrarApartados() {
    let input = document.getElementById("searchApartado").value.toLowerCase();
    let rows = document.querySelectorAll("#tabla_apartados tbody tr");
    rows.forEach(row => {
        let id = row.getAttribute("data-id");
        row.style.display = id.includes(input) ? "" : "none";
    });
}
    </script>
    {{-- MODAL DE HISTORIAL DE APARTADOS --}}
    <div id="modalApartados"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 transition-all">
        <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-100">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-3xl">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Historial de Apartados</h3>
                    <p class="text-xs text-slate-400">Listado de prendas reservadas por clientes</p>
                </div>
                <button onclick="toggleModal('modalApartados')"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-400 hover:text-slate-600 hover:shadow-sm transition font-bold">&times;</button>
                    
            </div>
            

            <div class="p-6 overflow-y-auto flex-1">
                <input type="text" id="searchApartado" onkeyup="filtrarApartados()" placeholder="Buscar por ID..." 
                   class="w-full mb-4 px-4 py-2 border border-slate-200 rounded-lg">
                <div class="overflow-x-auto rounded-2xl border border-slate-100 shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                <th class="py-3.5 px-4">Cliente</th>
                                <th class="py-3.5 px-4">Prenda</th>
                                <th class="py-3.5 px-4">Atendido Por</th>
                                <th class="py-3.5 px-4">Fecha Registro</th>
                                <th class="py-3.5 px-4">Anticipo</th>
                                <th class="py-3.5 px-4 text-rose-500">Fecha Límite</th>
                                <th class="py-3.5 px-4">Anticipo</th>
                                <th class="py-3.5 px-4">Total</th>
                                <th class="py-3.5 px-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-600 text-sm divide-y divide-slate-50">
                            @forelse($apartados as $ap)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-3.5 px-4">
                                        <div class="font-semibold text-slate-700">{{ $ap->cli_nom }} {{ $ap->cli_ape }}
                                        </div>
                                        <div class="text-xs text-slate-400"><i class="fas fa-envelope text-[10px]"></i>
                                            {{ $ap->cli_correo }}</div>
                                    </td>
                                    <td class="py-3.5 px-4">{{ $ap->nombre_prend }}</td>
                                    <td class="py-3.5 px-4">
                                        <div
                                            class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-2 py-1 rounded-lg text-xs font-bold">
                                            ID: {{ $ap->emp_id }}
                                        </div>
                                        <div class="text-xs font-medium text-slate-600 mt-0.5">{{ $ap->emp_nom }}
                                            {{ $ap->emp_ape }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-400 text-xs">
                                        {{ \Carbon\Carbon::parse($ap->fecha_apartado)->format('d/m/Y g:i a') }}</td>
                                    <td class="py-3.5 px-4 text-rose-600 font-bold text-xs">
                                        {{ $ap->fecha_limite ? \Carbon\Carbon::parse($ap->fecha_limite)->format('d/m/Y') : 'No estipulada' }}
                                    </td>

                                    <td class="py-3.5 px-4 font-medium text-emerald-600">
                                        ${{ number_format($ap->anticipo, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 font-medium text-emerald-600">
                                        ${{ number_format($ap->anticipo, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-4 font-bold text-slate-800">
                                        ${{ number_format($ap->total, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-4">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold {{ $ap->estado === 'pendiente' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}">
                                            {{ ucfirst($ap->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-8 text-center text-slate-400 text-sm">No hay registros de
                                        apartados guardados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modalTicket" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-80">
        <h2 class="font-bold text-lg mb-4">Ticket de Apartado</h2>
        <div id="contenidoTicket" class="text-sm space-y-2">
            </div>
        <button onclick="document.getElementById('modalTicket').classList.add('hidden')" class="mt-4 w-full bg-gray-300 py-2 rounded">Cerrar</button>
        <button onclick="window.print()" class="mt-2 w-full bg-pink-500 text-white py-2 rounded">Imprimir</button>
    </div>
</div>

<script>
function verTicket(id) {
    // Aquí haces un fetch a una ruta que te devuelva los datos del apartado
    fetch(`/apartado/detalles/${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('contenidoTicket').innerHTML = `
                <p><strong>ID:</strong> ${data.id_apartado}</p>
                <p><strong>Producto:</strong> ${data.nom_prend}</p>
                <p><strong>Cantidad:</strong> ${data.cantidad}</p>
                <p><strong>Abono:</strong> $${data.anticipo}</p>
                <p><strong>Total:</strong> $${data.total}</p>
                <p><strong>Fecha Límite:</strong> ${data.fecha_limite}</p>
            `;
            document.getElementById('modalTicket').classList.remove('hidden');
        });
         function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }
}
</script>
@endsection
