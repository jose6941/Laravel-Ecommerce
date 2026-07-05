<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Comentários de exemplo usados nas avaliações, agrupados pela nota
     * dada (1 a 5 estrelas) para soarem coerentes.
     */
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

                $this->gerarGaleriaDeImagens($produto, $slug);
                $this->gerarAvaliacoes($produto, $clientes);
            }
        }
    }

    /**
     * Gera uma galeria com 3 imagens de demonstração para o produto,
     * usando um serviço de placeholder com URL completa e determinística
     * (mesma semente = mesma imagem em toda nova execução da seeder).
     */
    private function gerarGaleriaDeImagens(Produto $produto, string $slug): void
    {
        // Remove imagens antigas para a seeder poder ser executada novamente
        // sem duplicar registros.
        $produto->imagens()->delete();

        for ($i = 0; $i < 3; $i++) {
            $produto->imagens()->create([
                'caminho' => "https://picsum.photos/seed/{$slug}-{$i}/800/800",
                'principal' => $i === 0,
                'ordem' => $i,
            ]);
        }
    }

    /**
     * Gera de 0 a 5 avaliações aprovadas por clientes distintos, com nota
     * e comentário coerentes entre si.
     */
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

    /**
     * Sorteia uma nota de 1 a 5 com maior probabilidade para notas altas,
     * como costuma acontecer em avaliações reais de e-commerce.
     */
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
     * @return array<string, array<int, array{nome: string, preco: float, promo?: float|null, estoque: int, destaque?: bool, descricao?: string}>>
     */
    private function catalogo(): array
    {
        return [
            'Eletrônicos' => [
                ['nome' => 'Fone de Ouvido Bluetooth TWS', 'preco' => 199.90, 'promo' => 149.90, 'estoque' => 40, 'destaque' => true],
                ['nome' => 'Smartwatch Sport Pro', 'preco' => 349.90, 'estoque' => 25, 'destaque' => true],
                ['nome' => 'Caixa de Som Portátil à Prova d\'Água', 'preco' => 179.90, 'promo' => 139.90, 'estoque' => 30],
                ['nome' => 'Carregador Portátil 20000mAh', 'preco' => 99.90, 'estoque' => 60],
                ['nome' => 'Mouse Gamer RGB', 'preco' => 129.90, 'promo' => 99.90, 'estoque' => 0],
                ['nome' => 'Teclado Mecânico Compacto', 'preco' => 259.90, 'estoque' => 18],
            ],
            'Moda Masculina' => [
                ['nome' => 'Camiseta Básica Algodão', 'preco' => 59.90, 'estoque' => 80, 'destaque' => true],
                ['nome' => 'Calça Jeans Slim', 'preco' => 149.90, 'promo' => 119.90, 'estoque' => 45],
                ['nome' => 'Jaqueta Corta-Vento', 'preco' => 189.90, 'estoque' => 20],
                ['nome' => 'Tênis Casual em Couro', 'preco' => 229.90, 'promo' => 189.90, 'estoque' => 15, 'destaque' => true],
                ['nome' => 'Bermuda em Tactel', 'preco' => 79.90, 'estoque' => 50],
            ],
            'Moda Feminina' => [
                ['nome' => 'Vestido Midi Floral', 'preco' => 139.90, 'estoque' => 35, 'destaque' => true],
                ['nome' => 'Blusa de Tricô', 'preco' => 89.90, 'promo' => 69.90, 'estoque' => 40],
                ['nome' => 'Legging Fitness', 'preco' => 69.90, 'estoque' => 55],
                ['nome' => 'Bolsa Transversal Couro Sintético', 'preco' => 159.90, 'promo' => 129.90, 'estoque' => 22],
                ['nome' => 'Sandália Rasteira', 'preco' => 99.90, 'estoque' => 0],
            ],
            'Casa e Decoração' => [
                ['nome' => 'Luminária de Mesa LED', 'preco' => 89.90, 'estoque' => 30],
                ['nome' => 'Jogo de Panelas Antiaderente 5 Peças', 'preco' => 249.90, 'promo' => 199.90, 'estoque' => 20, 'destaque' => true],
                ['nome' => 'Kit Organizadores de Gaveta', 'preco' => 49.90, 'estoque' => 70],
                ['nome' => 'Difusor de Aromas Elétrico', 'preco' => 79.90, 'promo' => 59.90, 'estoque' => 35],
                ['nome' => 'Manta de Sofá Soft', 'preco' => 99.90, 'estoque' => 28],
            ],
            'Esportes e Lazer' => [
                ['nome' => 'Bola de Futebol Oficial', 'preco' => 129.90, 'estoque' => 40],
                ['nome' => 'Kit Halteres Emborrachados 10kg', 'preco' => 199.90, 'promo' => 169.90, 'estoque' => 15, 'destaque' => true],
                ['nome' => 'Bicicleta Aro 29', 'preco' => 1299.90, 'promo' => 1099.90, 'estoque' => 8, 'destaque' => true],
                ['nome' => 'Corda de Pular Profissional', 'preco' => 39.90, 'estoque' => 90],
                ['nome' => 'Tapete de Yoga Antiderrapante', 'preco' => 89.90, 'estoque' => 33],
            ],
            'Livros' => [
                ['nome' => 'Livro: Introdução à Programação', 'preco' => 79.90, 'estoque' => 25, 'destaque' => true],
                ['nome' => 'Livro: O Poder do Hábito', 'preco' => 49.90, 'promo' => 39.90, 'estoque' => 60],
                ['nome' => 'Livro: Uma Breve História da Humanidade', 'preco' => 59.90, 'estoque' => 45],
                ['nome' => 'Livro: Contos de Fadas Ilustrado', 'preco' => 44.90, 'estoque' => 38],
                ['nome' => 'Livro: Atlas Geográfico Escolar', 'preco' => 69.90, 'estoque' => 0],
            ],
            'Beleza e Cuidados' => [
                ['nome' => 'Kit Skincare Facial Completo', 'preco' => 159.90, 'promo' => 129.90, 'estoque' => 30, 'destaque' => true],
                ['nome' => 'Perfume Importado 100ml', 'preco' => 249.90, 'estoque' => 20],
                ['nome' => 'Secador de Cabelo Profissional', 'preco' => 189.90, 'promo' => 159.90, 'estoque' => 18],
                ['nome' => 'Escova Alisadora Térmica', 'preco' => 129.90, 'estoque' => 25],
                ['nome' => 'Kit Maquiagem Completo', 'preco' => 179.90, 'estoque' => 22],
            ],
            'Brinquedos e Jogos' => [
                ['nome' => 'Quebra-Cabeça 1000 Peças', 'preco' => 69.90, 'estoque' => 40],
                ['nome' => 'Jogo de Tabuleiro Estratégia', 'preco' => 99.90, 'promo' => 79.90, 'estoque' => 25, 'destaque' => true],
                ['nome' => 'Carrinho de Controle Remoto', 'preco' => 149.90, 'estoque' => 20],
                ['nome' => 'Boneca com Acessórios', 'preco' => 89.90, 'estoque' => 35],
                ['nome' => 'Pelúcia Urso Gigante', 'preco' => 119.90, 'promo' => 99.90, 'estoque' => 15],
            ],
            'Pet Shop' => [
                ['nome' => 'Ração Premium para Cães 15kg', 'preco' => 189.90, 'estoque' => 50],
                ['nome' => 'Arranhador para Gatos', 'preco' => 99.90, 'estoque' => 24],
                ['nome' => 'Cama Pet Confort', 'preco' => 129.90, 'promo' => 99.90, 'estoque' => 20, 'destaque' => true],
                ['nome' => 'Coleira Ajustável com Guia', 'preco' => 49.90, 'estoque' => 60],
                ['nome' => 'Brinquedo Mordedor Resistente', 'preco' => 29.90, 'estoque' => 0],
            ],
            'Papelaria e Escritório' => [
                ['nome' => 'Mochila para Notebook', 'preco' => 149.90, 'estoque' => 30, 'destaque' => true],
                ['nome' => 'Caderno Inteligente A5', 'preco' => 79.90, 'promo' => 59.90, 'estoque' => 45],
                ['nome' => 'Kit Canetas Coloridas 24 Cores', 'preco' => 39.90, 'estoque' => 70],
                ['nome' => 'Organizador de Mesa em Bambu', 'preco' => 89.90, 'estoque' => 25],
                ['nome' => 'Cadeira de Escritório Ergonômica', 'preco' => 599.90, 'promo' => 499.90, 'estoque' => 10, 'destaque' => true],
            ],
        ];
    }
}
