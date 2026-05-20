<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pague Menos - Registrar Venta / Apartado</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-slate-100 p-6 flex flex-col justify-between shrink-0">
            <div class="space-y-8">
                <div class="flex items-center gap-2 px-2">
                    <div class="bg-pink-500 text-white p-2 rounded-xl font-black tracking-tighter text-lg">PM</div>
                    <div>
                        <h1 class="text-xs font-black uppercase tracking-widest text-pink-500">Pague</h1>
                        <h2 class="text-sm font-bold text-slate-800 -mt-1">Menos</h2>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center font-bold text-lg">
                        {{ substr(session('user_name', 'E'), 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-sm font-bold text-slate-800 truncate">{{ session('user_name', 'Empleado Paguemenos') }}</h4>
                        <p class="text-xs text-slate-400 font-medium truncate">Punto de Venta Activo</p>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-400 hover:text-pink-500 transition rounded-xl"><i class="fa-solid fa-chart-pie w-5 text-center"></i> Inicio</a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold bg-pink-50 text-pink-600 rounded-xl"><i class="fa-solid fa-basket-shopping w-5 text-center"></i> Nueva Venta / Apartado</a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-400 hover:text-pink-500 transition rounded-xl"><i class="fa-solid fa-boxes-stacked w-5 text-center"></i> Consultar Stock</a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-10 overflow-x-hidden">
            
            <div id="alertBox" class="hidden mb-6 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in"></div>

            <header class="mb-10">
                <span class="text-xs font-black uppercase tracking-widest text-slate-400">Operaciones</span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Módulo de Facturación</h2>
                <p class="text-sm text-slate-400 font-medium mt-0.5">Escanea el código de barras de la prenda para auto-completar los datos de venta de forma inmediata.</p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="lg:col-span-2 bg-white border border-slate-100 p-8 rounded-[2rem] shadow-sm space-y-6">
                    <div class="flex items-center gap-3 text-pink-500 border-b border-slate-50 pb-4">
                        <i class="fa-solid fa-cash-register text-xl"></i>
                        <h3 class="text-lg font-bold text-slate-800">Detalles de la Transacción</h3>
                    </div>

                    <form action="#" method="POST" class="space-y-6">
                        @csrf

                        <div class="bg-violet-50/50 border border-violet-100 p-5 rounded-2xl space-y-2">
                            <label class="block text-xs uppercase tracking-wider font-bold text-violet-600 flex items-center justify-between">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-barcode text-sm"></i> Escanear Código de Barras (PK)</span>
                                <span id="searchStatus" class="text-[10px] font-medium text-slate-400 normal-case bg-white px-2 py-0.5 rounded border border-slate-100 hidden">Buscando...</span>
                            </label>
                            <input type="text" id="codigo_barras_input" name="codigo_barras" required autofocus autocomplete="off"
                                placeholder="Pasa el lector de barras o escribe el código único..." 
                                class="w-full rounded-xl border border-violet-200 bg-white px-4 py-3.5 text-base text-slate-800 font-mono font-bold focus:border-violet-400 focus:ring-4 focus:ring-violet-50 outline-none transition" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-xs font-semibold text-slate-400">Prenda Encontrada</label>
                                <input type="text" id="nombre_prend" readonly placeholder="Ninguna prenda seleccionada"
                                    class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700 outline-none" />
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-semibold text-slate-400">Detalles de Diseño (Talla / Color / Género)</label>
                                <input type="text" id="detalles_prend" readonly placeholder="Mallas, colores y dimensiones"
                                    class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-500 outline-none" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="space-y-1">
                                <label class="block text-xs font-semibold text-slate-400">Precio Unitario ($ COP)</label>
                                <input type="number" id="precio_unitario" name="precio_unitario" readonly placeholder="0"
                                    class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-mono font-bold text-slate-800 outline-none" />
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-semibold text-slate-400">Stock en Bodega</label>
                                <input type="text" id="stock_disponible" readonly placeholder="0 uds"
                                    class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-600 outline-none" />
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-semibold text-slate-600 flex items-center gap-1"><i class="fa-solid fa-input-numeric text-pink-500"></i> Cantidad a Llevar</label>
                                <input type="number" id="cantidad_vendida" name="cantidad_vendida" required min="1" disabled value="1"
                                    class="w-full rounded-xl border border-pink-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-800 outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-50 transition" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div class="space-y-1">
                                <label class="block text-xs font-semibold text-slate-600">Asignar Cliente</label>
                                <select name="fk_id_cliente" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-pink-400">
                                    <option value="1">Cliente General / Ocasional</option>
                                    </select>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-semibold text-slate-600">Tipo de Proceso</label>
                                <select name="tipo_proceso" id="tipo_proceso" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-bold text-pink-600 outline-none focus:border-pink-400">
                                    <option value="venta">🛒 Registrar Venta Inmediata</option>
                                    <option value="apartado">📌 Apartar Prenda / Separado</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-50 flex justify-end">
                            <button type="submit" id="btnSubmit" disabled class="w-full sm:w-auto bg-slate-300 text-white font-bold text-sm px-8 py-3.5 rounded-xl transition shadow-md flex items-center justify-center gap-2 cursor-not-allowed">
                                <i class="fa-solid fa-check-to-slot"></i> Procesar Operación
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-slate-900 text-white p-8 rounded-[2rem] shadow-xl space-y-6 sticky top-6">
                    <h3 class="text-sm font-black uppercase tracking-widest text-pink-400">Resumen de Cobro</h3>
                    
                    <div class="space-y-4 border-b border-slate-800 pb-6">
                        <div class="flex justify-between text-xs font-medium text-slate-400">
                            <span>Subtotal Prenda:</span>
                            <span id="resumen_subtotal">$0</span>
                        </div>
                        <div class="flex justify-between text-xs font-medium text-slate-400">
                            <span>Impuestos (IVA 0%):</span>
                            <span>$0</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total a Pagar / Abonar</p>
                        <h2 class="text-4xl font-black text-white tracking-tight" id="resumen_total">$0</h2>
                    </div>

                    <div class="bg-slate-800/60 p-4 rounded-xl border border-slate-800 text-xs text-slate-400 leading-relaxed">
                        <i class="fa-solid fa-circle-info text-pink-400 mr-1"></i> Recuerda revisar que el stock en bodega sea suficiente antes de confirmar el ticket térmico.
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        document.getElementById('codigo_barras_input').addEventListener('input', function(e) {
            const codigo = e.target.value.trim();
            const statusLabel = document.getElementById('searchStatus');
            
            // Si el código tiene una longitud mínima para consultar (ej. mayor a 3 caracteres)
            if (codigo.length >= 3) {
                statusLabel.classList.remove('hidden');
                
                // Hacemos la consulta a la ruta de Laravel pasándole el string del código
                fetch(`/dashboard/prenda/buscar/${codigo}`)
                    .then(response => response.json())
                    .then(data => {
                        statusLabel.classList.add('hidden');
                        
                        if (data.success) {
                            const prenda = data.prenda;
                            
                            // 1. Rellenamos los inputs legibles
                            document.getElementById('nombre_prend').value = prenda.nombre_prend;
                            document.getElementById('detalles_prend').value = `${prenda.talla_prend} / ${prenda.nom_color} / ${prenda.tipo_genero}`;
                            document.getElementById('precio_unitario').value = prenda.precio;
                            document.getElementById('stock_disponible').value = `${prenda.stock} unidades`;
                            
                            // 2. Habilitamos la cantidad con su tope de stock máximo
                            const cantidadInput = document.getElementById('cantidad_vendida');
                            cantidadInput.disabled = false;
                            cantidadInput.max = prenda.stock;
                            cantidadInput.value = 1;
                            
                            // 3. Activar Botón de Registro
                            const btn = document.getElementById('btnSubmit');
                            btn.disabled = false;
                            btn.className = "w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm px-8 py-3.5 rounded-xl transition shadow-lg shadow-pink-500/20 flex items-center justify-center gap-2 cursor-pointer";

                            // 4. Calcular Totales en Pantalla
                            calcularTotales();
                            showAlert('Prenda cargada correctamente.', 'emerald');
                        }
                    })
                    .catch(error => {
                        statusLabel.classList.add('hidden');
                        resetFormulario();
                        showAlert('Código no encontrado o producto descontinuado.', 'rose');
                    });
            } else {
                resetFormulario();
            }
        });

        // Escucha si cambia la cantidad a comprar para re-calcular los totales
        document.getElementById('cantidad_vendida').addEventListener('input', calcularTotales);

        function calcularTotales() {
            const precio = parseFloat(document.getElementById('precio_unitario').value) || 0;
            const cantidad = parseInt(document.getElementById('cantidad_vendida').value) || 1;
            const total = precio * cantidad;
            
            // Formateador de moneda en pesos colombianos ($ COP)
            const formatter = new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0
            });

            document.getElementById('resumen_subtotal').innerText = formatter.format(total);
            document.getElementById('resumen_total').innerText = formatter.format(total);
        }

        function resetFormulario() {
            document.getElementById('nombre_prend').value = '';
            document.getElementById('detalles_prend').value = '';
            document.getElementById('precio_unitario').value = '';
            document.getElementById('stock_disponible').value = '';
            
            const cantidadInput = document.getElementById('cantidad_vendida');
            cantidadInput.disabled = true;
            cantidadInput.value = 1;

            const btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.className = "w-full sm:w-auto bg-slate-300 text-white font-bold text-sm px-8 py-3.5 rounded-xl transition shadow-md flex items-center justify-center gap-2 cursor-not-allowed";

            document.getElementById('resumen_subtotal').innerText = '$0';
            document.getElementById('resumen_total').innerText = '$0';
        }

        function showAlert(msg, color) {
            const alertBox = document.getElementById('alertBox');
            alertBox.innerText = msg;
            alertBox.className = `mb-6 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in bg-${color}-50 border border-${color}-100 text-${color}-700`;
            alertBox.classList.remove('hidden');
            
            setTimeout(() => { alertBox.classList.add('hidden'); }, 4000);
        }
    </script>
</body>
</html>