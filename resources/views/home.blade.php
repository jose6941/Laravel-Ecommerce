<x-app-layout>
    <!-- Banner Section - Ocupa toda a área abaixo da navbar e acima das categorias -->
    <div class="w-full bg-[#f0f0ee] relative overflow-hidden flex items-center" id="banner-section" style="min-height: calc(100vh - 5rem);">

        <!-- Tipografia gigante de fundo (efeito editorial/poster, como na referência) -->
        <div class="absolute inset-0 flex items-center justify-end pointer-events-none select-none z-0 overflow-hidden">
            <span class="gsap-bg-text font-display font-black text-[14rem] lg:text-[20rem] leading-none text-gray-300/40 tracking-tighter -mr-4 lg:-mr-10 whitespace-nowrap">MADE</span>
        </div>

        <!-- Partículas sutis -->
        <div id="particles-container" class="absolute inset-0 pointer-events-none z-10"></div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex flex-col lg:flex-row items-center">

                <!-- Left Side - Text Content -->
                <div class="w-full lg:w-[38%] pl-4 pr-4 sm:pl-12 sm:pr-10 lg:pl-20 lg:pr-6 py-16 lg:py-24 z-20">
                    <!-- Tagline superior -->
                    <div class="gsap-banner-item mb-5">
                        <span class="inline-flex items-center gap-2 text-xs font-bold text-[#1a1a1a] tracking-[0.25em] uppercase">
                            <span class="w-6 h-[2px] bg-gray-400"></span>
                            Heepzy &mdash; Nova Coleção
                        </span>
                    </div>

                    <!-- Título principal -->
                    <h1 class="gsap-banner-item font-display font-black leading-[0.85] tracking-tighter text-[#1a1a1a] mb-5">
                        <span class="text-[3.5rem] sm:text-[4.5rem] lg:text-[5.5rem] xl:text-[7rem]">CONFORTO</span><br>
                        <span class="text-[2.6rem] sm:text-[3.4rem] lg:text-[4.2rem] xl:text-[5rem] text-[#4a4a4a]" style="text-shadow: 0 0 30px rgba(74,74,74,0.2);">REIMAGINADO</span>
                    </h1>

                    <!-- Subtítulo -->
                    <p class="gsap-banner-item text-gray-600 text-sm sm:text-base font-normal leading-relaxed max-w-md mb-8">
                        Tecnologia de amortecimento dinâmico. Leveza absoluta.<br>
                        Design que vira cabeças. Feito para quem não passa despercebido.
                    </p>

                    <!-- CTA - Apenas o botão de comprar agora -->
                    <div class="gsap-banner-item flex flex-wrap items-center gap-3">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center gap-2.5 bg-brand text-white px-10 py-[18px] text-sm font-bold tracking-[0.15em] uppercase rounded-full hover:bg-brand-dark transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            COMPRAR AGORA
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
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
                <div class="w-full lg:w-[62%] flex items-center justify-center lg:justify-end pl-6 pr-4 lg:pr-4 lg:pl-8 z-20">
                    <div class="gsap-sneaker-wrapper relative w-full max-w-lg lg:max-w-xl">
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

    <!-- Categorias Section - Visual Cards -->
    <div class="relative py-16 lg:py-20 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full bg-black/[0.02] pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-64 h-64 rounded-full bg-black/[0.015] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="text-center mb-12 lg:mb-14 gsap-fade-up">
                <div class="flex items-center justify-center gap-4 mb-5">
                    <span class="w-10 h-[2px] bg-gray-400"></span>
                    <span class="text-xs font-bold text-[#1a1a1a] tracking-[0.3em] uppercase font-display">Categorias</span>
                    <span class="w-10 h-[2px] bg-gray-400"></span>
                </div>
                <h2 class="font-display font-black text-[#1a1a1a] text-4xl md:text-5xl lg:text-6xl leading-[0.9] tracking-tighter">
                    ENCONTRE<br class="sm:hidden"> O SEU ESTILO
                </h2>
                <p class="text-gray-400 text-sm mt-4 max-w-md mx-auto font-medium tracking-wide">
                    Navegue por nossas categorias e descubra o que faz sentido para você.
                </p>
            </div>

            @if($categorias->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 gsap-category-grid">
                    @foreach($categorias as $categoria)
                        <a href="{{ route('home', ['categoria' => $categoria->slug]) }}"
                           class="gsap-category-card group relative block aspect-[4/5] rounded-2xl overflow-hidden bg-gray-200 shadow-lg hover:shadow-2xl transition-all duration-500">
                            
                            <!-- Background Image -->
                            @if($categoria->imagem_fundo)
                                <div class="absolute inset-0 w-full h-full overflow-hidden">
                                    <x-img-skeleton src="{{ $categoria->imagem_fundo }}"
                                         alt="{{ $categoria->nome }}"
                                         wrapperClass="absolute inset-0"
                                         class="w-full h-full object-cover transition-all duration-700 ease-out group-hover:scale-110 group-hover:rotate-[2deg]" />
                                </div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-gray-300 to-gray-100"></div>
                            @endif

                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-dark/85 via-dark/25 to-transparent transition-all duration-500 group-hover:from-dark/70"></div>

                            <!-- Content at Bottom -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-7">
                                <h3 class="font-display font-bold text-white text-xl sm:text-2xl leading-tight mb-1.5">
                                    {{ $categoria->nome }}
                                </h3>
                                @if($categoria->descricao)
                                    <p class="text-white/60 text-xs sm:text-sm font-medium leading-relaxed line-clamp-2">
                                        {{ $categoria->descricao }}
                                    </p>
                                @endif
                                
                                <!-- Shop Now CTA (appears on hover) -->
                                <div class="mt-3 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-400 ease-out">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-brand tracking-wider uppercase">
                                        Shop Now
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                    </span>
                                </div>
                            </div>

                            <!-- Subtle border on hover -->
                            <div class="absolute inset-0 ring-1 ring-inset ring-white/10 rounded-2xl group-hover:ring-brand/40 transition-all duration-500"></div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-sm font-medium text-gray-500">Nenhuma categoria disponível no momento.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Bar -->
    <div class="bg-dark text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="flex items-center justify-center md:justify-start gap-4 px-4 py-2">
                    <div class="w-11 h-11 rounded-xl bg-brand/20 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                    </div>
                    <div><p class="font-bold text-sm">Free Shipping</p><p class="text-xs text-gray-400">On all orders</p></div>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-4 px-4 py-2">
                    <div class="w-11 h-11 rounded-xl bg-brand/20 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </div>
                    <div><p class="font-bold text-sm">Easy Returns</p><p class="text-xs text-gray-400">14 days returns</p></div>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-4 px-4 py-2">
                    <div class="w-11 h-11 rounded-xl bg-brand/20 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.965 11.965 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <div><p class="font-bold text-sm">100% Authentic</p><p class="text-xs text-gray-400">Original Products</p></div>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-4 px-4 py-2">
                    <div class="w-11 h-11 rounded-xl bg-brand/20 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <div><p class="font-bold text-sm">Secure Payment</p><p class="text-xs text-gray-400">100% Secure</p></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção Nova Coleção (texto + busca, sem categorias) -->
    <div class="py-10 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="gsap-fade-up">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-[2px] bg-gray-400"></span>
                    <span class="text-xs font-bold text-[#1a1a1a] tracking-[0.25em] uppercase font-display">Destaques</span>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-black text-dark leading-[0.9] uppercase tracking-tighter mb-6">NOVA COLEÇÃO<br class="sm:hidden"> PARA O SEU RITMO</h2>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-8 gsap-fade-up">
                <form method="GET" action="{{ route('home') }}" class="flex items-center bg-white border border-gray-200 focus-within:border-[#1a1a1a] focus-within:shadow-[0_0_0_2px_rgba(0,0,0,0.08),0_4px_16px_rgba(0,0,0,0.08)] rounded-full overflow-hidden transition-all duration-300 w-full sm:w-auto shadow-[0_0_0_1px_rgba(0,0,0,0.06),0_2px_8px_rgba(0,0,0,0.06)]">
                    @if (request('categoria'))
                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    @endif
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar produtos..."
                           class="text-base bg-transparent border-none px-6 py-3.5 text-dark placeholder-gray-400 focus:outline-none focus:ring-0 w-full sm:w-64 md:w-80 transition-all">
                    <button type="submit" class="px-4 text-gray-400 hover:text-[#1a1a1a] transition-colors duration-300 shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                </form>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-brand text-white px-8 py-3.5 text-base font-bold tracking-widest uppercase rounded-full hover:bg-brand-dark transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 shrink-0">
                    TODOS OS MODELOS
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </a>
            </div>
        </div>
    </div>

    <x-product-grid :produtos="$produtos" />

    <!-- Banner Relógio - Full-width, premium, sem cortes, sem opacidade -->
    <div class="w-full bg-[#1a1a1a] relative overflow-hidden flex items-center justify-center gsap-relogio-wrapper" id="relogio-banner" style="min-height: 95vh;">
        <img src="/images/relogio_banner.png"
             alt="Relógio Heepzy"
             class="gsap-relogio-img w-full h-full absolute inset-0 object-contain select-none"
             draggable="false"
             style="filter: brightness(1.04) contrast(1.03);">
        <!-- Overlay gradiente sutil nas bordas para suavizar a transição com o fundo escuro -->
        <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at center, transparent 60%, rgba(26,26,26,0.5) 100%);"></div>
    </div>

    <!-- Banner Fone Section - Fundo branco, fone à esquerda, texto à direita -->
    <div class="w-full bg-white relative overflow-hidden flex items-center" id="airpod-banner" style="min-height: 55vh;">

        <!-- Tipografia gigante de fundo -->
        <div class="absolute inset-0 flex items-center justify-start pointer-events-none select-none z-0 overflow-hidden">
            <span class="gsap-fone-bg-text font-display font-black text-[12rem] lg:text-[18rem] leading-none text-gray-200/50 tracking-tighter -ml-4 lg:-ml-10 whitespace-nowrap">SOUND</span>
        </div>

        <!-- Partículas sutis -->
        <div id="airpod-particles" class="absolute inset-0 pointer-events-none z-10"></div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-20">
            <div class="relative flex flex-col lg:flex-row items-center">

                <!-- Left Side - Fone de ouvido - Imersivo -->
                <div class="w-full lg:w-[58%] flex items-center justify-center lg:justify-center py-8 lg:py-14 overflow-visible pl-4 sm:pl-8 lg:pl-16 relative">
                    <!-- Círculo de brilho pulsante atrás do fone -->
                    <div class="gsap-fone-glow absolute left-[30%] top-1/2 -translate-y-1/2 w-[50%] aspect-square rounded-full bg-gradient-to-r from-gray-100 via-gray-50 to-white opacity-15 blur-3xl pointer-events-none"></div>
                    <img src="/images/fone-hd.png"
                         alt="Fone Heepzy Audio"
                         class="gsap-airpod-img w-full h-auto object-contain select-none relative max-h-[55vh]"
                         draggable="false"
                         style="filter: contrast(1.05) brightness(1.02);">
                </div>

                <!-- Right Side - Text Content (bem distribuído como primeiro banner) -->
                <div class="w-full lg:w-[42%] pl-4 pr-4 sm:pl-10 sm:pr-10 lg:pl-8 lg:pr-16 py-14 lg:py-20 z-20 text-center lg:text-left">
                    <!-- Tagline superior -->
                    <div class="gsap-airpod-item mb-5 flex lg:justify-start justify-center">
                        <span class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 tracking-[0.25em] uppercase">
                            <span class="w-6 h-[2px] bg-gray-300"></span>
                            Heepzy Audio
                        </span>
                    </div>

                    <!-- Título principal -->
                    <h1 class="gsap-airpod-item font-display font-black leading-[0.85] tracking-tighter text-[#1a1a1a] mb-5">
                        <span class="text-[3.2rem] sm:text-[4rem] lg:text-[5rem] xl:text-[5.5rem]">SOM</span><br>
                        <span class="text-[2.4rem] sm:text-[3.2rem] lg:text-[3.8rem] xl:text-[4.2rem] text-gray-400">SEM LIMITES</span>
                    </h1>

                    <!-- Subtítulo -->
                    <p class="gsap-airpod-item text-gray-500 text-sm sm:text-base font-normal leading-relaxed max-w-md mb-8">
                        Áudio espacial com cancelamento de ruído ativo.<br>
                        30 horas de bateria. Conecte-se ao que realmente importa.
                    </p>

                    <!-- CTA -->
                    <div class="gsap-airpod-item flex flex-wrap items-center gap-3 lg:justify-start justify-center">
                        <a href="{{ route('home', ['categoria' => 'eletronicos']) }}"
                           class="inline-flex items-center gap-2.5 bg-brand text-white px-10 py-[18px] text-sm font-bold tracking-[0.15em] uppercase rounded-full hover:bg-brand-dark transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            COMPRAR AGORA
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                        <span class="text-xs text-gray-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            A partir de R$ 499,90
                        </span>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="gsap-airpod-item flex items-center gap-6 mt-8 pt-6 border-t border-gray-100 lg:justify-start justify-center">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            <span class="text-xs font-medium text-gray-500">1 ano de garantia</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                            <span class="text-xs font-medium text-gray-500">Entrega expressa</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            <span class="text-xs font-medium text-gray-500">Troca grátis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- SWAP_MARKER_RELOGIO -->

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

            // ===== BANNER PRINCIPAL — PARALLAX AO SCROLL (como o relógio) =====
            const bannerSection = document.getElementById('banner-section');
            if (bannerSection) {
                // Background text "MADE" + sneaker image — parallax suave com scrub
                const bannerParallaxTl = gsap.timeline({
                    scrollTrigger: {
                        trigger: bannerSection,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: 1.5
                    }
                });

                // Background text "MADE" se move mais devagar (mais distante)
                bannerParallaxTl.to('.gsap-bg-text', {
                    yPercent: -18,
                    ease: 'none'
                }, 0);

                // Sneaker — parallax sutil na direção oposta (cria profundidade)
                bannerParallaxTl.to('.gsap-sneaker-img', {
                    yPercent: 8,
                    ease: 'none'
                }, 0);
            }

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

            // ===== FONE BANNER ANIMATIONS =====

            const foneTl = gsap.timeline({ defaults: { ease: 'expo.out' } });

            // 0. Background text "SOUND" fade + scale
            foneTl.from('.gsap-fone-bg-text', {
                opacity: 0,
                scale: 1.1,
                duration: 2.5,
                ease: 'power2.out'
            });

            // 1. Texto entra com stagger mais longo e suave
            foneTl.from('.gsap-airpod-item', {
                y: 70,
                opacity: 0,
                duration: 1.4,
                stagger: 0.25,
                ease: 'power4.out'
            }, '-=1.8');

            // 2. Imagem do fone entra com efeito mais dramático
            foneTl.from('.gsap-airpod-img', {
                x: 150,
                scale: 0.7,
                rotationZ: 12,
                opacity: 0,
                filter: 'blur(30px)',
                duration: 2.2,
                ease: 'expo.out'
            }, '-=2.0');

            // 3. Scroll indicator
            foneTl.from('.gsap-airpod-scroll', {
                opacity: 0,
                y: 15,
                duration: 1.0
            }, '-=0.5');

            // 4. Floating contínuo do fone — mais amplitude e rotação
            gsap.to('.gsap-airpod-img', {
                y: '-=20',
                rotationZ: '+=3',
                scale: 1.02,
                duration: 5.5,
                yoyo: true,
                repeat: -1,
                ease: 'sine.inOut',
                delay: 3.0
            });

            // 5. Pulsar sutil do brilho de fundo
            gsap.to('.gsap-fone-glow', {
                scale: 1.12,
                opacity: 0.3,
                duration: 3.0,
                yoyo: true,
                repeat: -1,
                ease: 'sine.inOut',
                delay: 3.5
            });

            // ===== BANNER FONE — PARALLAX AO SCROLL (como os outros banners) =====
            const foneBanner = document.getElementById('airpod-banner');
            if (foneBanner) {
                const foneParallaxTl = gsap.timeline({
                    scrollTrigger: {
                        trigger: foneBanner,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: 1.5
                    }
                });

                // Background text "SOUND" se move para cima (mais distante)
                foneParallaxTl.to('.gsap-fone-bg-text', {
                    yPercent: -15,
                    ease: 'none'
                }, 0);

                // Imagem do fone — parallax sutil na direção oposta (profundidade)
                foneParallaxTl.to('.gsap-airpod-img', {
                    yPercent: 8,
                    ease: 'none'
                }, 0);
            }

            // ===== PARTÍCULAS DO BANNER FONE =====
            (function createFoneParticles() {
                const container = document.getElementById('airpod-particles');
                if (!container) return;

                const colors = ['#d1d5db', '#9ca3af', '#e5e7eb', '#f3f4f6', '#000000', '#6b7280'];
                const particleCount = 14;

                container.innerHTML = '';

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    const size = gsap.utils.random(2, 6, 0.5);
                    const isCircle = Math.random() > 0.3;

                    particle.className = 'absolute';
                    particle.style.cssText = `
                        width: ${size}px;
                        height: ${isCircle ? size : size * 0.4}px;
                        border-radius: ${isCircle ? '50%' : '2px'};
                        background: ${gsap.utils.random(colors)};
                        opacity: ${gsap.utils.random(0.04, 0.15, 0.01)};
                        left: ${gsap.utils.random(2, 98, 0.1)}%;
                        top: ${gsap.utils.random(2, 98, 0.1)}%;
                        will-change: transform, opacity;
                    `;

                    container.appendChild(particle);

                    const maxX = Math.min(window.innerWidth * 0.1, 100);
                    const maxY = Math.min(window.innerHeight * 0.06, 60);

                    gsap.to(particle, {
                        x: gsap.utils.random(-maxX, maxX, 1),
                        y: gsap.utils.random(-maxY, maxY, 1),
                        rotation: gsap.utils.random(-20, 20, 1),
                        opacity: gsap.utils.random(0.02, 0.2, 0.01),
                        duration: gsap.utils.random(12, 25, 0.1),
                        delay: gsap.utils.random(0, 5, 0.1),
                        ease: 'sine.inOut',
                        yoyo: true,
                        repeat: -1,
                        repeatDelay: gsap.utils.random(0.5, 3, 0.1)
                    });
                }
            })();

            // ===== SCROLL ANIMATIONS =====
            if (typeof ScrollTrigger !== 'undefined') {
                // Fade-up sections — movimento suave (sempre visíveis)
                const fadeUpElements = document.querySelectorAll('.gsap-fade-up');
                fadeUpElements.forEach(el => {
                    gsap.from(el, {
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 85%',
                            toggleActions: 'play none none none'
                        },
                        y: 40,
                        duration: 1.0,
                        ease: 'power3.out'
                    });
                });

                // Category cards stagger — animação suave e premium
                const categoryCards = document.querySelectorAll('.gsap-category-card');
                const categoryGrid = document.querySelector('.gsap-category-grid');
                if (categoryCards.length && categoryGrid) {
                    gsap.set(categoryCards, { opacity: 0, y: 60, scale: 0.95 });

                    gsap.to(categoryCards, {
                        scrollTrigger: {
                            trigger: categoryGrid,
                            start: 'top 80%',
                            once: true,
                        },
                        y: 0,
                        opacity: 1,
                        scale: 1,
                        duration: 1.0,
                        stagger: { each: 0.15, from: 'start' },
                        ease: 'power3.out',
                        clearProps: 'all'
                    });
                }

                // Relógio banner — parallax suave (sem fade-in, sem opacidade, imagem sempre nítida)
                const relogioWrapper = document.querySelector('.gsap-relogio-wrapper');
                if (relogioWrapper) {
                    gsap.timeline({
                        scrollTrigger: {
                            trigger: relogioWrapper,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 1.5
                        }
                    })
                    .to('.gsap-relogio-img', { yPercent: 18, ease: 'none' }, 0)
                    .to('.gsap-relogio-img', { scale: 1.02, ease: 'none' }, 0);
                }

                // Product cards stagger — animação suave e sem tremor
                const productsGrid = document.querySelector('.gsap-products-grid');
                if (productsGrid) {
                    const productCards = document.querySelectorAll('.gsap-product-card');

                    gsap.set(productCards, { opacity: 0, y: 80, scale: 0.92 });

                    gsap.to(productCards, {
                        scrollTrigger: {
                            trigger: productsGrid,
                            start: 'top 83%',
                            once: true,
                        },
                        y: 0,
                        opacity: 1,
                        scale: 1,
                        duration: 1.1,
                        stagger: { each: 0.12, from: 'start' },
                        ease: 'power3.out',
                        clearProps: 'all'
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