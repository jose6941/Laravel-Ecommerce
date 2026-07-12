<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{

    private array $comentariosPorNota = [
        5 => [
            'Superou minhas expectativas, recomendo muito!',
            'Chegou rápido e a qualidade é excelente.',
            'Melhor compra que fiz esse mês.',
            'Produto exatamente como descrito, adorei.',
            'Ótimo custo-benefício, vou comprar de novo.',
        ],
        4 => [
            'Muito bom, só demorou um pouco na entrega.',
            'Boa qualidade, atendeu minhas expectativas.',
            'Gostei bastante, recomendo.',
            'Produto bom, mas o preço poderia ser menor.',
        ],
        3 => [
            'Produto ok, nada excepcional.',
            'Cumpre o que promete, mas esperava mais.',
            'Razoável pelo preço.',
        ],
        2 => [
            'Chegou com um pequeno defeito, mas o suporte resolveu.',
            'Esperava mais qualidade pelo preço pago.',
        ],
        1 => [
            'Não corresponde à descrição do anúncio.',
            'Tive problemas com esse produto, não recomendo.',
        ],
    ];

    /**
     * Esquemas de cor por categoria.
     * Cada categoria tem 3 variações cromáticas para gerar imagens distintas.
     */
    private const CORES_CATEGORIA = [
        'Eletrônicos' => [
            ['bg' => '#0f172a', 'g1' => '#1e3a5f', 'g2' => '#3b82f6', 'accent' => '#60a5fa', 'light' => '#93c5fd'],
            ['bg' => '#020617', 'g1' => '#1e293b', 'g2' => '#2563eb', 'accent' => '#3b82f6', 'light' => '#bfdbfe'],
            ['bg' => '#0c1929', 'g1' => '#172554', 'g2' => '#1d4ed8', 'accent' => '#6366f1', 'light' => '#a5b4fc'],
        ],
        'Moda Masculina' => [
            ['bg' => '#292524', 'g1' => '#44403c', 'g2' => '#78716c', 'accent' => '#a8a29e', 'light' => '#d6d3d1'],
            ['bg' => '#1c1917', 'g1' => '#292524', 'g2' => '#57534e', 'accent' => '#8b7355', 'light' => '#c4b5a5'],
            ['bg' => '#1a1a2e', 'g1' => '#2d2d44', 'g2' => '#4a4a6a', 'accent' => '#6b7280', 'light' => '#d1d5db'],
        ],
        'Moda Feminina' => [
            ['bg' => '#2d1b2e', 'g1' => '#4c1d3d', 'g2' => '#9d174d', 'accent' => '#db2777', 'light' => '#f9a8d4'],
            ['bg' => '#1f0f1a', 'g1' => '#3b1a30', 'g2' => '#7e2254', 'accent' => '#e11d48', 'light' => '#fda4af'],
            ['bg' => '#2d1f3d', 'g1' => '#4c1d95', 'g2' => '#7c3aed', 'accent' => '#a78bfa', 'light' => '#ddd6fe'],
        ],
        'Casa e Decoração' => [
            ['bg' => '#2d2416', 'g1' => '#5c3d2e', 'g2' => '#b45309', 'accent' => '#d97706', 'light' => '#fde68a'],
            ['bg' => '#1c1917', 'g1' => '#3d2e24', 'g2' => '#92400e', 'accent' => '#f59e0b', 'light' => '#fcd34d'],
            ['bg' => '#1e1b1a', 'g1' => '#3a2a22', 'g2' => '#7c2d12', 'accent' => '#9a3412', 'light' => '#fed7aa'],
        ],
        'Esportes e Lazer' => [
            ['bg' => '#052e16', 'g1' => '#14532d', 'g2' => '#16a34a', 'accent' => '#22c55e', 'light' => '#86efac'],
            ['bg' => '#0a2f1a', 'g1' => '#1b4332', 'g2' => '#2d6a4f', 'accent' => '#40916c', 'light' => '#95d5b2'],
            ['bg' => '#0c1a2d', 'g1' => '#1a365d', 'g2' => '#2b6cb0', 'accent' => '#4299e1', 'light' => '#bee3f8'],
        ],
        'Livros' => [
            ['bg' => '#1e1b4b', 'g1' => '#312e81', 'g2' => '#4f46e5', 'accent' => '#6366f1', 'light' => '#c7d2fe'],
            ['bg' => '#2d1b3d', 'g1' => '#4c1d95', 'g2' => '#6d28d9', 'accent' => '#8b5cf6', 'light' => '#ddd6fe'],
            ['bg' => '#1a1a2e', 'g1' => '#2d2d44', 'g2' => '#4a3064', 'accent' => '#7c3aed', 'light' => '#c4b5fd'],
        ],
        'Beleza e Cuidados' => [
            ['bg' => '#2d0f1f', 'g1' => '#4a1530', 'g2' => '#9d174d', 'accent' => '#ec4899', 'light' => '#fbcfe8'],
            ['bg' => '#2d1a0f', 'g1' => '#4a2d1a', 'g2' => '#9a3412', 'accent' => '#ea580c', 'light' => '#fdba74'],
            ['bg' => '#1f0f2d', 'g1' => '#3b1a4a', 'g2' => '#7e22ce', 'accent' => '#a855f7', 'light' => '#e9d5ff'],
        ],
        'Brinquedos e Jogos' => [
            ['bg' => '#2d2416', 'g1' => '#78350f', 'g2' => '#d97706', 'accent' => '#f59e0b', 'light' => '#fde68a'],
            ['bg' => '#1a1a2e', 'g1' => '#2d1b69', 'g2' => '#4c1d95', 'accent' => '#7c3aed', 'light' => '#c4b5fd'],
            ['bg' => '#2d0f0f', 'g1' => '#4a1525', 'g2' => '#be123c', 'accent' => '#e11d48', 'light' => '#fecdd3'],
        ],
        'Pet Shop' => [
            ['bg' => '#2d1a0f', 'g1' => '#4a2d1a', 'g2' => '#c2410c', 'accent' => '#ea580c', 'light' => '#fed7aa'],
            ['bg' => '#0f2d1a', 'g1' => '#1a4a2d', 'g2' => '#15803d', 'accent' => '#22c55e', 'light' => '#bbf7d0'],
            ['bg' => '#1a1f2d', 'g1' => '#2d354a', 'g2' => '#475569', 'accent' => '#64748b', 'light' => '#cbd5e1'],
        ],
        'Papelaria e Escritório' => [
            ['bg' => '#0f172a', 'g1' => '#1e293b', 'g2' => '#475569', 'accent' => '#64748b', 'light' => '#94a3b8'],
            ['bg' => '#0c1a2d', 'g1' => '#1a365d', 'g2' => '#2563eb', 'accent' => '#3b82f6', 'light' => '#93c5fd'],
            ['bg' => '#1a1a2e', 'g1' => '#2d2d44', 'g2' => '#4a4a6a', 'accent' => '#6b7280', 'light' => '#d1d5db'],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Categoria::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        if (Usuario::where('perfil', 'cliente')->count() === 0) {
            $this->call(UsuarioSeeder::class);
        }

        // Garantir que o diretório de imagens existe
        Storage::disk('public')->makeDirectory('images/products');

        $clientes = Usuario::where('perfil', 'cliente')->get();
        $catalogo = $this->catalogo();
        $skuIndex = 1;
        foreach ($catalogo as $nomeCategoria => $produtos) {
            $categoria = Categoria::where('nome', $nomeCategoria)->first();

            if (! $categoria) {
                continue;
            }

            $paleta = self::CORES_CATEGORIA[$nomeCategoria] ?? self::CORES_CATEGORIA['Eletrônicos'];

            foreach ($produtos as $dados) {
                $slug = Str::slug($dados['nome']);

                $produto = Produto::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'categoria_id' => $categoria->id,
                        'nome' => $dados['nome'],
                        'sku' => 'SKU-'.str_pad($skuIndex, 5, '0', STR_PAD_LEFT),
                        'descricao' => $dados['descricao'] ?? "Produto de qualidade para o dia a dia: {$dados['nome']}. Confira as especificações e avaliações de outros clientes.",
                        'preco' => $dados['preco'],
                        'preco_promocional' => $dados['promo'] ?? null,
                        'estoque' => $dados['estoque'],
                        'ativo' => true,
                        'destaque' => $dados['destaque'] ?? false,
                    ]
                );

                $skuIndex++;

                $this->gerarGaleriaDeImagens($produto, $slug, $dados['nome'], $paleta);
                $this->gerarAvaliacoes($produto, $clientes);
            }
        }
    }

    // ========================================================================
    //  AVALIAÇÕES
    // ========================================================================

    private function gerarAvaliacoes(Produto $produto, $clientes): void
    {
        $produto->avaliacoes()->delete();

        if ($clientes->isEmpty()) {
            return;
        }

        $quantidade = min($clientes->count(), rand(0, 5));

        if ($quantidade === 0) {
            return;
        }

        $avaliadores = $clientes->random($quantidade);
        $avaliadores = $avaliadores instanceof Usuario ? collect([$avaliadores]) : $avaliadores;

        foreach ($avaliadores as $usuario) {
            $nota = $this->notaAleatoriaPonderada();

            $produto->avaliacoes()->create([
                'usuario_id' => $usuario->id,
                'nota' => $nota,
                'comentario' => collect($this->comentariosPorNota[$nota])->random(),
                'aprovado' => true,
            ]);
        }
    }

    private function notaAleatoriaPonderada(): int
    {
        $sorteio = rand(1, 100);

        return match (true) {
            $sorteio <= 45 => 5,
            $sorteio <= 75 => 4,
            $sorteio <= 90 => 3,
            $sorteio <= 97 => 2,
            default => 1,
        };
    }

    // ========================================================================
    //  IMAGENS — Fotos reais via API Pexels
    //  Cada produto recebe 3 fotos reais de produtos buscadas no Pexels
    //  pela palavra-chave correspondente. As imagens são salvas localmente
    //  em storage/app/public/images/products/.
    //  Se a API falhar, cai no fallback de SVGs profissionais.
    // ========================================================================

    private function gerarGaleriaDeImagens(Produto $produto, string $slug, string $nome, array $paleta): void
    {
        $produto->imagens()->delete();

        $query = $this->buscarQueryPexels($nome);
        $imagens = $this->baixarImagensPexels($query, $slug);

        if (! empty($imagens)) {
            foreach ($imagens as $i => $caminho) {
                $produto->imagens()->create([
                    'caminho' => $caminho,
                    'principal' => $i === 0,
                    'ordem' => $i,
                ]);
            }
            return;
        }

        // Fallback: SVGs profissionais se Pexels falhar
        $this->gerarGaleriaSvgFallback($produto, $slug, $nome, $paleta);
    }

    /**
     * Fallback para SVGs vetoriais caso a API Pexels não responda.
     */
    private function gerarGaleriaSvgFallback(Produto $produto, string $slug, string $nome, array $paleta): void
    {
        for ($i = 0; $i < 3; $i++) {
            $variacao = $paleta[$i % count($paleta)];
            $svg = $this->gerarSvgProduto($nome, $variacao);
            $arquivo = "images/products/{$slug}-{$i}.svg";
            Storage::disk('public')->put($arquivo, $svg);

            $produto->imagens()->create([
                'caminho' => $arquivo,
                'principal' => $i === 0,
                'ordem' => $i,
            ]);
        }
    }

    /**
     * Mapeamento de padrões de nome de produto → query de busca no Pexels.
     */
    private function buscarQueryPexels(string $nome): string
    {
        $nomeLower = Str::lower($nome);

        $map = [
            // Eletrônicos
            'fone de ouvido'    => 'wireless headphones product',
            'smartwatch'        => 'smartwatch product',
            'caixa de som'      => 'bluetooth speaker product',
            'carregador'        => 'powerbank product',
            'mouse'             => 'gaming mouse product',
            'teclado'           => 'mechanical keyboard product',
            // Moda Masculina
            'camiseta'          => 'white t-shirt product',
            'calça'             => 'jeans product',
            'jaqueta'           => 'jacket product',
            'tênis'             => 'sneakers product',
            'bermuda'           => 'shorts product',
            // Moda Feminina
            'vestido'           => 'dress product',
            'blusa'             => 'blouse product',
            'legging'           => 'leggings product',
            'bolsa'             => 'handbag product',
            'sandália'          => 'sandals product',
            // Casa
            'luminária'         => 'desk lamp product',
            'panelas'           => 'cookware product',
            'organizadores'     => 'drawer organizer product',
            'difusor'           => 'aroma diffuser product',
            'manta'             => 'throw blanket product',
            // Esportes
            'futebol'           => 'soccer ball product',
            'halteres'          => 'dumbbell product',
            'bicicleta'         => 'bicycle product',
            'corda'             => 'jump rope product',
            'yoga'              => 'yoga mat product',
            // Livros
            'programação'       => 'programming book product',
            'hábito'            => 'self help book product',
            'história'          => 'history book product',
            'contos'            => 'book product',
            'atlas'             => 'atlas book product',
            // Beleza
            'skincare'          => 'skincare product',
            'perfume'           => 'perfume bottle product',
            'secador'           => 'hair dryer product',
            'escova'            => 'hair brush product',
            'maquiagem'         => 'makeup palette product',
            // Brinquedos
            'quebra-cabeça'     => 'jigsaw puzzle product',
            'tabuleiro'         => 'board game product',
            'carrinho'          => 'rc car toy product',
            'boneca'            => 'doll toy product',
            'pelúcia'           => 'teddy bear plush product',
            // Pet
            'ração'             => 'dog food product',
            'arranhador'        => 'cat tree product',
            'cama pet'          => 'pet bed product',
            'coleira'           => 'dog collar product',
            'mordedor'          => 'dog chew toy product',
            // Papelaria
            'mochila'           => 'backpack product',
            'caderno'           => 'notebook product',
            'canetas'           => 'colored pens product',
            'organizador'       => 'desk organizer product',
            'cadeira'           => 'office chair product',
        ];

        foreach ($map as $pattern => $query) {
            if (str_contains($nomeLower, $pattern)) {
                return $query;
            }
        }

        return 'product photography';
    }

    /**
     * Busca 3 fotos no Pexels pela query, baixa e salva localmente.
     * Retorna array com os caminhos relativos das imagens salvas.
     */
    private function baixarImagensPexels(string $query, string $slug): array
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(['Authorization' => config('services.pexels.key')])
                ->get('https://api.pexels.com/v1/search', [
                    'query' => $query,
                    'per_page' => 3,
                    'orientation' => 'square',
                ]);

            if (! $response->successful()) {
                return [];
            }

            $data = $response->json();

            if (empty($data['photos'])) {
                return [];
            }

            $caminhos = [];

            foreach ($data['photos'] as $i => $photo) {
                $imageUrl = $photo['src']['large'] ?? $photo['src']['medium'] ?? $photo['src']['original'] ?? null;

                if (! $imageUrl) {
                    continue;
                }

                // Baixa a imagem
                $imgResponse = Http::timeout(30)->get($imageUrl);

                if (! $imgResponse->successful()) {
                    continue;
                }

                $ext = 'jpg';
                $arquivo = "images/products/{$slug}-{$i}." . $ext;
                Storage::disk('public')->put($arquivo, $imgResponse->body());
                $caminhos[] = $arquivo;

                // Pequena pausa entre downloads
                if ($i < count($data['photos']) - 1) {
                    usleep(200000);
                }
            }

            return $caminhos;

        } catch (\Exception $e) {
            return [];
        }
    }

    // ========================================================================
    //  GERADOR DE SVG — Ilustrações vetoriais profissionais (fallback)
    //  Usado quando a API Pexels não responde.
    //  Cada produto tem sua própria ilustração única feita de formas
    //  geométricas que representam visualmente o item.
    // ========================================================================

    // ========================================================================
    //  GERADOR DE SVG — Ilustrações vetoriais profissionais
    //  Cada produto tem sua própria ilustração única feita de formas
    //  geométricas que representam visualmente o item.
    // ========================================================================

    private function gerarSvgProduto(string $nome, array $cor): string
    {
        $bg = $cor['bg'];
        $g1 = $cor['g1'];
        $g2 = $cor['g2'];
        $accent = $cor['accent'];
        $light = $cor['light'];

        $ilustracao = $this->desenharProduto($nome, $accent, $light);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800" width="800" height="800">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$bg}"/>
      <stop offset="50%" stop-color="{$g1}"/>
      <stop offset="100%" stop-color="{$g2}"/>
    </linearGradient>
    <linearGradient id="shine" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$light}" stop-opacity="0.15"/>
      <stop offset="100%" stop-color="{$light}" stop-opacity="0"/>
    </linearGradient>
    <filter id="shadow">
      <feDropShadow dx="0" dy="8" stdDeviation="16" flood-color="#000" flood-opacity="0.35"/>
    </filter>
    <filter id="glow">
      <feGaussianBlur stdDeviation="3" result="blur"/>
      <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
    </filter>
  </defs>
  <rect width="800" height="800" rx="16" fill="url(#bg)"/>
  <rect width="800" height="800" rx="16" fill="url(#shine)"/>
  <g transform="translate(400, 400)" filter="url(#shadow)">
    {$ilustracao}
  </g>
</svg>
SVG;
    }

    /**
     * Desenha a ilustração vetorial de cada produto usando shapes SVG.
     * Todas as coordenadas são relativas ao centro (0,0) da tela 800×800.
     */
    private function desenharProduto(string $nome, string $accent, string $light): string
    {
        $nomeLower = Str::lower($nome);

        return match (true) {
            // ======================== ELETRÔNICOS ========================
            str_contains($nomeLower, 'fone de ouvido') => $this->svgHeadphone($accent, $light),
            str_contains($nomeLower, 'smartwatch')     => $this->svgSmartwatch($accent, $light),
            str_contains($nomeLower, 'caixa de som')   => $this->svgSpeaker($accent, $light),
            str_contains($nomeLower, 'carregador')      => $this->svgPowerbank($accent, $light),
            str_contains($nomeLower, 'mouse')           => $this->svgMouse($accent, $light),
            str_contains($nomeLower, 'teclado')         => $this->svgKeyboard($accent, $light),

            // ======================== MODA MASCULINA ========================
            str_contains($nomeLower, 'camiseta')        => $this->svgTshirt($accent, $light),
            str_contains($nomeLower, 'calça')           => $this->svgJeans($accent, $light),
            str_contains($nomeLower, 'jaqueta')         => $this->svgJacket($accent, $light),
            str_contains($nomeLower, 'tênis')           => $this->svgSneaker($accent, $light),
            str_contains($nomeLower, 'bermuda')         => $this->svgShorts($accent, $light),

            // ======================== MODA FEMININA ========================
            str_contains($nomeLower, 'vestido')         => $this->svgDress($accent, $light),
            str_contains($nomeLower, 'blusa')           => $this->svgSweater($accent, $light),
            str_contains($nomeLower, 'legging')         => $this->svgLeggings($accent, $light),
            str_contains($nomeLower, 'bolsa')           => $this->svgBag($accent, $light),
            str_contains($nomeLower, 'sandália')        => $this->svgSandal($accent, $light),

            // ======================== CASA ========================
            str_contains($nomeLower, 'luminária')       => $this->svgLamp($accent, $light),
            str_contains($nomeLower, 'panelas')         => $this->svgCookware($accent, $light),
            str_contains($nomeLower, 'organizadores')   => $this->svgOrganizer($accent, $light),
            str_contains($nomeLower, 'difusor')         => $this->svgDiffuser($accent, $light),
            str_contains($nomeLower, 'manta')           => $this->svgBlanket($accent, $light),

            // ======================== ESPORTES ========================
            str_contains($nomeLower, 'futebol')         => $this->svgFootball($accent, $light),
            str_contains($nomeLower, 'halteres')        => $this->svgDumbbell($accent, $light),
            str_contains($nomeLower, 'bicicleta')       => $this->svgBicycle($accent, $light),
            str_contains($nomeLower, 'corda')           => $this->svgJumpRope($accent, $light),
            str_contains($nomeLower, 'yoga')            => $this->svgYogaMat($accent, $light),

            // ======================== LIVROS ========================
            str_contains($nomeLower, 'programação')     => $this->svgBooks($accent, $light, '#3b82f6'),
            str_contains($nomeLower, 'hábito')          => $this->svgBooks($accent, $light, '#ec4899'),
            str_contains($nomeLower, 'história')        => $this->svgBooks($accent, $light, '#f59e0b'),
            str_contains($nomeLower, 'contos')          => $this->svgBooks($accent, $light, '#8b5cf6'),
            str_contains($nomeLower, 'atlas')           => $this->svgBooks($accent, $light, '#10b981'),

            // ======================== BELEZA ========================
            str_contains($nomeLower, 'skincare')        => $this->svgSkincare($accent, $light),
            str_contains($nomeLower, 'perfume')         => $this->svgPerfume($accent, $light),
            str_contains($nomeLower, 'secador')         => $this->svgHairDryer($accent, $light),
            str_contains($nomeLower, 'escova')          => $this->svgHairBrush($accent, $light),
            str_contains($nomeLower, 'maquiagem')       => $this->svgMakeup($accent, $light),

            // ======================== BRINQUEDOS ========================
            str_contains($nomeLower, 'quebra-cabeça')   => $this->svgPuzzle($accent, $light),
            str_contains($nomeLower, 'tabuleiro')       => $this->svgBoardGame($accent, $light),
            str_contains($nomeLower, 'carrinho')        => $this->svgRcCar($accent, $light),
            str_contains($nomeLower, 'boneca')          => $this->svgDoll($accent, $light),
            str_contains($nomeLower, 'pelúcia')         => $this->svgTeddy($accent, $light),

            // ======================== PET ========================
            str_contains($nomeLower, 'ração')           => $this->svgDogFood($accent, $light),
            str_contains($nomeLower, 'arranhador')      => $this->svgCatTree($accent, $light),
            str_contains($nomeLower, 'cama pet')        => $this->svgPetBed($accent, $light),
            str_contains($nomeLower, 'coleira')         => $this->svgDogCollar($accent, $light),
            str_contains($nomeLower, 'mordedor')        => $this->svgDogToy($accent, $light),

            // ======================== PAPELARIA ========================
            str_contains($nomeLower, 'mochila')         => $this->svgBackpack($accent, $light),
            str_contains($nomeLower, 'caderno')         => $this->svgNotebook($accent, $light),
            str_contains($nomeLower, 'canetas')         => $this->svgPencils($accent, $light),
            str_contains($nomeLower, 'organizador')     => $this->svgDeskOrganizer($accent, $light),
            str_contains($nomeLower, 'cadeira')         => $this->svgOfficeChair($accent, $light),

            default => $this->svgDefault($accent, $light),
        };
    }

    // ========================================================================
    //  FUNÇÕES DE ILUSTRAÇÃO SVG — Cada uma desenha um produto específico
    //  usando elementos SVG básicos (rect, circle, ellipse, path, line).
    //  Todas as coordenadas são relativas ao centro (0,0) da viewBox 800×800.
    // ========================================================================

    private function svgHeadphone(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Arco headphone -->
      <path d="M-110,-80 Q0,-180 110,-80" fill="none" stroke="{$accent}" stroke-width="18" stroke-linecap="round"/>
      <!-- Fone esquerdo -->
      <ellipse cx="-110" cy="-20" rx="50" ry="65" fill="{$light}" opacity="0.9"/>
      <ellipse cx="-110" cy="-20" rx="65" ry="80" fill="none" stroke="{$accent}" stroke-width="4"/>
      <ellipse cx="-110" cy="-20" rx="35" ry="48" fill="none" stroke="{$light}" stroke-width="2" opacity="0.4"/>
      <!-- Fone direito -->
      <ellipse cx="110" cy="-20" rx="50" ry="65" fill="{$light}" opacity="0.9"/>
      <ellipse cx="110" cy="-20" rx="65" ry="80" fill="none" stroke="{$accent}" stroke-width="4"/>
      <ellipse cx="110" cy="-20" rx="35" ry="48" fill="none" stroke="{$light}" stroke-width="2" opacity="0.4"/>
      <!-- Almofadas -->
      <ellipse cx="-110" cy="-20" rx="42" ry="55" fill="{$accent}" opacity="0.15"/>
      <ellipse cx="110" cy="-20" rx="42" ry="55" fill="{$accent}" opacity="0.15"/>
SVG;
    }

    private function svgSmartwatch(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Pulseira parte superior -->
      <rect x="-40" y="-200" width="80" height="100" rx="12" fill="{$light}" opacity="0.7"/>
      <rect x="-34" y="-200" width="68" height="100" rx="8" fill="none" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
      <line x1="-20" y1="-175" x2="20" y2="-175" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
      <line x1="-20" y1="-160" x2="20" y2="-160" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
      <line x1="-20" y1="-145" x2="20" y2="-145" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
      <!-- Pulseira parte inferior -->
      <rect x="-40" y="100" width="80" height="100" rx="12" fill="{$light}" opacity="0.7"/>
      <rect x="-34" y="100" width="68" height="100" rx="8" fill="none" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
      <!-- Corpo (caixa do relógio) -->
      <rect x="-65" y="-100" width="130" height="200" rx="32" fill="{$accent}"/>
      <rect x="-55" y="-90" width="110" height="180" rx="28" fill="{$light}" opacity="0.15"/>
      <!-- Tela -->
      <rect x="-52" y="-85" width="104" height="170" rx="24" fill="#0a0a1a" opacity="0.8"/>
      <rect x="-52" y="-85" width="104" height="170" rx="24" fill="none" stroke="{$accent}" stroke-width="1.5" opacity="0.3"/>
      <!-- Conteúdo da tela -->
      <circle cx="0" cy="-40" r="8" fill="{$accent}" opacity="0.6"/>
      <rect x="-28" y="-15" width="56" height="4" rx="2" fill="{$light}" opacity="0.5"/>
      <rect x="-35" y="0" width="70" height="3" rx="1.5" fill="{$light}" opacity="0.3"/>
      <rect x="-25" y="10" width="50" height="3" rx="1.5" fill="{$light}" opacity="0.3"/>
      <rect x="-30" y="20" width="60" height="3" rx="1.5" fill="{$light}" opacity="0.3"/>
      <!-- Coroa -->
      <rect x="52" y="-15" width="20" height="30" rx="6" fill="{$accent}" opacity="0.7"/>
      <rect x="52" y="-10" width="20" height="20" rx="4" fill="none" stroke="{$light}" stroke-width="1" opacity="0.3"/>
      <!-- Botão -->
      <ellipse cx="52" cy="35" rx="5" ry="8" fill="{$accent}" opacity="0.5"/>
SVG;
    }

    private function svgSpeaker(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo principal -->
      <rect x="-90" y="-170" width="180" height="340" rx="40" fill="{$accent}"/>
      <rect x="-78" y="-158" width="156" height="316" rx="34" fill="{$light}" opacity="0.08"/>
      <!-- Gradiente -->
      <rect x="-70" y="-140" width="140" height="140" rx="70" fill="{$light}" opacity="0.12"/>
      <!-- Alto-falante principal -->
      <circle cx="0" cy="-60" r="65" fill="none" stroke="{$light}" stroke-width="2.5" opacity="0.5"/>
      <circle cx="0" cy="-60" r="55" fill="none" stroke="{$light}" stroke-width="2" opacity="0.4"/>
      <circle cx="0" cy="-60" r="45" fill="none" stroke="{$light}" stroke-width="2" opacity="0.3"/>
      <circle cx="0" cy="-60" r="35" fill="none" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <circle cx="0" cy="-60" r="25" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <circle cx="0" cy="-60" r="8" fill="{$light}" opacity="0.3"/>
      <!-- Alto-falante secundário -->
      <circle cx="0" cy="80" r="35" fill="none" stroke="{$light}" stroke-width="2" opacity="0.4"/>
      <circle cx="0" cy="80" r="25" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.3"/>
      <circle cx="0" cy="80" r="15" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.2"/>
      <circle cx="0" cy="80" r="5" fill="{$light}" opacity="0.25"/>
      <!-- LEDs indicadores -->
      <circle cx="-15" cy="135" r="4" fill="{$accent}" opacity="0.6"/>
      <circle cx="0" cy="135" r="4" fill="{$accent}" opacity="0.3"/>
      <circle cx="15" cy="135" r="4" fill="{$accent}" opacity="0.6"/>
      <!-- Pé -->
      <rect x="-50" y="160" width="100" height="8" rx="4" fill="{$light}" opacity="0.2"/>
SVG;
    }

    private function svgPowerbank(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo -->
      <rect x="-65" y="-130" width="130" height="260" rx="30" fill="{$accent}"/>
      <rect x="-55" y="-120" width="110" height="240" rx="24" fill="{$light}" opacity="0.1"/>
      <!-- Borda -->
      <rect x="-65" y="-130" width="130" height="260" rx="30" fill="none" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <!-- Indicador de bateria (4 barras) -->
      <rect x="-20" y="-100" width="8" height="20" rx="3" fill="{$light}" opacity="0.9"/>
      <rect x="-6" y="-100" width="8" height="20" rx="3" fill="{$light}" opacity="0.9"/>
      <rect x="8" y="-100" width="8" height="20" rx="3" fill="{$light}" opacity="0.9"/>
      <rect x="22" y="-100" width="8" height="20" rx="3" fill="{$light}" opacity="0.4"/>
      <!-- Porta USB (entrada) -->
      <rect x="-20" y="-60" width="40" height="12" rx="3" fill="#0a0a1a" opacity="0.5"/>
      <rect x="-8" y="-58" width="16" height="8" rx="2" fill="{$light}" opacity="0.3"/>
      <!-- Porta USB (saída) -->
      <rect x="-20" y="48" width="40" height="12" rx="3" fill="#0a0a1a" opacity="0.5"/>
      <rect x="-8" y="50" width="16" height="8" rx="2" fill="{$light}" opacity="0.3"/>
      <!-- LED indicador -->
      <circle cx="0" cy="95" r="4" fill="#22c55e" opacity="0.7"/>
SVG;
    }

    private function svgMouse(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo do mouse -->
      <path d="M-45,-120 Q-60,-60 -55,20 Q-50,100 -30,130 Q-10,155 0,155 Q10,155 30,130 Q50,100 55,20 Q60,-60 45,-120 Q25,-140 0,-140 Q-25,-140 -45,-120Z" fill="{$accent}"/>
      <path d="M-35,-115 Q-48,-60 -44,20 Q-40,90 -24,120 Q-8,142 0,142 Q8,142 24,120 Q40,90 44,20 Q48,-60 35,-115 Q20,-132 0,-132 Q-20,-132 -35,-115Z" fill="{$light}" opacity="0.08"/>
      <!-- Scroll wheel -->
      <rect x="-10" y="-60" width="20" height="40" rx="10" fill="{$light}" opacity="0.5"/>
      <rect x="-8" y="-55" width="16" height="30" rx="8" fill="{$light}" opacity="0.2"/>
      <!-- Linha divisória (botões) -->
      <line x1="0" y1="-140" x2="0" y2="-25" stroke="{$light}" stroke-width="1" opacity="0.2"/>
      <!-- Base -->
      <ellipse cx="0" cy="140" rx="35" ry="10" fill="{$light}" opacity="0.15"/>
      <!-- Cabo -->
      <path d="M0,-140 Q0,-180 -20,-200" fill="none" stroke="{$accent}" stroke-width="5" stroke-linecap="round" opacity="0.5"/>
SVG;
    }

    private function svgKeyboard(string $accent, string $light): string
    {
        $keys = '';
        $rows = [
            [-120, -30, 240, 18, 10],  // bottom row
            [-120, -5, 240, 18, 10],
            [-120, 20, 240, 18, 10],
            [-120, 45, 240, 18, 10],
            [-120, 70, 240, 18, 10],
        ];
        foreach ($rows as $r) {
            $x = $r[0];
            $y = $r[1];
            $w = $r[2];
            $h = $r[3];
            $cols = $r[4];
            $colW = $w / $cols;
            for ($c = 0; $c < $cols; $c++) {
                $keys .= "<rect x=\"" . ($x + $c * $colW + 2) . "\" y=\"{$y}\" width=\"" . ($colW - 4) . "\" height=\"{$h}\" rx=\"3\" fill=\"{$light}\" opacity=\"" . (0.15 + ($c % 3) * 0.08) . "\"/>\n";
            }
        }
        return <<<SVG
      <!-- Base -->
      <rect x="-145" y="-100" width="290" height="200" rx="16" fill="{$accent}"/>
      <rect x="-140" y="-96" width="280" height="192" rx="14" fill="{$light}" opacity="0.06"/>
      <!-- Teclas -->
      {$keys}
      <!-- Trackpad / espaço -->
      <rect x="-80" y="60" width="90" height="22" rx="4" fill="{$light}" opacity="0.2"/>
      <rect x="40" y="60" width="30" height="22" rx="4" fill="{$light}" opacity="0.15"/>
SVG;
    }

    // ======================== MODA MASCULINA ========================

    private function svgTshirt(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Camiseta - corpo -->
      <path d="M-80,-160 L-100,-80 L-90,-50 L-70,-60 L-70,160 L70,160 L70,-60 L90,-50 L100,-80 L80,-160 Z" fill="{$accent}"/>
      <path d="M-75,-155 L-94,-82 L-86,-56 L-66,-66 L-66,155 L66,155 L66,-66 L86,-56 L94,-82 L75,-155 Z" fill="{$light}" opacity="0.06"/>
      <!-- Decote -->
      <path d="M-35,-160 Q0,-175 35,-160" fill="none" stroke="{$light}" stroke-width="2.5" opacity="0.3"/>
      <!-- Gola -->
      <path d="M-30,-160 Q0,-172 30,-160" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.2"/>
      <!-- Vinco central -->
      <line x1="0" y1="-60" x2="0" y2="155" stroke="{$light}" stroke-width="1" opacity="0.08"/>
      <!-- Barra inferior -->
      <rect x="-68" y="150" width="136" height="8" rx="3" fill="{$light}" opacity="0.12"/>
SVG;
    }

    private function svgJeans(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Calça - perna esquerda -->
      <path d="M-80,-160 L-85,0 L-90,140 L-30,140 L-30,0 L-20,-160 Z" fill="{$accent}"/>
      <path d="M-78,-155 L-83,0 L-88,135 L-32,135 L-32,0 L-22,-155 Z" fill="{$light}" opacity="0.05"/>
      <!-- Calça - perna direita -->
      <path d="M20,-160 L30,0 L30,140 L90,140 L85,0 L80,-160 Z" fill="{$accent}"/>
      <path d="M22,-155 L32,0 L32,135 L88,135 L83,0 L78,-155 Z" fill="{$light}" opacity="0.05"/>
      <!-- Cintura -->
      <rect x="-85" y="-165" width="170" height="25" rx="5" fill="{$light}" opacity="0.15"/>
      <rect x="-85" y="-165" width="170" height="5" rx="2" fill="{$light}" opacity="0.2"/>
      <!-- Bolsos -->
      <path d="M-75,-130 Q-60,-135 -50,-125" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.2"/>
      <path d="M75,-130 Q60,-135 50,-125" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.2"/>
      <!-- Braguilha -->
      <line x1="0" y1="-140" x2="0" y2="-80" stroke="{$light}" stroke-width="1" opacity="0.15"/>
      <!-- Botoes -->
      <circle cx="0" cy="-145" r="4" fill="{$light}" opacity="0.3"/>
SVG;
    }

    private function svgJacket(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Jaqueta - corpo -->
      <path d="M-90,-170 L-110,-80 L-100,-40 L-75,-50 L-75,160 L75,160 L75,-50 L100,-40 L110,-80 L90,-170 Z" fill="{$accent}"/>
      <path d="M-85,-165 L-104,-80 L-96,-44 L-71,-54 L-71,155 L71,155 L71,-54 L96,-44 L104,-80 L85,-165 Z" fill="{$light}" opacity="0.05"/>
      <!-- Gola/Lapela -->
      <path d="M-40,-170 L-60,-130 L-30,-140 Z" fill="{$light}" opacity="0.15"/>
      <path d="M40,-170 L60,-130 L30,-140 Z" fill="{$light}" opacity="0.15"/>
      <!-- Zíper -->
      <line x1="0" y1="-140" x2="0" y2="155" stroke="{$light}" stroke-width="1.5" opacity="0.25"/>
      <!-- Bolsos -->
      <rect x="-65" y="40" width="35" height="5" rx="2" fill="{$light}" opacity="0.2"/>
      <rect x="30" y="40" width="35" height="5" rx="2" fill="{$light}" opacity="0.2"/>
      <!-- Ombreiras -->
      <path d="M-90,-170 Q-110,-150 -110,-80" fill="none" stroke="{$light}" stroke-width="2" opacity="0.1"/>
      <path d="M90,-170 Q110,-150 110,-80" fill="none" stroke="{$light}" stroke-width="2" opacity="0.1"/>
SVG;
    }

    private function svgSneaker(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Sola -->
      <path d="M-110,90 Q-120,80 -115,70 L-80,60 L100,60 Q130,60 135,80 Q140,100 120,110 L-90,110 Q-110,110 -110,90Z" fill="#1a1a1a" opacity="0.8"/>
      <!-- Sola detalhe -->
      <path d="M-105,95 Q-112,85 -108,75 L-78,66 L98,66 Q126,66 130,83 Q134,98 116,106 L-86,106 Q-104,106 -105,95Z" fill="none" stroke="{$light}" stroke-width="1" opacity="0.15"/>
      <!-- Cabedal -->
      <path d="M-80,60 L-70,-20 Q-65,-60 -40,-75 Q-15,-90 10,-85 Q40,-80 60,-50 Q80,-20 100,60 Z" fill="{$accent}"/>
      <path d="M-75,55 L-66,-18 Q-61,-55 -38,-70 Q-14,-84 9,-80 Q37,-76 56,-47 Q75,-19 94,55 Z" fill="{$light}" opacity="0.06"/>
      <!-- Swoosh/franja -->
      <path d="M20,-40 Q50,-30 75,-15 Q90,-5 95,10" fill="none" stroke="{$light}" stroke-width="3" stroke-linecap="round" opacity="0.4"/>
      <path d="M20,-40 Q50,-30 75,-15 Q90,-5 95,10" fill="none" stroke="{$light}" stroke-width="2" stroke-linecap="round" opacity="0.2"/>
      <!-- Cadarço -->
      <line x1="-40" y1="-30" x2="-20" y2="-25" stroke="{$light}" stroke-width="2" opacity="0.4"/>
      <line x1="-25" y1="-45" x2="-5" y2="-40" stroke="{$light}" stroke-width="2" opacity="0.3"/>
      <line x1="-10" y1="-55" x2="10" y2="-50" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <!-- Calcanhar -->
      <path d="M-75,30 Q-85,10 -75,-20" fill="none" stroke="{$light}" stroke-width="2" opacity="0.15"/>
      <!-- Bico -->
      <path d="M85,50 Q100,50 100,60" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
SVG;
    }

    private function svgShorts(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Shorts - corpo -->
      <path d="M-90,-140 L-100,0 L-95,60 L-30,80 L-20,0 L-15,-140 Z" fill="{$accent}"/>
      <path d="M15,-140 L20,0 L30,80 L95,60 L100,0 L90,-140 Z" fill="{$accent}"/>
      <!-- Detalhes -->
      <path d="M-85,-135 L-94,0 L-90,55 L-32,74 L-22,0 L-17,-135 Z" fill="{$light}" opacity="0.04"/>
      <path d="M17,-135 L22,0 L32,74 L90,55 L94,0 L85,-135 Z" fill="{$light}" opacity="0.04"/>
      <!-- Cintura -->
      <rect x="-95" y="-145" width="190" height="20" rx="5" fill="{$light}" opacity="0.15"/>
      <rect x="-95" y="-145" width="190" height="4" rx="2" fill="{$light}" opacity="0.2"/>
      <!-- Cós -->
      <line x1="-60" y1="-125" x2="-60" y2="-145" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <line x1="60" y1="-125" x2="60" y2="-145" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <!-- Bolsos -->
      <path d="M-80,-90 Q-65,-100 -50,-90" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.2"/>
      <path d="M80,-90 Q65,-100 50,-90" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.2"/>
      <!-- Barra das pernas -->
      <line x1="-30" y1="78" x2="-93" y2="58" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <line x1="30" y1="78" x2="93" y2="58" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
SVG;
    }

    // ======================== MODA FEMININA ========================

    private function svgDress(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Vestido - corpo -->
      <path d="M-50,-170 Q-60,-140 -55,-110 L-80,-40 Q-100,30 -120,120 Q-130,170 -110,170 L110,170 Q130,170 120,120 Q100,30 80,-40 L55,-110 Q60,-140 50,-170 Z" fill="{$accent}"/>
      <path d="M-45,-165 Q-55,-138 -50,-108 L-75,-38 Q-94,30 -114,118 Q-123,165 -106,165 L106,165 Q123,165 114,118 Q94,30 75,-38 L50,-108 Q55,-138 45,-165 Z" fill="{$light}" opacity="0.05"/>
      <!-- Decote -->
      <path d="M-40,-170 Q0,-185 40,-170" fill="none" stroke="{$light}" stroke-width="2.5" opacity="0.35"/>
      <!-- Cintura marcada -->
      <path d="M-65,-30 Q0,-20 65,-30" fill="none" stroke="{$light}" stroke-width="2" opacity="0.15"/>
      <!-- Detalhe floral -->
      <circle cx="-30" cy="20" r="6" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.2"/>
      <circle cx="30" cy="40" r="6" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <circle cx="-20" cy="70" r="4" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <!-- Barra inferior -->
      <path d="M-110,165 Q0,175 110,165" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.12"/>
SVG;
    }

    private function svgSweater(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Blusa - corpo -->
      <path d="M-85,-150 L-100,-70 L-90,-40 L-70,-50 L-70,150 L70,150 L70,-50 L90,-40 L100,-70 L85,-150 Z" fill="{$accent}"/>
      <path d="M-80,-145 L-94,-70 L-86,-44 L-66,-54 L-66,145 L66,145 L66,-54 L86,-44 L94,-70 L80,-145 Z" fill="{$light}" opacity="0.05"/>
      <!-- Gola rolê -->
      <path d="M-35,-150 Q0,-168 35,-150 L30,-140 Q0,-155 -30,-140 Z" fill="{$light}" opacity="0.25"/>
      <path d="M-30,-148 Q0,-162 30,-148" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <!-- Trança (textura de tricô) -->
      <path d="M-40,-80 Q-30,-90 -20,-80 Q-10,-70 0,-80 Q10,-90 20,-80 Q30,-70 40,-80" fill="none" stroke="{$light}" stroke-width="2" opacity="0.12"/>
      <path d="M-40,-60 Q-30,-70 -20,-60 Q-10,-50 0,-60 Q10,-70 20,-60 Q30,-50 40,-60" fill="none" stroke="{$light}" stroke-width="2" opacity="0.10"/>
      <path d="M-40,-40 Q-30,-50 -20,-40 Q-10,-30 0,-40 Q10,-50 20,-40 Q30,-30 40,-40" fill="none" stroke="{$light}" stroke-width="2" opacity="0.08"/>
      <!-- Costura inferior -->
      <rect x="-68" y="142" width="136" height="6" rx="3" fill="{$light}" opacity="0.1"/>
      <!-- Ombro detalhe -->
      <path d="M-85,-150 Q-95,-120 -95,-90" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.08"/>
      <path d="M85,-150 Q95,-120 95,-90" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.08"/>
SVG;
    }

    private function svgLeggings(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Legging perna esquerda -->
      <path d="M-75,-160 L-80,-40 L-85,110 L-30,110 L-25,-40 L-20,-160 Z" fill="{$accent}"/>
      <path d="M-72,-155 L-77,-40 L-82,105 L-33,105 L-28,-40 L-23,-155 Z" fill="{$light}" opacity="0.04"/>
      <!-- Legging perna direita -->
      <path d="M20,-160 L25,-40 L30,110 L85,110 L80,-40 L75,-160 Z" fill="{$accent}"/>
      <path d="M23,-155 L28,-40 L33,105 L82,105 L77,-40 L72,-155 Z" fill="{$light}" opacity="0.04"/>
      <!-- Cintura alta -->
      <rect x="-82" y="-165" width="164" height="30" rx="6" fill="{$light}" opacity="0.15"/>
      <rect x="-82" y="-165" width="164" height="6" rx="3" fill="{$light}" opacity="0.2"/>
      <!-- Costuras laterais -->
      <line x1="-75" y1="-130" x2="-85" y2="105" stroke="{$light}" stroke-width="1" opacity="0.1"/>
      <line x1="75" y1="-130" x2="85" y2="105" stroke="{$light}" stroke-width="1" opacity="0.1"/>
      <!-- Elástico -->
      <rect x="-30" y="-135" width="60" height="2" rx="1" fill="{$light}" opacity="0.15"/>
      <rect x="-30" y="80" width="60" height="2" rx="1" fill="{$light}" opacity="0.15"/>
SVG;
    }

    private function svgBag(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo da bolsa -->
      <path d="M-100,-80 Q-120,-60 -115,30 L-110,130 Q-105,160 -80,160 L80,160 Q105,160 110,130 L115,30 Q120,-60 100,-80 Z" fill="{$accent}"/>
      <path d="M-95,-75 Q-114,-57 -109,30 L-104,127 Q-100,155 -78,155 L78,155 Q100,155 104,127 L109,30 Q114,-57 95,-75 Z" fill="{$light}" opacity="0.05"/>
      <!-- Tampa / aba -->
      <path d="M-95,-80 Q0,-110 95,-80 L80,-40 Q0,-70 -80,-40 Z" fill="{$light}" opacity="0.12"/>
      <!-- Fecho -->
      <rect x="-15" y="-55" width="30" height="10" rx="4" fill="{$accent}" stroke="{$light}" stroke-width="1.5" opacity="0.4"/>
      <circle cx="0" cy="-50" r="3" fill="{$light}" opacity="0.6"/>
      <!-- Alça -->
      <path d="M-70,-85 Q-65,-160 0,-170 Q65,-160 70,-85" fill="none" stroke="{$accent}" stroke-width="10" stroke-linecap="round" opacity="0.7"/>
      <path d="M-70,-85 Q-65,-160 0,-170 Q65,-160 70,-85" fill="none" stroke="{$light}" stroke-width="3" stroke-linecap="round" opacity="0.2"/>
      <!-- Costuras -->
      <path d="M-90,0 Q0,20 90,0" fill="none" stroke="{$light}" stroke-width="1" opacity="0.08"/>
      <path d="M-85,60 Q0,80 85,60" fill="none" stroke="{$light}" stroke-width="1" opacity="0.08"/>
SVG;
    }

    private function svgSandal(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Sola -->
      <path d="M-100,80 Q-120,60 -115,30 Q-110,0 -100,-10 L100,-10 Q110,0 115,30 Q120,60 100,80 Z" fill="#1a1a1a" opacity="0.7"/>
      <path d="M-95,75 Q-113,56 -109,28 Q-104,2 -96,-6 L96,-6 Q104,2 109,28 Q113,56 95,75 Z" fill="none" stroke="{$light}" stroke-width="1" opacity="0.1"/>
      <!-- Palmilha -->
      <path d="M-98,70 Q-116,52 -112,26 Q-108,4 -98,-2 L98,-2 Q108,4 112,26 Q116,52 98,70 Z" fill="{$accent}" opacity="0.6"/>
      <!-- Tira principal -->
      <path d="M-40,-2 Q-30,-60 0,-70 Q30,-60 40,-2" fill="none" stroke="{$accent}" stroke-width="12" stroke-linecap="round"/>
      <path d="M-40,-2 Q-30,-60 0,-70 Q30,-60 40,-2" fill="none" stroke="{$light}" stroke-width="4" stroke-linecap="round" opacity="0.2"/>
      <!-- Tira lateral -->
      <path d="M-70,20 Q-65,-20 -50,-30" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round" opacity="0.7"/>
      <path d="M70,20 Q65,-20 50,-30" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round" opacity="0.7"/>
      <!-- Fivela -->
      <rect x="-15" y="-35" width="30" height="10" rx="3" fill="{$accent}" stroke="{$light}" stroke-width="1" opacity="0.4"/>
      <line x1="0" y1="-35" x2="0" y2="-25" stroke="{$light}" stroke-width="1.5" opacity="0.4"/>
SVG;
    }

    // ======================== CASA ========================

    private function svgLamp(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Base -->
      <ellipse cx="0" cy="165" rx="45" ry="10" fill="{$accent}"/>
      <ellipse cx="0" cy="163" rx="42" ry="8" fill="{$light}" opacity="0.1"/>
      <!-- Haste -->
      <rect x="-6" y="-80" width="12" height="245" rx="4" fill="{$light}" opacity="0.3"/>
      <rect x="-4" y="-80" width="8" height="245" rx="3" fill="{$light}" opacity="0.15"/>
      <!-- Cúpula externa -->
      <path d="M-120,-80 Q-130,-130 -100,-170 Q-60,-200 0,-200 Q60,-200 100,-170 Q130,-130 120,-80 Z" fill="{$accent}"/>
      <path d="M-115,-80 Q-124,-127 -96,-165 Q-58,-193 0,-193 Q58,-193 96,-165 Q124,-127 115,-80 Z" fill="{$light}" opacity="0.05"/>
      <!-- Interior da cúpula (luz) -->
      <path d="M-90,-80 Q0,-70 90,-80 Q70,-160 0,-175 Q-70,-160 -90,-80 Z" fill="#fef3c7" opacity="0.15"/>
      <path d="M-80,-80 Q0,-72 80,-80 Q60,-148 0,-160 Q-60,-148 -80,-80 Z" fill="#fef3c7" opacity="0.08"/>
      <!-- Lâmpada -->
      <ellipse cx="0" cy="-75" rx="18" ry="10" fill="#fef3c7" opacity="0.5"/>
      <ellipse cx="0" cy="-75" rx="10" ry="6" fill="#fef3c7" opacity="0.3"/>
      <!-- Detalhe da base -->
      <ellipse cx="0" cy="158" rx="15" ry="4" fill="{$accent}" opacity="0.5"/>
SVG;
    }

    private function svgCookware(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Tampa -->
      <ellipse cx="0" cy="-105" rx="120" ry="15" fill="{$accent}"/>
      <ellipse cx="0" cy="-107" rx="115" ry="12" fill="{$light}" opacity="0.08"/>
      <!-- Pegador da tampa -->
      <rect x="-8" y="-135" width="16" height="30" rx="6" fill="{$accent}" opacity="0.8"/>
      <rect x="-6" y="-133" width="12" height="26" rx="4" fill="{$light}" opacity="0.15"/>
      <!-- Corpo da panela -->
      <rect x="-120" y="-105" width="240" height="160" rx="20" fill="{$accent}"/>
      <rect x="-115" y="-100" width="230" height="152" rx="16" fill="{$light}" opacity="0.05"/>
      <!-- Alça esquerda -->
      <path d="M-120,-60 Q-160,-60 -155,-30 Q-150,-10 -120,-10" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <path d="M-120,-60 Q-160,-60 -155,-30 Q-150,-10 -120,-10" fill="none" stroke="{$light}" stroke-width="2" stroke-linecap="round" opacity="0.2"/>
      <!-- Alça direita -->
      <path d="M120,-60 Q160,-60 155,-30 Q150,-10 120,-10" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <path d="M120,-60 Q160,-60 155,-30 Q150,-10 120,-10" fill="none" stroke="{$light}" stroke-width="2" stroke-linecap="round" opacity="0.2"/>
      <!-- Conteúdo (líquido) -->
      <rect x="-110" y="-60" width="220" height="110" rx="10" fill="{$accent}" opacity="0.2"/>
      <!-- Divisória de panelas (2) -->
      <rect x="-115" y="30" width="110" height="22" rx="6" fill="{$accent}" opacity="0.3"/>
      <rect x="5" y="30" width="110" height="22" rx="6" fill="{$accent}" opacity="0.3"/>
      <!-- Fundo -->
      <rect x="-100" y="50" width="200" height="5" rx="2" fill="{$accent}" opacity="0.3"/>
SVG;
    }

    private function svgOrganizer(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Gaveta 1 -->
      <rect x="-130" y="-120" width="260" height="70" rx="8" fill="{$accent}"/>
      <rect x="-125" y="-115" width="250" height="60" rx="6" fill="{$light}" opacity="0.06"/>
      <!-- Puxador 1 -->
      <rect x="-20" y="-90" width="40" height="6" rx="3" fill="{$light}" opacity="0.3"/>
      <!-- Divisórias da gaveta 1 -->
      <rect x="-80" y="-115" width="3" height="60" fill="{$light}" opacity="0.1"/>
      <rect x="-30" y="-115" width="3" height="60" fill="{$light}" opacity="0.1"/>
      <rect x="20" y="-115" width="3" height="60" fill="{$light}" opacity="0.1"/>
      <rect x="70" y="-115" width="3" height="60" fill="{$light}" opacity="0.1"/>
      <!-- Gaveta 2 -->
      <rect x="-130" y="-40" width="260" height="70" rx="8" fill="{$accent}" opacity="0.85"/>
      <rect x="-125" y="-35" width="250" height="60" rx="6" fill="{$light}" opacity="0.04"/>
      <!-- Puxador 2 -->
      <rect x="-20" y="-10" width="40" height="6" rx="3" fill="{$light}" opacity="0.25"/>
      <!-- Gaveta 3 -->
      <rect x="-130" y="40" width="260" height="70" rx="8" fill="{$accent}" opacity="0.7"/>
      <rect x="-125" y="45" width="250" height="60" rx="6" fill="{$light}" opacity="0.04"/>
      <!-- Puxador 3 -->
      <rect x="-20" y="70" width="40" height="6" rx="3" fill="{$light}" opacity="0.2"/>
      <!-- Estrutura externa -->
      <rect x="-135" y="-130" width="270" height="250" rx="12" fill="none" stroke="{$accent}" stroke-width="3" opacity="0.3"/>
SVG;
    }

    private function svgDiffuser(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo (frasco) -->
      <path d="M-60,-140 Q-80,-120 -75,-20 L-70,100 Q-65,140 -40,150 L40,150 Q65,140 70,100 L75,-20 Q80,-120 60,-140 Z" fill="{$accent}"/>
      <path d="M-55,-135 Q-74,-117 -69,-18 L-64,97 Q-60,133 -38,143 L38,143 Q60,133 64,97 L69,-18 Q74,-117 55,-135 Z" fill="{$light}" opacity="0.05"/>
      <!-- Conteúdo (líquido) -->
      <path d="M-68,10 Q-60,40 -55,100 Q-50,135 -35,143 L35,143 Q50,135 55,100 Q60,40 68,10 Z" fill="{$accent}" opacity="0.25"/>
      <!-- Gargalo -->
      <rect x="-25" y="-155" width="50" height="20" rx="6" fill="{$accent}" opacity="0.8"/>
      <rect x="-22" y="-152" width="44" height="14" rx="4" fill="{$light}" opacity="0.1"/>
      <!-- Vapor -->
      <path d="M-15,-160 Q-20,-185 -10,-200 Q0,-215 10,-200 Q20,-185 15,-160" fill="none" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <path d="M10,-158 Q5,-180 12,-195 Q20,-208 28,-195 Q35,-180 30,-158" fill="none" stroke="{$light}" stroke-width="2" opacity="0.15"/>
      <!-- Detalhe decorativo -->
      <ellipse cx="0" cy="-80" rx="40" ry="6" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <ellipse cx="0" cy="-60" rx="35" ry="5" fill="none" stroke="{$light}" stroke-width="1" opacity="0.1"/>
      <!-- Base -->
      <rect x="-45" y="148" width="90" height="6" rx="3" fill="{$accent}" opacity="0.5"/>
      <!-- LED -->
      <circle cx="0" cy="40" r="3" fill="#22c55e" opacity="0.4"/>
SVG;
    }

    private function svgBlanket(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Manta dobrada -->
      <rect x="-140" y="-110" width="280" height="220" rx="16" fill="{$accent}"/>
      <rect x="-135" y="-105" width="270" height="210" rx="14" fill="{$light}" opacity="0.04"/>
      <!-- Dobra 1 -->
      <rect x="-140" y="-30" width="280" height="4" rx="2" fill="{$light}" opacity="0.12"/>
      <!-- Dobra 2 -->
      <rect x="-140" y="50" width="280" height="4" rx="2" fill="{$light}" opacity="0.08"/>
      <!-- Textura sutil -->
      <rect x="-130" y="-100" width="4" height="200" rx="2" fill="{$light}" opacity="0.04"/>
      <rect x="-100" y="-100" width="4" height="200" rx="2" fill="{$light}" opacity="0.03"/>
      <rect x="-40" y="-100" width="4" height="200" rx="2" fill="{$light}" opacity="0.03"/>
      <rect x="20" y="-100" width="4" height="200" rx="2" fill="{$light}" opacity="0.03"/>
      <rect x="80" y="-100" width="4" height="200" rx="2" fill="{$light}" opacity="0.03"/>
      <rect x="120" y="-100" width="4" height="200" rx="2" fill="{$light}" opacity="0.04"/>
      <!-- Borda -->
      <rect x="-135" y="-105" width="270" height="16" rx="8" fill="{$light}" opacity="0.08"/>
      <rect x="-135" y="89" width="270" height="16" rx="8" fill="{$light}" opacity="0.08"/>
      <!-- Etiqueta -->
      <rect x="100" y="-20" width="25" height="12" rx="2" fill="{$light}" opacity="0.15"/>
SVG;
    }

    // ======================== ESPORTES ========================

    private function svgFootball(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Bola -->
      <circle cx="0" cy="0" r="140" fill="{$accent}"/>
      <circle cx="0" cy="0" r="135" fill="{$light}" opacity="0.04"/>
      <!-- Pentágonos -->
      <path d="M0,-80 L52,-25 L32,68 L-32,68 L-52,-25 Z" fill="none" stroke="{$light}" stroke-width="3" opacity="0.4"/>
      <path d="M0,-80 L52,-25 L32,68 L-32,68 L-52,-25 Z" fill="{$light}" opacity="0.08"/>
      <!-- Hexágonos -->
      <path d="M52,-25 L100,-30 L120,20 L80,60 L32,68" fill="none" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <path d="M-52,-25 L-100,-30 L-120,20 L-80,60 L-32,68" fill="none" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <path d="M0,-80 L60,-100 L100,-30 L52,-25" fill="none" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <path d="M0,-80 L-60,-100 L-100,-30 L-52,-25" fill="none" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <!-- Brilho -->
      <ellipse cx="-40" cy="-60" rx="20" ry="10" transform="rotate(-30, -40, -60)" fill="{$light}" opacity="0.12"/>
      <!-- Sombra -->
      <ellipse cx="0" cy="145" rx="100" ry="10" fill="#000" opacity="0.15"/>
SVG;
    }

    private function svgDumbbell(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Barra -->
      <rect x="-15" y="-12" width="30" height="24" rx="4" fill="{$accent}"/>
      <rect x="-12" y="-9" width="24" height="18" rx="3" fill="{$light}" opacity="0.1"/>
      <!-- Anilha esquerda 1 -->
      <rect x="-100" y="-40" width="60" height="80" rx="12" fill="{$accent}"/>
      <rect x="-95" y="-35" width="50" height="70" rx="10" fill="{$light}" opacity="0.05"/>
      <rect x="-85" y="-32" width="30" height="64" rx="8" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <!-- Anilha esquerda 2 -->
      <rect x="-130" y="-35" width="30" height="70" rx="8" fill="{$accent}" opacity="0.85"/>
      <rect x="-127" y="-32" width="24" height="64" rx="6" fill="none" stroke="{$light}" stroke-width="1" opacity="0.12"/>
      <!-- Anilha direita 1 -->
      <rect x="40" y="-40" width="60" height="80" rx="12" fill="{$accent}"/>
      <rect x="45" y="-35" width="50" height="70" rx="10" fill="{$light}" opacity="0.05"/>
      <rect x="55" y="-32" width="30" height="64" rx="8" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <!-- Anilha direita 2 -->
      <rect x="100" y="-35" width="30" height="70" rx="8" fill="{$accent}" opacity="0.85"/>
      <rect x="103" y="-32" width="24" height="64" rx="6" fill="none" stroke="{$light}" stroke-width="1" opacity="0.12"/>
      <!-- Rosca da barra -->
      <rect x="-20" y="-20" width="8" height="40" rx="3" fill="{$light}" opacity="0.2"/>
      <rect x="12" y="-20" width="8" height="40" rx="3" fill="{$light}" opacity="0.2"/>
      <!-- Sombras -->
      <ellipse cx="0" cy="65" rx="130" ry="8" fill="#000" opacity="0.1"/>
SVG;
    }

    private function svgBicycle(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Roda traseira -->
      <circle cx="-90" cy="50" r="65" fill="none" stroke="{$accent}" stroke-width="6"/>
      <circle cx="-90" cy="50" r="60" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <circle cx="-90" cy="50" r="8" fill="{$accent}"/>
      <!-- Raios traseiros -->
      <line x1="-90" y1="-15" x2="-90" y2="115" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <line x1="-155" y1="50" x2="-25" y2="50" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <line x1="-136" y1="14" x2="-44" y2="86" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <line x1="-44" y1="14" x2="-136" y2="86" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <!-- Roda dianteira -->
      <circle cx="110" cy="50" r="65" fill="none" stroke="{$accent}" stroke-width="6"/>
      <circle cx="110" cy="50" r="60" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <circle cx="110" cy="50" r="8" fill="{$accent}"/>
      <!-- Raios dianteiros -->
      <line x1="110" y1="-15" x2="110" y2="115" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <line x1="45" y1="50" x2="175" y2="50" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <line x1="64" y1="14" x2="156" y2="86" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <line x1="156" y1="14" x2="64" y2="86" stroke="{$accent}" stroke-width="1.5" opacity="0.2"/>
      <!-- Quadro -->
      <line x1="-90" y1="50" x2="-40" y2="-80" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <line x1="-40" y1="-80" x2="60" y2="-40" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <line x1="60" y1="-40" x2="110" y2="50" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <line x1="-20" y1="10" x2="110" y2="50" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
      <!-- Selim -->
      <ellipse cx="-45" cy="-95" rx="30" ry="8" fill="{$accent}"/>
      <rect x="-8" y="-95" width="8" height="15" fill="{$accent}"/>
      <!-- Guidom -->
      <line x1="60" y1="-40" x2="75" y2="-90" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
      <line x1="65" y1="-90" x2="95" y2="-85" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
      <line x1="65" y1="-90" x2="55" y2="-100" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
      <!-- Pedivela -->
      <ellipse cx="-20" cy="10" rx="8" ry="8" fill="{$accent}"/>
      <line x1="-20" y1="10" x2="-20" y2="40" stroke="{$accent}" stroke-width="4" stroke-linecap="round"/>
      <line x1="-20" y1="10" x2="-20" y2="-20" stroke="{$accent}" stroke-width="4" stroke-linecap="round"/>
      <!-- Corrente -->
      <path d="M-20,10 Q-60,30 -90,50" fill="none" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
SVG;
    }

    private function svgJumpRope(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corda (em movimento) -->
      <path d="M-120,-60 Q-60,-160 0,-80 Q60,0 120,-60" fill="none" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
      <path d="M-120,-60 Q-60,-160 0,-80 Q60,0 120,-60" fill="none" stroke="{$light}" stroke-width="2" stroke-linecap="round" opacity="0.2"/>
      <!-- Cabo esquerdo -->
      <rect x="-145" y="-75" width="30" height="16" rx="8" fill="{$accent}" opacity="0.9"/>
      <rect x="-140" y="-72" width="22" height="10" rx="5" fill="{$light}" opacity="0.12"/>
      <!-- Cabo direito -->
      <rect x="115" y="-75" width="30" height="16" rx="8" fill="{$accent}" opacity="0.9"/>
      <rect x="118" y="-72" width="22" height="10" rx="5" fill="{$light}" opacity="0.12"/>
      <!-- Anéis de giro -->
      <circle cx="-115" cy="-67" r="6" fill="none" stroke="{$accent}" stroke-width="2" opacity="0.5"/>
      <circle cx="115" cy="-67" r="6" fill="none" stroke="{$accent}" stroke-width="2" opacity="0.5"/>
      <!-- Sombra -->
      <ellipse cx="0" cy="130" rx="80" ry="8" fill="#000" opacity="0.1"/>
SVG;
    }

    private function svgYogaMat(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Tapete enrolado - corpo -->
      <rect x="-140" y="-90" width="280" height="180" rx="20" fill="{$accent}"/>
      <rect x="-135" y="-85" width="270" height="170" rx="16" fill="{$light}" opacity="0.04"/>
      <!-- Curvas do enrolamento -->
      <rect x="-140" y="-90" width="40" height="180" rx="20" fill="{$light}" opacity="0.12"/>
      <rect x="-130" y="-80" width="20" height="160" rx="10" fill="{$light}" opacity="0.08"/>
      <!-- Círculo central do enrolamento -->
      <ellipse cx="-120" cy="0" rx="12" ry="70" fill="{$accent}" opacity="0.5"/>
      <ellipse cx="-120" cy="0" rx="8" ry="62" fill="{$light}" opacity="0.06"/>
      <!-- Textura do tapete -->
      <rect x="-100" y="-80" width="230" height="160" rx="8" fill="none" stroke="{$light}" stroke-width="1" opacity="0.04"/>
      <rect x="-90" y="-70" width="210" height="140" rx="6" fill="none" stroke="{$light}" stroke-width="0.5" opacity="0.03"/>
      <!-- Detalhe de ponta solta -->
      <path d="M135,-70 Q150,-70 148,-30 Q146,10 148,50 Q150,80 135,75" fill="none" stroke="{$accent}" stroke-width="4" stroke-linecap="round" opacity="0.5"/>
      <!-- Pulseira -->
      <rect x="-100" y="-105" width="50" height="18" rx="5" fill="{$light}" opacity="0.15"/>
      <rect x="-95" y="-103" width="40" height="14" rx="3" fill="{$accent}" opacity="0.3"/>
SVG;
    }

    // ======================== LIVROS ========================

    private function svgBooks(string $accent, string $light, string $bookColor): string
    {
        $altLombadas = [
            '#3b82f6', '#a855f7', '#22c55e', '#f59e0b',
        ];
        $col1 = $altLombadas[array_rand($altLombadas)];
        $col2 = $altLombadas[array_rand($altLombadas)];

        return <<<SVG
      <!-- Livro 1 (base) -->
      <rect x="-120" y="-40" width="240" height="80" rx="4" fill="{$accent}" opacity="0.9"/>
      <rect x="-115" y="-35" width="230" height="70" rx="3" fill="{$bookColor}" opacity="0.5"/>
      <rect x="-110" y="-30" width="220" height="60" rx="2" fill="{$light}" opacity="0.04"/>
      <!-- Lombada 1 -->
      <rect x="-120" y="-40" width="20" height="80" rx="4" fill="{$accent}"/>
      <rect x="-118" y="-35" width="6" height="70" rx="2" fill="{$light}" opacity="0.15"/>
      <!-- Páginas 1 -->
      <rect x="-100" y="-35" width="4" height="70" rx="1" fill="#f8fafc" opacity="0.08"/>
      <!-- Livro 2 (meio) -->
      <rect x="-100" y="-90" width="200" height="60" rx="4" fill="{$accent}" opacity="0.85"/>
      <rect x="-96" y="-86" width="192" height="52" rx="3" fill="{$col1}" opacity="0.5"/>
      <rect x="-92" y="-82" width="184" height="44" rx="2" fill="{$light}" opacity="0.04"/>
      <!-- Lombada 2 -->
      <rect x="-100" y="-90" width="18" height="60" rx="4" fill="{$accent}" opacity="0.9"/>
      <rect x="-98" y="-86" width="5" height="52" rx="2" fill="{$light}" opacity="0.12"/>
      <!-- Livro 3 (topo) -->
      <rect x="-80" y="-135" width="160" height="50" rx="4" fill="{$accent}" opacity="0.8"/>
      <rect x="-76" y="-131" width="152" height="42" rx="3" fill="{$col2}" opacity="0.5"/>
      <rect x="-72" y="-127" width="144" height="34" rx="2" fill="{$light}" opacity="0.04"/>
      <!-- Lombada 3 -->
      <rect x="-80" y="-135" width="16" height="50" rx="4" fill="{$accent}" opacity="0.85"/>
      <rect x="-78" y="-131" width="4" height="42" rx="2" fill="{$light}" opacity="0.12"/>
      <!-- Títulos (linhas finas) -->
      <rect x="-85" y="-20" width="130" height="3" rx="1.5" fill="{$light}" opacity="0.15"/>
      <rect x="-80" y="-70" width="110" height="3" rx="1.5" fill="{$light}" opacity="0.12"/>
      <rect x="-60" y="-115" width="90" height="3" rx="1.5" fill="{$light}" opacity="0.1"/>
SVG;
    }

    // ======================== BELEZA ========================

    private function svgSkincare(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Frasco 1 (sérum) -->
      <path d="M-100,-90 Q-110,-60 -105,40 L-100,130 Q-95,150 -75,150 L-25,150 Q-5,150 0,130 L5,40 Q10,-60 0,-90 Z" fill="{$accent}"/>
      <path d="M-95,-85 Q-104,-58 -100,38 L-95,127 Q-91,145 -73,145 L-27,145 Q-9,145 -5,127 L0,38 Q4,-58 -5,-85 Z" fill="{$light}" opacity="0.05"/>
      <!-- Tampa 1 -->
      <rect x="-70" y="-120" width="40" height="35" rx="6" fill="{$light}" opacity="0.2"/>
      <rect x="-65" y="-117" width="30" height="29" rx="4" fill="{$light}" opacity="0.08"/>
      <!-- Conteúdo 1 -->
      <path d="M-95,20 Q-90,50 -88,100 Q-85,130 -70,140 L-30,140 Q-15,130 -12,100 Q-10,50 -5,20 Z" fill="{$accent}" opacity="0.2"/>
      <!-- Frasco 2 (menor) -->
      <path d="M30,-60 Q25,-40 28,30 L32,100 Q35,120 50,120 L90,120 Q105,120 108,100 L112,30 Q115,-40 110,-60 Z" fill="{$accent}" opacity="0.85"/>
      <path d="M35,-55 Q30,-38 33,28 L37,97 Q40,115 52,115 L88,115 Q100,115 103,97 L107,28 Q110,-38 105,-55 Z" fill="{$light}" opacity="0.04"/>
      <!-- Tampa 2 -->
      <rect x="50" y="-85" width="40" height="30" rx="5" fill="{$light}" opacity="0.15"/>
      <rect x="54" y="-82" width="32" height="24" rx="3" fill="{$light}" opacity="0.06"/>
      <!-- Rótulos -->
      <rect x="-75" y="20" width="30" height="80" rx="4" fill="{$light}" opacity="0.08"/>
      <rect x="50" y="20" width="20" height="60" rx="3" fill="{$light}" opacity="0.06"/>
      <!-- Pump -->
      <rect x="-15" y="-130" width="10" height="15" rx="3" fill="{$light}" opacity="0.2"/>
      <rect x="-8" y="-145" width="16" height="20" rx="4" fill="{$light}" opacity="0.1"/>
SVG;
    }

    private function svgPerfume(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo do frasco -->
      <path d="M-80,-80 Q-100,-60 -95,20 L-90,120 Q-85,150 -60,150 L60,150 Q85,150 90,120 L95,20 Q100,-60 80,-80 Z" fill="{$accent}"/>
      <path d="M-75,-75 Q-94,-57 -89,18 L-84,117 Q-80,143 -58,143 L58,143 Q80,143 84,117 L89,18 Q94,-57 75,-75 Z" fill="{$light}" opacity="0.05"/>
      <!-- Ângulo facetado -->
      <path d="M-75,-75 L0,-100 L75,-75 L0,150 Z" fill="{$light}" opacity="0.04"/>
      <path d="M-60,-60 L0,-85 L60,-60 L0,120 Z" fill="{$light}" opacity="0.03"/>
      <!-- Conteúdo -->
      <path d="M-85,30 Q-80,60 -78,110 Q-75,138 -55,140 L55,140 Q75,138 78,110 Q80,60 85,30 Z" fill="{$accent}" opacity="0.25"/>
      <!-- Gargalo -->
      <rect x="-20" y="-110" width="40" height="35" rx="6" fill="{$light}" opacity="0.15"/>
      <rect x="-16" y="-107" width="32" height="29" rx="4" fill="{$light}" opacity="0.06"/>
      <!-- Atomizador -->
      <rect x="-6" y="-132" width="12" height="25" rx="4" fill="{$accent}" opacity="0.7"/>
      <rect x="-4" y="-130" width="8" height="21" rx="2" fill="{$light}" opacity="0.1"/>
      <!-- Botão -->
      <rect x="-14" y="-135" width="28" height="8" rx="4" fill="{$accent}" opacity="0.5"/>
      <!-- Tampão -->
      <rect x="-24" y="-145" width="48" height="14" rx="7" fill="{$accent}" opacity="0.6"/>
      <!-- Rótulo -->
      <rect x="-50" y="30" width="100" height="70" rx="4" fill="{$light}" opacity="0.08"/>
      <rect x="-40" y="42" width="80" height="2" rx="1" fill="{$light}" opacity="0.1"/>
      <rect x="-35" y="52" width="70" height="2" rx="1" fill="{$light}" opacity="0.08"/>
      <rect x="-30" y="80" width="60" height="2" rx="1" fill="{$light}" opacity="0.08"/>
SVG;
    }

    private function svgHairDryer(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo do secador -->
      <path d="M-120,-50 Q-140,-60 -140,-30 Q-140,10 -120,20 L20,20 Q60,20 80,-10 L80,-60 Q60,-90 20,-90 L-120,-90 Q-140,-90 -140,-70 Q-140,-40 -120,-50Z" fill="{$accent}"/>
      <path d="M-115,-45 Q-134,-54 -134,-30 Q-134,5 -115,15 L18,15 Q55,15 74,-12 L74,-58 Q55,-85 18,-85 L-115,-85 Q-134,-85 -134,-70 Q-134,-45 -115,-45Z" fill="{$light}" opacity="0.04"/>
      <!-- Grade de ar (traseira) -->
      <circle cx="20" cy="-50" r="35" fill="{$light}" opacity="0.08"/>
      <circle cx="20" cy="-50" r="28" fill="none" stroke="{$light}" stroke-width="2" opacity="0.12"/>
      <circle cx="20" cy="-50" r="20" fill="none" stroke="{$light}" stroke-width="2" opacity="0.10"/>
      <circle cx="20" cy="-50" r="12" fill="none" stroke="{$light}" stroke-width="2" opacity="0.08"/>
      <!-- Botões -->
      <rect x="-80" y="-70" width="8" height="8" rx="3" fill="{$light}" opacity="0.25"/>
      <rect x="-65" y="-70" width="8" height="8" rx="3" fill="{$light}" opacity="0.15"/>
      <!-- Bocal -->
      <path d="M60,-10 L100,-5 Q110,-10 110,-30 Q110,-60 100,-65 L60,-60 Z" fill="{$accent}" opacity="0.85"/>
      <path d="M65,-12 L96,-7 Q105,-12 105,-30 Q105,-57 96,-61 L65,-57 Z" fill="{$light}" opacity="0.04"/>
      <!-- Cabo -->
      <path d="M-120,-45 Q-145,20 -140,60 Q-135,90 -115,100 Q-95,110 -80,95 Q-70,80 -90,50 Q-100,30 -110,-45" fill="{$accent}" opacity="0.7"/>
      <line x1="-98" y1="10" x2="-90" y2="60" stroke="{$light}" stroke-width="2" opacity="0.08"/>
      <!-- Abertura -->
      <ellipse cx="105" cy="-35" rx="6" ry="22" fill="#0a0a1a" opacity="0.4"/>
      <!-- Fluxo de ar -->
      <path d="M115,-45 Q130,-50 145,-40" fill="none" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <path d="M115,-35 Q132,-32 150,-35" fill="none" stroke="{$light}" stroke-width="2" opacity="0.15"/>
      <path d="M115,-25 Q130,-20 140,-28" fill="none" stroke="{$light}" stroke-width="2" opacity="0.1"/>
SVG;
    }

    private function svgHairBrush(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Cabo -->
      <path d="M-110,-20 Q-140,-10 -135,40 Q-130,80 -110,95 Q-90,110 -70,90 Q-60,75 -65,40 Q-70,0 -90,-20 Z" fill="{$accent}"/>
      <path d="M-105,-15 Q-133,-6 -129,38 Q-124,75 -106,88 Q-90,100 -74,84 Q-66,72 -70,38 Q-74,2 -92,-15 Z" fill="{$light}" opacity="0.04"/>
      <!-- Base da escova -->
      <path d="M-90,-20 Q-60,-60 10,-70 Q60,-75 90,-60 Q95,-55 95,-40 L95,40 Q95,55 80,60 Q40,75 -10,70 Q-60,60 -80,40 Q-90,25 -90,-20Z" fill="{$accent}"/>
      <path d="M-85,-15 Q-56,-55 8,-65 Q55,-70 84,-55 Q88,-50 88,-38 L88,35 Q88,50 75,55 Q38,69 -8,65 Q-55,56 -75,38 Q-85,22 -85,-15Z" fill="{$light}" opacity="0.04"/>
      <!-- Cerdas -->
      <line x1="-50" y1="-55" x2="-50" y2="-75" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <line x1="-25" y1="-60" x2="-25" y2="-80" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <line x1="0" y1="-62" x2="0" y2="-82" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <line x1="25" y1="-60" x2="25" y2="-80" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <line x1="50" y1="-55" x2="50" y2="-75" stroke="{$light}" stroke-width="2" opacity="0.25"/>
      <line x1="-37" y1="-58" x2="-37" y2="-78" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <line x1="-12" y1="-61" x2="-12" y2="-81" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <line x1="12" y1="-61" x2="12" y2="-81" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <line x1="37" y1="-58" x2="37" y2="-78" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <!-- Base almofadada -->
      <ellipse cx="0" cy="-50" rx="65" ry="12" fill="{$light}" opacity="0.08"/>
SVG;
    }

    private function svgMakeup(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Estojo - tampa aberta -->
      <rect x="-130" y="-110" width="260" height="60" rx="10" fill="{$accent}" transform="rotate(-20, 0, -110)"/>
      <rect x="-125" y="-106" width="250" height="50" rx="8" fill="{$light}" opacity="0.05" transform="rotate(-20, 0, -110)"/>
      <!-- Espelho na tampa -->
      <ellipse cx="0" cy="-90" rx="40" ry="18" fill="#e2e8f0" opacity="0.15" transform="rotate(-20, 0, -110)"/>
      <!-- Estojo - base -->
      <rect x="-130" y="-50" width="260" height="200" rx="12" fill="{$accent}"/>
      <rect x="-125" y="-45" width="250" height="190" rx="10" fill="{$light}" opacity="0.04"/>
      <!-- Divisórias internas -->
      <rect x="-120" y="-40" width="108" height="175" rx="6" fill="{$accent}" opacity="0.4"/>
      <rect x="-115" y="-35" width="98" height="165" rx="4" fill="{$light}" opacity="0.04"/>
      <rect x="-5" y="-40" width="120" height="175" rx="6" fill="{$accent}" opacity="0.3"/>
      <!-- Sombra (disco) -->
      <circle cx="-65" cy="20" r="30" fill="{$light}" opacity="0.12"/>
      <circle cx="-65" cy="20" r="25" fill="{$light}" opacity="0.08"/>
      <circle cx="-65" cy="20" r="20" fill="{$light}" opacity="0.05"/>
      <!-- Blush -->
      <ellipse cx="-65" cy="90" rx="25" ry="12" fill="#db2777" opacity="0.15"/>
      <!-- Pó compacto -->
      <ellipse cx="55" cy="30" rx="40" ry="15" fill="{$light}" opacity="0.1"/>
      <ellipse cx="55" cy="30" rx="35" ry="12" fill="{$light}" opacity="0.06"/>
      <!-- Pincel -->
      <line x1="80" y1="-100" x2="180" y2="30" stroke="{$accent}" stroke-width="4" stroke-linecap="round" opacity="0.6"/>
      <line x1="80" y1="-100" x2="180" y2="30" stroke="{$light}" stroke-width="1.5" stroke-linecap="round" opacity="0.15"/>
      <ellipse cx="185" cy="38" rx="6" ry="18" transform="rotate(35, 185, 38)" fill="{$light}" opacity="0.15"/>
      <!-- Fecho -->
      <rect x="-8" y="-55" width="16" height="8" rx="4" fill="{$light}" opacity="0.25"/>
SVG;
    }

    // ======================== BRINQUEDOS ========================

    private function svgPuzzle(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Peça 1 (esquerda superior) -->
      <path d="M-180,-80 Q-170,-120 -140,-120 L-60,-120 Q-50,-120 -50,-110 L-50,-90 Q-50,-80 -40,-80 L-30,-80 Q-20,-80 -20,-70 L-20,-40 Q-20,-30 -30,-30 L-40,-30 Q-50,-30 -50,-20 L-50,0 Q-50,10 -60,10 L-140,10 Q-150,10 -150,0 L-150,-70 Q-150,-80 -180,-80Z" fill="{$accent}"/>
      <path d="M-175,-75 Q-167,-110 -140,-110 L-62,-110 Q-52,-110 -52,-100 L-52,-88 Q-52,-78 -42,-78 L-32,-78 Q-22,-78 -22,-68 L-22,-42 Q-22,-32 -32,-32 L-42,-32 Q-52,-32 -52,-22 L-52,-2 Q-52,8 -62,8 L-140,8 Q-148,8 -148,0 L-148,-68 Q-148,-75 -175,-75Z" fill="{$light}" opacity="0.04"/>
      <!-- Peça 2 (direita superior) -->
      <path d="M40,-80 L130,-80 Q160,-80 170,-50 L170,10 Q170,20 160,20 L140,20 Q130,20 130,30 L130,50 Q130,60 120,60 L90,60 Q80,60 80,50 L80,30 Q80,20 70,20 L50,20 Q40,20 40,10 L40,-70 Q40,-80 40,-80Z" fill="{$accent}" opacity="0.85"/>
      <path d="M42,-78 L128,-78 Q155,-78 165,-50 L165,8 Q165,18 158,18 L140,18 Q132,18 132,28 L132,48 Q132,58 120,58 L92,58 Q82,58 82,48 L82,28 Q82,18 72,18 L52,18 Q42,18 42,8 L42,-68 Q42,-78 42,-78Z" fill="{$light}" opacity="0.04"/>
      <!-- Peça 3 (inferior) -->
      <path d="M-170,30 Q-160,10 -140,10 L-20,10 Q-10,10 -10,20 L-10,40 Q-10,50 -20,50 L-90,50 Q-100,50 -100,60 L-100,90 Q-100,100 -90,100 L-20,100 Q-10,100 -10,110 L-10,130 Q-10,140 -20,140 L-50,140 Q-60,140 -60,150 L-60,170 Q-60,180 -70,180 L-100,180 L-170,180 Q-180,180 -180,170 L-180,40 Q-180,30 -170,30Z" fill="{$accent}" opacity="0.75"/>
      <!-- Conectores das peças -->
      <circle cx="-100" cy="-45" r="6" fill="{$light}" opacity="0.15"/>
      <circle cx="130" cy="-20" r="6" fill="{$light}" opacity="0.12"/>
      <circle cx="-100" cy="130" r="6" fill="{$light}" opacity="0.1"/>
      <!-- Detalhes de encaixe -->
      <path d="M-50,-80 L-50,-70" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <path d="M130,60 L130,50" stroke="{$light}" stroke-width="2" opacity="0.15"/>
SVG;
    }

    private function svgBoardGame(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Caixa do jogo -->
      <rect x="-140" y="-160" width="280" height="320" rx="12" fill="{$accent}"/>
      <rect x="-135" y="-155" width="270" height="310" rx="10" fill="{$light}" opacity="0.04"/>
      <!-- Tampa (ângulo) -->
      <rect x="-140" y="-160" width="280" height="60" rx="12" fill="{$accent}" opacity="0.85"/>
      <rect x="-135" y="-155" width="270" height="50" rx="8" fill="{$light}" opacity="0.06"/>
      <!-- Tabuleiro (visto de cima) -->
      <rect x="-110" y="-80" width="220" height="220" rx="8" fill="{$accent}" opacity="0.3"/>
      <rect x="-105" y="-75" width="210" height="210" rx="6" fill="{$light}" opacity="0.04"/>
      <!-- Grid do tabuleiro (8x8 simplificado) -->
      <g opacity="0.15">
        <line x1="-52" y1="-75" x2="-52" y2="135" stroke="{$light}" stroke-width="1.5"/>
        <line x1="0" y1="-75" x2="0" y2="135" stroke="{$light}" stroke-width="1.5"/>
        <line x1="52" y1="-75" x2="52" y2="135" stroke="{$light}" stroke-width="1.5"/>
        <line x1="-105" y1="-25" x2="105" y2="-25" stroke="{$light}" stroke-width="1.5"/>
        <line x1="-105" y1="25" x2="105" y2="25" stroke="{$light}" stroke-width="1.5"/>
        <line x1="-105" y1="75" x2="105" y2="75" stroke="{$light}" stroke-width="1.5"/>
      </g>
      <!-- Peças do jogo -->
      <circle cx="-35" cy="-40" r="8" fill="{$accent}"/>
      <circle cx="10" cy="-40" r="8" fill="{$accent}" opacity="0.7"/>
      <circle cx="55" cy="-40" r="8" fill="{$accent}" opacity="0.5"/>
      <circle cx="-60" cy="5" r="6" fill="{$light}" opacity="0.3"/>
      <circle cx="35" cy="50" r="6" fill="{$light}" opacity="0.2"/>
      <circle cx="-10" cy="90" r="6" fill="{$light}" opacity="0.25"/>
      <!-- Nome do jogo -->
      <rect x="-60" y="-145" width="120" height="6" rx="3" fill="{$light}" opacity="0.12"/>
      <rect x="-40" y="-132" width="80" height="4" rx="2" fill="{$light}" opacity="0.08"/>
SVG;
    }

    private function svgRcCar(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Chassis -->
      <rect x="-100" y="-20" width="200" height="40" rx="8" fill="{$accent}"/>
      <rect x="-95" y="-16" width="190" height="32" rx="6" fill="{$light}" opacity="0.04"/>
      <!-- Carroceria -->
      <path d="M-70,-20 L-60,-80 Q-40,-100 0,-100 Q40,-100 60,-80 L70,-20 Z" fill="{$accent}"/>
      <path d="M-65,-20 L-56,-76 Q-38,-95 0,-95 Q38,-95 56,-76 L65,-20 Z" fill="{$light}" opacity="0.04"/>
      <!-- Para-brisa -->
      <path d="M-40,-75 Q-20,-95 20,-95 Q40,-75 40,-20 L-40,-20 Z" fill="{$light}" opacity="0.08"/>
      <path d="M-35,-72 Q-18,-90 18,-90 Q35,-72 35,-20 L-35,-20 Z" fill="{$light}" opacity="0.04"/>
      <!-- Roda traseira -->
      <circle cx="-70" cy="20" r="30" fill="#1a1a1a"/>
      <circle cx="-70" cy="20" r="24" fill="none" stroke="{$accent}" stroke-width="4"/>
      <circle cx="-70" cy="20" r="8" fill="{$accent}"/>
      <circle cx="-70" cy="20" r="4" fill="{$light}" opacity="0.3"/>
      <!-- Roda dianteira -->
      <circle cx="70" cy="20" r="30" fill="#1a1a1a"/>
      <circle cx="70" cy="20" r="24" fill="none" stroke="{$accent}" stroke-width="4"/>
      <circle cx="70" cy="20" r="8" fill="{$accent}"/>
      <circle cx="70" cy="20" r="4" fill="{$light}" opacity="0.3"/>
      <!-- Antena -->
      <line x1="40" y1="-100" x2="45" y2="-180" stroke="{$accent}" stroke-width="3" stroke-linecap="round"/>
      <circle cx="45" cy="-185" r="5" fill="{$accent}"/>
      <!-- Spoiler -->
      <rect x="-30" y="-105" width="60" height="6" rx="3" fill="{$accent}" opacity="0.7"/>
      <line x1="-30" y1="-100" x2="-30" y2="-85" stroke="{$accent}" stroke-width="3" opacity="0.5"/>
      <line x1="30" y1="-100" x2="30" y2="-85" stroke="{$accent}" stroke-width="3" opacity="0.5"/>
      <!-- Faróis -->
      <ellipse cx="80" cy="-40" rx="6" ry="4" fill="#fef3c7" opacity="0.3"/>
      <ellipse cx="80" cy="-30" rx="6" ry="4" fill="#fef3c7" opacity="0.3"/>
      <!-- Sombra -->
      <ellipse cx="0" cy="65" rx="120" ry="10" fill="#000" opacity="0.1"/>
SVG;
    }

    private function svgDoll(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Cabelo -->
      <ellipse cx="0" cy="-125" rx="55" ry="40" fill="{$accent}" opacity="0.85"/>
      <ellipse cx="0" cy="-130" rx="50" ry="35" fill="{$light}" opacity="0.06"/>
      <!-- Rabo de cavalo -->
      <path d="M40,-140 Q70,-120 65,-80 Q60,-60 45,-50" fill="none" stroke="{$accent}" stroke-width="12" stroke-linecap="round" opacity="0.7"/>
      <!-- Rosto -->
      <ellipse cx="0" cy="-95" rx="40" ry="35" fill="#f5d0b8"/>
      <ellipse cx="0" cy="-92" rx="37" ry="32" fill="#fae8d2"/>
      <!-- Olhos -->
      <ellipse cx="-14" cy="-100" rx="7" ry="9" fill="#1a1a1a"/>
      <ellipse cx="14" cy="-100" rx="7" ry="9" fill="#1a1a1a"/>
      <circle cx="-12" cy="-103" r="3" fill="#fff" opacity="0.6"/>
      <circle cx="16" cy="-103" r="3" fill="#fff" opacity="0.6"/>
      <!-- Cílios -->
      <line x1="-20" y1="-108" x2="-14" y2="-112" stroke="#1a1a1a" stroke-width="1.5" opacity="0.5"/>
      <line x1="20" y1="-108" x2="14" y2="-112" stroke="#1a1a1a" stroke-width="1.5" opacity="0.5"/>
      <!-- Bochechas -->
      <circle cx="-22" cy="-82" r="8" fill="#fca5a5" opacity="0.2"/>
      <circle cx="22" cy="-82" r="8" fill="#fca5a5" opacity="0.2"/>
      <!-- Sorriso -->
      <path d="M-8,-78 Q0,-70 8,-78" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
      <!-- Corpo (vestido) -->
      <path d="M-35,-60 Q-50,0 -60,80 L60,80 Q50,0 35,-60 Z" fill="{$accent}"/>
      <path d="M-32,-55 Q-46,0 -55,75 L55,75 Q46,0 32,-55 Z" fill="{$light}" opacity="0.04"/>
      <!-- Braços -->
      <path d="M-35,-50 Q-70,-20 -75,20" fill="none" stroke="{$accent}" stroke-width="10" stroke-linecap="round"/>
      <path d="M35,-50 Q70,-20 75,20" fill="none" stroke="{$accent}" stroke-width="10" stroke-linecap="round"/>
      <!-- Mãos -->
      <circle cx="-75" cy="25" r="6" fill="#f5d0b8"/>
      <circle cx="75" cy="25" r="6" fill="#f5d0b8"/>
      <!-- Pernas -->
      <rect x="-25" y="80" width="18" height="50" rx="6" fill="#f5d0b8"/>
      <rect x="7" y="80" width="18" height="50" rx="6" fill="#f5d0b8"/>
      <!-- Sapatos -->
      <ellipse cx="-16" cy="135" rx="14" ry="6" fill="{$accent}"/>
      <ellipse cx="16" cy="135" rx="14" ry="6" fill="{$accent}"/>
      <!-- Laço no cabelo -->
      <circle cx="0" cy="-148" r="8" fill="{$light}" opacity="0.2"/>
      <path d="M-5,-155 L0,-165 L5,-155" fill="none" stroke="{$light}" stroke-width="2" opacity="0.15"/>
SVG;
    }

    private function svgTeddy(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo -->
      <ellipse cx="0" cy="40" rx="90" ry="95" fill="{$accent}"/>
      <ellipse cx="0" cy="38" rx="85" ry="90" fill="{$light}" opacity="0.04"/>
      <!-- Barriga -->
      <ellipse cx="0" cy="50" rx="55" ry="60" fill="{$light}" opacity="0.12"/>
      <ellipse cx="0" cy="48" rx="50" ry="55" fill="{$light}" opacity="0.06"/>
      <!-- Cabeça -->
      <circle cx="0" cy="-80" r="70" fill="{$accent}"/>
      <circle cx="0" cy="-82" r="66" fill="{$light}" opacity="0.04"/>
      <!-- Focinho -->
      <ellipse cx="0" cy="-68" rx="28" ry="22" fill="{$light}" opacity="0.15"/>
      <!-- Nariz -->
      <ellipse cx="0" cy="-72" rx="8" ry="6" fill="#1a1a1a"/>
      <circle cx="-3" cy="-74" r="2" fill="#fff" opacity="0.4"/>
      <!-- Boca -->
      <path d="M-6,-66 L0,-62 L6,-66" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
      <line x1="0" y1="-66" x2="0" y2="-62" stroke="#1a1a1a" stroke-width="1.5" opacity="0.4"/>
      <!-- Olhos -->
      <circle cx="-22" cy="-90" r="8" fill="#1a1a1a"/>
      <circle cx="22" cy="-90" r="8" fill="#1a1a1a"/>
      <circle cx="-20" cy="-93" r="3" fill="#fff" opacity="0.5"/>
      <circle cx="24" cy="-93" r="3" fill="#fff" opacity="0.5"/>
      <!-- Sobrancelhas -->
      <path d="M-30,-100 Q-22,-105 -14,-100" fill="none" stroke="#1a1a1a" stroke-width="2" opacity="0.3"/>
      <path d="M14,-100 Q22,-105 30,-100" fill="none" stroke="#1a1a1a" stroke-width="2" opacity="0.3"/>
      <!-- Orelhas -->
      <circle cx="-50" cy="-130" r="25" fill="{$accent}"/>
      <circle cx="-50" cy="-130" r="18" fill="{$light}" opacity="0.1"/>
      <circle cx="50" cy="-130" r="25" fill="{$accent}"/>
      <circle cx="50" cy="-130" r="18" fill="{$light}" opacity="0.1"/>
      <!-- Patas superiores -->
      <ellipse cx="-105" cy="20" rx="25" ry="40" fill="{$accent}" transform="rotate(-20, -105, 20)"/>
      <ellipse cx="105" cy="20" rx="25" ry="40" fill="{$accent}" transform="rotate(20, 105, 20)"/>
      <ellipse cx="-115" cy="45" rx="15" ry="12" fill="{$light}" opacity="0.1"/>
      <ellipse cx="115" cy="45" rx="15" ry="12" fill="{$light}" opacity="0.1"/>
      <!-- Patas inferiores -->
      <ellipse cx="-50" cy="120" rx="30" ry="20" fill="{$accent}"/>
      <ellipse cx="50" cy="120" rx="30" ry="20" fill="{$accent}"/>
      <ellipse cx="-50" cy="125" rx="18" ry="10" fill="{$light}" opacity="0.08"/>
      <ellipse cx="50" cy="125" rx="18" ry="10" fill="{$light}" opacity="0.08"/>
SVG;
    }

    // ======================== PET ========================

    private function svgDogFood(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Tigela - parte externa -->
      <path d="M-120,-60 Q-130,-140 -130,-160 L130,-160 Q130,-140 120,-60 Q100,20 60,60 L-60,60 Q-100,20 -120,-60Z" fill="{$accent}"/>
      <path d="M-115,-55 Q-124,-132 -124,-155 L124,-155 Q124,-132 115,-55 Q96,16 58,55 L-58,55 Q-96,16 -115,-55Z" fill="{$light}" opacity="0.04"/>
      <!-- Interior da tigela -->
      <path d="M-110,-60 Q-120,-140 -120,-155 L120,-155 Q120,-140 110,-60 Q92,10 55,45 L-55,45 Q-92,10 -110,-60Z" fill="{$accent}" opacity="0.3"/>
      <!-- Ração -->
      <ellipse cx="-35" cy="-100" rx="18" ry="10" fill="{$accent}" opacity="0.6"/>
      <ellipse cx="30" cy="-110" rx="15" ry="8" fill="{$accent}" opacity="0.6"/>
      <ellipse cx="5" cy="-95" rx="14" ry="9" fill="{$accent}" opacity="0.5"/>
      <ellipse cx="-20" cy="-120" rx="12" ry="7" fill="{$accent}" opacity="0.5"/>
      <ellipse cx="40" cy="-95" rx="10" ry="6" fill="{$accent}" opacity="0.5"/>
      <ellipse cx="-5" cy="-115" rx="10" ry="6" fill="{$accent}" opacity="0.4"/>
      <circle cx="-30" cy="-105" r="3" fill="{$light}" opacity="0.15"/>
      <circle cx="25" cy="-112" r="3" fill="{$light}" opacity="0.12"/>
      <!-- Base -->
      <ellipse cx="0" cy="58" rx="55" ry="6" fill="{$accent}" opacity="0.4"/>
      <!-- Nome -->
      <rect x="-30" y="-150" width="60" height="6" rx="3" fill="{$light}" opacity="0.1"/>
SVG;
    }

    private function svgCatTree(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Poste central -->
      <rect x="-15" y="-180" width="30" height="340" rx="10" fill="{$accent}"/>
      <rect x="-12" y="-175" width="24" height="330" rx="6" fill="{$light}" opacity="0.04"/>
      <!-- Corda (textura do poste) -->
      <line x1="-15" y1="-160" x2="15" y2="-155" stroke="{$accent}" stroke-width="2" opacity="0.2"/>
      <line x1="-15" y1="-130" x2="15" y2="-125" stroke="{$accent}" stroke-width="2" opacity="0.15"/>
      <line x1="-15" y1="-100" x2="15" y2="-95" stroke="{$accent}" stroke-width="2" opacity="0.15"/>
      <line x1="-15" y1="-70" x2="15" y2="-65" stroke="{$accent}" stroke-width="2" opacity="0.12"/>
      <line x1="-15" y1="-40" x2="15" y2="-35" stroke="{$accent}" stroke-width="2" opacity="0.12"/>
      <line x1="-15" y1="-10" x2="15" y2="-5" stroke="{$accent}" stroke-width="2" opacity="0.1"/>
      <!-- Plataforma 1 (topo) -->
      <ellipse cx="0" cy="-170" rx="80" ry="15" fill="{$accent}"/>
      <ellipse cx="0" cy="-173" rx="75" ry="12" fill="{$light}" opacity="0.06"/>
      <!-- Almofada 1 -->
      <ellipse cx="0" cy="-175" rx="45" ry="8" fill="{$accent}" opacity="0.5"/>
      <ellipse cx="0" cy="-178" rx="40" ry="6" fill="{$light}" opacity="0.08"/>
      <!-- Plataforma 2 (meio) -->
      <ellipse cx="70" cy="-50" rx="65" ry="14" fill="{$accent}"/>
      <ellipse cx="70" cy="-52" rx="60" ry="11" fill="{$light}" opacity="0.05"/>
      <ellipse cx="70" cy="-56" rx="35" ry="6" fill="{$accent}" opacity="0.4"/>
      <!-- Suporte plataforma 2 -->
      <line x1="15" y1="-55" x2="40" y2="-55" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <!-- Plataforma 3 (base) -->
      <ellipse cx="-60" cy="60" rx="70" ry="15" fill="{$accent}"/>
      <ellipse cx="-60" cy="58" rx="65" ry="12" fill="{$light}" opacity="0.05"/>
      <ellipse cx="-60" cy="55" rx="40" ry="7" fill="{$accent}" opacity="0.4"/>
      <!-- Suporte plataforma 3 -->
      <line x1="-15" y1="55" x2="-30" y2="55" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <!-- Base -->
      <ellipse cx="0" cy="155" rx="90" ry="12" fill="{$accent}" opacity="0.6"/>
      <!-- Brinquedo pendurado -->
      <line x1="15" y1="-65" x2="40" y2="10" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
      <circle cx="42" cy="15" r="6" fill="{$accent}" opacity="0.5"/>
SVG;
    }

    private function svgPetBed(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Cama - borda externa -->
      <ellipse cx="0" cy="20" rx="150" ry="70" fill="{$accent}"/>
      <ellipse cx="0" cy="18" rx="145" ry="66" fill="{$light}" opacity="0.04"/>
      <!-- Borda elevada -->
      <ellipse cx="0" cy="-10" rx="140" ry="55" fill="{$accent}" opacity="0.85"/>
      <ellipse cx="0" cy="-12" rx="135" ry="52" fill="{$light}" opacity="0.05"/>
      <!-- Interior acolchoado -->
      <ellipse cx="0" cy="-15" rx="110" ry="38" fill="{$accent}" opacity="0.5"/>
      <ellipse cx="0" cy="-18" rx="105" ry="35" fill="{$light}" opacity="0.06"/>
      <!-- Acolchoamento -->
      <ellipse cx="0" cy="-20" rx="90" ry="28" fill="{$accent}" opacity="0.3"/>
      <line x1="-60" y1="-20" x2="60" y2="-20" stroke="{$light}" stroke-width="1" opacity="0.08"/>
      <line x1="-40" y1="-10" x2="40" y2="-10" stroke="{$light}" stroke-width="1" opacity="0.06"/>
      <line x1="-50" y1="-30" x2="50" y2="-30" stroke="{$light}" stroke-width="1" opacity="0.06"/>
      <!-- Costuras -->
      <ellipse cx="0" cy="-12" rx="130" ry="48" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.1"/>
      <!-- Base -->
      <ellipse cx="0" cy="65" rx="120" ry="15" fill="{$accent}" opacity="0.3"/>
SVG;
    }

    private function svgDogCollar(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Coleira (curva) -->
      <path d="M-140,-80 Q-100,-120 -40,-130 Q20,-140 80,-110 Q120,-85 140,-50" fill="none" stroke="{$accent}" stroke-width="22" stroke-linecap="round"/>
      <path d="M-138,-78 Q-98,-118 -40,-128 Q20,-138 78,-108 Q118,-83 138,-48" fill="none" stroke="{$light}" stroke-width="8" stroke-linecap="round" opacity="0.08"/>
      <!-- Fivela -->
      <rect x="-12" y="-105" width="24" height="32" rx="6" fill="#1a1a1a" opacity="0.7"/>
      <rect x="-8" y="-100" width="16" height="22" rx="4" fill="{$accent}"/>
      <rect x="-4" y="-95" width="8" height="12" rx="2" fill="#1a1a1a" opacity="0.5"/>
      <!-- Argola -->
      <circle cx="0" cy="-150" r="12" fill="none" stroke="{$accent}" stroke-width="5"/>
      <circle cx="0" cy="-150" r="10" fill="none" stroke="{$light}" stroke-width="2" opacity="0.15"/>
      <!-- Medalha -->
      <circle cx="20" cy="-100" r="14" fill="{$accent}" opacity="0.7"/>
      <circle cx="20" cy="-100" r="11" fill="{$accent}"/>
      <circle cx="20" cy="-100" r="8" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.3"/>
      <circle cx="20" cy="-100" r="4" fill="{$light}" opacity="0.15"/>
      <!-- Furos -->
      <circle cx="-60" cy="-95" r="3" fill="#1a1a1a" opacity="0.3"/>
      <circle cx="-70" cy="-88" r="3" fill="#1a1a1a" opacity="0.25"/>
      <circle cx="-80" cy="-79" r="3" fill="#1a1a1a" opacity="0.2"/>
      <!-- Rebitamento -->
      <circle cx="-90" cy="-70" r="4" fill="{$light}" opacity="0.12"/>
      <circle cx="-100" cy="-60" r="4" fill="{$light}" opacity="0.1"/>
SVG;
    }

    private function svgDogToy(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Osso - parte central -->
      <rect x="-80" y="-20" width="160" height="40" rx="12" fill="{$accent}"/>
      <rect x="-75" y="-15" width="150" height="30" rx="8" fill="{$light}" opacity="0.04"/>
      <!-- Nó esquerdo -->
      <ellipse cx="-100" cy="-15" rx="30" ry="28" fill="{$accent}"/>
      <ellipse cx="-100" cy="-17" rx="27" ry="25" fill="{$light}" opacity="0.04"/>
      <ellipse cx="-100" cy="-15" rx="18" ry="17" fill="{$accent}" opacity="0.5"/>
      <!-- Nó direito -->
      <ellipse cx="100" cy="-15" rx="30" ry="28" fill="{$accent}"/>
      <ellipse cx="100" cy="-17" rx="27" ry="25" fill="{$light}" opacity="0.04"/>
      <ellipse cx="100" cy="-15" rx="18" ry="17" fill="{$accent}" opacity="0.5"/>
      <!-- Detalhes de brinquedo (mordedor) -->
      <ellipse cx="-100" cy="10" rx="20" ry="8" fill="{$light}" opacity="0.08"/>
      <ellipse cx="100" cy="10" rx="20" ry="8" fill="{$light}" opacity="0.08"/>
      <!-- Textura mordedor -->
      <line x1="-60" y1="-5" x2="-40" y2="-5" stroke="{$light}" stroke-width="2" opacity="0.1"/>
      <line x1="-20" y1="-5" x2="0" y2="-5" stroke="{$light}" stroke-width="2" opacity="0.1"/>
      <line x1="20" y1="-5" x2="40" y2="-5" stroke="{$light}" stroke-width="2" opacity="0.1"/>
      <!-- Sombra -->
      <ellipse cx="0" cy="45" rx="120" ry="10" fill="#000" opacity="0.08"/>
SVG;
    }

    // ======================== PAPELARIA ========================

    private function svgBackpack(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Corpo da mochila -->
      <path d="M-110,-80 Q-120,-60 -115,40 L-110,140 Q-105,165 -80,165 L80,165 Q105,165 110,140 L115,40 Q120,-60 110,-80 Z" fill="{$accent}"/>
      <path d="M-105,-75 Q-114,-57 -109,38 L-104,137 Q-100,158 -78,158 L78,158 Q100,158 104,137 L109,38 Q114,-57 105,-75 Z" fill="{$light}" opacity="0.04"/>
      <!-- Tampa -->
      <path d="M-100,-80 Q0,-120 100,-80 L85,-40 Q0,-75 -85,-40 Z" fill="{$light}" opacity="0.12"/>
      <!-- Bolso frontal -->
      <rect x="-80" y="30" width="160" height="80" rx="10" fill="{$accent}" opacity="0.5"/>
      <rect x="-75" y="35" width="150" height="70" rx="8" fill="{$light}" opacity="0.04"/>
      <!-- Zíper do bolso -->
      <path d="M-60,70 L60,70" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <circle cx="-60" cy="70" r="3" fill="{$light}" opacity="0.15"/>
      <!-- Alças -->
      <path d="M-50,-80 Q-60,-150 -70,-170 Q-75,-180 -65,-180" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round" opacity="0.7"/>
      <path d="M50,-80 Q60,-150 70,-170 Q75,-180 65,-180" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round" opacity="0.7"/>
      <!-- Alça de mão -->
      <path d="M-15,-100 Q0,-130 15,-100" fill="none" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
      <!-- Fecho -->
      <rect x="-10" y="-70" width="20" height="8" rx="3" fill="{$light}" opacity="0.2"/>
      <!-- Fundo reforçado -->
      <rect x="-85" y="155" width="170" height="8" rx="4" fill="{$accent}" opacity="0.4"/>
      <!-- Detalhes de costura -->
      <path d="M-100,-30 Q0,-10 100,-30" fill="none" stroke="{$light}" stroke-width="1" opacity="0.06"/>
SVG;
    }

    private function svgNotebook(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Capa -->
      <rect x="-110" y="-140" width="220" height="280" rx="8" fill="{$accent}"/>
      <rect x="-106" y="-136" width="212" height="272" rx="6" fill="{$light}" opacity="0.04"/>
      <!-- Lombada -->
      <rect x="-110" y="-140" width="25" height="280" rx="8" fill="{$accent}" opacity="0.85"/>
      <rect x="-106" y="-136" width="17" height="272" rx="4" fill="{$light}" opacity="0.06"/>
      <!-- Páginas (borda) -->
      <rect x="-85" y="-132" width="195" height="264" rx="4" fill="#f8fafc" opacity="0.08"/>
      <rect x="-83" y="-130" width="191" height="260" rx="3" fill="#f8fafc" opacity="0.05"/>
      <!-- Linhas do caderno -->
      <g opacity="0.06">
        <line x1="-78" y1="-90" x2="98" y2="-90" stroke="#1a1a1a" stroke-width="1"/>
        <line x1="-78" y1="-60" x2="98" y2="-60" stroke="#1a1a1a" stroke-width="1"/>
        <line x1="-78" y1="-30" x2="98" y2="-30" stroke="#1a1a1a" stroke-width="1"/>
        <line x1="-78" y1="0" x2="98" y2="0" stroke="#1a1a1a" stroke-width="1"/>
        <line x1="-78" y1="30" x2="98" y2="30" stroke="#1a1a1a" stroke-width="1"/>
        <line x1="-78" y1="60" x2="98" y2="60" stroke="#1a1a1a" stroke-width="1"/>
        <line x1="-78" y1="90" x2="98" y2="90" stroke="#1a1a1a" stroke-width="1"/>
      </g>
      <!-- Margem vermelha -->
      <line x1="-75" y1="-130" x2="-75" y2="130" stroke="#e11d48" stroke-width="1" opacity="0.08"/>
      <!-- Elástico de fecho -->
      <rect x="-108" y="130" width="216" height="4" rx="2" fill="{$accent}" opacity="0.5"/>
      <!-- Marca-página -->
      <path d="M90,-40 L100,-40 L100,100 L95,90 L90,100 Z" fill="{$light}" opacity="0.12"/>
      <!-- Rótulo -->
      <rect x="-30" y="-30" width="60" height="60" rx="4" fill="{$light}" opacity="0.06"/>
SVG;
    }

    private function svgPencils(string $accent, string $light): string
    {
        $pencils = '';
        $xStart = -120;
        $colorsForPencils = [
            ['body' => '#f59e0b', 'tip' => '#fbbf24'],
            ['body' => '#ef4444', 'tip' => '#fca5a5'],
            ['body' => '#3b82f6', 'tip' => '#93c5fd'],
            ['body' => '#22c55e', 'tip' => '#86efac'],
            ['body' => '#a855f7', 'tip' => '#d8b4fe'],
        ];
        foreach ($colorsForPencils as $i => $c) {
            $x = $xStart + $i * 50;
            $rot = -15 + $i * 7;
            $pencils .= "<g transform=\"translate({$x}, 0) rotate({$rot})\">\n";
            $pencils .= "  <rect x=\"-12\" y=\"-100\" width=\"24\" height=\"170\" rx=\"4\" fill=\"{$c['body']}\"/>\n";
            $pencils .= "  <rect x=\"-10\" y=\"-96\" width=\"20\" height=\"162\" rx=\"3\" fill=\"{$c['tip']}\" opacity=\"0.3\"/>\n";
            $pencils .= "  <polygon points=\"-12,70 12,70 0,100\" fill=\"{$c['tip']}\"/>\n";
            $pencils .= "  <rect x=\"-3\" y=\"95\" width=\"6\" height=\"10\" fill=\"#1a1a1a\"/>\n";
            $pencils .= "  <rect x=\"-14\" y=\"-120\" width=\"28\" height=\"25\" rx=\"4\" fill=\"#1a1a1a\" opacity=\"0.3\"/>\n";
            $pencils .= "  <rect x=\"-10\" y=\"-115\" width=\"20\" height=\"15\" rx=\"2\" fill=\"{$accent}\" opacity=\"0.3\"/>\n";
            $pencils .= "</g>\n";
        }
        return $pencils;
    }

    private function svgDeskOrganizer(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Base do organizador -->
      <rect x="-140" y="-100" width="280" height="200" rx="12" fill="{$accent}"/>
      <rect x="-135" y="-95" width="270" height="190" rx="10" fill="{$light}" opacity="0.04"/>
      <!-- Divisória vertical -->
      <rect x="-5" y="-100" width="10" height="200" rx="3" fill="{$accent}" opacity="0.6"/>
      <!-- Compartimento esquerdo (mais fundo) -->
      <rect x="-135" y="-90" width="125" height="180" rx="6" fill="{$accent}" opacity="0.3"/>
      <!-- Canetas no compartimento esquerdo -->
      <line x1="-110" y1="-60" x2="-110" y2="70" stroke="{$light}" stroke-width="4" stroke-linecap="round" opacity="0.15"/>
      <line x1="-90" y1="-50" x2="-90" y2="70" stroke="{$light}" stroke-width="4" stroke-linecap="round" opacity="0.12"/>
      <line x1="-70" y1="-55" x2="-70" y2="70" stroke="{$light}" stroke-width="4" stroke-linecap="round" opacity="0.1"/>
      <!-- Compartimento direito (dividido) -->
      <rect x="10" y="-90" width="125" height="80" rx="6" fill="{$accent}" opacity="0.2"/>
      <rect x="10" y="5" width="125" height="85" rx="6" fill="{$accent}" opacity="0.15"/>
      <!-- Clips no compartimento direito -->
      <circle cx="45" cy="-40" r="8" fill="none" stroke="{$light}" stroke-width="2" opacity="0.15"/>
      <circle cx="75" cy="-50" r="6" fill="none" stroke="{$light}" stroke-width="2" opacity="0.12"/>
      <circle cx="60" cy="-30" r="5" fill="none" stroke="{$light}" stroke-width="2" opacity="0.1"/>
      <!-- Post-it -->
      <rect x="110" y="-80" width="25" height="30" rx="2" fill="#fef3c7" opacity="0.15" transform="rotate(5, 122, -65)"/>
      <!-- Borda frontal -->
      <rect x="-140" y="92" width="280" height="6" rx="3" fill="{$accent}" opacity="0.3"/>
SVG;
    }

    private function svgOfficeChair(string $accent, string $light): string
    {
        return <<<SVG
      <!-- Encosto -->
      <path d="M-90,-160 Q-100,-80 -90,0 L90,0 Q100,-80 90,-160 Z" fill="{$accent}"/>
      <path d="M-85,-155 Q-94,-78 -85,0 L85,0 Q94,-78 85,-155 Z" fill="{$light}" opacity="0.04"/>
      <!-- Apoio de cabeça -->
      <rect x="-70" y="-190" width="140" height="35" rx="12" fill="{$accent}"/>
      <rect x="-65" y="-186" width="130" height="27" rx="10" fill="{$light}" opacity="0.05"/>
      <!-- Assento -->
      <rect x="-100" y="0" width="200" height="40" rx="12" fill="{$accent}"/>
      <rect x="-95" y="4" width="190" height="30" rx="10" fill="{$light}" opacity="0.04"/>
      <!-- Braço esquerdo -->
      <path d="M-90,10 Q-120,10 -115,30 L-115,50" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <rect x="-125" y="30" width="20" height="8" rx="4" fill="{$accent}"/>
      <!-- Braço direito -->
      <path d="M90,10 Q120,10 115,30 L115,50" fill="none" stroke="{$accent}" stroke-width="8" stroke-linecap="round"/>
      <rect x="105" y="30" width="20" height="8" rx="4" fill="{$accent}"/>
      <!-- Base (haste) -->
      <rect x="-8" y="40" width="16" height="60" rx="4" fill="{$accent}"/>
      <!-- Base (pés) -->
      <g opacity="0.6">
        <line x1="0" y1="100" x2="-80" y2="140" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
        <line x1="0" y1="100" x2="80" y2="140" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
        <line x1="0" y1="100" x2="-50" y2="150" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
        <line x1="0" y1="100" x2="50" y2="150" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
        <line x1="0" y1="100" x2="0" y2="155" stroke="{$accent}" stroke-width="6" stroke-linecap="round"/>
      </g>
      <!-- Rodinhas -->
      <circle cx="-80" cy="142" r="6" fill="{$accent}" opacity="0.5"/>
      <circle cx="80" cy="142" r="6" fill="{$accent}" opacity="0.5"/>
      <circle cx="-50" cy="152" r="6" fill="{$accent}" opacity="0.5"/>
      <circle cx="50" cy="152" r="6" fill="{$accent}" opacity="0.5"/>
      <circle cx="0" cy="157" r="6" fill="{$accent}" opacity="0.5"/>
      <!-- Almofada do assento -->
      <rect x="-90" y="2" width="180" height="15" rx="6" fill="{$accent}" opacity="0.2"/>
SVG;
    }

    // ========================================================================
    //  CATÁLOGO
    // ========================================================================

    /**
     * @return array<string, array<int, array{nome: string, preco: float, promo?: float|null, estoque: int, destaque?: bool, descricao?: string}>>
     */
    private function catalogo(): array
    {
        return [
            'Eletrônicos' => [
                ['nome' => 'Fone de Ouvido Bluetooth TWS',        'preco' => 199.90, 'promo' => 149.90, 'estoque' => 40, 'destaque' => true],
                ['nome' => 'Smartwatch Sport Pro',                 'preco' => 349.90, 'estoque' => 25, 'destaque' => true],
                ['nome' => "Caixa de Som Portátil à Prova d'Água", 'preco' => 179.90, 'promo' => 139.90, 'estoque' => 30],
                ['nome' => 'Carregador Portátil 20000mAh',         'preco' => 99.90,  'estoque' => 60],
                ['nome' => 'Mouse Gamer RGB',                      'preco' => 129.90, 'promo' => 99.90,  'estoque' => 0],
                ['nome' => 'Teclado Mecânico Compacto',            'preco' => 259.90, 'estoque' => 18],
            ],
            'Moda Masculina' => [
                ['nome' => 'Camiseta Básica Algodão',   'preco' => 59.90,  'estoque' => 80, 'destaque' => true],
                ['nome' => 'Calça Jeans Slim',          'preco' => 149.90, 'promo' => 119.90, 'estoque' => 45],
                ['nome' => 'Jaqueta Corta-Vento',       'preco' => 189.90, 'estoque' => 20],
                ['nome' => 'Tênis Casual em Couro',     'preco' => 229.90, 'promo' => 189.90, 'estoque' => 15, 'destaque' => true],
                ['nome' => 'Bermuda em Tactel',         'preco' => 79.90,  'estoque' => 50],
            ],
            'Moda Feminina' => [
                ['nome' => 'Vestido Midi Floral',               'preco' => 139.90, 'estoque' => 35, 'destaque' => true],
                ['nome' => 'Blusa de Tricô',                    'preco' => 89.90,  'promo' => 69.90,  'estoque' => 40],
                ['nome' => 'Legging Fitness',                   'preco' => 69.90,  'estoque' => 55],
                ['nome' => 'Bolsa Transversal Couro Sintético', 'preco' => 159.90, 'promo' => 129.90, 'estoque' => 22],
                ['nome' => 'Sandália Rasteira',                 'preco' => 99.90,  'estoque' => 0],
            ],
            'Casa e Decoração' => [
                ['nome' => 'Luminária de Mesa LED',               'preco' => 89.90,  'estoque' => 30],
                ['nome' => 'Jogo de Panelas Antiaderente 5 Peças', 'preco' => 249.90, 'promo' => 199.90, 'estoque' => 20, 'destaque' => true],
                ['nome' => 'Kit Organizadores de Gaveta',         'preco' => 49.90,  'estoque' => 70],
                ['nome' => 'Difusor de Aromas Elétrico',          'preco' => 79.90,  'promo' => 59.90,  'estoque' => 35],
                ['nome' => 'Manta de Sofá Soft',                  'preco' => 99.90,  'estoque' => 28],
            ],
            'Esportes e Lazer' => [
                ['nome' => 'Bola de Futebol Oficial',         'preco' => 129.90,  'estoque' => 40],
                ['nome' => 'Kit Halteres Emborrachados 10kg', 'preco' => 199.90,  'promo' => 169.90, 'estoque' => 15, 'destaque' => true],
                ['nome' => 'Bicicleta Aro 29',                'preco' => 1299.90, 'promo' => 1099.90, 'estoque' => 8,  'destaque' => true],
                ['nome' => 'Corda de Pular Profissional',     'preco' => 39.90,   'estoque' => 90],
                ['nome' => 'Tapete de Yoga Antiderrapante',   'preco' => 89.90,   'estoque' => 33],
            ],
            'Livros' => [
                ['nome' => 'Livro: Introdução à Programação',        'preco' => 79.90, 'estoque' => 25, 'destaque' => true],
                ['nome' => 'Livro: O Poder do Hábito',               'preco' => 49.90, 'promo' => 39.90, 'estoque' => 60],
                ['nome' => 'Livro: Uma Breve História da Humanidade', 'preco' => 59.90, 'estoque' => 45],
                ['nome' => 'Livro: Contos de Fadas Ilustrado',       'preco' => 44.90, 'estoque' => 38],
                ['nome' => 'Livro: Atlas Geográfico Escolar',        'preco' => 69.90, 'estoque' => 0],
            ],
            'Beleza e Cuidados' => [
                ['nome' => 'Kit Skincare Facial Completo',   'preco' => 159.90, 'promo' => 129.90, 'estoque' => 30, 'destaque' => true],
                ['nome' => 'Perfume Importado 100ml',        'preco' => 249.90, 'estoque' => 20],
                ['nome' => 'Secador de Cabelo Profissional', 'preco' => 189.90, 'promo' => 159.90, 'estoque' => 18],
                ['nome' => 'Escova Alisadora Térmica',       'preco' => 129.90, 'estoque' => 25],
                ['nome' => 'Kit Maquiagem Completo',         'preco' => 179.90, 'estoque' => 22],
            ],
            'Brinquedos e Jogos' => [
                ['nome' => 'Quebra-Cabeça 1000 Peças',       'preco' => 69.90,  'estoque' => 40],
                ['nome' => 'Jogo de Tabuleiro Estratégia',   'preco' => 99.90,  'promo' => 79.90,  'estoque' => 25, 'destaque' => true],
                ['nome' => 'Carrinho de Controle Remoto',    'preco' => 149.90, 'estoque' => 20],
                ['nome' => 'Boneca com Acessórios',          'preco' => 89.90,  'estoque' => 35],
                ['nome' => 'Pelúcia Urso Gigante',           'preco' => 119.90, 'promo' => 99.90,  'estoque' => 15],
            ],
            'Pet Shop' => [
                ['nome' => 'Ração Premium para Cães 15kg', 'preco' => 189.90, 'estoque' => 50],
                ['nome' => 'Arranhador para Gatos',        'preco' => 99.90,  'estoque' => 24],
                ['nome' => 'Cama Pet Confort',             'preco' => 129.90, 'promo' => 99.90,  'estoque' => 20, 'destaque' => true],
                ['nome' => 'Coleira Ajustável com Guia',   'preco' => 49.90,  'estoque' => 60],
                ['nome' => 'Brinquedo Mordedor Resistente', 'preco' => 29.90, 'estoque' => 0],
            ],
            'Papelaria e Escritório' => [
                ['nome' => 'Mochila para Notebook',             'preco' => 149.90, 'estoque' => 30, 'destaque' => true],
                ['nome' => 'Caderno Inteligente A5',            'preco' => 79.90,  'promo' => 59.90,  'estoque' => 45],
                ['nome' => 'Kit Canetas Coloridas 24 Cores',    'preco' => 39.90,  'estoque' => 70],
                ['nome' => 'Organizador de Mesa em Bambu',      'preco' => 89.90,  'estoque' => 25],
                ['nome' => 'Cadeira de Escritório Ergonômica',  'preco' => 599.90, 'promo' => 499.90, 'estoque' => 10, 'destaque' => true],
            ],
        ];
    }

        // Fallback genérico
    private function svgDefault(string $accent, string $light): string
    {
        return <<<SVG
      <rect x="-80" y="-100" width="160" height="200" rx="20" fill="{$accent}"/>
      <rect x="-70" y="-90" width="140" height="180" rx="14" fill="{$light}" opacity="0.06"/>
      <circle cx="0" cy="-20" r="40" fill="none" stroke="{$light}" stroke-width="2" opacity="0.2"/>
      <circle cx="0" cy="-20" r="25" fill="none" stroke="{$light}" stroke-width="1.5" opacity="0.15"/>
      <circle cx="0" cy="-20" r="10" fill="{$light}" opacity="0.1"/>
      <rect x="-40" y="40" width="80" height="6" rx="3" fill="{$light}" opacity="0.12"/>
      <rect x="-30" y="55" width="60" height="6" rx="3" fill="{$light}" opacity="0.08"/>
      <rect x="-20" y="70" width="40" height="6" rx="3" fill="{$light}" opacity="0.06"/>
SVG;
    }
}
