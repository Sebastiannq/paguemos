@extends('layouts.app')

@section('title', 'Tienda - Pague Menos')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header/Navbar -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bebas leading-tight">
                    <span class="text-gray-900">PAGUE</span>
                    <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
                </h1>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('client.cart') }}" class="text-gray-700 hover:text-pink-600 transition">
                    🛒 Carrito
                </a>
                <a href="{{ route('client.profile') }}" class="text-gray-700 hover:text-pink-600 transition">
                    👤 Perfil
                </a>
                <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-semibold">
                    {{ session('user_name') }}
                </span>
                <a href="{{ route('logout') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Salir
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-pink-600 to-pink-400 py-16 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bebas mb-4">Bienvenido a nuestra Tienda</h2>
            <p class="text-lg opacity-90">Descubre las mejores prendas de moda con los mejores precios</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative">
        <div id="cartOverlay" class="fixed inset-0 z-40 bg-black/20 opacity-0 pointer-events-none transition-opacity"></div>
        <aside id="cartSidebar" class="fixed right-0 top-0 z-50 h-full w-full max-w-md translate-x-full bg-white shadow-2xl border-l border-slate-200 transition-transform duration-300">
            <div class="flex h-full flex-col">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-pink-500 font-semibold">Carrito de compras</p>
                        <p class="text-sm text-slate-500">Tus productos seleccionados</p>
                    </div>
                    <button id="closeCart" class="text-slate-500 hover:text-slate-900 transition">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto px-6 py-5">
                    <div id="cartItems" class="space-y-4"></div>
                    <div id="cartEmpty" class="rounded-[2rem] border border-dashed border-pink-200 bg-pink-50 p-8 text-center text-slate-500 hidden">
                        <div class="text-4xl mb-4">🛒</div>
                        <p class="font-semibold text-slate-900">Tu carrito está vacío</p>
                        <p class="mt-2 text-sm">Agrega una prenda y la verás aquí.</p>
                    </div>
                </div>
                <div class="border-t border-slate-200 px-6 py-5">
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <span>Subtotal</span>
                        <span id="cartSubtotal">$0</span>
                    </div>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('client.checkout') }}" id="checkoutButton" class="block rounded-2xl bg-pink-600 px-6 py-3 text-center text-white font-bold hover:bg-pink-700 transition disabled:opacity-60" aria-disabled="true">Ir a pagar</a>
                        <button type="button" id="clearCartButton" class="w-full rounded-2xl border border-red-600 bg-white px-6 py-3 text-center text-red-600 font-bold hover:bg-red-50 transition">Vaciar carrito</button>
                    </div>
                    <p class="mt-3 text-xs text-slate-500">Podrás finalizar el pedido con los datos requeridos.</p>
                </div>
            </div>
        </aside>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div id="stockMessage" class="mb-6 hidden rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-700">
            <p id="stockMessageText" class="text-sm"></p>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="mb-8 flex gap-4">
            <input 
                type="text" 
                placeholder="Buscar productos..." 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 outline-none"
            >
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 outline-none">
                <option>Todas las categorías</option>
                <option>Hombres</option>
                <option>Mujeres</option>
                <option>Accesorios</option>
            </select>
            <button class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                Filtrar
            </button>
        </div>

        <!-- Productos Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($prendas as $prenda)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    <div class="h-56 bg-gray-100 overflow-hidden flex items-center justify-center">
                        @if($prenda->imagen_url)
                            <img src="{{ $prenda->imagen_url }}" alt="{{ $prenda->nombre_prend }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-6xl">👕</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2">{{ $prenda->nombre_prend }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $prenda->descripcion_prend }}</p>
                        <div class="space-y-1 mb-4 text-sm text-gray-600">
                            <p class="font-semibold text-base">Género: {{ $prenda->tipo_genero ?? 'N/A' }}</p>
                            <p class="font-semibold text-base">Talla: {{ $prenda->talla_prend ?? 'N/A' }}</p>
                            <p class="font-semibold text-base">Color: {{ $prenda->nom_color ?? 'N/A' }}</p>
                        </div>
                        @php
                            $productoJson = json_encode([
                                'codigo_barras' => $prenda->codigo_barras,
                                'nombre_prend' => $prenda->nombre_prend,
                                'descripcion_prend' => $prenda->descripcion_prend,
                                'precio' => $prenda->precio,
                                'imagen' => $prenda->imagen_url,
                                'talla_prend' => $prenda->talla_prend,
                                'nom_color' => $prenda->nom_color,
                                'stock' => $prenda->stock ?? 0,
                            ], JSON_HEX_APOS | JSON_HEX_QUOT);
                        @endphp
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-2xl font-bold text-pink-600">${{ number_format($prenda->precio, 2, ',', '.') }}</span>
                            <span class="text-sm text-slate-500">Stock: {{ $prenda->stock ?? 0 }}</span>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <input type="number" min="1" max="{{ $prenda->stock ?? 1 }}" value="1" {{ ($prenda->stock ?? 0) <= 0 ? 'disabled' : '' }} class="w-20 rounded-2xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-pink-400 focus:ring-2 focus:ring-pink-100 outline-none {{ ($prenda->stock ?? 0) <= 0 ? 'bg-slate-100 cursor-not-allowed' : '' }}" />
                            <button type="button" data-product="{{ $productoJson }}" class="add-to-cart-button px-4 py-2 {{ ($prenda->stock ?? 0) <= 0 ? 'bg-slate-400 cursor-not-allowed' : 'bg-pink-600 hover:bg-pink-700' }} text-white rounded transition" {{ ($prenda->stock ?? 0) <= 0 ? 'disabled' : '' }}>
                                {{ ($prenda->stock ?? 0) <= 0 ? 'Sin stock' : 'Agregar' }}
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-10 bg-white rounded-lg shadow text-center text-gray-500">
                    No hay prendas registradas en el catálogo.
                </div>
            @endforelse
        </div>

        <!-- Más Productos -->
        <div class="mt-12 text-center">
            <button class="px-8 py-3 border-2 border-pink-600 text-pink-600 rounded-lg hover:bg-pink-50 transition font-semibold">
                Cargar Más Productos
            </button>
        </div>
    </main>

    <!-- Footer -->
    <script>
        const cartKey = 'paguemenos_cart';
        let cart = JSON.parse(localStorage.getItem(cartKey) || '[]');
        const cartSidebar = document.getElementById('cartSidebar');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartItemsContainer = document.getElementById('cartItems');
        const cartEmpty = document.getElementById('cartEmpty');
        const cartSubtotal = document.getElementById('cartSubtotal');
        const checkoutButton = document.getElementById('checkoutButton');
        const clearCartButton = document.getElementById('clearCartButton');
        const closeCartButton = document.getElementById('closeCart');
        const stockMessage = document.getElementById('stockMessage');
        const stockMessageText = document.getElementById('stockMessageText');

        function saveCart() {
            localStorage.setItem(cartKey, JSON.stringify(cart));
        }

        function formatMoney(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }

        function openCart() {
            cartSidebar.classList.remove('translate-x-full');
            cartOverlay.classList.remove('pointer-events-none', 'opacity-0');
            cartOverlay.classList.add('opacity-100');
        }

        function closeCart() {
            cartSidebar.classList.add('translate-x-full');
            cartOverlay.classList.remove('opacity-100');
            cartOverlay.classList.add('opacity-0', 'pointer-events-none');
        }

        function showStockMessage(message) {
            stockMessageText.textContent = message;
            stockMessage.classList.remove('hidden');
        }

        function hideStockMessage() {
            stockMessage.classList.add('hidden');
            stockMessageText.textContent = '';
        }

        closeCartButton.addEventListener('click', closeCart);
        cartOverlay.addEventListener('click', closeCart);
        clearCartButton.addEventListener('click', clearCart);

        function renderCart() {
            cartItemsContainer.innerHTML = '';
            if (!cart.length) {
                cartEmpty.classList.remove('hidden');
                cartSubtotal.textContent = '$0';
                checkoutButton.classList.add('opacity-50');
                checkoutButton.setAttribute('aria-disabled', 'true');
                return;
            }

            cartEmpty.classList.add('hidden');
            let subtotal = 0;
            cart.forEach((item, index) => {
                const cantidad = item.cantidad || 1;
                subtotal += item.precio * cantidad;
                const itemCard = document.createElement('div');
                itemCard.className = 'rounded-[1.5rem] border border-pink-100 p-4 shadow-sm';
                itemCard.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="h-20 w-20 overflow-hidden rounded-3xl bg-gray-100">
                            ${item.imagen ? `<img src="${item.imagen}" alt="${item.nombre_prend}" class="h-full w-full object-cover">` : '<div class="grid h-full place-items-center text-3xl">👕</div>'}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-slate-900">${item.nombre_prend}</p>
                            <p class="text-sm text-slate-500">${item.talla_prend} · ${item.nom_color}</p>
                            <p class="mt-2 text-sm text-slate-600">Cantidad: ${cantidad}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-3 text-sm text-slate-700">
                        <span>${formatMoney(item.precio * cantidad)}</span>
                        <button type="button" onclick="removeFromCart(${index})" class="rounded-2xl bg-red-600 px-3 py-2 text-white hover:bg-red-700 transition">Quitar 1</button>
                    </div>
                `;
                cartItemsContainer.appendChild(itemCard);
            });
            cartSubtotal.textContent = formatMoney(subtotal);
            checkoutButton.classList.remove('opacity-50');
            checkoutButton.removeAttribute('aria-disabled');
        }

        function addToCart(item, cantidad = 1) {
            hideStockMessage();
            const stock = Number(item.stock || 0);
            if (stock <= 0) {
                showStockMessage('No hay stock disponible para este producto.');
                return;
            }

            const existingIndex = cart.findIndex(i => i.codigo_barras === item.codigo_barras);
            let currentQty = 0;
            if (existingIndex !== -1) {
                currentQty = cart[existingIndex].cantidad || 0;
            }

            const maxAllowed = stock - currentQty;
            if (maxAllowed <= 0) {
                showStockMessage(`Ya llevas ${currentQty} de este producto en el carrito y no puedes agregar más. Stock total: ${stock}. Ajusta la cantidad.`);
                return;
            }

            if (cantidad > maxAllowed) {
                showStockMessage(`Solo quedan ${maxAllowed} unidades en stock. Ingresa una cantidad de ${maxAllowed} o menos.`);
                return;
            }

            if (existingIndex !== -1) {
                cart[existingIndex].cantidad += cantidad;
            } else {
                item.cantidad = cantidad;
                cart.push(item);
            }
            saveCart();
            renderCart();
            openCart();
        }

        function removeFromCart(index) {
            if (!cart[index]) return;
            cart[index].cantidad -= 1;
            if (cart[index].cantidad <= 0) {
                cart.splice(index, 1);
            }
            saveCart();
            renderCart();
        }

        function clearCart() {
            cart = [];
            saveCart();
            renderCart();
        }

        function initAddButtons() {
            document.querySelectorAll('button.add-to-cart-button').forEach(button => {
                button.addEventListener('click', () => {
                    try {
                        const item = JSON.parse(button.dataset.product);
                        const quantityInput = button.previousElementSibling;
                        const cantidad = Number(quantityInput?.value) || 1;
                        addToCart(item, cantidad);
                    } catch (error) {
                        console.error('Error parsing producto:', error, button.dataset.product);
                    }
                });
            });
        }

        initAddButtons();
        renderCart();
    </script>

    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="text-xl font-bebas mb-4">PAGUE MENOS</h4>
                    <p class="text-gray-400">Tu tienda de moda en línea con los mejores precios.</p>
                </div>
                <div>
                    <h5 class="font-semibold mb-4">Información</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Acerca de nosotros</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold mb-4">Políticas</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Términos y Condiciones</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacidad</a></li>
                        <li><a href="#" class="hover:text-white transition">Devoluciones</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold mb-4">Síguenos</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                        <li><a href="#" class="hover:text-white transition">Instagram</a></li>
                        <li><a href="#" class="hover:text-white transition">Twitter</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2026 Pague Menos. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</div>
@endsection
