# Arquitetura E-commerce Laravel

Este documento contém as representações visuais e arquiteturais do nosso sistema de E-commerce, modelado em Laravel. Ele foi criado como um material de apoio definitivo para que desenvolvedores (júniores e plenos) possam entender e explicar o ecossistema com a propriedade de um Arquiteto de Soluções.

---

## 1. Fluxograma

```mermaid
graph TD
    classDef pain fill:#f9f9f9,stroke:#333,stroke-width:2px,color:#333;
    classDef success fill:#d4edda,stroke:#28a745,stroke-width:2px,color:#155724;
    classDef auth fill:#fff3cd,stroke:#ffc107,stroke-width:2px,color:#856404;
    
    A[Descoberta do Produto] -->|Catálogo e Filtros| B(Decisão de Compra)
    B -->|Adição ao Carrinho| C{Validação de Segurança}
    
    C -->|Não Autenticado| E[Redirecionamento p/ Login]
    E --> C
    
    C -->|Sessão Válida via Middleware| D[Checkout e Endereço]
    
    D -->|Integração de Pagamento| F[Persistência do Pedido]
    F -->|Processamento em Fila| G((Sucesso da Venda))

    class A,B,D pain;
    class C,E auth;
    class G success;
```

> *"Neste fluxo de valor, modelamos a jornada desde a **Descoberta do Produto** até a **Persistência do Pedido**. Utilizamos os **Middlewares de Autenticação** do Laravel para barrar requisições não autorizadas, protegendo os dados sensíveis. A persistência do pedido é atômica no banco de dados e ações demoradas ocorrem em Filas."*

---

## 2. Requisitos e Casos de Uso

O Diagrama de Casos de Uso abaixo ilustra os atores (humanos e sistemas) e as fronteiras dentro do ecossistema.

```mermaid
flowchart LR
    %% Atores da Esquerda
    Vis((Visitante))
    Cli((Cliente))

    %% Fronteira do Sistema (Caixa Central)
    subgraph Sistema [Sistema E-commerce]
        direction TB
        UC1([Explorar Catálogo])
        UC2([Gerenciar Carrinho])
        UC4([Finalizar Compra])
        UC3([Fazer Login])
        UC5([Acompanhar Pedidos])
        
        %% Inclusões (Dependencies) simulando o modelo fornecido
        UC2 -.->|<<include>>| UC1
        UC2 -.->|<<include>>| UC4
    end

    %% Atores da Direita (Serviços e Admin)
    Auth((Provedor de Identidade))
    Pay((Gateway de Pagamento))
    Adm((Administrador))

    %% Conexões dos Atores da Esquerda
    Vis --- UC1
    Vis --- UC2
    
    Cli --- UC2
    Cli --- UC4
    Cli --- UC3
    Cli --- UC5

    %% Conexões dos Atores da Direita
    UC1 --- Adm
    UC3 --- Auth
    UC4 --- Pay
```

> *"O Diagrama de Casos de Uso nos ajuda a entender as restrições e permissões do negócio. Observe que as funcionalidades de **Descoberta** e **Carrinho** estão abertas a Visitantes, maximizando nossas taxas de conversão inicial. O funil se fecha no **Checkout**, exigindo Autenticação para que o Cliente converse indiretamente com o Gateway de Pagamento, garantindo rastreabilidade. O Administrador possui uma fronteira totalmente isolada para gestão."*

### Contexto em Código: Etapas do Fluxo

**1. Descoberta do Produto:**
```php
// app/Http/Controllers/ProdutoController.php
public function index()
{
    $produtos = Produto::with('categoria')
        ->where('ativo', true)
        ->paginate(12);

    return view('produtos.index', compact('produtos'));
}
```

**2. Adição ao Carrinho**
```php
// app/Http/Controllers/CarrinhoController.php
public function store(Request $request)
{
    // Valida se o produto existe no banco e se a quantidade é um número válido (mínimo 1)
    $request->validate([
        'produto_id' => 'required|exists:produtos,id',
        'quantidade' => 'nullable|integer|min:1'
    ]);

    // Recupera o produto ou retorna erro 404 se não for encontrado
    $produto = Produto::findOrFail($request->produto_id);
    $quantidade = $request->input('quantidade', 1);

    // Impede a adição de itens se não houver estoque suficiente
    if ($quantidade > $produto->estoque) {
        return back()->with('error', 'Quantidade solicitada maior que o estoque disponível.');
    }
    
    // Busca o carrinho do usuário/sessão atual ou cria um novo caso não exista
    $carrinho = Carrinho::obterAtual(criarSeNaoExistir: true);

    // Verifica se este produto já está no carrinho atual
    $item = $carrinho->itens()->where('produto_id', $produto->id)->first();

    if ($item) {
        $item->increment('quantidade', $quantidade);
    } else {
        $carrinho->itens()->create([
            'produto_id' => $produto->id,
            'quantidade' => $quantidade,
            'preco_unitario' => $produto->preco_final,
        ]);
    }

    return redirect()->route('carrinho.index')->with('success', 'Produto adicionado ao carrinho.');
}
```

**Função de obter o carrinho**
```php
public static function obterAtual(bool $criarSeNaoExistir = false): ?self
{
    $usuario = Auth::user();
    $sessaoId = session()->getId();

    // Busca o carrinho pelo ID do usuário (se logado) ou pelo ID da sessão (se visitante)
    $carrinho = self::where(
        $usuario ? 'usuario_id' : 'sessao_id',
        $usuario ? $usuario->id : $sessaoId
    )->first();

    // Se não encontrar e for solicitado, cria um novo carrinho no banco
    if (!$carrinho && $criarSeNaoExistir) {
        $carrinho = self::create([
            'usuario_id' => $usuario?->id, 
            'sessao_id'  => $sessaoId,    
        ]);
    }

    return $carrinho;
}
```

**3. Validação e Persistência do Pedido (Transação Atômica):**
```php
// app/Http/Controllers/CheckoutController.php
public function store(Request $request)
{
    $request->validate([
        'endereco_id' => 'required|exists:enderecos,id',
        'metodo_pagamento' => 'required|string',
        'codigo_cupom' => 'nullable|string'
    ]);

    $usuario = $request->user();
    $carrinho = Carrinho::where('usuario_id', $usuario->id)->with('itens.produto')->first();

    if (! $carrinho || $carrinho->itens->isEmpty()) {
        return back()->with('error', 'O carrinho está vazio.');
    }

    $endereco = Endereco::where('usuario_id', $usuario->id)->findOrFail($request->endereco_id);

    try {
        // Inicia a transação no banco de dados. Se algo falhar aqui dentro, nada é salvo.
        $pedido = DB::transaction(function () use ($usuario, $carrinho, $endereco, $request) {
            
            // Calcula a soma de todos os itens usando o preço unitário guardado no carrinho
            $subtotal = $carrinho->itens->sum(fn ($item) => $item->preco_unitario * $item->quantidade);
            $desconto = 0;
            $cupom = null;

            // Tratamento do Cupom de Desconto (caso tenha sido enviado)
            if ($request->codigo_cupom) {
                // O lockForUpdate impede que outros processos alterem este cupom concorrentemente
                $cupom = Cupom::where('codigo', $request->codigo_cupom)
                    ->lockForUpdate()
                    ->first();

                if (! $cupom || ! $cupom->valido()) {
                    throw new \Exception('Cupom inválido ou expirado.');
                }

                $desconto = $cupom->calcularDesconto($subtotal);
                $cupom->increment('usos'); // Registra o uso do cupom
            }

            // Criação do cabeçalho do Pedido (com cópia física do endereço de entrega)
            $pedido = Pedido::create([
                'usuario_id' => $usuario->id,
                'cupom_id' => $cupom?->id,
                'subtotal' => $subtotal,
                'desconto' => $desconto,
                'frete' => 0,
                'total' => $subtotal - $desconto,
                'metodo_pagamento' => $request->metodo_pagamento,
                'endereco_entrega' => $endereco->only(['rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'cep']),
            ]);

            foreach ($carrinho->itens as $item) {
                // Bloqueia o produto no banco de dados para garantir consistência de estoque
                $produto = Produto::where('id', $item->produto_id)
                    ->lockForUpdate()
                    ->first();

                // Valida se ainda há estoque suficiente antes de finalizar
                if ($produto->estoque < $item->quantidade) {
                    throw new \Exception("Estoque insuficiente para \"{$produto->nome}\".");
                }

                // Cria o registro do item que pertence a este pedido específico
                $pedido->itens()->create([
                    'produto_id'     => $item->produto_id,
                    'nome_produto'   => $produto->nome,
                    'preco_unitario' => $item->preco_unitario,
                    'quantidade'     => $item->quantidade,
                    'total'          => $item->preco_unitario * $item->quantidade,
                ]);

                // Baixa o estoque do produto comprado
                $produto->decrement('estoque', $item->quantidade);
            }

            // Esvazia o carrinho do usuário
            $carrinho->itens()->delete();

            return $pedido;
        });
        
    } catch (\Exception $e) {
        // Se houver qualquer erro/exceção na transação, retorna com a mensagem de erro específica
        return back()->with('error', $e->getMessage());
    }

    return redirect()->route('pedidos.show', $pedido)->with('success', 'Pedido realizado!');
}

```

---

## 3. Modelo de Entidade-Relacionamento (MER)

Diagrama otimizado para evitar linhas cruzadas, com as entidades dispostas de forma hierárquica (do Domínio Principal até as tabelas Pivot).

```mermaid
erDiagram
    %% Relacionamentos Estruturados (Top-Down)
    USUARIOS ||--o{ ENDERECOS : "possui"
    USUARIOS ||--o| CARRINHOS : "tem ativo"
    USUARIOS ||--o{ PEDIDOS : "realiza"
    
    CATEGORIAS ||--o{ PRODUTOS : "agrupa"
    CATEGORIAS ||--o{ CATEGORIAS : "auto-relaciona (parent)"

    CARRINHOS ||--o{ ITENS_CARRINHO : "contém"
    PRODUTOS ||--o{ ITENS_CARRINHO : "adicionado em"
    
    PEDIDOS ||--o{ ITENS_PEDIDO : "contém"
    PRODUTOS ||--o{ ITENS_PEDIDO : "faz parte de"

    %% Estrutura das Entidades no Padrão MySQL Workbench
    USUARIOS {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        VARCHAR_255 nome
        VARCHAR_255 email "UNIQUE"
        TIMESTAMP email_verified_at "NULL"
        VARCHAR_255 senha
        ENUM_cliente_admin perfil "DEFAULT 'cliente'"
        VARCHAR_255 telefone "NULL"
        VARCHAR_100 remember_token "NULL"
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }
    
    ENDERECOS {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        BIGINT_UNSIGNED usuario_id FK
        VARCHAR_9 cep
        VARCHAR_255 rua "NULL"
        VARCHAR_50 numero "NULL"
        VARCHAR_255 complemento "NULL"
        VARCHAR_255 bairro "NULL"
        VARCHAR_255 cidade "NULL"
        VARCHAR_2 estado "NULL"
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    CATEGORIAS {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        VARCHAR_255 nome
        VARCHAR_255 slug "UNIQUE"
        TEXT descricao "NULL"
        BIGINT_UNSIGNED parent_id FK "NULL"
        TINYINT_1 ativo "DEFAULT 1"
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }
    
    PRODUTOS {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        BIGINT_UNSIGNED categoria_id FK
        VARCHAR_255 nome
        VARCHAR_255 slug "UNIQUE"
        VARCHAR_255 sku "UNIQUE"
        TEXT descricao "NULL"
        DECIMAL_10_2 preco
        DECIMAL_10_2 preco_promocional "NULL"
        INT_UNSIGNED estoque "DEFAULT 0"
        TINYINT_1 ativo "DEFAULT 1"
        TINYINT_1 destaque "DEFAULT 0"
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
        TIMESTAMP deleted_at "NULL"
    }
    
    CARRINHOS {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        BIGINT_UNSIGNED usuario_id FK "NULL"
        VARCHAR_255 sessao_id "NULL"
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }
    
    ITENS_CARRINHO {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        BIGINT_UNSIGNED carrinho_id FK
        BIGINT_UNSIGNED produto_id FK
        INT_UNSIGNED quantidade "DEFAULT 1"
        DECIMAL_10_2 preco_unitario
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    PEDIDOS {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        VARCHAR_255 uuid "UNIQUE"
        BIGINT_UNSIGNED usuario_id FK
        BIGINT_UNSIGNED cupom_id "NULL"
        ENUM_status status "DEFAULT 'pendente'"
        DECIMAL_10_2 subtotal
        DECIMAL_10_2 desconto "DEFAULT 0.00"
        DECIMAL_10_2 frete "DEFAULT 0.00"
        DECIMAL_10_2 total
        VARCHAR_255 metodo_pagamento "NULL"
        TIMESTAMP pago_em "NULL"
        JSON endereco_entrega
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }
    
    ITENS_PEDIDO {
        BIGINT_UNSIGNED_AUTO_INCREMENT id PK
        BIGINT_UNSIGNED pedido_id FK
        BIGINT_UNSIGNED produto_id FK "NULL"
        VARCHAR_255 nome_produto
        DECIMAL_10_2 preco_unitario
        INT_UNSIGNED quantidade
        DECIMAL_10_2 total
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }
```

> O **Usuário** é a entidade pivot, possuindo relacionamentos 1:N com Endereços e Pedidos, e 1:1 com o Carrinho. Os **Produtos não ligam direto aos Pedidos ou Carrinhos**. Utilizamos tabelas intermediárias (ItemPedido e ItemCarrinho). Isso é vital para o sistema financeiro, pois salvamos o `preco_unitario` no momento da venda, congelando o preço permanentemente para aquele pedido."*

### Contexto em Código: As Migrations do Projeto
Esta seção contém exatamente como as tabelas do MER foram construídas utilizando a *Schema Builder* do Laravel, ilustrando a aplicação de *Foreign Keys*, exclusão em cascata e atributos Snapshot.

#### 1. Entidades Base (Usuários, Categorias e Produtos)
```php
// database/migrations/0001_01_01_000000_create_users_table
Schema::create('usuarios', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('senha');
    $table->enum('perfil', ['cliente', 'admin'])->default('cliente');
    $table->string('telefone')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
```

```php
// database/migrations/2026_07_03_000846_create_categorias_table
Schema::create('categorias', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->string('slug')->unique();
    $table->text('descricao')->nullable();
    $table->foreignId('parent_id')->nullable()->constrained('categorias')->onDelete('cascade');
    $table->boolean('ativo')->default(true);
    $table->timestamps();
});
```

```php
// database/migrations/2026_07_03_001859_create_produtos_table
Schema::create('produtos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
    $table->string('nome');
    $table->string('slug')->unique();
    $table->string('sku')->unique();
    $table->text('descricao')->nullable();
    $table->decimal('preco', 10, 2);
    $table->decimal('preco_promocional', 10, 2)->nullable();
    $table->unsignedInteger('estoque')->default(0);
    $table->boolean('ativo')->default(true);
    $table->boolean('destaque')->default(false);
    $table->timestamps();
    $table->softDeletes(); 
});
```

#### 2. Entidades de Fluxo: Carrinho de Compras
```php
// database/migrations/2026_07_03_002842_create_carrinho_table
Schema::create('carrinhos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->cascadeOnDelete();
    $table->string('sessao_id')->nullable()->index(); // usado por visitantes
    $table->timestamps();
});

Schema::create('itens_carrinho', function (Blueprint $table) {
    $table->id();
    $table->foreignId('carrinho_id')->constrained('carrinhos')->cascadeOnDelete();
    $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
    $table->unsignedInteger('quantidade')->default(1);
    $table->decimal('preco_unitario', 10, 2); // preço no momento
    $table->timestamps();
    $table->unique(['carrinho_id', 'produto_id']); // não duplica o mesmo produto no carrinho
});
```

#### 3. Entidades de Consumação: Pedidos Financeiros
```php
// database/migrations/2026_07_03_003411_create_pedidos_table
Schema::create('pedidos', function (Blueprint $table) {
    $table->id();
    $table->string('uuid')->unique(); // identificador público (não mostra o id sequencial)
    $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
    $table->foreignId('cupom_id')->nullable();
    $table->enum('status', ['pendente', 'pago', 'processando', 'enviado', 'entregue', 'cancelado'])->default('pendente');
    $table->decimal('subtotal', 10, 2);
    $table->decimal('desconto', 10, 2)->default(0);
    $table->decimal('frete', 10, 2)->default(0);
    $table->decimal('total', 10, 2);
    $table->string('metodo_pagamento')->nullable();
    $table->timestamp('pago_em')->nullable();
    $table->json('endereco_entrega'); // snapshot do endereço no momento da compra
    $table->timestamps();
});

Schema::create('itens_pedido', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
    $table->foreignId('produto_id')->nullable()->constrained('produtos')->nullOnDelete();
    $table->string('nome_produto');   // nome do produto na hora da compra
    $table->decimal('preco_unitario', 10, 2);
    $table->unsignedInteger('quantidade');
    $table->decimal('total', 10, 2);
    $table->timestamps();
});
```

---

## 4. Autenticação e Controle de Acesso

Ela garante que apenas as pessoas certas acessem áreas sensíveis, como o fechamento da compra (Checkout) e o painel de gerenciamento (Admin).

> O visitante pode olhar os Produtos e encher o carrinho livremente. Mas, na hora de passar no caixa (Checkout), precisa fazer login. Se for um funcionário (Admin), ele ganha uma chave mestra para acessar a sala do estoque. Tudo isso é gerenciado pelos **Middlewares**, que filtram quem passa por qual porta de forma invisível e segura.

### Contexto em Código: Rotas, Middlewares e Controllers

**1. A Barreira das Rotas**

O login só é exigido a partir do checkout. Já a área administrativa fica aninhada dentro do grupo autenticado e ganha uma camada extra: o middleware `IsAdmin`.

```php
// routes/web.php

// Área pública
Route::get('/', [InicioController::class, 'index'])->name('home');
Route::resource('produtos', ProdutoController::class)->only(['index', 'show']);
Route::resource('carrinho', CarrinhoController::class)->only(['index', 'store', 'update', 'destroy']);

// Avaliar um produto exige login, mesmo estando na área pública
Route::resource('produtos.avaliacoes', AvaliacaoController::class)->only(['store'])
    ->middleware('auth');

// Apenas Usuários Logados
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : view('dashboard');
    })->name('dashboard');

    Route::resource('checkout', CheckoutController::class)->only(['index', 'store']);
    Route::resource('pedidos', PedidoController::class)->only(['show']);
    Route::resource('enderecos', EnderecoController::class)->only(['store', 'destroy']);

    Route::get('/perfil', [PerfilController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [PerfilController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [PerfilController::class, 'destroy'])->name('profile.destroy');

    // Apenas Administradores (auth + IsAdmin)
    Route::middleware([\App\Http\Middleware\IsAdmin::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', [PainelController::class, 'index'])->name('dashboard');
            Route::resource('produtos', AdminProdutoController::class)->only(['index', 'edit', 'update']);
        });
});
```

**2. O Middleware Personalizado**

O Laravel já traz o middleware `auth` pronto para verificar se a pessoa está logada. Mas para a área administrativa da loja, criamos um guarda próprio (`IsAdmin`), que consulta o método `isAdmin()` do próprio usuário.

```php
// app/Http/Middleware/IsAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Acesso restrito à equipe administrativa.');
        }

        return $next($request);
    }
}
```
