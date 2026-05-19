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

        <!-- Empty Cart -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Tu carrito está vacío</h2>
            <p class="text-gray-600 mb-8">¡Comienza a comprar y agrega productos a tu carrito!</p>
            <a href="{{ route('client.home') }}" class="inline-block px-8 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition font-semibold">
                Continuar Comprando
            </a>
        </div>
    </main>
</div>
@endsection
