<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paguemenos - Gestión de Usuarios</title>
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
                    <a href="{{ route('dashboard.staff') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-900 hover:text-slate-200 rounded-lg transition"><i class="fa-solid fa-box"></i> Inventario Prendas</a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-900 hover:text-slate-200 rounded-lg transition"><i class="fa-solid fa-chart-line"></i> Ventas</a>
                    <a href="{{ route('usuarios.index') }}" class="flex items-center gap-3 px-4 py-3 bg-cyan-950/50 text-cyan-400 rounded-lg font-medium transition"><i class="fa-solid fa-users"></i> Usuarios</a>
                </nav>
            </div>
            <div class="p-4 border-t border-slate-800">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 text-rose-400 hover:bg-rose-950/30 rounded-lg transition"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-slate-900 p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold">Control de Usuarios</h1>
                    <p class="text-slate-400 text-sm mt-1">Administra las cuentas de trabajadores, clientes y privilegios del sistema.</p>
                </div>
                <button onclick="toggleModal('createModal')" class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-lg shadow-cyan-500/20"><i class="fa-solid fa-user-plus"></i> Nuevo Usuario</button>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-slate-950 p-6 rounded-xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase">Total Cuentas</p>
                        <h3 class="text-3xl font-bold mt-1">{{ count($usuarios) }}</h3>
                    </div>
                    <div class="bg-blue-500/10 text-blue-400 p-4 rounded-xl"><i class="fa-solid fa-users text-2xl"></i></div>
                </div>
                <div class="bg-slate-950 p-6 rounded-xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase">Usuarios Activos</p>
                        <h3 class="text-3xl font-bold mt-1 text-emerald-500">{{ $usuarios->where('estado', 1)->count() }}</h3>
                    </div>
                    <div class="bg-emerald-500/10 text-emerald-400 p-4 rounded-xl"><i class="fa-solid fa-user-check text-2xl"></i></div>
                </div>
                <div class="bg-slate-950 p-6 rounded-xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase">Usuarios Suspendidos</p>
                        <h3 class="text-3xl font-bold mt-1 text-rose-500">{{ $usuarios->where('estado', 0)->count() }}</h3>
                    </div>
                    <div class="bg-rose-500/10 text-rose-400 p-4 rounded-xl"><i class="fa-solid fa-user-slash text-2xl"></i></div>
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
                            <th class="p-4">Nombre Completo</th>
                            <th class="p-4">Correo Electrónico</th>
                            <th class="p-4">Fecha de Ingreso</th>
                            <th class="p-4">Estado</th>
                            <th class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm">
                        @foreach($usuarios as $user)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-4 font-mono text-slate-500">#{{ $user->id_usuario }}</td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-200">{{ $user->primer_nom }} {{ $user->segund_nom }}</div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $user->primer_apelli }} {{ $user->segund_apelli }}</div>
                            </td>
                            <td class="p-4 text-cyan-400 font-medium">{{ $user->correo }}</td>
                            <td class="p-4 text-slate-300">{{ $user->fecha_ingreso }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->estado == 1 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400' }}">
                                    {{ $user->estado == 1 ? 'Activo' : 'Suspendido' }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <button onclick="openEditUserModal({{ json_encode($user) }})" class="text-cyan-400 hover:text-cyan-300 transition p-1.5"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form action="{{ route('usuarios.destroy', $user->id_usuario) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Seguro deseas eliminar permanentemente a este usuario?')" class="text-rose-400 hover:text-rose-300 transition p-1.5"><i class="fa-solid fa-trash-can"></i></button>
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
                <h2 class="text-xl font-bold flex items-center gap-2 text-cyan-400"><i class="fa-solid fa-user-plus"></i> Registrar Nuevo Usuario</h2>
                <button onclick="toggleModal('createModal')" class="text-slate-400 hover:text-slate-200 text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Primer Nombre</label>
                        <input type="text" name="primer_nom" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Segundo Nombre</label>
                        <input type="text" name="segund_nom" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Primer Apellido</label>
                        <input type="text" name="primer_apelli" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Segundo Apellido</label>
                        <input type="text" name="segund_apelli" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Correo Electrónico</label>
                        <input type="email" name="correo" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Contraseña</label>
                        <input type="password" name="contrasena" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Estado de Cuenta</label>
                        <select name="estado" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            <option value="1">Activo</option>
                            <option value="0">Suspendido</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('createModal')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 rounded-lg transition font-medium">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold rounded-lg transition">Guardar Cuenta</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editUserModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
        <div class="bg-slate-950 border border-slate-800 w-full max-w-2xl rounded-xl p-6 shadow-2xl overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold flex items-center gap-2 text-amber-400"><i class="fa-solid fa-user-pen"></i> Modificar Datos del Usuario</h2>
                <button onclick="toggleModal('editUserModal')" class="text-slate-400 hover:text-slate-200 text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="editUserForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Primer Nombre</label>
                        <input type="text" name="primer_nom" id="edit_primer_nom" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Segundo Nombre</label>
                        <input type="text" name="segund_nom" id="edit_segund_nom" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Primer Apellido</label>
                        <input type="text" name="primer_apelli" id="edit_primer_apelli" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Segundo Apellido</label>
                        <input type="text" name="segund_apelli" id="edit_segund_apelli" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Correo Electrónico</label>
                        <input type="email" name="correo" id="edit_correo" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Contraseña <span class="text-slate-500 lowercase">(Vacío para mantener)</span></label>
                        <input type="password" name="contrasena" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Estado</label>
                        <select name="estado" id="edit_estado" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2.5 text-slate-100 focus:outline-none focus:border-cyan-500">
                            <option value="1">Activo</option>
                            <option value="0">Suspendido</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('editUserModal')" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 rounded-lg transition font-medium">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-semibold rounded-lg transition">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function openEditUserModal(user) {
            // Setea la URL dinámica apuntando a la ruta de actualización
            document.getElementById('editUserForm').action = `/dashboard/usuarios/${user.id_usuario}`;
            
            // Llena los campos del modal de edición
            document.getElementById('edit_primer_nom').value = user.primer_nom;
            document.getElementById('edit_segund_nom').value = user.segund_nom || '';
            document.getElementById('edit_primer_apelli').value = user.primer_apelli;
            document.getElementById('edit_segund_apelli').value = user.segund_apelli || '';
            document.getElementById('edit_correo').value = user.correo;
            document.getElementById('edit_estado').value = user.estado;

            toggleModal('editUserModal');
        }
    </script>
</body>
</html>