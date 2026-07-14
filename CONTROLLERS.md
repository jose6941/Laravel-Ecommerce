# Controllers do Projeto

Este documento foi criado para desmistificar o papel de cada Controller no nosso ecossistema. Vamos entender, de forma simples e didática, qual é a responsabilidade de cada um, como eles interagem com outras camadas, como Models, Views e como influenciam o cliente.

---

## 1. `ProdutoController` e `InicioController`

Faz a exibição de todos os produtos e categorias na página inicial e na página de produtos.
Eles são os responsáveis por buscar os produtos no banco de dados e enviá-los para as Views.

O `ProdutoController` não altera dados, apenas lê. A grande sacada aqui é a utilização do **Eager Loading**, que garante que a loja carregue rápido, buscando os produtos e suas categorias em uma única viagem ao banco de dados, evitando gargalos de performance, N+1 queries.

**Exemplo Prático de como as camadas conversam:**

```php
// app/Http/Controllers/ProdutoController.php
public function index()
{
    // O 'with' chama o relacionamento definido no Model Produto
    $produtos = Produto::with('categoria')
        ->where('ativo', true)
        ->paginate(12);

    return view('produtos.index', compact('produtos'));
}
```

```php
// app/Models/Produto.php
class Produto extends Model
{
    // O Model define que um Produto pertence a uma Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
```

```blade
<!-- resources/views/produtos/index.blade.php -->
<div class="grid grid-cols-4 gap-4">
    @foreach($produtos as $produto)
        <div class="card-produto">
            <h2>{{ $produto->nome }}</h2>
            <span class="tag-categoria">{{ $produto->categoria->nome }}</span> 
            <p>R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
        </div>
    @endforeach
</div>
```

O `InicioController` monta o **menu de categorias com uma imagem de fundo** para cada uma. Ele também é o controller que recebe a busca (`?q=`) e o filtro por categoria vindos da barra de navegação.

```php
// app/Http/Controllers/InicioController.php
public function index(Request $request)
{
    // Menu de categorias
    $categorias = Categoria::ativo()->nivelRaiz()->get()->each(function ($cat) {
        // Para cada categoria, escolhemos "o produto-vitrine" (o destaque)
        // e usamos a imagem principal dele como imagem de fundo do card.
        // O operador `?->` (nullsafe) evita erro quando a categoria está vazia
        // ou quando o produto ainda não tem imagem cadastrada.
        $cat->imagem_fundo = $cat->produtos()
            ->where('ativo', true)
            ->with('imagemPrincipal')
            ->orderBy('destaque', 'desc')
            ->first()?->imagemPrincipal?->url;
    });

    // Listagem de produtos
    $produtos = Produto::ativo()                                
        ->with(['categoria', 'imagemPrincipal', 'avaliacoesAprovadas']) 
        ->filtrar($request->categoria, $request->q)                
        ->orderBy('destaque', 'desc')                         
        ->orderBy('created_at', 'desc')                           
        ->paginate(12)
        ->withQueryString();                                       // Mantém ?q= e ?categoria= nos links da paginação

    return view('home', compact('produtos', 'categorias'));
}
```

**O que cada peça influencia no cliente final:**

| Trecho | Efeito prático na loja |
| --- | --- |
| `->filtrar($request->categoria, $request->q)` | É o que faz a barra de busca e os filtros funcionarem. A lógica do `LIKE`/`where` fica no **Model** (scope), então o Controller só repassa o que o usuário digitou. |
| `->orderBy('destaque', 'desc')` | Produtos marcados como destaque no painel admin sobem para o topo da home. É o "merchandising" da loja. |
| `->withQueryString()` | Sem isso, o cliente busca "tênis", clica na página 2 e **perde o filtro**, voltando a ver a loja inteira. |
| `with('avaliacoesAprovadas')` | Permite exibir a nota/estrelinhas no card sem disparar uma query por produto. |

> **Ponto de atenção honesto (débito técnico conhecido):**
> Enquanto a listagem de produtos é um exemplo de Eager Loading, o bloco do `->each()` nas categorias faz exatamente o oposto: ele executa **uma query por categoria** para descobrir a `imagem_fundo` (clássico N+1). Com 8 categorias são 8 queries extras; com 40, são 40.
> Isso funciona, mas não escala. O caminho natural de refatoração é mover essa responsabilidade para o Model, por exemplo com um relacionamento `hasOneThrough` de "produto em destaque" carregado via `with()`, ou cacheando a imagem de fundo da categoria. Fica registrado aqui para não ser "descoberto" em produção.

---

## 2. `CarrinhoController`

Mantem o estado do que o usuário quer comprar antes de finalizar o pedido.

### Lógica e Influência no Código

Este controller gerencia o fluxo de itens. Se o cliente clicar duas vezes para adicionar o mesmo tênis, ele não cria duas linhas repetidas no carrinho; ele intercepta a ação, identifica o item e apenas soma `+1` na quantidade da linha existente.

**Exemplo Prático:**

*O Controller gerencia a adição e quantificação inteligente:*
```php
// app/Http/Controllers/CarrinhoController.php
public function store(Request $request)
{
    // Tenta encontrar um carrinho com o ID do usuário ou o ID da Sessão local
    $carrinho = Carrinho::firstOrCreate([
        'usuario_id' => Auth::id(), 
        'sessao_id'  => Auth::check() ? null : session()->getId()
    ]);

    // Cria o item ou apenas atualiza a quantidade 
    $carrinho->itens()->updateOrCreate(
        ['produto_id' => $request->produto_id],
        [
            // Se o item já existir, o banco entende e soma a quantidade!
            'quantidade' => DB::raw("quantidade + {$request->quantidade}"),
        ]
    );

    return back()->with('sucesso', 'Produto adicionado ao seu carrinho!');
}
```

---

## 3. `CheckoutController`

Pega o carrinho de compras, valida os dados, congela os preços e gera o pedido final.  

Em vez de delegar para uma camada de serviço externa, o controller resolve o checkout de forma procedural e segura utilizando **Transações de Banco de Dados (`DB::transaction`)**. Isso garante o princípio do *Tudo ou Nada*: se a baixa de estoque falhar ou se o cupom for inválido, nenhuma alteração é persistida.

---

```php
// app/Http/Controllers/CheckoutController.php

class CheckoutController extends Controller
{
    // Exibe a tela de finalização de compra
    public function index(Request $request)
    {
        $carrinho = Carrinho::where('usuario_id',$request->user()->id)->with('itens.produto')->first();

        if (! $carrinho \vert{}\vert{}$carrinho->itens->isEmpty()) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        $enderecos = Endereco::where('usuario_id',$request->user()->id)->get();

        return view('checkout.index', compact('carrinho', 'enderecos'));
    }

    // Processa o fechamento do pedido
    public function store(Request $request)
    {
        // Validação local dos dados de entrega e pagamento
        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
            'metodo_pagamento' => 'required|string',
            'codigo_cupom' => 'nullable|string'
        ]);

        $usuario =$request->user();
        $carrinho = Carrinho::where('usuario_id',$usuario->id)->with('itens.produto')->first();

        if (! $carrinho \vert{}\vert{}$carrinho->itens->isEmpty()) {
            return back()->with('error', 'O carrinho está vazio.');
        }

        $endereco = Endereco::where('usuario_id', $usuario->id)->findOrFail($request->endereco_id);

        try {
            // Execução da Transação (Garante consistência total)
            $pedido = DB::transaction(function () use ($usuario,$carrinho, $endereco,$request) {
                $subtotal =$carrinho->itens->sum(fn ($item) =>$item->preco_unitario * $item->quantidade);$desconto = 0;
                $cupom = null;

                // Validação e cálculo do cupom de desconto
                if ($request->codigo_cupom) {
                    $cupom = Cupom::where('codigo',$request->codigo_cupom)->first();

                    if (! $cupom \vert{}\vert{} !$cupom->valido()) {
                        throw new \Exception('Cupom inválido ou expirado.');
                    }

                    $desconto = $cupom->calcularDesconto($subtotal);
                }

                // Criação do registro pedido com o Snapshot do endereço
                $pedido = Pedido::create([
                    'usuario_id' => $usuario->id,
                    'cupom_id' => $cupom?->id,
                    'subtotal' => $subtotal,
                    'desconto' => $desconto,
                    'frete' => 0,
                    'total' => $subtotal -$desconto,
                    'metodo_pagamento' => $request->metodo_pagamento,
                    'endereco_entrega' => $endereco->only(['rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'cep']),
                ]);

                // Criação dos itens do pedido com o "Snapshot" dos preços e baixa no estoque
                foreach ($carrinho->itens as $item) {$pedido->itens()->create([
                        'produto_id' => $item->produto_id,
                        'nome_produto' => $item->produto->nome,
                        'preco_unitario' => $item->preco_unitario, // Histórico de preço congelado aqui
                        'quantidade' => $item->quantidade,
                        'total' => $item->preco_unitario * $item->quantidade,
                    ]);

                    $item->produto()->decrement('estoque',$item->quantidade);
                }

                $carrinho->itens()->delete();

                return $pedido;
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('pedidos.show', $pedido)->with('success', 'Pedido realizado!');
    }
}

---

## 4. `PedidoController` e `PerfilController`: O Pós-Venda

Exibe os detalhes de um pedido específico de forma segura, garantindo que um cliente não possa visualizar o pedido de outro.

* O controller compara o `usuario_id` do pedido com o ID do usuário atualmente autenticado (`Auth::id()`). Se não forem idênticos, ele interrompe a requisição imediatamente disparando um erro **403 Forbidden** (`abort(403)`), impedindo que usuários furem a URL para espionar compras alheias.
* Usa o método `$pedido->load('itens')` para trazer os itens do pedido em uma única consulta subsequente, evitando o problema de performance de múltiplas queries ($N+1$) na renderização da View.

---

```php
public function show(Pedido $pedido){
    // Garante que o pedido pertence ao usuário logado
    if ($pedido->usuario_id !== Auth::id()) {
        abort(403);
    }

    // Carrega os relacionamentos necessários de forma eficiente
    $pedido->load('itens');

    return view('pedidos.show', compact('pedido'));
}

O PerfilController Gerencia o perfil do usuário autenticado, permitindo a exibição, atualização de dados cadastrais e a exclusão segura da conta do usuário. Este controller lida com operações diretas no cadastro do usuário ativo e implementa boas práticas de segurança e integridade de dados:

---

```php
// app/Http/Controllers/PerfilController.php

// Exibe o formulário de edição do perfil
public function edit(Request $request)
{
    return view('profile.edit', [
        'user' => $request->user(),
    ]);
}

public function update(Request $request){
    $usuario =$request->user();

    // Validação dos dados com regra de unicidade inteligente
    $validated =$request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required','string','lowercase','email','max:255',
        Rule::unique('usuarios')->ignore($usuario->id),],
    ]);

    // Mapeia os inputs do formulário para as colunas do banco
    $usuario->fill([
        'nome' => $validated['name'],
        'email' => $validated['email'],
    ]);

    // Se o e-mail foi alterado, remove a marcação de e-mail verificado
    if ($usuario->isDirty('email')) {$usuario->email_verified_at = null;}

    $usuario->save();

    return redirect()->route('profile.edit')->with('status', 'profile-updated');
}

public function destroy(Request $request){
     // Valida a senha atual em um "Error Bag" específico de deleção
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $usuario =$request->user();

    // Desloga o usuário e remove o registro
    Auth::logout();
    $usuario->delete();

    // Invalida a sessão atual e gera um novo token CSRF por segurança
    $request->session()->invalidate();$request->session()->regenerateToken();

    return redirect('/');
}

---

## 5. `PainelController`

Entrega os números que o dono da loja precisa ver ao abrir o sistema.

Ele usa funções de agregação (`sum`, `count`) direto no SQL. A diferença é brutal: `Pedido::all()->sum('total')` traria 50 mil pedidos para a memória do servidor; `Pedido::sum('total')` devolve **um único número** vindo do banco.

```php
// app/Http/Controllers/PainelController.php
public function index()
{
    $metricas = [
        'receita_total' => Pedido::whereIn('status', ['pago', 'entregue'])->sum('total'),
        'total_pedidos' => Pedido::count(),
        'produtos_estoque_baixo' => Produto::where('estoque', '<=', 5)->count(),
    ];

    return view('admin.dashboard', compact('metricas'));
}
```

**Influência no cliente (no caso, o lojista):** `produtos_estoque_baixo` é o que dispara o badge vermelho de "reponha isto agora". É a métrica que evita venda de produto inexistente — e, por consequência, o cancelamento e a reclamação do consumidor final.

**Pontos de evolução sugeridos:**
1. **O número 5 é um "magic number".** Ele deveria virar uma constante (`Produto::ESTOQUE_MINIMO`) ou um scope (`Produto::estoqueBaixo()`), para que a regra viva no Model e possa ser reutilizada em relatórios e alertas por e-mail.
2. **Proteção da rota.** Este controller expõe faturamento; a autorização (middleware `admin` / Gate) precisa estar garantida na definição da rota, já que não há checagem alguma dentro do método.
3. **Cache.** Em bases grandes, `sum()` sobre a tabela de pedidos a cada abertura do painel pesa. Um `Cache::remember` de poucos minutos resolve sem prejuízo de leitura.

---

## 6. `AdminProdutoController`

Permite que a equipe da loja liste, edite e atualize os produtos e suas imagens.

```php
// app/Http/Controllers/AdminProdutoController.php
public function index()
{
    // dispararia 20 queries só para escrever o nome da categoria em cada linha.
    $produtos = Produto::with('categoria')->latest()->paginate(20);
    return view('admin.produtos.index', compact('produtos'));
}

public function edit(Produto $produto)
{
    $categorias = Categoria::all();
    return view('admin.produtos.edit', compact('produto', 'categorias'));
}

public function update(UpdateProdutoRequest $request, Produto $produto)
{
    // safe() devolve apenas os campos que passaram pela validação;
    // except('imagem') remove o arquivo, que NÃO é uma coluna da tabela produtos
    $produto->update($request->safe()->except('imagem'));

    if ($request->hasFile('imagem')) {
        // Salva o arquivo no disco público (storage/app/public/produtos)
        $path = $request->file('imagem')->store('produtos', 'public');

        // Rebaixa a imagem principal antiga: só pode haver uma capa por produto.
        $produto->imagens()->update(['principal' => false]);

        // A nova imagem assume o posto de capa.
        $produto->imagens()->create([
            'caminho'  => $path,
            'principal' => true,
            'ordem'    => 1
        ]);
    }

    return redirect()->route('admin.produtos.index')->with('success', 'Produto atualizado com sucesso!');
}
```
