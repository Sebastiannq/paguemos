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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

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
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-2xl font-bold text-pink-600">${{ number_format($prenda->precio, 2, ',', '.') }}</span>
                            <button class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 transition">
                                Agregar
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
