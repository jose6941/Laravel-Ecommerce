<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
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

        $clientes = Usuario::where('perfil', 'cliente')->get();
        $catalogo = $this->catalogo();
        $skuIndex = 1;
        foreach ($catalogo as $nomeCategoria => $produtos) {
            $categoria = Categoria::where('nome', $nomeCategoria)->first();

            if (! $categoria) {
                continue;
            }

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

                $this->gerarGaleriaDeImagens($produto, $slug, $dados['img'] ?? 'product');
                $this->gerarAvaliacoes($produto, $clientes);
            }
        }
    }

    private function gerarGaleriaDeImagens(Produto $produto, string $slug, string $palavraChave): void
    {
        $produto->imagens()->delete();

        for ($i = 0; $i < 3; $i++) {
            $lock = crc32("{$slug}-{$i}");
            $produto->imagens()->create([
                'caminho' => "https://loremflickr.com/800/800/{$palavraChave}?lock={$lock}",
                'principal' => $i === 0,
                'ordem' => $i,
            ]);
        }
    }

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

    /**
     * Catálogo de produtos de exemplo, agrupado por categoria.
     *
     * @return array<string, array<int, array{nome: string, preco: float, promo?: float|null, estoque: int, destaque?: bool, descricao?: string, img: string}>>
     */
    private function catalogo(): array
    {
        return [
            'Eletrônicos' => [
                ['nome' => 'Fone de Ouvido Bluetooth TWS', 'preco' => 199.90, 'promo' => 149.90, 'estoque' => 40, 'destaque' => true, 'img' => 'headphones'],
                ['nome' => 'Smartwatch Sport Pro', 'preco' => 349.90, 'estoque' => 25, 'destaque' => true, 'img' => 'smartwatch'],
                ['nome' => 'Caixa de Som Portátil à Prova d\'Água', 'preco' => 179.90, 'promo' => 139.90, 'estoque' => 30, 'img' => 'speaker'],
                ['nome' => 'Carregador Portátil 20000mAh', 'preco' => 99.90, 'estoque' => 60, 'img' => 'powerbank'],
                ['nome' => 'Mouse Gamer RGB', 'preco' => 129.90, 'promo' => 99.90, 'estoque' => 0, 'img' => 'mouse'],
                ['nome' => 'Teclado Mecânico Compacto', 'preco' => 259.90, 'estoque' => 18, 'img' => 'keyboard'],
            ],
            'Moda Masculina' => [
                ['nome' => 'Camiseta Básica Algodão', 'preco' => 59.90, 'estoque' => 80, 'destaque' => true, 'img' => 'tshirt'],
                ['nome' => 'Calça Jeans Slim', 'preco' => 149.90, 'promo' => 119.90, 'estoque' => 45, 'img' => 'jeans'],
                ['nome' => 'Jaqueta Corta-Vento', 'preco' => 189.90, 'estoque' => 20, 'img' => 'jacket'],
                ['nome' => 'Tênis Casual em Couro', 'preco' => 229.90, 'promo' => 189.90, 'estoque' => 15, 'destaque' => true, 'img' => 'shoes'],
                ['nome' => 'Bermuda em Tactel', 'preco' => 79.90, 'estoque' => 50, 'img' => 'shorts'],
            ],
            'Moda Feminina' => [
                ['nome' => 'Vestido Midi Floral', 'preco' => 139.90, 'estoque' => 35, 'destaque' => true, 'img' => 'dress'],
                ['nome' => 'Blusa de Tricô', 'preco' => 89.90, 'promo' => 69.90, 'estoque' => 40, 'img' => 'sweater'],
                ['nome' => 'Legging Fitness', 'preco' => 69.90, 'estoque' => 55, 'img' => 'leggings'],
                ['nome' => 'Bolsa Transversal Couro Sintético', 'preco' => 159.90, 'promo' => 129.90, 'estoque' => 22, 'img' => 'handbag'],
                ['nome' => 'Sandália Rasteira', 'preco' => 99.90, 'estoque' => 0, 'img' => 'sandals'],
            ],
            'Casa e Decoração' => [
                ['nome' => 'Luminária de Mesa LED', 'preco' => 89.90, 'estoque' => 30, 'img' => 'lamp'],
                ['nome' => 'Jogo de Panelas Antiaderente 5 Peças', 'preco' => 249.90, 'promo' => 199.90, 'estoque' => 20, 'destaque' => true, 'img' => 'cookware'],
                ['nome' => 'Kit Organizadores de Gaveta', 'preco' => 49.90, 'estoque' => 70, 'img' => 'organizer'],
                ['nome' => 'Difusor de Aromas Elétrico', 'preco' => 79.90, 'promo' => 59.90, 'estoque' => 35, 'img' => 'diffuser'],
                ['nome' => 'Manta de Sofá Soft', 'preco' => 99.90, 'estoque' => 28, 'img' => 'blanket'],
            ],
            'Esportes e Lazer' => [
                ['nome' => 'Bola de Futebol Oficial', 'preco' => 129.90, 'estoque' => 40, 'img' => 'soccer'],
                ['nome' => 'Kit Halteres Emborrachados 10kg', 'preco' => 199.90, 'promo' => 169.90, 'estoque' => 15, 'destaque' => true, 'img' => 'dumbbells'],
                ['nome' => 'Bicicleta Aro 29', 'preco' => 1299.90, 'promo' => 1099.90, 'estoque' => 8, 'destaque' => true, 'img' => 'bicycle'],
                ['nome' => 'Corda de Pular Profissional', 'preco' => 39.90, 'estoque' => 90, 'img' => 'rope'],
                ['nome' => 'Tapete de Yoga Antiderrapante', 'preco' => 89.90, 'estoque' => 33, 'img' => 'yoga'],
            ],
            'Livros' => [
                ['nome' => 'Livro: Introdução à Programação', 'preco' => 79.90, 'estoque' => 25, 'destaque' => true, 'img' => 'book'],
                ['nome' => 'Livro: O Poder do Hábito', 'preco' => 49.90, 'promo' => 39.90, 'estoque' => 60, 'img' => 'book'],
                ['nome' => 'Livro: Uma Breve História da Humanidade', 'preco' => 59.90, 'estoque' => 45, 'img' => 'book'],
                ['nome' => 'Livro: Contos de Fadas Ilustrado', 'preco' => 44.90, 'estoque' => 38, 'img' => 'book'],
                ['nome' => 'Livro: Atlas Geográfico Escolar', 'preco' => 69.90, 'estoque' => 0, 'img' => 'atlas'],
            ],
            'Beleza e Cuidados' => [
                ['nome' => 'Kit Skincare Facial Completo', 'preco' => 159.90, 'promo' => 129.90, 'estoque' => 30, 'destaque' => true, 'img' => 'skincare'],
                ['nome' => 'Perfume Importado 100ml', 'preco' => 249.90, 'estoque' => 20, 'img' => 'perfume'],
                ['nome' => 'Secador de Cabelo Profissional', 'preco' => 189.90, 'promo' => 159.90, 'estoque' => 18, 'img' => 'hairdryer'],
                ['nome' => 'Escova Alisadora Térmica', 'preco' => 129.90, 'estoque' => 25, 'img' => 'hairstyle'],
                ['nome' => 'Kit Maquiagem Completo', 'preco' => 179.90, 'estoque' => 22, 'img' => 'makeup'],
            ],
            'Brinquedos e Jogos' => [
                ['nome' => 'Quebra-Cabeça 1000 Peças', 'preco' => 69.90, 'estoque' => 40, 'img' => 'puzzle'],
                ['nome' => 'Jogo de Tabuleiro Estratégia', 'preco' => 99.90, 'promo' => 79.90, 'estoque' => 25, 'destaque' => true, 'img' => 'boardgame'],
                ['nome' => 'Carrinho de Controle Remoto', 'preco' => 149.90, 'estoque' => 20, 'img' => 'toycar'],
                ['nome' => 'Boneca com Acessórios', 'preco' => 89.90, 'estoque' => 35, 'img' => 'doll'],
                ['nome' => 'Pelúcia Urso Gigante', 'preco' => 119.90, 'promo' => 99.90, 'estoque' => 15, 'img' => 'teddybear'],
            ],
            'Pet Shop' => [
                ['nome' => 'Ração Premium para Cães 15kg', 'preco' => 189.90, 'estoque' => 50, 'img' => 'dogfood'],
                ['nome' => 'Arranhador para Gatos', 'preco' => 99.90, 'estoque' => 24, 'img' => 'cat'],
                ['nome' => 'Cama Pet Confort', 'preco' => 129.90, 'promo' => 99.90, 'estoque' => 20, 'destaque' => true, 'img' => 'petbed'],
                ['nome' => 'Coleira Ajustável com Guia', 'preco' => 49.90, 'estoque' => 60, 'img' => 'dogcollar'],
                ['nome' => 'Brinquedo Mordedor Resistente', 'preco' => 29.90, 'estoque' => 0, 'img' => 'dogtoy'],
            ],
            'Papelaria e Escritório' => [
                ['nome' => 'Mochila para Notebook', 'preco' => 149.90, 'estoque' => 30, 'destaque' => true, 'img' => 'backpack'],
                ['nome' => 'Caderno Inteligente A5', 'preco' => 79.90, 'promo' => 59.90, 'estoque' => 45, 'img' => 'notebook'],
                ['nome' => 'Kit Canetas Coloridas 24 Cores', 'preco' => 39.90, 'estoque' => 70, 'img' => 'pens'],
                ['nome' => 'Organizador de Mesa em Bambu', 'preco' => 89.90, 'estoque' => 25, 'img' => 'desk'],
                ['nome' => 'Cadeira de Escritório Ergonômica', 'preco' => 599.90, 'promo' => 499.90, 'estoque' => 10, 'destaque' => true, 'img' => 'officechair'],
            ],
        ];
    }
}