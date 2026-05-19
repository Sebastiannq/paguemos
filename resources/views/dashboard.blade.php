<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paguemenos - Panel de Contro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 font-sans hidden-scrollbar">

    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col justify-between">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-8">
                    <div class="bg-cyan-500 p-2 rounded-lg text-slate-950 font-bold text-xl tracking-wider">PM</div>
                    <span class="text-xl font-bold tracking-wide bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">Paguemenos</span>
                </div>
                <nav class="space-y-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 bg-cyan-950/50 text-cyan-400 rounded-lg font-medium transition"><i class="fa-solid fa-box"></i> Inventario Prendas</a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-900 hover:text-slate-200 rounded-lg transition"><i class="fa-solid fa-chart-line"></i> Ventas</a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-900 hover:text-slate-200 rounded-lg transition"><i class="fa-solid fa-users"></i> Usuarios</a>
                </nav>
            </div>
            <div class="p-4 border-t border-slate-800">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 text-rose-400 hover:bg-rose-950/30 rounded-lg transition"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-slate-900 p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold">Inventario de Prendas</h1>
                    <p class="text-slate-400 text-sm mt-1">Administra el stock, precios y características de la tienda.</p>
                </div>
                <button onclick="toggleModal('createModal')" class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-lg shadow-cyan-500/20"><i class="fa-solid fa-plus"></i> Nueva Prenda</button>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-slate-950 p-6 rounded-xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase">Total Prendas</p>
                        <h3 class="text-3xl font-bold mt-1">{{ count($prendas) }}</h3>
                    </div>
                    <div class="bg-blue-500/10 text-blue-400 p-4 rounded-xl"><i class="fa-solid fa-shirt text-2xl"></i></div>
                </div>
                <div class="bg-slate-950 p-6 rounded-xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase">Stock Alerta Crítica</p>
                        <h3 class="text-3xl font-bold mt-1 text-amber-500">
                            {{ $prendas->filter(fn($p) => $p->stock <= $p->min_stock)->count() }}
                        </h3>
                    </div>
                    <div class="bg-amber-500/10 text-amber-400 p-4 rounded-xl"><i class="fa-solid fa-triangle-exclamation text-2xl"></i></div>
                </div>
                <div class="bg-slate-950 p-6 rounded-xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase">Estado Activo</p>
                        <h3 class="text-3xl font-bold mt-1 text-emerald-500">{{ $prendas->where('estado', 1)->count() }}</h3>
                    </div>
                    <div class="bg-emerald-500/10 text-emerald-400 p-4 rounded-xl"><i class="fa-solid fa-circle-check text-2xl"></i></div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-950/50 border border-emerald-500 text-emerald-400 p-4 rounded-lg mb-6 flex items-center gap-2"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <div class="bg-slate-950 border border-slate-800 rounded-xl overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 border-b border-slate-800 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="p-4">ID</th>
                            <th class="p-4">Prenda</th>
                            <th class="p-4">Precio</th>
                            <th class="p-4">Stock (Min/Max)</th>
                            <th class="p-4">Atributos</th>
                            <th class="p-4">Estado</th>
                            <th class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm">
                        @foreach($prendas as $p)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-4 font-mono text-slate-500">#{{ $p->id_prenda }}</td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-200">{{ $p->nombre_prend }}</div>
                                <div class="text-slate-500 text-xs mt-0.5">{{ $p->descripcion_prend }}</div>
                            </td>
                            <td class="p-4 font-medium text-cyan-400">${{ number_format($p->precio, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <span class="{{ $p->stock <= $p->min_stock ? 'text-rose-400 font-bold' : 'text-slate-300' }}">{{ $p->stock }}</span>
                                <span class="text-slate-600 text-xs"> / ({{ $p->min_stock }}-{{ $p->max_stock }})</span>
                            </td>
                            <td class="p-4">
                                <div class="flex gap-1.5 flex-wrap">
                                    <span class="bg-slate-800 px-2 py-0.5 rounded text-xs text-slate-400 border border-slate-700">{{ $p->talla_prend }}</span>
                                    <span class="bg-slate-800 px-2 py-0.5 rounded text-xs text-slate-400 border border-slate-700">{{ $p->nom_color }}</span>
                                    <span class="bg-slate-800 px-2 py-0.5 rounded text-xs text-slate-400 border border-slate-700">{{ $p->tipo_genero }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $p->estado == 1 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400' }}">
                                    {{ $p->estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <button onclick="openEditModal({{ json_encode($p) }})" class="text-cyan-400 hover:text-cyan-300 transition p-1.5"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form action="{{ route('prenda.destroy', $p->id_prenda) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Seguro deseas eliminar esta prenda?')" class="text-rose-400 hover:text-rose-300 transition p-1.5"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="createModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
        <div class="bg-slate-950 border border-slate-800 w-full max-w-2xl rounded-xl p-6 shadow-2xl overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold flex items-center gap-2 text-cyan-400"><i class="fa-solid fa-shirt"></i> Agregar Nueva Prenda</h2>
                <button onclick="toggleModal('createModal')" class="text-slate-400 hover:text-slate-200 text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('prenda.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Nombre Prenda</label>
                        <input type="text" name="nombre_prend" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Descripción Breve</label>
                        <input type="text" name="descripcion_prend" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Precio ($ COP)</label>
                        <input type="number" name="precio" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Stock Actual</label>
                        <input type="number" name="stock" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Stock Mínimo</label>
                        <input type="number" name="min_stock" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Stock Máximo</label>
                        <input type="number" name="max_stock" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Género</label>
                        <select name="fk_id_genero" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            @foreach($generos as $g) <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Talla</label>
                        <select name="fk_idt_prendas" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            @foreach($tallas as $t) <option value="{{ $t->idt_prendas }}">{{ $t->talla_prend }}</option> @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Color</label>
                        <select name="fk_id_color" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            @foreach($colores as $c) <option value="{{ $c->id_color }}">{{ $c->nom_color }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('createModal')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 rounded-lg transition font-medium">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold rounded-lg transition">Guardar Prenda</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
        <div class="bg-slate-950 border border-slate-800 w-full max-w-2xl rounded-xl p-6 shadow-2xl overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold flex items-center gap-2 text-amber-400"><i class="fa-solid fa-pen-to-square"></i> Editar Prenda</h2>
                <button onclick="toggleModal('editModal')" class="text-slate-400 hover:text-slate-200 text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Nombre Prenda</label>
                        <input type="text" name="nombre_prend" id="edit_nombre" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Descripción Breve</label>
                        <input type="text" name="descripcion_prend" id="edit_descripcion" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Precio ($ COP)</label>
                        <input type="number" name="precio" id="edit_precio" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Stock Actual</label>
                        <input type="number" name="stock" id="edit_stock" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Stock Mínimo</label>
                        <input type="number" name="min_stock" id="edit_min" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Stock Máximo</label>
                        <input type="number" name="max_stock" id="edit_max" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Género</label>
                        <select name="fk_id_genero" id="edit_genero" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            @foreach($generos as $g) <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Talla</label>
                        <select name="fk_idt_prendas" id="edit_talla" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            @foreach($tallas as $t) <option value="{{ $t->idt_prendas }}">{{ $t->talla_prend }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Color</label>
                        <select name="fk_id_color" id="edit_color" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            @foreach($colores as $c) <option value="{{ $c->id_color }}">{{ $c->nom_color }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Estado del Producto</label>
                        <select name="estado" id="edit_estado" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            <option value="1">Activo (Visible)</option>
                            <option value="0">Inactivo (Oculto)</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('editModal')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 rounded-lg transition font-medium">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-semibold rounded-lg transition">Actualizar Cambios</button>
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
            // Setea dinámicamente la URL de actualización del formulario
            document.getElementById('editForm').action = `/dashboard/prenda/${prenda.id_prenda}`;
            
            // Carga los inputs con los valores del registro seleccionado
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
    </script>
</body>
</html>