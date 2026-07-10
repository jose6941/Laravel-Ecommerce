<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Breadcrumb -->
        <nav class="text-xs font-bold tracking-widest uppercase mb-10">
            <ol class="list-none p-0 inline-flex items-center">
                <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-[#1a1a1a] transition">Home</a></li>
                <li class="mx-3 text-gray-300">/</li>
                <li><a href="{{ route('produtos.index') }}" class="text-gray-400 hover:text-[#1a1a1a] transition">{{ $produto->categoria->nome ?? 'Produtos' }}</a></li>
                <li class="mx-3 text-gray-300">/</li>
                <li class="text-[#1a1a1a] font-semibold">{{ $produto->nome }}</li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start" x-data="productGallery()">

            <!-- Product Images (Left side) -->
            <div class="lg:w-[55%] w-full gsap-hero-image">
                <!-- Main Image with Magnifying Glass -->
                <div class="relative bg-[#f5f5f5] rounded-3xl overflow-hidden mb-4 aspect-square"
                     @mouseenter="lensActive = true"
                     @mouseleave="lensActive = false"
                     @mousemove="moveLens($event)"
                     x-ref="imageContainer">

                    @if ($produto->imagens->isNotEmpty())
                        <!-- Base image -->
                        <img :src="activeImage"
                             alt="{{ $produto->nome }}"
                             class="w-full h-full object-contain select-none"
                             draggable="false">

                        <!-- Lens (follows cursor) -->
                        <div x-show="lensActive"
                             x-cloak
                             class="absolute pointer-events-none z-10 rounded-full border-2 border-white shadow-lg"
                             :style="lensStyle"
                             style="width: 120px; height: 120px; background-repeat: no-repeat;">
                        </div>

                        <!-- Zoom result panel -->
                        <div x-show="lensActive"
                             x-cloak
                             class="absolute top-0 left-[calc(100%+16px)] w-[400px] h-full rounded-2xl overflow-hidden shadow-2xl border border-gray-100 z-20 bg-white hidden lg:block"
                             x-ref="zoomResult">
                            <div class="w-full h-full"
                                 :style="zoomStyle">
                            </div>
                        </div>
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 font-medium">Sem imagem</div>
                    @endif

                    <!-- Hint text -->
                    <div x-show="!lensActive"
                         class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-sm rounded-full px-3 py-1.5 text-[10px] font-medium text-gray-500 shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                        </svg>
                        Passe o mouse para ampliar
                    </div>
                </div>

                <!-- Thumbnails -->
                @if ($produto->imagens->count() > 1)
                    <div class="flex gap-3 overflow-x-auto no-scrollbar pb-1">
                        @foreach ($produto->imagens as $imagem)
                            <button @click="setActive('{{ $imagem->url }}')"
                                    class="shrink-0 w-20 h-20 rounded-xl bg-[#f5f5f5] overflow-hidden border-2 transition-all duration-300 hover:border-[#1a1a1a]/40"
                                    :class="activeImage === '{{ $imagem->url }}' ? 'border-[#1a1a1a] ring-1 ring-[#1a1a1a]/20' : 'border-transparent'">
                                <img src="{{ $imagem->url }}"
                                     alt="{{ $produto->nome }}"
                                     class="w-full h-full object-contain p-1.5">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details (Right side) -->
            <div class="lg:w-[45%] w-full flex flex-col justify-center max-w-lg mx-auto lg:mx-0">
                <!-- Badges -->
                <div class="flex items-center gap-3 mb-4 gsap-hero-text">
                    <span class="bg-[#1a1a1a] text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                        {{ $produto->estoque > 0 ? 'Disponível' : 'Indisponível' }}
                    </span>
                    @if ($produto->preco_promocional)
                        <span class="bg-red-50 text-red-600 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                            Promoção
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-[#1a1a1a] mb-4 leading-tight gsap-hero-text">
                    {{ $produto->nome }}
                </h1>

                <!-- Price -->
                <div class="flex items-end gap-3 mb-6 gsap-hero-text">
                    @if ($produto->preco_promocional)
                        <span class="text-3xl font-bold text-[#1a1a1a]">
                            R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}
                        </span>
                        <span class="text-xl text-gray-400 line-through font-medium mb-0.5">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </span>
                    @else
                        <span class="text-3xl font-bold text-[#1a1a1a]">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-gray-50 rounded-2xl p-5 mb-8 border border-gray-200 gsap-hero-text">
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $produto->descricao ?: 'Produto de alta qualidade, desenvolvido para oferecer a melhor experiência no seu dia a dia.' }}
                    </p>
                </div>

                <!-- SKU & Estoque -->
                <div class="flex items-center gap-6 mb-8 text-sm gsap-hero-text">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-medium">SKU:</span>
                        <span class="text-[#1a1a1a] font-semibold">{{ $produto->sku }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-medium">Estoque:</span>
                        <span class="font-semibold {{ $produto->estoque > 5 ? 'text-emerald-600' : ($produto->estoque > 0 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $produto->estoque > 0 ? $produto->estoque . ' unidades' : 'Esgotado' }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mb-10 gsap-hero-text">
                    <!-- Quantity Control -->
                    <div x-data="{ count: 1 }" class="flex items-center bg-gray-50 rounded-full h-14 px-2 w-full sm:w-auto shrink-0 border border-gray-100">
                        <button @click="count = Math.max(1, count - 1)" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-white hover:shadow transition text-xl font-medium text-gray-600 hover:text-[#1a1a1a]">-</button>
                        <input type="text" x-model="count" class="w-12 h-full border-none bg-transparent text-center focus:ring-0 font-bold text-lg text-[#1a1a1a]" readonly>
                        <button @click="count++" class="w-10 h-10 rounded-full flex items-center justify-center bg-white shadow-sm hover:shadow-md transition text-xl font-medium text-gray-600 hover:text-[#1a1a1a]">+</button>
                    </div>

                    <!-- Add to Cart Form -->
                    <form method="POST" action="{{ route('carrinho.store') }}" class="flex-1 w-full">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <input type="hidden" name="quantidade" value="1" x-bind:value="count">
                        <button type="submit"
                                class="w-full h-14 bg-[#1a1a1a] text-white rounded-full font-bold text-base hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2.5 group">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.608-7.164.075-.3-.155-.586-.464-.586H5.106M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            Adicionar ao Carrinho
                        </button>
                    </form>
                </div>

                <!-- Features List -->
                <div class="grid grid-cols-2 gap-3 gsap-hero-text">
                    <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm">
                        <div class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center mb-2.5">
                            <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs text-[#1a1a1a] mb-0.5">Frete Grátis</h4>
                        <p class="text-[10px] text-gray-400">Para pedidos acima de R$ 199</p>
                    </div>
                    <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm">
                        <div class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center mb-2.5">
                            <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs text-[#1a1a1a] mb-0.5">Troca Fácil</h4>
                        <p class="text-[10px] text-gray-400">Em até 30 dias</p>
                    </div>
                    <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm">
                        <div class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center mb-2.5">
                            <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs text-[#1a1a1a] mb-0.5">Pagamento Seguro</h4>
                        <p class="text-[10px] text-gray-400">Criptografia SSL</p>
                    </div>
                    <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm">
                        <div class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center mb-2.5">
                            <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs text-[#1a1a1a] mb-0.5">Entrega Rápida</h4>
                        <p class="text-[10px] text-gray-400">Em até 5 dias úteis</p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Alpine.js Product Gallery with Magnifying Glass -->
    <script>
        function productGallery() {
            return {
                activeImage: '{{ $produto->imagens->isNotEmpty() ? $produto->imagens->first()->url : "" }}',
                lensActive: false,
                lensX: 0,
                lensY: 0,
                zoomScale: 2.5,

                get lensStyle() {
                    const lensSize = 120;
                    const halfLens = lensSize / 2;
                    const x = this.lensX - halfLens;
                    const y = this.lensY - halfLens;
                    return {
                        left: x + 'px',
                        top: y + 'px',
                        backgroundImage: 'url("' + this.activeImage + '")',
                        backgroundSize: (this.$refs.imageContainer?.offsetWidth * this.zoomScale) + 'px ' + (this.$refs.imageContainer?.offsetHeight * this.zoomScale) + 'px',
                        // Posiciona o fundo ampliado: centro da lente alinhado com (lensX, lensY)
                        backgroundPosition: (-this.lensX * this.zoomScale + halfLens) + 'px ' + (-this.lensY * this.zoomScale + halfLens) + 'px',
                        backgroundRepeat: 'no-repeat',
                        backgroundColor: '#f5f5f5'
                    };
                },

                get zoomStyle() {
                    if (!this.$refs.imageContainer) return {};
                    const rect = this.$refs.imageContainer.getBoundingClientRect();
                    const w = rect.width;
                    const h = rect.height;
                    return {
                        backgroundImage: 'url("' + this.activeImage + '")',
                        backgroundSize: (w * this.zoomScale) + 'px ' + (h * this.zoomScale) + 'px',
                        // Mesma lógica: centro do painel alinhado com (lensX, lensY) no original
                        backgroundPosition: (-this.lensX * this.zoomScale + w / 2) + 'px ' + (-this.lensY * this.zoomScale + h / 2) + 'px',
                        backgroundRepeat: 'no-repeat',
                        backgroundColor: '#f5f5f5'
                    };
                },

                moveLens(event) {
                    const rect = this.$refs.imageContainer.getBoundingClientRect();
                    let x = event.clientX - rect.left;
                    let y = event.clientY - rect.top;

                    // Keep lens within bounds
                    const lensSize = 120;
                    const halfLens = lensSize / 2;
                    x = Math.max(halfLens, Math.min(x, rect.width - halfLens));
                    y = Math.max(halfLens, Math.min(y, rect.height - halfLens));

                    this.lensX = x;
                    this.lensY = y;
                },

                setActive(url) {
                    this.activeImage = url;
                }
            };
        }
    </script>

    <style>
        /* Esconde scrollbar das thumbnails */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Lens glow animation */
        [x-cloak] { display: none !important; }

        /* Zoom panel fade in */
        .zoom-panel-enter {
            animation: zoomFadeIn 0.2s ease-out;
        }

        @keyframes zoomFadeIn {
            from { opacity: 0; transform: scale(0.95) translateX(-8px); }
            to { opacity: 1; transform: scale(1) translateX(0); }
        }
    </style>

    <!-- GSAP Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                gsap.from('.gsap-hero-text', {
                    y: 30,
                    opacity: 0,
                    duration: 0.8,
                    stagger: 0.08,
                    ease: 'power3.out',
                    delay: 0.1,
                    clearProps: 'all'
                });

                gsap.from('.gsap-hero-image', {
                    scale: 0.95,
                    opacity: 0,
                    duration: 1,
                    ease: 'power3.out',
                    delay: 0.2,
                    clearProps: 'all'
                });
            }
        });
    </script>
</x-app-layout>
