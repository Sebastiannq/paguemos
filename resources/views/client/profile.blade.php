@extends('layouts.app')

@section('title', 'Mi Perfil - Pague Menos')

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
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mi Perfil</h1>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow p-8">
            <div class="flex items-center gap-6 mb-8">
                <div class="text-6xl">👤</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ session('user_name') }}</h2>
                    <p class="text-gray-600">{{ session('user_email') }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold capitalize">
                        Cliente
                    </span>
                </div>
            </div>

            <hr class="my-8">

            <!-- Profile Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Correo Electrónico</h3>
                    <p class="text-gray-900">{{ session('user_email') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Estado de Cuenta</h3>
                    <p class="text-green-600 font-semibold">✓ Activa</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <button class="w-full px-6 py-3 border-2 border-pink-600 text-pink-600 rounded-lg hover:bg-pink-50 transition font-semibold">
                    Editar Perfil
                </button>
                <button class="w-full px-6 py-3 border-2 border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-semibold">
                    Cambiar Contraseña
                </button>
            </div>
        </div>

        <!-- Mis Pedidos -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Mis Pedidos</h2>
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-600">Aún no tienes pedidos. ¡Empieza a comprar!</p>
            </div>
        </div>
    </main>
</div>
@endsection
