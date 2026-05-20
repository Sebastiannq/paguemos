<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Pague Menos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%); font-family: 'Space Grotesk', sans-serif; }
        .font-bebas { font-family: 'Bebas Neue', cursive; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-8">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <h1 class="text-4xl font-bebas leading-tight">
                    <span class="text-gray-900">PAGUE</span>
                    <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
                </h1>
                <p class="text-gray-500 text-sm mt-1">Moda a los mejores precios</p>
            </div>

            <h2 class="text-2xl font-bebas text-gray-900 mb-6 tracking-wide text-center">Crear Cuenta</h2>

            <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="flex gap-3">
                    <div class="flex-1">
                        <label for="primer_nom" class="block text-gray-700 font-semibold mb-2">Primer Nombre</label>
                        <input id="primer_nom" name="primer_nom" type="text" required value="{{ old('primer_nom') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('primer_nom') border-red-500 @enderror">
                        @error('primer_nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-1">
                        <label for="segund_nom" class="block text-gray-700 font-semibold mb-2">Segundo Nombre</label>
                        <input id="segund_nom" name="segund_nom" type="text" value="{{ old('segund_nom') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('segund_nom') border-red-500 @enderror">
                        @error('segund_nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="flex-1">
                        <label for="primer_apelli" class="block text-gray-700 font-semibold mb-2">Primer Apellido</label>
                        <input id="primer_apelli" name="primer_apelli" type="text" required value="{{ old('primer_apelli') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('primer_apelli') border-red-500 @enderror">
                        @error('primer_apelli') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-1">
                        <label for="segund_apelli" class="block text-gray-700 font-semibold mb-2">Segundo Apellido</label>
                        <input id="segund_apelli" name="segund_apelli" type="text" value="{{ old('segund_apelli') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('segund_apelli') border-red-500 @enderror">
                        @error('segund_apelli') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Correo Electrónico</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                    <input id="password" name="password" type="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirmar Contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-pink-700 text-white font-bold py-2 px-4 rounded-lg hover:opacity-90 transition mt-2">Crear Cuenta</button>
            </form>

            <div class="my-6 flex items-center">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2 text-gray-500 text-sm">O</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <p class="text-center text-gray-600">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:underline">Inicia sesión aquí</a></p>

            <div class="mt-6 pt-6 border-t border-gray-200 text-center text-sm text-gray-500">
                <a href="/" class="text-pink-600 hover:underline">Volver al inicio</a>
            </div>
        </div>

        <p class="text-center text-white text-sm mt-6">© 2024 Pague Menos. Todos los derechos reservados.</p>
    </div>
</body>
</html>