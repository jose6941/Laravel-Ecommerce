# 🛒 Heepzy Store — Documentação Completa do Projeto

> **Para quê serve este documento?**  
> Explicar de forma simples e completa como todo o código do projeto funciona.  
> Ideal para um desenvolvedor júnior que precisa apresentar ou dar manutenção no sistema.

---

## 📋 Índice

1. [Visão Geral](#1-visão-geral)
2. [Arquitetura do Projeto](#2-arquitetura-do-projeto)
3. [Banco de Dados (Migrations)](#3-banco-de-dados-migrations)
4. [Models (Modelos)](#4-models-modelos)
5. [Controllers (Controladores)](#5-controllers-controladores)
6. [Rotas (Routes)](#6-rotas-routes)
7. [Middleware](#7-middleware)
8. [Requests (Validação)](#8-requests-validação)
9. [Resources (API)](#9-resources-api)
10. [Providers (Provedores de Serviço)](#10-providers-provedores-de-serviço)
11. [Seeders (Dados de Exemplo)](#11-seeders-dados-de-exemplo)
12. [View Components (Componentes Blade)](#12-view-components-componentes-blade)
13. [Autenticação (Sanctum + Laravel Breeze)](#13-autenticação-sanctum--laravel-breeze)
14. [Políticas (Policies)](#14-políticas-policies)
15. [Views (Telas)](#15-views-telas)
16. [Estilização com Tailwind CSS](#16-estilização-com-tailwind-css)
17. [Animações com GSAP](#17-animações-com-gsap)
18. [Imagens dos Produtos (Pexels API)](#18-imagens-dos-produtos-pexels-api)
19. [Fluxo Completo do Carrinho ao Pedido](#19-fluxo-completo-do-carrinho-ao-pedido)
20. [Comandos Úteis](#20-comandos-úteis)

---

## 1. Visão Geral

**Heepzy Store** é uma loja virtual (e-commerce) completa construída com **Laravel 11** (PHP) e **Tailwind CSS** (CSS). O sistema permite:

- **Clientes**: navegar por produtos, buscar por nome ou categoria, ver detalhes, adicionar ao carrinho, finalizar compra (checkout), avaliar produtos, gerenciar endereços e perfil.
- **Administradores**: painel de controle com métricas, gerenciamento de produtos (CRUD).
- **Visitantes** (não logados): podem navegar no catálogo e adicionar itens ao carrinho (pela sessão).

### Tecnologias principais

| Tecnologia | Para que serve |
|---|---|
| **Laravel 11** | Framework PHP — estrutura todo o back-end (rotas, controllers, banco, etc.) |
| **Tailwind CSS 3** | Framework CSS — estiliza as páginas com classes utilitárias |
| **GSAP + ScrollTrigger** | Biblioteca JavaScript — animações profissionais de entrada e parallax |
| **MySQL** | Banco de dados relacional |
| **Laravel Sanctum** | Autenticação via tokens para a API |
| **Laravel Breeze** | Autenticação web (login, registro, senha) |
| **Pexels API** | API gratuita de fotos reais para as imagens dos produtos |
| **Alpine.js** | Framework JS leve para interações simples no front-end |

---

## 2. Arquitetura do Projeto

O projeto segue o padrão **MVC** (Model-View-Controller) do Laravel:

```
📁 app/
  ├── Http/
  │   ├── Controllers/    ← Lógica das páginas (controladores)
  │   ├── Middleware/      ← Filtros de requisição (ex: verificar admin)
  │   ├── Requests/       ← Validação de formulários
  │   └── Resources/      ← Formatação de dados para API
  ├── Models/             ← Representação das tabelas do banco
  ├── Providers/          ← Configurações de inicialização
  ├── Policies/           ← Regras de permissão (quem pode fazer o quê)
  └── View/Components/    ← Componentes Blade reutilizáveis
📁 database/
  ├── migrations/         ← Estrutura das tabelas (criação do banco)
  └── seeders/            ← Dados de exemplo para testes
📁 resources/views/       ← Templates HTML (Blade)
📁 routes/                ← Definição das rotas/URLs
📁 config/                ← Configurações do Laravel
```

---

## 3. Banco de Dados (Migrations)

As migrations são arquivos PHP que **criam e estruturam as tabelas** do banco.  
Quando você roda `php artisan migrate`, o Laravel executa esses arquivos em ordem.

### Tabelas do sistema:

| Tabela | Finalidade |
|---|---|
| `usuarios` | Usuários (clientes e administradores) |
| `categorias` | Categorias de produtos (ex: Eletrônicos, Moda) |
| `produtos` | Produtos do catálogo |
| `imagens_produto` | Imagens de cada produto (1 produto → várias fotos) |
| `avaliacoes` | Avaliações dos clientes sobre os produtos |
| `enderecos` | Endereços de entrega dos usuários |
| `carrinhos` | Carrinho de compras (1 por usuário ou sessão) |
| `itens_carrinho` | Itens dentro do carrinho |
| `pedidos` | Pedidos finalizados |
| `itens_pedido` | Itens dentro de cada pedido |
| `cupons` | Cupons de desconto |
| `cache` | Cache do Laravel (sistema) |
| `sessions` | Sessões dos usuários (sistema) |
| `jobs` | Filas de tarefas (sistema) |

### Destaques importantes:

**Tabela `usuarios`** — Usa o campo `senha` (não `password` como no Laravel padrão) e tem uma coluna `perfil` que pode ser `'cliente'` ou `'admin'`.

**Tabela `produtos`** — Tem `slug` único (usado nas URLs amigáveis, ex: `/produtos/tenis-preto`), `softDeletes` (exclusão lógica — o produto não é apagado de verdade, apenas marcado como deletado).

**Tabela `carrinhos`** — Pode pertencer a um usuário logado (`usuario_id`) ou a um visitante (`sessao_id` — identificador da sessão do navegador). Isso permite que visitantes usem o carrinho.

**Tabela `pedidos`** — Usa `uuid` como identificador público em vez do `id` numérico (para não expor quantos pedidos existem). O campo `endereco_entrega` é do tipo `json` porque guarda uma "fotografia" dos dados do endereço no momento da compra.

**Tabela `avaliacoes`** — Cada cliente só pode avaliar um produto 1 vez (unique `produto_id` + `usuario_id`). As avaliações precisam ser aprovadas (`aprovado` = false por padrão).

---

## 4. Models (Modelos)

Os Models são classes PHP que **representam as tabelas do banco**. Cada model permite fazer consultas, relacionamentos e lógica de negócio.

### Produto (`app/Models/Produto.php`)

```php
class Produto extends Model
{
    use HasFactory, SoftDeletes;
```

- **`HasFactory`** — Permite criar produtos de teste com `Produto::factory()`.
- **`SoftDeletes`** — Exclusão lógica (o registro fica no banco com uma data em `deleted_at`).

**Relacionamentos:**
- `categoria()` → Cada produto pertence a uma categoria
- `imagens()` → Um produto tem várias imagens (ordenadas por `ordem`)
- `avaliacoes()` → Um produto tem várias avaliações
- `avaliacoesAprovadas()` → Só as avaliações aprovadas (filtro `where('aprovado', true)`)
- `imagemPrincipal()` → A imagem principal (primeira que for `principal = true`)

**Atributos calculados:**
- `preco_final` → Retorna o preço promocional se existir, senão o preço normal

**Scopes (filtros prontos para consultas):**
- `ativo()` → `WHERE ativo = true`
- `destaque()` → `WHERE destaque = true`

**Slug automático:** Quando um produto é criado, o Laravel gera um slug único baseado no nome + 6 caracteres aleatórios.

### Usuario (`app/Models/Usuario.php`)

- A tabela se chama `usuarios` (não `users` como no Laravel padrão)
- O campo de senha se chama `senha` (não `password`)
- Método `getAuthPassword()` → Ensina o Laravel a usar o campo `senha` para autenticação
- `isAdmin()` → Verifica se o perfil é `'admin'`
- `getNameAttribute()` → Adapta o campo `nome` para funcionar com o Laravel Breeze

### Categoria (`app/Models/Categoria.php`)

- Suporta **subcategorias** através do campo `parent_id` (auto-relacionamento)
- `parent()` → Categoria pai
- `children()` → Subcategorias
- Escopo `nivelRaiz()` → Só categorias sem pai (categorias principais)

### Carrinho (`app/Models/Carrinho.php`)

- `usuario()` → Carrinho pode pertencer a um usuário
- Armazena `sessao_id` para visitantes não logados

### ItemCarrinho (`app/Models/ItemCarrinho.php`)

- Tabela `itens_carrinho` — cada item tem `produto_id`, `quantidade`, `preco_unitario`
- O preço é "fotografado" no momento em que o item é adicionado (não muda se o preço do produto mudar depois)
- Unique `[carrinho_id, produto_id]` — não permite o mesmo produto duplicado no carrinho (apenas incrementa quantidade)

### Pedido (`app/Models/Pedido.php`)

- Gera um `uuid` automaticamente na criação
- `endereco_entrega` é um campo JSON que guarda os dados do endereço no momento da compra
- Status: `pendente → pago → processando → enviado → entregue → cancelado`

### ItemPedido (`app/Models/ItemPedido.php`)

- Tabela `itens_pedido` — registra o nome do produto (`nome_produto`), preço, quantidade e total
- `produto_id` pode ser nulo se o produto for deletado depois (mas o nome fica salvo)

### Cupom (`app/Models/Cupom.php`)

- `tipo`: `'porcentagem'` (ex: 10% de desconto) ou `'fixo'` (ex: R$ 20 de desconto)
- `valido()` → Verifica se está ativo, não expirou e não atingiu o limite de usos
- `calcularDesconto($subtotal)` → Calcula o valor do desconto com base no tipo

### ImagemProduto (`app/Models/ImagemProduto.php`)

- `getUrlAttribute()` → Gera a URL correta da imagem:
  - Se for URL completa (http/https) → retorna direto (imagens de seeders)
  - Se for caminho relativo → gera URL com `asset('storage/' . $caminho)`

### Endereco (`app/Models/Endereco.php`)

- Armazena endereço de entrega com campos: CEP, rua, número, complemento, bairro, cidade, estado

---

## 5. Controllers (Controladores)

Os Controllers são a **lógica do sistema** — eles recebem requisições HTTP, processam dados e retornam respostas (geralmente views).

### InicioController (`InicioController.php`)

**Rota:** `/` (página inicial)

- Busca categorias ativas de nível raiz
- Busca produtos ativos com paginação (12 por página)
- Suporta filtro por **categoria** (`?categoria=...`) e **busca** (`?q=...`)
- Ordena por destaque primeiro, depois por data de criação
- Usa `withQueryString()` para manter os filtros na paginação

### ProdutoController (`ProdutoController.php`)

**Rotas:** `/produtos` e `/produtos/{slug}`

- `index()` → Lista todos os produtos com paginação (12/página), com filtros de categoria e busca
- `show()` → Exibe detalhes de um produto (carrega imagens, categoria, avaliações)
- `store()` → Cria um novo produto (usado pelo admin). Faz upload de imagens para `storage/app/public/produtos/`

### CarrinhoController (`CarrinhoController.php`)

**Rotas:** `/carrinho`

- `index()` → Mostra o carrinho atual
- `store($produto)` → Adiciona um produto ao carrinho (se já existir, incrementa quantidade)
- `update($item)` → Altera a quantidade de um item
- `destroy($item)` → Remove um item do carrinho

**Método privado `obterCarrinho()`:**
- Se o usuário está logado → busca carrinho pelo `usuario_id`
- Se não está logado → busca pelo `sessao_id` (ID da sessão do navegador)
- Se `criarSeNaoExistir = true` → cria um novo carrinho se não existir

**Segurança:** O método `garantirQueItemPertenceAoCarrinhoAtual()` impede que um usuário mexa em itens de carrinho de outro usuário.

### CheckoutController (`CheckoutController.php`)

**Rotas:** `/checkout` (GET = formulário, POST = finalizar)

- `index()` → Mostra a página de checkout (exige login)
- `store()` → Processa o pedido:
  1. Valida endereço e método de pagamento
  2. Calcula subtotal, desconto (cupom), frete e total
  3. Cria o pedido com os dados do carrinho
  4. Cria os itens do pedido (copia os dados do carrinho)
  5. Decrementa o estoque dos produtos
  6. Limpa o carrinho
  7. Redireciona para a página do pedido

**Transação:** Toda a lógica do pedido roda dentro de `DB::transaction()` para garantir que, se algo der errado, nada seja salvo pela metade.

### AdminProdutoController (`AdminProdutoController.php`)

**Rotas:** `/admin/produtos` (protegida por middleware IsAdmin)

- `index()` → Lista todos os produtos (inclusive inativos) com paginação
- `edit($produto)` → Formulário de edição
- `update($produto, $request)` → Atualiza o produto e opcionalmente faz upload de nova imagem

### PedidoController (`PedidoController.php`)

**Rota:** `/pedidos/{uuid}`

- `show($pedido)` → Exibe os detalhes de um pedido. Verifica se o pedido pertence ao usuário logado.

### AvaliacaoController (`AvaliacaoController.php`)

**Rota:** `POST /produtos/{slug}/avaliacoes` (exige login)

- `store($request, $produto)` → Cria uma avaliação com nota (1-5) e comentário opcional. A avaliação fica pendente de aprovação (`aprovado = false`).

### PainelController (`PainelController.php`)

**Rota:** `/admin` (exige perfil admin)

- `index()` → Mostra o dashboard administrativo com métricas: receita total, total de pedidos, produtos com estoque baixo.

### PerfilController (`PerfilController.php`)

- `edit()` → Exibe formulário de edição de perfil
- `update()` → Atualiza nome e email. Se o email mudar, marca como não verificado.
- `destroy()` → Exclui a conta do usuário (com confirmação de senha)

### EnderecoController (`EnderecoController.php`)

- `store()` → Cadastra novo endereço
- `destroy($endereco)` → Remove endereço (verifica se pertence ao usuário)

### Controllers de Autenticação (`Auth/`)

São os controllers padrão do **Laravel Breeze** adaptados:

| Controller | Função |
|---|---|
| `AuthenticatedSessionController` | Login e logout |
| `RegisteredUserController` | Cadastro de novos usuários |
| `PasswordController` | Alteração de senha (logado) |
| `NewPasswordController` | Redefinição de senha (esqueci) |
| `PasswordResetLinkController` | Envio de link de redefinição |
| `ConfirmablePasswordController` | Confirmação de senha para ações sensíveis |
| `VerifyEmailController` | Verificação de email |
| `EmailVerificationPromptController` | Tela "verifique seu email" |
| `EmailVerificationNotificationController` | Reenvio do link de verificação |

---

## 6. Rotas (Routes)

O arquivo `routes/web.php` define todas as URLs do site:

### Rotas Públicas (qualquer pessoa pode acessar)

```php
GET  /                          → InicioController@index     (home)
GET  /produtos                  → ProdutoController@index    (lista de produtos)
GET  /produtos/{produto:slug}   → ProdutoController@show     (detalhes do produto)
POST /produtos/{slug}/avaliacoes → AvaliacaoController@store  (avaliar)
```

### Rotas de Carrinho

```php
GET    /carrinho             → CarrinhoController@index
POST   /carrinho/{slug}      → CarrinhoController@store     (adicionar)
PATCH  /carrinho/item/{item}  → CarrinhoController@update   (atualizar qtd)
DELETE /carrinho/item/{item}  → CarrinhoController@destroy  (remover)
```

### Rotas Protegidas (exigem login — `middleware('auth')`)

```php
GET    /dashboard             → dashboard ou admin.dashboard
GET    /checkout              → CheckoutController@index
POST   /checkout              → CheckoutController@store
GET    /pedidos/{pedido:uuid} → PedidoController@show
POST   /enderecos             → EnderecoController@store
DELETE /enderecos/{endereco}   → EnderecoController@destroy
GET    /perfil                → PerfilController@edit
PATCH  /perfil                → PerfilController@update
DELETE /perfil                → PerfilController@destroy
```

### Rotas de Admin (exigem perfil admin)

```php
GET    /admin           → PainelController@index       (dashboard admin)
GET    /admin/produtos  → AdminProdutoController@index  (lista admin)
GET    /admin/produtos/create  → criar produto
POST   /admin/produtos         → salvar novo
GET    /admin/produtos/{id}/edit  → editar
PUT    /admin/produtos/{id}   → atualizar
DELETE /admin/produtos/{id}   → deletar
```

### Rotas de Autenticação (`routes/auth.php`)

**Para visitantes (guest):**
```php
GET  /registrar       → formulário de cadastro
POST /registrar       → processar cadastro
GET  /login           → formulário de login
POST /login           → processar login
GET  /esqueci-senha   → formulário de redefinição
POST /esqueci-senha   → enviar link
GET  /redefinir-senha/{token} → formulário com token
POST /redefinir-senha → salvar nova senha
```

**Para logados:**
```php
POST /logout          → sair
PUT  /senha           → atualizar senha
GET  /verificar-email → tela de verificação
POST /email/verificacao-notificacao → reenviar link
GET  /confirmar-senha → confirmar senha
```

### Rotas de API (`routes/api.php`)

```php
POST  /api/v1/auth/login      → login via API (Sanctum)
GET   /api/v1/products         → listar produtos (público)
GET   /api/v1/orders           → pedidos do usuário (autenticado)
```

---

## 7. Middleware

Middlewares são filtros executados **antes** de uma requisição chegar ao Controller.

### IsAdmin (`app/Http/Middleware/IsAdmin.php`)

```php
if (! $request->user() || ! $request->user()->isAdmin()) {
    abort(403, 'Acesso restrito à equipe administrativa.');
}
```

- Verifica se o usuário está logado E tem perfil `'admin'`
- Se não for admin → erro 403
- Aplicado nas rotas `/admin/*`

---

## 8. Requests (Validação)

As Request classes são responsáveis por validar os dados dos formulários.

### ProfileUpdateRequest

- Valida nome e email do perfil
- Verifica se o email é único (ignorando o próprio usuário)

### LoginRequest

- Valida email e senha
- **Rate limiting**: após 5 tentativas de login com erro, o usuário precisa esperar 1 minuto
- Usa o IP + email como chave para o limite

### CheckoutRequest

- Valida endereço, método de pagamento e cupom (opcional)
- Métodos aceitos: `pix`, `boleto`, `credit_card`

---

## 9. Resources (API)

Os Resources formatam os dados retornados pela API.

### ProductResource (`app/Http/Resources/ProductResource.php`)

```php
return [
    'id' => $this->id,
    'name' => $this->name,
    'price' => $this->final_price,
    'image' => $this->mainImage?->url,
];
```

- Usado na API (`/api/v1/products`)
- Retorna apenas os campos necessários (id, nome, preço e imagem)

---

## 10. Providers (Provedores de Serviço)

### AppServiceProvider

Registra componentes Blade e compartilha dados com as views:

```php
Blade::component('layouts.app', 'app-layout');
Blade::component('layouts.guest', 'guest-layout');
```

**View Composer:** Antes de renderizar o menu de navegação, o sistema consulta a **quantidade de itens no carrinho** e disponibiliza para o menu, evitando repetir essa consulta em cada controller.

```php
View::composer('layouts.navigation', function ($view) {
    // Busca carrinho do usuário logado ou da sessão
    // Envia $quantidadeCarrinho para a view
});
```

---

## 11. Seeders (Dados de Exemplo)

Os seeders preenchem o banco com dados para testes e desenvolvimento.

### DatabaseSeeder — Ordem de execução

```php
AdminUserSeeder   → Cria o admin (admin@acme.com.br / senha123)
UsuarioSeeder     → Cria 20 clientes de exemplo
CategorySeeder    → Cria 10 categorias (Eletrônicos, Moda, Casa, etc.)
ProductSeeder     → Cria 51 produtos com imagens reais
CouponSeeder      → Cria 7 cupons de desconto
```

### AdminUserSeeder

Cria o usuário administrador:
- Email: `admin@acme.com.br`
- Senha: `senha123`
- Perfil: `admin`

### CategorySeeder

Cria 10 categorias: Eletrônicos, Moda Masculina, Moda Feminina, Casa e Decoração, Esportes e Lazer, Livros, Beleza e Cuidados, Brinquedos e Jogos, Pet Shop, Papelaria e Escritório.

### ProductSeeder (o mais complexo!)

**Cria 51 produtos** distribuídos pelas 10 categorias. Cada produto recebe:

1. **3 fotos reais** buscadas da API do Pexels (fotos de produtos reais, não ilustrações)
2. **Avaliações** aleatórias de clientes (ponderadas: mais notas altas que baixas)
3. **Paleta de cores** específica da categoria

**Estratégia de imagens:**
1. Tenta buscar 3 fotos no Pexels pela palavra-chave do produto (ex: "sneakers product", "wireless headphones product")
2. Se a API falhar, gera **SVGs vetoriais profissionais** como fallback (51 ilustrações únicas)
3. As imagens são salvas em `storage/app/public/images/products/`

**Funcionalidades auxiliares:**
- `catalogo()` → Retorna um array com todos os 51 produtos organizados por categoria
- `gerarGaleriaDeImagens()` → Baixa as fotos do Pexels ou gera SVGs
- `buscarQueryPexels()` → Mapeia nome do produto → query de busca em inglês
- `gerarAvaliacoes()` → Cria avaliações aleatórias com comentários pré-definidos

### CouponSeeder

Cria 7 cupons, incluindo:
- `BEMVINDO10` — 10% de desconto
- `FRETE20` — R$ 20 de desconto
- `BLACKFRIDAY30` — 30% de desconto
- `PROMOANTIGA` — já expirado (para testar validação)
- `DESATIVADO5` — desativado (para testar validação)

---

## 12. View Components (Componentes Blade)

Os componentes são pedaços de HTML reutilizáveis.

### AppLayout

- Usado em todas as páginas internas (home, produtos, carrinho, etc.)
- Renderiza o layout completo: `<head>`, navbar, conteúdo (`{{ $slot }}`), footer

### GuestLayout

- Usado nas páginas de login e cadastro
- Layout mais simples, sem navbar

### product-card.blade.php (componente inline)

- Renderiza um card individual de produto (imagem, nome, categoria, preço, botão)
- Usado tanto na home quanto na página de produtos
- Exibe badge "NOVIDADE" se o produto for destaque
- Exibe "Esgotado" se o estoque for 0
- Mostra preço original com risco se houver promoção

---

## 13. Autenticação (Sanctum + Laravel Breeze)

### Autenticação Web (Breeze)

O Laravel Breeze fornece todo o fluxo de autenticação com Laravel:
- **Registro**: `/registrar` — cria usuário com nome, email e senha
- **Login**: `/login` — autentica com email + senha
- **Esqueci a senha**: envio de link de redefinição por email
- **Verificação de email**: o sistema suporta verificação, mas não é obrigatória
- **Confirmação de senha**: necessária para alterar email ou excluir conta

**Diferença importante:** O Laravel normalmente usa o campo `password`. Este projeto usa `senha`. Para isso:
- O model `Usuario` implementa `getAuthPassword()` que retorna `$this->senha`
- O login verifica com `Hash::check($request->senha, $usuario->senha)` (no AuthController da API)

**Redirecionamento pós-login:** 
- Admin → `/admin` (dashboard administrativo)
- Cliente → `/dashboard` (painel do cliente)

### Autenticação API (Sanctum)

Sanctum fornece **tokens de API** para aplicativos mobile ou terceiros:

```
POST /api/v1/auth/login
  → retorna { "token": "token_aqui" }
  
GET /api/v1/orders (header: Authorization: Bearer token)
  → retorna pedidos do usuário
```

O `AuthController.php` (em `app/Http/Controllers/AuthController.php`) é usado **apenas para API**, retornando tokens Sanctum.

### Proteção de rotas

- `middleware('auth')` → Exige que o usuário esteja logado
- `middleware('guest')` → Só pode acessar se NÃO estiver logado
- `middleware('auth:sanctum')` → Exige token Sanctum (API)
- `middleware(IsAdmin::class)` → Exige perfil admin

---

## 14. Políticas (Policies)

As políticas definem **quem pode fazer o quê**.

### ProductPolicy (`app/Policies/ProductPolicy.php`)

```php
viewAny(?Usuario $usuario) → true     // Catálogo público
create(Usuario $usuario)   → isAdmin() // Só admin cria produtos
update(Usuario $usuario)   → isAdmin() // Só admin edita produtos
```

---

## 15. Views (Telas)

As views estão em `resources/views/` e usam o template engine **Blade** do Laravel.

### Estrutura de diretórios

```
views/
├── admin/             ← Painel administrativo
│   ├── dashboard.blade.php      ← Métricas: receita, pedidos, estoque
│   └── produtos/
│       ├── index.blade.php      ← Lista de produtos (admin)
│       └── edit.blade.php       ← Formulário de edição
├── auth/              ← Páginas de autenticação
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   ├── confirm-password.blade.php
│   └── verify-email.blade.php
├── carrinho/          ← Carrinho de compras
│   └── index.blade.php
├── checkout/          ← Finalização de pedido
│   └── index.blade.php
├── pedidos/           ← Pedidos
│   └── show.blade.php
├── produtos/          ← Catálogo de produtos
│   ├── index.blade.php         ← Grade de produtos (público)
│   └── show.blade.php          ← Detalhes do produto
├── profile/           ← Perfil do usuário
│   └── edit.blade.php
├── components/        ← Componentes reutilizáveis
│   ├── product-card.blade.php  ← Card de produto
│   └── ... (navbar, dropdown, modal, etc.)
├── layouts/           ← Layouts base
│   ├── app.blade.php           ← Layout principal (com navbar e footer)
│   ├── guest.blade.php         ← Layout de login
│   └── navigation.blade.php    ← Menu de navegação
├── home.blade.php     ← Página inicial (completa)
├── welcome.blade.php  ← Página de boas-vindas
└── dashboard.blade.php ← Painel do cliente
```

### home.blade.php (página principal)

É a página mais complexa, contendo:

1. **Banner principal** (tênis) — fundo bege com imagem, texto e CTA
2. **Categorias** — botões para filtrar produtos por categoria
3. **Info Bar** — ícones com frete grátis, troca fácil, etc.
4. **Nova Coleção** — cabeçalho editorial + barra de busca
5. **Grade de produtos** — grid com 12 produtos/página e paginação
6. **Banner Relógio** — imagem full-width com parallax
7. **Banner Fone** — fundo branco com fone de ouvido e texto

**Animações GSAP estão integradas diretamente na view** (no final do arquivo, dentro de uma tag `<script>`).

---

## 16. Estilização com Tailwind CSS

O projeto usa **Tailwind CSS 3** com configuração personalizada em `tailwind.config.js`:

### Cores personalizadas

```js
colors: {
    primary: '#e2e8f0', // Prata/slate
    dark: '#0A0A0A',    // Preto quase absoluto
    light: '#F8F9FA',   // Quase branco
}
```

### Fontes

- `font-sans` → **Inter** (textos em geral)
- `font-display` → **Outfit** (títulos e cabeçalhos)

### Zoom global

No `<body>` do `app.blade.php`:
```html
<body style="zoom: 0.8;">
```

Isso reduz a escala geral da página em 80%, fazendo com que tudo pareça menor — uma escolha de design para dar uma aparência mais compacta.

---

## 17. Animações com GSAP

O projeto usa **GSAP (GreenSock Animation Platform)** com o plugin **ScrollTrigger** para animações profissionais.

### Onde está o código GSAP?

No final do arquivo **`home.blade.php`**, dentro de uma tag `<script>`.

### Funções principais

- `initGsapAnimations()` → Inicializa todas as animações quando GSAP e ScrollTrigger carregam
- `waitForGsap()` → Espera até 6 segundos pelo carregamento do GSAP, tentando a cada 200ms

### Animações do Banner Principal

1. **Background text "MADE"** → fade + zoom lento (2.2s)
2. **Itens do banner** (tagline, título, CTA) → sobem com stagger (0.2s entre cada)
3. **Imagem do tênis** → zoom + rotação + blur → clareia
4. **Scroll indicator** → fade in
5. **Floating contínuo** → o tênis "flutua" suavemente para sempre

### Animações do Banner Fone

Mesmo padrão: fade, stagger, floating contínuo + pulso de brilho

### Parallax em todos os 3 banners

Cada banner tem uma **timeline com scrub** que move o fundo e o elemento principal em direções opostas enquanto o usuário rola a página:

| Banner | Fundo (elemento) | Direção | Elemento principal | Direção |
|---|---|---|---|---|
| Principal | "MADE" | -18% (sobe) | Tênis | +8% (desce) |
| Relógio | Imagem | +20% (desce) | — | — |
| Fone | "SOUND" | -15% (sobe) | Fone | +8% (desce) |

### Scroll Animations

- **Fade-up sections**: seções com classe `gsap-fade-up` sobem 40px ao entrar na tela
- **Category chips**: botões de categoria sobem 15px com stagger
- **Product cards**: cards dos produtos sobem 80px com escala 0.92 → 1 e stagger de 0.12s

---

## 18. Imagens dos Produtos (Pexels API)

O sistema usa fotos **reais de produtos** do banco de imagens **Pexels**.

### Como funciona

1. O `ProductSeeder` chama `gerarGaleriaDeImagens()` para cada produto
2. O método `buscarQueryPexels()` mapeia o nome do produto para uma query em inglês (ex: "Camiseta Básica Algodão" → "white t-shirt product")
3. `baixarImagensPexels()` faz uma requisição HTTP para a API do Pexels:
   ```
   GET https://api.pexels.com/v1/search?query=...&per_page=3&orientation=square
   ```
4. As 3 fotos retornadas são baixadas e salvas em `storage/app/public/images/products/`
5. Se a API falhar, o sistema gera SVGs profissionais como fallback

### Chave da API

A chave está hardcoded no seeder (`ProductSeeder::PEXELS_API_KEY`). Em produção, o ideal seria mover para o arquivo `.env`.

### Tratamento de erros

O download é envolvido em um `try/catch` — se qualquer erro ocorrer (timeout, API fora do ar, etc.), o sistema simplesmente usa o fallback de SVGs sem quebrar.

---

## 19. Fluxo Completo do Carrinho ao Pedido

### 1. Navegação (qualquer um)

```
Usuário acessa / → vê produtos
Usuário clica em um produto → vê detalhes (fotos, descrição, avaliações)
```

### 2. Carrinho (qualquer um, até sem login)

```
Usuário clica em "Adicionar ao Carrinho"
  → CarrinhoController@store
  → Carrinho buscado por:
      - usuario_id (se logado)
      - sessao_id (se visitante)
  → Se o produto já existir no carrinho, aumenta a quantidade
  → Se não existir, cria um novo item

Usuário acessa /carrinho
  → Vê todos os itens com quantidades e preços
  → Pode alterar quantidade ou remover itens
```

### 3. Checkout (exige login)

```
Usuário clica em "Finalizar Compra"
  → Redirecionado para /login se não estiver logado

Usuário preenche endereço e método de pagamento
  → Pode cadastrar novo endereço
  → Pode aplicar cupom de desconto

Usuário confirma o pedido
  → CheckoutController@store:
      1. Valida dados
      2. Calcula subtotal, desconto, frete e total
      3. Cria Pedido com UUID único
      4. Cria ItensPedido (cópia dos dados)
      5. Decrementa estoque dos produtos
      6. Limpa o carrinho
      7. Redireciona para /pedidos/{uuid}
```

### 4. Pedido finalizado

```
Usuário vê confirmação com detalhes do pedido
Usuário pode avaliar os produtos comprados
  → POST /produtos/{slug}/avaliacoes
  → Avaliação fica pendente de aprovação
```

---

## 20. Comandos Úteis

### Primeira instalação

```bash
# Instalar dependências PHP
composer install

# Instalar dependências JS
npm install && npm run build

# Copiar configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Criar link simbólico para storage
php artisan storage:link
```

### Banco de dados

```bash
# Criar as tabelas
php artisan migrate

# Popular com dados de exemplo
php artisan db:seed

# Ou tudo de uma vez (limpa e recria):
php artisan migrate:fresh --seed
```

### Desenvolvimento

```bash
# Servidor de desenvolvimento
php artisan serve

# Compilar CSS/JS (fica observando mudanças)
npm run dev
```

### Cache

```bash
php artisan optimize:clear   # Limpa todos os caches
```

---

## Apêndice: Glossário

| Termo | Significado |
|---|---|
| **Blade** | Template engine do Laravel (arquivos `.blade.php`) |
| **Eloquent** | ORM do Laravel (como o PHP conversa com o banco) |
| **Scope** | Filtro pré-definido para consultas (ex: `Produto::ativo()`) |
| **Accessor** | Atributo calculado (ex: `$produto->preco_final`) |
| **Middleware** | Filtro executado antes do Controller |
| **Migration** | Arquivo que cria/modifica tabelas do banco |
| **Seeder** | Arquivo que popula o banco com dados de exemplo |
| **Route Model Binding** | Laravel busca automaticamente o model pela URL (ex: `{produto}` vira o objeto `Produto`) |
| **Stagger** | Animação em cascata (itens animam um após o outro) |
| **Scrub** | Animação ligada ao scroll (avança/volta conforme o usuário rola) |
| **Parallax** | Efeito onde elementos se movem em velocidades diferentes criando profundidade |
| **Sanctum** | Pacote de autenticação por tokens para APIs |
| **Soft Deletes** | Exclusão lógica (o registro não é apagado, só marcado como deletado) |

---

> **Dica para apresentação:** Comece pela visão geral, mostre o fluxo do carrinho (seção 19) que é o coração do e-commerce, e depois explique os detalhes de cada camada (Models → Controllers → Views). Use o diagrama de arquitetura (seção 2) como guia visual.
