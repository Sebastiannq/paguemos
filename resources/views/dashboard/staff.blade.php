@extends('layouts.app')

@section('title', 'Dashboard - Pague Menos Staff')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="min-h-screen bg-gray-100">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bebas leading-tight">
                    <span class="text-gray-900">PAGUE</span>
                    <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
                </h1>   
                <p class="text-gray-600 text-sm">Panel de Administración</p>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-gray-700 font-medium">{{ session('user_name') }}</span>
                <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-semibold capitalize">
                    {{ session('user_role') }}
                </span>
                <a href="{{ route('logout') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-sm">
                    Cerrar Sesión
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">¡Bienvenido de vuelta!</h2>
                <p class="text-gray-600">Aquí puedes gestionar tu tienda, controlar el inventario y ver las estadísticas.</p>
            </div>
            <div>
                <button onclick="toggleModal('createModal')" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-5 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                    <i class="fa-solid fa-plus"></i> Nueva Prenda
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-pink-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Prendas en Sistema</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ count($prendas) }}</p>
                    </div>
                    <div class="text-4xl text-pink-200"><i class="fa-solid fa-shirt"></i></div>
                </div>
                <p class="text-gray-600 text-xs mt-4">Modelos de ropa registrados</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Stock Crítico</p>
                        <p class="text-3xl font-bold text-amber-600 mt-2">
                            {{ $prendas->filter(fn($p) => $p->stock <= $p->min_stock)->count() }}
                        </p>
                    </div>
                    <div class="text-4xl text-amber-200"><i class="fa-solid fa-triangle-exclamation"></i></div>
                </div>
                <p class="text-gray-600 text-xs mt-4">Prendas por debajo del mínimo</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Visibles en Tienda</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">
                            {{ $prendas->where('estado', 1)->count() }}
                        </p>
                    </div>
                    <div class="text-4xl text-green-200"><i class="fa-solid fa-eye"></i></div>
                </div>
                <p class="text-gray-600 text-xs mt-4">Estado catálogo activo</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-gray-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Inactivos / Ocultos</p>
                        <p class="text-3xl font-bold text-gray-700 mt-2">
                            {{ $prendas->where('estado', 0)->count() }}
                        </p>
                    </div>
                    <div class="text-4xl text-gray-300"><i class="fa-solid fa-eye-slash"></i></div>
                </div>
                <p class="text-gray-600 text-xs mt-4">Fuera de línea temporalmente</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mb-12">
            <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900">Listado Maestro de Prendas</h3>
                <span class="text-xs text-gray-500 font-mono">Tabla: prenda</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 text-xs font-semibold uppercase tracking-wider">
                            <th class="p-4">ID</th>
                            <th class="p-4">Prenda</th>
                            <th class="p-4">Precio</th>
                            <th class="p-4">Stock Actual</th>
                            <th class="p-4">Rangos (Mín/Máx)</th>
                            <th class="p-4">Atributos (BDD)</th>
                            <th class="p-4">Estado</th>
                            <th class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        @foreach($prendas as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-mono text-gray-400">#{{ $p->id_prenda }}</td>
                            <td class="p-4">
                                <div class="font-bold text-gray-900">{{ $p->nombre_prend }}</div>
                                <div class="text-gray-500 text-xs mt-0.5">{{ $p->descripcion_prend }}</div>
                            </td>
                            <td class="p-4 font-semibold text-pink-600">${{ number_format($p->precio, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded text-xs font-bold {{ $p->stock <= $p->min_stock ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $p->stock }} unds
                                </span>
                            </td>
                            <td class="p-4 font-mono text-xs text-gray-500">
                                Min: {{ $p->min_stock }} | Max: {{ $p->max_stock }}
                            </td>
                            <td class="p-4">
                                <div class="flex gap-1.5 flex-wrap">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-xs text-gray-600 border border-gray-200 font-medium">{{ $p->talla_prend }}</span>
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-xs text-gray-600 border border-gray-200 font-medium">{{ $p->nom_color }}</span>
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-xs text-gray-600 border border-gray-200 font-medium">{{ $p->tipo_genero }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $p->estado == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $p->estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <button onclick="openEditModal({{ json_encode($p) }})" class="text-blue-600 hover:text-blue-800 transition p-1" title="Editar Prenda">
                                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                                </button>
                                <form action="{{ route('prenda.destroy', $p->id_prenda) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Seguro deseas eliminar esta prenda del inventario por completo?')" class="text-red-500 hover:text-red-700 transition p-1" title="Eliminar">
                                        <i class="fa-solid fa-trash-can text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($prendas) == 0)
                        <tr>
                            <td colspan="8" class="text-center p-8 text-gray-400 font-medium">No hay prendas registradas en el inventario actual.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-12">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Administración de Empleados</h3>
            @if (session('user_role') === 'administrador')
                <div class="bg-white rounded-lg shadow p-6">
                    <button class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition font-semibold shadow-sm">
                        + Agregar Empleado
                    </button>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <p class="text-blue-800 font-medium"><i class="fa-solid fa-info-circle mr-1"></i> Eres un empleado. Solo los administradores pueden gestionar la plantilla de empleados.</p>
                </div>
            @endif
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
            <h2 class="text-xl font-bold flex items-center gap-2 text-blue-600"><i class="fa-solid fa-pen-to-square"></i> Editar Características de Prenda</h2>
            <button onclick="toggleModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nombre Prenda</label>
                    <input type="text" name="nombre_prend" id="edit_nombre" max="25" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Descripción Breve</label>
                    <input type="text" name="descripcion_prend" id="edit_descripcion" max="35" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Precio ($ COP)</label>
                    <input type="number" name="precio" id="edit_precio" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Actual</label>
                    <input type="number" name="stock" id="edit_stock" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Mínimo</label>
                    <input type="number" name="min_stock" id="edit_min" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Stock Máximo</label>
                    <input type="number" name="max_stock" id="edit_max" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Género</label>
                    <select name="fk_id_genero" id="edit_genero" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                        @foreach($generos as $g) <option value="{{ $g->id_genero_prend }}">{{ $g->tipo_genero }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Talla</label>
                    <select name="fk_idt_prendas" id="edit_talla" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                        @foreach($tallas as $t) <option value="{{ $t->idt_prendas }}">{{ $t->talla_prend }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Color</label>
                    <select name="fk_id_color" id="edit_color" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                        @foreach($colores as $c) <option value="{{ $c->id_color }}">{{ $c->nom_color }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Estado de Visibilidad</label>
                    <select name="estado" id="edit_estado" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-gray-900 focus:outline-none focus:border-blue-500">
                        <option value="1">Activo (Visible en Tienda)</option>
                        <option value="0">Inactivo (Oculto)</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="toggleModal('editModal')" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition font-medium">Cancelar</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">Actualizar Prenda</button>
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
</script>
@endsection