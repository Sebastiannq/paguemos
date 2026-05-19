<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pague Menos - Moda a los Mejores Precios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
        .font-bebas {
            font-family: 'Bebas Neue', sans-serif;
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navegación -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-3xl font-bebas leading-tight">
                <span class="text-gray-900">PAGUE</span>
                <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
            </div>
            <div class="space-x-4">
<a href="{{ route('login') }}">Iniciar Sesión</a>                <a href="{{ route('register.show') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded transition">Regístrate</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-pink-600 to-pink-500 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-6xl font-bebas mb-4 leading-tight">Pague Menos</h1>
            <p class="text-xl text-pink-100 mb-8">La mejor moda al mejor precio</p>
            <p class="text-lg text-pink-100 max-w-2xl mx-auto mb-8">
                Descubre nuestra colección exclusiva de ropa y accesorios de alta calidad a precios increíbles. 
                Ahora es el momento perfecto para renovar tu guardarropa.
            </p>
            <a href="{{ route('register.show') }}" class="bg-white text-pink-600 font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition text-lg">
                Comenzar Ahora
            </a>
        </div>
    </section>

    <!-- Características -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bebas text-center text-gray-900 mb-12">¿Por Qué Elegirnos?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md text-center hover:shadow-lg transition">
                    <div class="text-5xl mb-4">💰</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Precios Increíbles</h3>
                    <p class="text-gray-600">
                        Ofertas exclusivas con descuentos de hasta 50% en moda de calidad
                    </p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md text-center hover:shadow-lg transition">
                    <div class="text-5xl mb-4">🚚</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Envío Rápido</h3>
                    <p class="text-gray-600">
                        Entrega garantizada en 3-5 días hábiles a todo el país
                    </p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md text-center hover:shadow-lg transition">
                    <div class="text-5xl mb-4">✨</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Calidad Garantizada</h3>
                    <p class="text-gray-600">
                        Productos premium con garantía de satisfacción o devolvemos tu dinero
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categorías Destacadas -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bebas text-center text-gray-900 mb-12">Nuestras Categorías</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg p-8 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <div class="text-6xl mb-4">👔</div>
                    <h3 class="text-xl font-bold">Ropa Casual</h3>
                    <p class="text-pink-100 mt-2">Cómodidad en cada prenda</p>
                </div>

                <div class="bg-gradient-to-br from-pink-500 to-pink-700 rounded-lg p-8 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <div class="text-6xl mb-4">👗</div>
                    <h3 class="text-xl font-bold">Ropa Formal</h3>
                    <p class="text-pink-100 mt-2">Elegancia garantizada</p>
                </div>

                <div class="bg-gradient-to-br from-pink-300 to-pink-500 rounded-lg p-8 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <div class="text-6xl mb-4">👞</div>
                    <h3 class="text-xl font-bold">Calzado</h3>
                    <p class="text-pink-100 mt-2">Estilo desde los pies</p>
                </div>

                <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-lg p-8 text-white text-center hover:shadow-lg transition cursor-pointer">
                    <div class="text-6xl mb-4">👒</div>
                    <h3 class="text-xl font-bold">Accesorios</h3>
                    <p class="text-gray-300 mt-2">Complementos únicos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bebas text-center text-gray-900 mb-12">Lo que Dicen Nuestros Clientes</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-yellow-400 mb-3">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600 mb-4">
                        "Excelente tienda. Precios muy buenos y la ropa es de muy buena calidad. Recomendado 100%"
                    </p>
                    <p class="font-bold text-gray-800">- María López</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-yellow-400 mb-3">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600 mb-4">
                        "Enviaron muy rápido. La ropa llegó en perfectas condiciones. Volveré a comprar"
                    </p>
                    <p class="font-bold text-gray-800">- Carlos García</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-yellow-400 mb-3">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600 mb-4">
                        "No esperaba tanta calidad a estos precios. Definitivamente es la mejor opción"
                    </p>
                    <p class="font-bold text-gray-800">- Ana Rodríguez</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Llamada a Acción -->
    <section class="bg-gradient-to-r from-pink-600 to-pink-700 text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-5xl font-bebas mb-4">¿Listo para Pagar Menos?</h2>
            <p class="text-xl text-pink-100 mb-8">Únete a miles de clientes satisfechos hoy mismo</p>
            <a href="{{ route('register.show') }}" class="bg-white text-pink-600 font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition text-lg">
                Crear Cuenta Ahora
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">Pague Menos</h3>
                    <p class="text-gray-400">Moda a los mejores precios</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Categorías</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li><a href="#" class="hover:text-white transition">Ropa Casual</a></li>
                        <li><a href="#" class="hover:text-white transition">Ropa Formal</a></li>
                        <li><a href="#" class="hover:text-white transition">Calzado</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Compañía</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li><a href="#" class="hover:text-white transition">Sobre Nosotros</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Síguenos</h3>
                    <p class="text-gray-400">
                        <a href="#" class="hover:text-white transition">Facebook</a> | 
                        <a href="#" class="hover:text-white transition">Instagram</a> | 
                        <a href="#" class="hover:text-white transition">Twitter</a>
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p class="text-gray-400">&copy; 2024 Pague Menos. Todos los derechos reservados.</p>
                    <p class="text-gray-400 text-right">
                        <a href="#" class="hover:text-white transition">Privacidad</a> | 
                        <a href="#" class="hover:text-white transition">Términos</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
