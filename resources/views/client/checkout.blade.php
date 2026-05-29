@extends('layouts.app')

@section('title', 'Checkout - Pague Menos')

@section('content')
<div class="min-h-screen bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('client.home') }}" class="text-3xl font-bebas">
                <span class="text-gray-900">PAGUE</span>
                <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('client.home') }}" class="text-gray-700 hover:text-pink-600 transition">Volver a Tienda</a>
                <a href="{{ route('client.cart') }}" class="text-gray-700 hover:text-pink-600 transition">Ver Carrito</a>
                <a href="{{ route('logout') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Salir</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-6">
            <section class="bg-white p-8 rounded-[2rem] shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-8">
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-pink-500">Finaliza tu compra</p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-900">Pago y facturación</h1>
                    </div>
                    <div class="rounded-full bg-pink-50 px-4 py-2 text-sm font-semibold text-pink-600">Cliente: {{ $clienteNombre }}</div>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid gap-6 lg:grid-cols-2 mb-8">
                    <div class="rounded-[2rem] border border-pink-100 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-900">Información de pago</h2>
                        <p class="mt-3 text-sm text-slate-600">Tu pedido se guardará como factura solicitada. El administrador podrá revisar y aceptar la orden.</p>
                    </div>
                    <div class="rounded-[2rem] border border-pink-100 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold text-slate-900">Consejo</h3>
                        <p class="mt-3 text-sm text-slate-600">Asegúrate de revisar que los datos del pedido sean correctos antes de enviar.</p>
                    </div>
                </div>

                <div class="mb-8 rounded-[2rem] border-2 border-pink-300 bg-pink-50 p-8 shadow-sm">
                    <p class="text-xs uppercase tracking-widest text-pink-600 font-bold">Datos del cliente que verificamos</p>
                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <div>
                            <p class="text-sm text-pink-600 font-semibold uppercase tracking-widest">Nombre</p>
                            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $clienteNombre }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-pink-600 font-semibold uppercase tracking-widest">Correo</p>
                            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $clienteEmail }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8 rounded-[2rem] border border-pink-100 bg-pink-50 p-6">
                    <h2 class="text-xl font-semibold text-pink-700">Resumen del pedido</h2>
                    <p class="mt-2 text-sm text-pink-700/80">Revisa tus prendas, tallas y colores antes de confirmar.</p>
                    <div id="pedidoResumen" class="mt-6 space-y-4"></div>
                    <div id="pedidoVacio" class="mt-6 rounded-3xl border border-dashed border-pink-200 bg-white p-6 text-center text-pink-700 hidden">
                        No hay productos en el carrito. Regresa a la tienda para agregar prendas.
                    </div>
                </div>

                <form id="checkoutForm" action="{{ route('client.checkout.store') }}" method="POST" class="mt-10 space-y-6">
                    @csrf
                    <input type="hidden" name="carrito_items" id="carrito_items_input" value="[]">
                    <input type="hidden" name="nombre_cliente" value="{{ $clienteNombre }}">
                    <input type="hidden" name="correo_cliente" value="{{ $clienteEmail }}">
                    <input type="hidden" name="cedula" value="">
                    <input type="hidden" name="fk_id_empleado" value="1">
                    <div class="rounded-[2rem] border border-pink-100 bg-pink-50 p-6 text-sm text-slate-700 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold">Subtotal</span>
                            <span id="checkoutSubtotal">$0</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold">Total</span>
                            <span id="checkoutTotal" class="text-lg font-bold text-pink-600">$0</span>
                        </div>
                        <button type="button" id="checkoutSubmit" onclick="submitCheckout()" class="mt-4 w-full rounded-2xl bg-pink-600 px-6 py-3 text-white font-bold hover:bg-pink-700 transition disabled:cursor-not-allowed disabled:opacity-60" disabled>Pagar</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</div>

<script>
    const cartKey = 'paguemenos_cart';
    const carrito = JSON.parse(localStorage.getItem(cartKey) || '[]');
    const resumen = document.getElementById('pedidoResumen');
    const vacio = document.getElementById('pedidoVacio');
    const subtotalEl = document.getElementById('checkoutSubtotal');
    const totalEl = document.getElementById('checkoutTotal');
    const hiddenInput = document.getElementById('carrito_items_input');
    const submitBtn = document.getElementById('checkoutSubmit');

    function formatMoney(value) {
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
    }

    function renderCheckoutCart() {
        resumen.innerHTML = '';
        if (!carrito.length) {
            vacio.classList.remove('hidden');
            submitBtn.disabled = true;
            hiddenInput.value = '[]';
            subtotalEl.textContent = '$0';
            totalEl.textContent = '$0';
            return;
        }

        vacio.classList.add('hidden');
        submitBtn.disabled = false;
        let subtotal = 0;

        carrito.forEach(item => {
            const cantidad = item.cantidad || 1;
            subtotal += item.precio * cantidad;

            const itemDiv = document.createElement('div');
            itemDiv.className = 'rounded-3xl border border-pink-100 bg-white p-4 shadow-sm';
            itemDiv.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="h-20 w-20 rounded-3xl bg-gray-100 overflow-hidden">
                        ${item.imagen ? `<img src="${item.imagen}" alt="${item.nombre_prend}" class="h-full w-full object-cover">` : '<div class="flex h-full items-center justify-center text-3xl">👕</div>'}
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-slate-900">${item.nombre_prend}</h3>
                        <p class="text-sm text-slate-500">${item.talla_prend} · ${item.nom_color}</p>
                        <p class="mt-2 text-sm text-slate-600">Cantidad: ${cantidad}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-pink-600">${formatMoney(item.precio * cantidad)}</p>
                        <p class="text-xs text-slate-400">${formatMoney(item.precio)} c/u</p>
                    </div>
                </div>
            `;

            resumen.appendChild(itemDiv);
        });

        hiddenInput.value = JSON.stringify(carrito);
        subtotalEl.textContent = formatMoney(subtotal);
        totalEl.textContent = formatMoney(subtotal);
    }

    renderCheckoutCart();

    function submitCheckout() {
        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);

        fetch('{{ route('client.checkout.store') }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Si la respuesta es exitosa, limpiar carrito y redirigir
            localStorage.removeItem('paguemenos_cart');
            window.location.href = '{{ route('client.inicio') }}';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar el pedido');
        });
    }

    const successMessage = {!! json_encode(session('success')) !!};
    if (successMessage) {
        localStorage.removeItem(cartKey);
    }
</script>
@endsection
