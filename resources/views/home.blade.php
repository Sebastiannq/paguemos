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
<body class="bg-white text-gray-900">
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-3xl font-bebas leading-tight">
                <span class="text-gray-900">PAGUE</span>
                <span class="bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">MENOS</span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('client.home') }}" class="px-5 py-2 border border-pink-200 text-pink-600 rounded-full hover:bg-pink-50 transition">Catálogo</a>
                @if(session('user_name'))
                    <a href="{{ route('client.profile') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition font-medium">👤 Perfil</a>
                    <span class="px-4 py-2 rounded-lg bg-pink-100 text-pink-700 font-semibold">{{ session('user_name') }}</span>
                    <a href="{{ route('logout') }}" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition font-medium">Salir</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-gray-700 hover:bg-gray-100 transition">Iniciar Sesión</a>
                    <a href="{{ route('register.show') }}" class="px-5 py-2 rounded-full bg-pink-600 text-white hover:bg-pink-700 transition">Regístrate</a>
                @endif
            </div>
        </div>
    </nav>

    <header class="relative overflow-hidden bg-gradient-to-br from-pink-600 via-pink-500 to-pink-400 text-white">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.35),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(255,255,255,0.15),_transparent_25%)]"></div>
        <div class="container mx-auto px-6 py-24 relative z-10">
            <div class="grid gap-10 lg:grid-cols-2 items-center">
                <div class="space-y-8">
                    <p class="inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-sm uppercase tracking-[0.35em] text-white/90 font-semibold">Moda accesible • Calidad real • Atención local</p>
                    <h1 class="text-5xl md:text-6xl font-bebas leading-tight">Descubre el estilo que te queda bien sin pagar de más.</h1>
                    <p class="max-w-2xl text-lg text-white/90">Encuentra prendas únicas con atención personalizada en tienda y precios especiales. Renovar tu armario ahora es fácil, cómodo y cercano.</p>
                </div>
                
            </div>
        </div>
    </header>

    <main class="space-y-20">
        <section class="container mx-auto px-6 py-16">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <span class="inline-flex rounded-full bg-pink-100 px-5 py-3 text-lg md:text-xl font-semibold uppercase tracking-[0.25em] text-pink-700">Nuestra historia</span>
                    <h2 class="mt-6 text-5xl md:text-6xl font-bebas text-gray-900 leading-tight">De un local de barrio a un estilo auténtico</h2>
                    <p class="mt-5 text-base md:text-lg text-gray-600 leading-relaxed">Pague Menos nació en un pequeño local cercano con la misión de ofrecer moda accesible, atención amable y prendas seleccionadas con cuidado. Queremos que cada visita a nuestra tienda sea una experiencia cercana y confiable.</p>
                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm transition-shadow duration-300 hover:shadow-lg">
                            <h3 class="text-2xl font-semibold text-gray-900">Atención local</h3>
                            <p class="mt-3 text-base text-gray-600">Recibe asesoría directa en tienda y encuentra las prendas que mejor te quedan.</p>
                        </div>
                        <div class="rounded-3xl border border-pink-100 bg-white p-6 shadow-sm transition-shadow duration-300 hover:shadow-lg">
                            <h3 class="text-2xl font-semibold text-gray-900">Calidad responsable</h3>
                            <p class="mt-3 text-base text-gray-600">Seleccionamos ropa cómoda y duradera pensada para tu día a día.</p>
                        </div>
                    </div>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="rounded-[2rem] bg-white p-8 shadow-2xl shadow-pink-200/50">
                        <p class="text-sm uppercase tracking-[0.35em] text-pink-500">Valores</p>
                        <h3 class="mt-4 text-3xl font-semibold text-gray-900">Cercanía y confianza</h3>
                        <p class="mt-4 text-sm leading-relaxed text-gray-600">Creemos en el comercio local, en precios claros y en un trato honesto con cada cliente.</p>
                    </div>
                    <div class="rounded-[2rem] bg-pink-600 p-8 text-white shadow-2xl shadow-pink-500/20">
                        <p class="text-sm uppercase tracking-[0.35em] text-pink-100">Tienda local</p>
                        <h3 class="mt-4 text-3xl font-semibold">Compra en tienda</h3>
                        <p class="mt-4 text-sm leading-relaxed text-pink-100/90">Visítanos y pruébate las prendas en persona. Aquí tenemos lo mejor para que te lleves lo que realmente te queda bien.</p>
                    </div>
                    <div class="rounded-[2rem] bg-pink-50 p-8 shadow-2xl shadow-pink-200/40">
                        <p class="text-sm uppercase tracking-[0.35em] text-pink-500">Asesoría</p>
                        <h3 class="mt-4 text-3xl font-semibold text-gray-900">Te ayudamos a elegir</h3>
                        <p class="mt-4 text-sm leading-relaxed text-gray-600">Nuestro equipo está listo para mostrarte opciones según tu estilo, talla y ocasión. Ven y descubre tu próximo look favorito.</p>
                    </div>
                    <div class="rounded-[2rem] bg-white p-8 shadow-2xl shadow-pink-200/40">
                        <p class="text-sm uppercase tracking-[0.35em] text-pink-500">Prueba cómoda</p>
                        <h3 class="mt-4 text-3xl font-semibold text-gray-900">Sin apuros ni presión</h3>
                        <p class="mt-4 text-sm leading-relaxed text-gray-600">Siente la tranquilidad de probar varias opciones en un ambiente relajado, con atención amable y sin prisas.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-16">
            <div class="container mx-auto px-6">
                <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="uppercase tracking-[0.35em] text-pink-500 font-semibold">Nuestra historia</p>
                        <h2 class="mt-4 text-4xl font-bebas text-gray-900">Un recorrido de estilo y servicio cercano</h2>
                    </div>
                </div>
                <div class="mt-10 grid gap-6 lg:grid-cols-[1.6fr_1fr]">
                    <div class="overflow-hidden rounded-[2rem] bg-gray-100 p-4 shadow-xl">
                        <div id="storyCarousel" class="relative overflow-hidden rounded-[2rem]">
                            <div id="storyTrack" class="flex transition-transform duration-500 will-change-transform">
                                <div class="min-w-full flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1521334884684-d80222895322?q=80&w=1200&auto=format&fit=crop" alt="Tienda de ropa" class="h-96 w-full object-cover">
                                </div>
                                <div class="min-w-full flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1200&auto=format&fit=crop" alt="Ropa en exhibición" class="h-96 w-full object-cover">
                                </div>
                                <div class="min-w-full flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1514996937319-344454492b37?q=80&w=1200&auto=format&fit=crop" alt="Clientes felices" class="h-96 w-full object-cover">
                                </div>
                            </div>
                            <button id="prevStory" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-3 text-gray-800 shadow hover:bg-white transition">‹</button>
                            <button id="nextStory" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-3 text-gray-800 shadow hover:bg-white transition">›</button>
                        </div>
                    </div>
                    <div class="space-y-6 rounded-[2rem] bg-gray-50 p-8 shadow-xl">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900">De dónde venimos</h3>
                            <p class="mt-4 text-gray-600 leading-relaxed">Empezamos como un local de barrio con la idea de ofrecer moda asequible y un servicio cálido. Cada prenda se elige con atención para que puedas vestir bien sin sacrificar tu presupuesto.</p>
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900">Qué defendemos</h3>
                            <p class="mt-4 text-gray-600 leading-relaxed">Valoramos la transparencia, el respeto por nuestros clientes y el apoyo al comercio local. Aquí encuentras un lugar donde te escuchamos y te ayudamos a elegir.</p>
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900">Qué ofrecemos</h3>
                            <p class="mt-4 text-gray-600 leading-relaxed">Prendas cómodas, con estilo y disponibles para que las pruebes en tienda. Si buscas asesoría personal y una experiencia cercana, este es tu lugar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const track = document.getElementById('storyTrack');
                const slideElements = Array.from(track.children);
                const totalSlides = slideElements.length;
                if (totalSlides === 0) return;

                const firstClone = slideElements[0].cloneNode(true);
                const lastClone = slideElements[totalSlides - 1].cloneNode(true);
                track.appendChild(firstClone);
                track.insertBefore(lastClone, slideElements[0]);

                let index = 1;
                track.style.transform = `translateX(-${index * 100}%)`;

                const prevButton = document.getElementById('prevStory');
                const nextButton = document.getElementById('nextStory');
                let autoAdvance = null;

                function moveTo(targetIndex) {
                    track.style.transition = 'transform 0.5s ease';
                    index = targetIndex;
                    track.style.transform = `translateX(-${index * 100}%)`;
                }

                function startAutoAdvance() {
                    autoAdvance = setInterval(() => moveTo(index + 1), 5000);
                }

                function resetAutoAdvance() {
                    if (autoAdvance) {
                        clearInterval(autoAdvance);
                    }
                    startAutoAdvance();
                }

                prevButton.addEventListener('click', function() {
                    moveTo(index - 1);
                    resetAutoAdvance();
                });

                nextButton.addEventListener('click', function() {
                    moveTo(index + 1);
                    resetAutoAdvance();
                });

                track.addEventListener('transitionend', function() {
                    if (index === 0) {
                        track.style.transition = 'none';
                        index = totalSlides;
                        track.style.transform = `translateX(-${index * 100}%)`;
                    }
                    if (index === totalSlides + 1) {
                        track.style.transition = 'none';
                        index = 1;
                        track.style.transform = `translateX(-${index * 100}%)`;
                    }
                });

                startAutoAdvance();
            });
        </script>

        <section class="bg-gradient-to-r from-pink-600 to-pink-700 text-white py-20">
            <div class="container mx-auto px-6 text-center">
                <p class="text-sm uppercase tracking-[0.35em] text-pink-100">Hazlo tuyo</p>
                <h2 class="mt-5 text-5xl font-bebas">Comienza a ahorrar con estilo</h2>
                <p class="mt-5 max-w-3xl mx-auto text-lg text-pink-100/90">Regístrate y recibe ofertas exclusivas, lanzamientos especiales y ventajas para tu primer pedido.</p>
                <a href="{{ route('register.show') }}" class="mt-10 inline-flex items-center justify-center rounded-full bg-white px-10 py-4 text-lg font-semibold text-pink-600 shadow-lg shadow-pink-500/20 hover:bg-gray-100 transition">Crear Cuenta Ahora</a>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-16">
            <div class="grid gap-10 lg:grid-cols-4">
                <div>
                    <h3 class="text-xl font-bebas mb-4">PAGUE MENOS</h3>
                    <p class="text-gray-400">Tu tienda de moda en línea con los mejores precios y las tendencias más frescas.</p>
                </div>
                <div>
                    <h4 class="mb-4 font-semibold text-white">Compañía</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Sobre Nosotros</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-semibold text-white">Ayuda</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Preguntas frecuentes</a></li>
                        <li><a href="#" class="hover:text-white transition">Cómo comprar</a></li>
                        <li><a href="#" class="hover:text-white transition">Devoluciones</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-semibold text-white">Síguenos</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                        <li><a href="#" class="hover:text-white transition">Instagram</a></li>
                        <li><a href="#" class="hover:text-white transition">Twitter</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-white/10 pt-8 text-sm text-gray-500 flex flex-col gap-3 md:flex-row md:justify-between">
                <p>&copy; 2026 Pague Menos. Todos los derechos reservados.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#" class="hover:text-white transition">Privacidad</a>
                    <a href="#" class="hover:text-white transition">Términos</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
