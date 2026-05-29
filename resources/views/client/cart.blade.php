@extends('layouts.app')

@section('title', 'Carrito - Pague Menos')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('client.home') }}" class="text-3xl font-bebas">
                <span class="text-gray-900">PAGUE</span>
                <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('client.home') }}" class="text-gray-700 hover:text-pink-600 transition">
                    Volver a Tienda
                </a>
                <a href="{{ route('logout') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Salir
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Tu Carrito de Compras</h1>

        <div id="cartContainer" class="space-y-6"></div>
    </main>

    <script>
        const cartKey = 'paguemenos_cart';
        const cartContainer = document.getElementById('cartContainer');
        const cart = JSON.parse(localStorage.getItem(cartKey) || '[]');

        function formatMoney(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }

        function renderCartPage() {
            cartContainer.innerHTML = '';

            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <div class="text-6xl mb-4">🛒</div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Tu carrito está vacío</h2>
                        <p class="text-gray-600 mb-8">¡Comienza a comprar y agrega productos a tu carrito!</p>
                        <a href="{{ route('client.home') }}" class="inline-block px-8 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition font-semibold">Continuar Comprando</a>
                    </div>
                `;
                return;
            }

            let subtotal = 0;
            cart.forEach((item, index) => {
                const cantidad = item.cantidad || 1;
                subtotal += item.precio * cantidad;
                cartContainer.innerHTML += `
                    <div class="bg-white rounded-[2rem] border border-pink-100 p-6 shadow-sm">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-24 w-24 overflow-hidden rounded-3xl bg-gray-100">
                                    ${item.imagen ? `<img src="${item.imagen}" alt="${item.nombre_prend}" class="h-full w-full object-cover">` : '<div class="grid h-full place-items-center text-4xl">👕</div>'}
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">${item.nombre_prend}</h2>
                                    <p class="text-sm text-slate-500">${item.descripcion_prend}</p>
                                    <p class="mt-2 text-sm text-slate-600">Talla: ${item.talla_prend} · Color: ${item.nom_color}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <div class="text-right">
                                    <p class="text-sm text-slate-500">Cantidad ${cantidad}</p>
                                    <p class="mt-1 text-lg font-bold text-pink-600">${formatMoney(item.precio * cantidad)}</p>
                                </div>
                                <button onclick="removeFromCart(${index})" class="rounded-2xl bg-rose-100 px-4 py-2 text-rose-600 hover:bg-rose-200 transition">Quitar</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            cartContainer.innerHTML += `
                <div class="rounded-[2rem] bg-white border border-pink-100 p-6 shadow-sm">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-pink-500">Subtotal</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">${formatMoney(subtotal)}</p>
                        </div>
                        <div class="space-y-3 text-right">
                            <a href="{{ route('client.home') }}" class="inline-flex items-center justify-center rounded-2xl border border-pink-200 px-5 py-3 text-sm font-semibold text-pink-700 hover:bg-pink-50 transition">Seguir comprando</a>
                            <a href="{{ route('client.checkout') }}" class="inline-flex items-center justify-center rounded-2xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white hover:bg-pink-700 transition">Pagar pedido</a>
                        </div>
                    </div>
                </div>
            `;
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            localStorage.setItem(cartKey, JSON.stringify(cart));
            renderCartPage();
        }

        renderCartPage();
    </script>
</div>
@endsection
