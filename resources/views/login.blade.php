@extends('layouts.app')

@section('title', 'Login - Pague Menos')

@section('content')
<div class="min-h-screen flex">
    <!-- LEFT PANEL -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-gray-900 via-gray-800 to-black relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-gradient-to-r from-pink-500/20 to-transparent"></div>
        </div>
        
        <div class="relative z-10 flex flex-col justify-center p-12 lg:p-16">
            <h1 class="text-6xl lg:text-7xl font-black leading-tight mb-6">
                <span class="text-white">PAGUEloca</span>
                <br>
                <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
            </h1>
            <p class="text-gray-400 text-lg leading-relaxed max-w-md mb-12">
                Tu tienda de ropa en línea con los mejores precios. Accede ahora a tu cuenta.
            </p>
            
            <div class="space-y-4 mb-12">
                <div class="flex items-start gap-3">
                    <div class="text-pink-500 mt-1">✓</div>
                    <div>
                        <h3 class="text-white font-semibold">Ropa de Calidad</h3>
                        <p class="text-gray-500 text-sm">Las mejores marcas al mejor precio</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="text-pink-500 mt-1">✓</div>
                    <div>
                        <h3 class="text-white font-semibold">Envíos Rápidos</h3>
                        <p class="text-gray-500 text-sm">Llega a tu puerta en 24-48 horas</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="text-pink-500 mt-1">✓</div>
                    <div>
                        <h3 class="text-white font-semibold">Seguridad Garantizada</h3>
                        <p class="text-gray-500 text-sm">Protegemos tus datos personales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-16 bg-white">
        <div class="max-w-md w-full mx-auto">
            <!-- Logo Mobile -->
            <div class="lg:hidden mb-8 text-center">
                <h2 class="text-4xl font-black mb-2">
                    <span class="text-gray-900">PAGUE</span>
                    <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
                </h2>
                <p class="text-gray-600 text-sm">Tu tienda de ropa en línea</p>
            </div>

            <!-- Heading -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">¡Bienvenido!</h1>
                <p class="text-gray-600">Inicia sesión en tu cuenta</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-600 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                        Correo Electrónico
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent outline-none transition"
                        placeholder="tu@correo.com"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent outline-none transition"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Remember & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300">
                        <span class="text-sm text-gray-600">Recuérdame</span>
                    </label>
                    <a href="#" class="text-sm text-pink-600 hover:text-pink-700 font-semibold">¿Olvidaste tu contraseña?</a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200"
                >
                    Iniciar Sesión
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span class="text-sm text-gray-500">O</span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>

            <!-- Register Link -->
            <p class="text-center text-gray-600 text-sm">
                ¿No tienes cuenta? 
                <a href="{{ route('register.show') }}" class="text-pink-600 hover:text-pink-700 font-bold">
                    Regístrate aquí
                </a>
            </p>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-center text-xs text-gray-500">
                    © 2026 Pague Menos. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
