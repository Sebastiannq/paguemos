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
                <a href="{{ route('client.home') }}" class="bg-pink-100 text-pink-600 px-4 py-2 rounded hover:bg-pink-200 transition">Catálogo</a>
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Iniciar Sesión</a>
                <a href="{{ route('register.show') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded transition">Regístrate</a>
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

    <!-- Nuestra Historia (destacada) -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-4xl font-bebas text-gray-900 mb-4">Nuestra Historia</h2>
                    <p class="text-gray-600 mb-4">Pague Menos nació de una idea simple: ofrecer moda de calidad sin sacrificar el bolsillo. Empezamos como un pequeño equipo que creía que la ropa accesible también podía ser estilosa y responsable.</p>
                    <p class="text-gray-600 mb-4">Con el tiempo, colaboramos con fabricantes locales y diseñadores emergentes para crear colecciones pensadas en la comodidad, el estilo y la durabilidad. Hoy, nuestra familia crece cada día gracias a clientes que valoran la calidad y el precio justo.</p>
                    <p class="text-gray-600">Nos importa la sostenibilidad y apoyamos prácticas responsables en nuestra cadena de suministro. Cada compra ayuda a impulsar talento local y prácticas más limpias en la industria.</p>
                </div>
                <div>
                    <div class="relative overflow-hidden rounded-3xl shadow-xl">
                        <div id="storyCarousel" class="flex transition-transform duration-500">
                            <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=placeholder" alt="Tienda" class="w-full h-96 object-cover flex-shrink-0 rounded-3xl">
                            <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=placeholder" alt="Ropa" class="w-full h-96 object-cover flex-shrink-0 rounded-3xl">
                            <img src="https://images.unsplash.com/photo-1514996937319-344454492b37?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3&s=placeholder" alt="Accesorios" class="w-full h-96 object-cover flex-shrink-0 rounded-3xl">
                        </div>
                        <button id="prevStory" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 text-gray-800 rounded-full p-3 shadow hover:bg-white transition">
                            ‹
                        </button>
                        <button id="nextStory" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 text-gray-800 rounded-full p-3 shadow hover:bg-white transition">
                            ›
                        </button>
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                            <span class="story-dot w-3 h-3 rounded-full bg-white/70"></span>
                            <span class="story-dot w-3 h-3 rounded-full bg-white/40"></span>
                            <span class="story-dot w-3 h-3 rounded-full bg-white/40"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('storyCarousel');
                const dots = Array.from(document.querySelectorAll('.story-dot'));
                let index = 0;
                const total = carousel.children.length;

                function updateCarousel() {
                    carousel.style.transform = 'translateX(-' + index * 100 + '%)';
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('bg-white/70', i === index);
                        dot.classList.toggle('bg-white/40', i !== index);
                    });
                }

                document.getElementById('prevStory').addEventListener('click', function() {
                    index = (index - 1 + total) % total;
                    updateCarousel();
                });

                document.getElementById('nextStory').addEventListener('click', function() {
                    index = (index + 1) % total;
                    updateCarousel();
                });

                setInterval(function() {
                    index = (index + 1) % total;
                    updateCarousel();
                }, 5000);
            });
        </script>
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
