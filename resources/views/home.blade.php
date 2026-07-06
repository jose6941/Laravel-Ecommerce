<x-app-layout>
    <!-- Banner Section - Ocupa toda a área abaixo da navbar e acima das categorias -->
    <div class="w-full bg-[#f0f0ee] relative overflow-hidden flex items-center" id="banner-section" style="min-height: calc(100vh - 6rem);">

        <!-- Tipografia gigante de fundo (efeito editorial/poster, como na referência) -->
        <div class="absolute inset-0 flex items-center justify-end pointer-events-none select-none z-0 overflow-hidden">
            <span class="gsap-bg-text font-display font-black text-[14rem] lg:text-[20rem] leading-none text-gray-300/40 tracking-tighter -mr-4 lg:-mr-10 whitespace-nowrap">MADE</span>
        </div>

        <!-- Partículas sutis -->
        <div id="particles-container" class="absolute inset-0 pointer-events-none z-10"></div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex flex-col lg:flex-row items-center">

                <!-- Left Side - Text Content -->
                <div class="w-full lg:w-[44%] pl-4 pr-4 sm:pl-8 sm:pr-8 lg:pl-2 lg:pr-6 py-16 lg:py-24 z-20">
                    <!-- Tagline superior -->
                    <div class="gsap-banner-item mb-5">
                        <span class="inline-flex items-center gap-2 text-xs font-bold text-[#1a1a1a] tracking-[0.25em] uppercase">
                            <span class="w-6 h-[2px] bg-gray-400"></span>
                            Heepzy &mdash; Nova Coleção
                        </span>
                    </div>

                    <!-- Título principal -->
                    <h1 class="gsap-banner-item font-display font-black leading-[0.85] tracking-tighter text-[#1a1a1a] mb-4">
                        <span class="text-[3rem] sm:text-[4rem] lg:text-[5rem] xl:text-[6rem]">CONFORTO</span><br>
                        <span class="text-[2.2rem] sm:text-[3rem] lg:text-[3.8rem] xl:text-[4.5rem] text-gray-400" style="text-shadow: 0 0 45px rgba(113,113,122,0.35);">REIMAGINADO</span>
                    </h1>

                    <!-- Subtítulo -->
                    <p class="gsap-banner-item text-gray-500 text-sm sm:text-base font-light leading-relaxed max-w-md mb-8">
                        Tecnologia de amortecimento dinâmico. Leveza absoluta.<br>
                        Design que vira cabeças. Feito para quem não passa despercebido.
                    </p>

                    <!-- CTA - Apenas o botão de comprar agora -->
                    <div class="gsap-banner-item flex flex-wrap items-center gap-3">
                        <a href="{{ route('produtos.index') }}"
                           class="inline-flex items-center gap-2 bg-[#1a1a1a] text-white px-9 py-4 text-xs font-bold tracking-[0.15em] uppercase rounded-full hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            COMPRAR AGORA
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="gsap-banner-item flex items-center gap-6 mt-8 pt-6 border-t border-gray-200/50">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            <span class="text-xs font-medium text-gray-500">Garantia Heepzy</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                            <span class="text-xs font-medium text-gray-500">Frete Grátis</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            <span class="text-xs font-medium text-gray-500">Troca Fácil</span>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Tênis preto (foto real recortada, fundo transparente, sem cortes) -->
                <div class="w-full lg:w-[56%] flex items-center justify-center lg:justify-end pl-6 pr-4 lg:pr-0 lg:pl-4 z-20">
                    <div class="gsap-sneaker-wrapper relative w-full max-w-xl lg:max-w-2xl">
                        <img src="/images/sneaker-photo-final.png"
                             alt="Tênis Preto Heepzy"
                             class="gsap-sneaker-img w-full h-auto object-contain select-none"
                             draggable="false"
                             style="filter: drop-shadow(0 30px 50px rgba(0,0,0,0.28));">
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-1.5 gsap-scroll-indicator">
            <span class="text-[7px] font-medium text-gray-400 tracking-[0.2em] uppercase">Scroll</span>
            <div class="w-3 h-5 border border-gray-300 rounded-full flex justify-center pt-1">
                <div class="w-0.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></div>
            </div>
        </div>
    </div>

    <!-- Categorias Section -->
    <div class="py-8 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 overflow-x-auto no-scrollbar">
            <div class="flex gap-4 min-w-max pb-2">
                @foreach($categorias as $categoria)
                    <a href="{{ route('produtos.index', ['categoria' => $categoria->slug]) }}" class="px-6 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-bold tracking-wide text-dark hover:bg-primary hover:text-white hover:border-primary hover:scale-105 hover:shadow-lg transition-all duration-300 gsap-fade-up">
                        {{ $categoria->nome }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Info Bar -->
    <div class="bg-dark text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center md:text-left divide-x divide-gray-800">
                <div class="flex items-center justify-center md:justify-start gap-3 px-4">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                    <div><p class="font-bold text-sm">Free Shipping</p><p class="text-xs text-gray-400">On all orders</p></div>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-3 px-4">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <div><p class="font-bold text-sm">Easy Returns</p><p class="text-xs text-gray-400">14 days returns</p></div>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-3 px-4">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.965 11.965 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    <div><p class="font-bold text-sm">100% Authentic</p><p class="text-xs text-gray-400">Original Products</p></div>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-3 px-4">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    <div><p class="font-bold text-sm">Secure Payment</p><p class="text-xs text-gray-400">100% Secure</p></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Best Sellers -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start mb-12 gsap-fade-up">
                <div class="md:w-1/2">
                    <h2 class="text-4xl lg:text-5xl font-display font-black text-dark leading-tight uppercase tracking-tighter">NOVA<br>COLEÇÃO<br>PARA O SEU<br>RITMO</h2>
                </div>
                
                <div class="md:w-1/3 flex flex-col items-start mt-6 md:mt-0">
                    <p class="text-gray-500 mb-6 text-sm font-medium leading-relaxed">Tecnológicos para corrida, treinos e cidade. Escolha seu par e siga em frente.</p>
                    <a href="{{ route('produtos.index') }}" class="inline-flex items-center gap-3 bg-dark text-white px-6 py-3 text-xs font-bold tracking-widest uppercase hover:bg-gray-800 transition">
                        TODOS OS MODELOS
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </a>
                </div>
            </div>

            @if(isset($produtosDestaque) && $produtosDestaque->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 gsap-products-grid">
                    @foreach ($produtosDestaque->take(8) as $index => $produto)
                        <div class="gsap-product-card">
                            <x-product-card :produto="$produto" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">Nenhum produto encontrado.</div>
            @endif
        </div>
    </div>

    <!-- Dark Banner 1 -->
    <div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-dark rounded-3xl p-12 lg:p-20 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gsap-fade-up">
            <div class="relative z-10 md:w-1/2">
                <span class="text-xs font-bold text-gray-400 tracking-widest uppercase mb-4 block">/ Why Heepzy?</span>
                <h2 class="text-4xl lg:text-5xl font-display font-bold text-white leading-tight mb-8">Designed For Comfort.<br>Built To Last.</h2>
                <a href="#" class="inline-flex items-center gap-2 bg-primary text-dark px-8 py-3 rounded-full font-bold hover:bg-white transition">
                    Learn More &rarr;
                </a>
                
                <div class="flex gap-8 mt-12 text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="font-medium text-sm">Premium<br>Quality</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                        <span class="font-medium text-sm">Breathable<br>Comfort</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M3.512 15H9v5.488A9.025 9.025 0 013.512 15z" /></svg>
                        <span class="font-medium text-sm">Lightweight<br>Build</span>
                    </div>
                </div>
            </div>
            
            <div class="absolute right-0 top-0 bottom-0 w-1/2 hidden md:block">
                <!-- Shoe image cut off on the right -->
                <div class="w-full h-full bg-gray-800 rounded-r-3xl opacity-50 flex items-center justify-center text-white">Dark Sneaker Mockup</div>
            </div>
        </div>
    </div>

    <!-- GSAP Initialization -->
    <script>
        function initGsapAnimations() {
            // ===== BANNER SECTION ANIMATIONS =====

            const bannerTl = gsap.timeline({ defaults: { ease: 'expo.out' } });

            // 0. Tipografia gigante de fundo entra com fade + zoom lento (efeito poster)
            bannerTl.from('.gsap-bg-text', {
                opacity: 0,
                scale: 1.08,
                duration: 2.2,
                ease: 'power2.out'
            });

            // 1. Texto entra com stagger lento e suave (tagline, título, subtítulo, botão, trust)
            bannerTl.from('.gsap-banner-item', {
                y: 55,
                opacity: 0,
                duration: 1.2,
                stagger: 0.2,
                ease: 'power3.out'
            }, '-=1.6');

            // 2. Imagem do tênis entra com zoom, rotação 3D sutil e desfoque suave
            bannerTl.from('.gsap-sneaker-img', {
                x: 110,
                scale: 0.78,
                rotationZ: 10,
                opacity: 0,
                filter: 'blur(20px)',
                duration: 1.8,
                ease: 'power3.out'
            }, '-=1.5');

            // 3. Scroll indicator fade in
            bannerTl.from('.gsap-scroll-indicator', {
                opacity: 0,
                y: 10,
                duration: 0.8
            }, '-=0.3');

            // 4. Floating suave contínuo do tênis (a "imagem do tenis que deve ficar animado")
            gsap.to('.gsap-sneaker-img', {
                y: '-=16',
                rotationZ: '+=2',
                duration: 4.5,
                yoyo: true,
                repeat: -1,
                ease: 'sine.inOut',
                delay: 2.6
            });

            // ===== PARTÍCULAS FLUTUANTES =====
            function createParticles() {
                const container = document.getElementById('particles-container');
                if (!container) return [];

                const colors = ['#9ca3af', '#1a1a1a', '#4b5563', '#d1d5db', '#ffffff', '#6b7280'];
                const particleCount = 12;
                const particles = [];

                container.innerHTML = '';

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    const size = gsap.utils.random(2, 5, 0.5);
                    const isCircle = Math.random() > 0.3;

                    particle.className = 'absolute';
                    particle.style.cssText = `
                        width: ${size}px;
                        height: ${isCircle ? size : size * 0.4}px;
                        border-radius: ${isCircle ? '50%' : '2px'};
                        background: ${gsap.utils.random(colors)};
                        opacity: ${gsap.utils.random(0.06, 0.2, 0.01)};
                        left: ${gsap.utils.random(2, 98, 0.1)}%;
                        top: ${gsap.utils.random(2, 98, 0.1)}%;
                        will-change: transform, opacity;
                    `;

                    container.appendChild(particle);
                    particles.push(particle);
                }

                return particles;
            }

            function animateParticles(particles) {
                if (!particles.length) return;

                const maxX = Math.min(window.innerWidth * 0.08, 80);
                const maxY = Math.min(window.innerHeight * 0.05, 50);

                particles.forEach((particle) => {
                    gsap.to(particle, {
                        x: gsap.utils.random(-maxX, maxX, 1),
                        y: gsap.utils.random(-maxY, maxY, 1),
                        rotation: gsap.utils.random(-15, 15, 1),
                        opacity: gsap.utils.random(0.04, 0.25, 0.01),
                        duration: gsap.utils.random(10, 20, 0.1),
                        delay: gsap.utils.random(1, 5, 0.1),
                        ease: 'sine.inOut',
                        yoyo: true,
                        repeat: -1,
                        repeatDelay: gsap.utils.random(0.5, 2, 0.1)
                    });
                });
            }

            setTimeout(() => {
                const particles = createParticles();
                animateParticles(particles);
            }, 600);

            // ===== SCROLL ANIMATIONS =====
            if (typeof ScrollTrigger !== 'undefined') {
                // Fade-up sections
                const fadeUpElements = document.querySelectorAll('.gsap-fade-up');
                fadeUpElements.forEach(el => {
                    gsap.from(el, {
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 85%',
                            toggleActions: 'play none none none'
                        },
                        y: 50,
                        opacity: 0,
                        duration: 0.9,
                        ease: 'power3.out'
                    });
                });

                // Product cards stagger
                const productsGrid = document.querySelector('.gsap-products-grid');
                if (productsGrid) {
                    gsap.from('.gsap-product-card', {
                        scrollTrigger: {
                            trigger: productsGrid,
                            start: 'top 85%',
                            toggleActions: 'play none none none'
                        },
                        y: 60,
                        opacity: 0,
                        scale: 0.95,
                        duration: 0.8,
                        stagger: 0.1,
                        ease: 'power3.out'
                    });
                }
            }
        }

        function waitForGsap(retries = 30) {
            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                initGsapAnimations();
            } else if (retries > 0) {
                setTimeout(() => waitForGsap(retries - 1), 200);
            } else {
                console.warn('GSAP não carregou após múltiplas tentativas.');
            }
        }

        document.addEventListener('DOMContentLoaded', waitForGsap);
    </script>
</x-app-layout>