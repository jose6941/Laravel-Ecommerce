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
                <div class="w-full lg:w-[40%] pl-4 pr-4 sm:pl-10 sm:pr-8 lg:pl-14 lg:pr-4 py-16 lg:py-24 z-20">
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
                        <span class="text-[2.6rem] sm:text-[3.4rem] lg:text-[4.2rem] xl:text-[5rem] text-gray-400" style="text-shadow: 0 0 45px rgba(113,113,122,0.35);">REIMAGINADO</span>
                    </h1>

                    <!-- Subtítulo -->
                    <p class="gsap-banner-item text-gray-500 text-sm sm:text-base font-light leading-relaxed max-w-md mb-8">
                        Tecnologia de amortecimento dinâmico. Leveza absoluta.<br>
                        Design que vira cabeças. Feito para quem não passa despercebido.
                    </p>

                    <!-- CTA - Apenas o botão de comprar agora -->
                    <div class="gsap-banner-item flex flex-wrap items-center gap-3">
                        <a href="{{ route('produtos.index') }}"
                           class="inline-flex items-center gap-2.5 bg-[#1a1a1a] text-white px-10 py-[18px] text-sm font-bold tracking-[0.15em] uppercase rounded-full hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl">
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
                <div class="w-full lg:w-[60%] flex items-center justify-center lg:justify-end pl-6 pr-4 lg:pr-8 lg:pl-4 z-20">
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

    <!-- Categorias Section -->
    <div class="relative py-16 lg:py-20 bg-[#f0f0ee]">
        <!-- Linha divisória sutil no topo (transição do banner) -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-300/40 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cabeçalho editorial -->
            <div class="text-center mb-10 lg:mb-12 gsap-fade-up">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <span class="w-8 h-[2px] bg-gray-400"></span>
                    <span class="text-[10px] font-bold text-[#1a1a1a] tracking-[0.3em] uppercase font-display">Categorias</span>
                    <span class="w-8 h-[2px] bg-gray-400"></span>
                </div>
                <h2 class="font-display font-black text-[#1a1a1a] text-3xl md:text-4xl lg:text-5xl leading-[0.9] tracking-tighter">
                    ENCONTRE<br class="sm:hidden"> O SEU ESTILO
                </h2>
            </div>

            @if($categorias->isNotEmpty())
                @php
                    $iconMap = [
                        'eletronicos' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>',
                        'moda-masculina' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661l-2.412-7.839a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859" /></svg>',
                        'moda-feminina' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>',
                        'casa-e-decoracao' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>',
                        'esportes-e-lazer' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM6.75 21H18M4.5 21v-3.75A3.75 3.75 0 018.25 13.5h7.5a3.75 3.75 0 013.75 3.75V21" /></svg>',
                        'livros' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>',
                        'beleza-e-cuidados' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>',
                        'brinquedos-e-jogos' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.401.604-.401.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.959.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z" /></svg>',
                        'pet-shop' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" /></svg>',
                        'papelaria-e-escritorio' => '<svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>',
                    ];
                @endphp
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach($categorias as $categoria)
                        <a href="{{ route('produtos.index', ['categoria' => $categoria->slug]) }}"
                           class="gsap-category-chip group inline-flex items-center gap-2.5 px-6 py-3 bg-[#1a1a1a] text-white border-2 border-[#1a1a1a] rounded-full text-sm font-display font-bold tracking-wider hover:bg-white hover:text-[#1a1a1a] hover:scale-105 hover:shadow-xl transition-all duration-500 ease-out shadow-lg">
                            @if(isset($iconMap[$categoria->slug]))
                                {!! $iconMap[$categoria->slug] !!}
                            @endif
                            <span>{{ $categoria->nome }}</span>
                            <span class="inline-block transition-transform duration-500 ease-out group-hover:translate-x-1 opacity-60">&rarr;</span>
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
    <div class="py-20 lg:py-24 bg-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 lg:mb-14 gsap-fade-up">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-6 h-[2px] bg-gray-400"></span>
                    <span class="text-[10px] font-bold text-[#1a1a1a] tracking-[0.25em] uppercase font-display">Destaques</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-display font-black text-dark leading-[0.9] uppercase tracking-tighter mb-6">NOVA COLEÇÃO<br class="sm:hidden"> PARA O SEU RITMO</h2>
                
                <div class="flex flex-col items-start gap-4">
                    <p class="text-gray-500 text-sm font-medium leading-relaxed max-w-lg">Tecnológicos para corrida, treinos e cidade. Escolha seu par e siga em frente.</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                        <form action="{{ route('produtos.index') }}" method="GET" class="flex items-center bg-white border border-gray-300 focus-within:border-[#1a1a1a] focus-within:shadow-sm rounded-full overflow-hidden transition-all duration-300 w-full sm:w-auto">
                            <input type="text" name="q" placeholder="Buscar produtos..." class="text-sm bg-transparent border-none px-4 py-2.5 text-dark placeholder-gray-400 focus:outline-none focus:ring-0 w-full sm:w-48 md:w-56 transition-all">
                            <button type="submit" class="px-3.5 text-gray-400 hover:text-[#1a1a1a] transition-colors duration-300 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </form>
                        <a href="{{ route('produtos.index') }}" class="inline-flex items-center gap-2 bg-dark text-white px-6 py-2.5 text-xs font-bold tracking-widest uppercase rounded-full hover:bg-gray-800 transition-all duration-300 hover:shadow-lg shrink-0">
                            TODOS OS MODELOS
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                    </div>
                </div>
            </div>

            @if(isset($produtosDestaque) && $produtosDestaque->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-3 gap-5 sm:gap-6 lg:gap-7 gsap-products-grid">
                    @foreach ($produtosDestaque->take(9) as $index => $produto)
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

                // Category chips stagger (apenas movimento sutil, sem opacity)
                const categoryChips = document.querySelectorAll('.gsap-category-chip');
                if (categoryChips.length) {
                    gsap.from(categoryChips, {
                        scrollTrigger: {
                            trigger: categoryChips[0].parentElement,
                            start: 'top 88%',
                            toggleActions: 'play none none none'
                        },
                        y: 15,
                        duration: 0.5,
                        stagger: 0.05,
                        ease: 'power2.out'
                    });
                }

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