# Ecommerce em Laravel

Este é um projeto completo de Ecommerce desenvolvido em Laravel, criado com foco em simplicidade, boas práticas e facilidade de manutenção. A estrutura foi pensada para ser direta, evitando camadas excessivas de abstração, ideal para apresentações técnicas.

## Tecnologias Utilizadas

- **PHP 8.2+**
- **Laravel 12**
- **Breeze (Autenticação)**
- **Banco de Dados Relacional** (MySQL / SQLite / PostgreSQL configurado via `.env`)
- **Sanctum** (Para tokens de API)

---

## Como Configurar e Rodar o Projeto

Siga os passos abaixo para iniciar o projeto localmente:

1. **Instale as dependências do PHP:**
   ```bash
   composer install
   ```

2. **Instale as dependências do Node (Frontend):**
   ```bash
   npm install
   npm run build
   ```

3. **Configure o ambiente:**
   Copie o arquivo `.env.example` para `.env` e configure os dados do seu banco de dados local.
   ```bash
   cp .env.example .env
   ```
   *Dica: Caso use SQLite, apenas crie o arquivo `database/database.sqlite` e configure o `DB_CONNECTION=sqlite` no `.env`.*

4. **Gere a chave da aplicação e rode as migrações:**
   Isso criará todas as tabelas no seu banco de dados de uma vez.
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Inicie o Servidor Local:**
   ```bash
   php artisan serve
   ```
   Acesse no navegador: `http://localhost:8000`

---

## Lógica e Arquitetura do Projeto

Para facilitar a sua apresentação, aqui está o resumo de como a lógica foi construída e estruturada:

### 1. Modelagem de Dados (Banco)
Todo o banco foi criado pensando num padrão semântico em português.
- **`usuarios` e `enderecos`**: Guardam os dados de quem está comprando e onde o pedido deve ser entregue.
- **`produtos`, `categorias`, `imagens_produto` e `avaliacoes`**: Organização do catálogo da loja. A categoria possui auto-relacionamento (uma categoria pode ter uma categoria pai).
- **`carrinhos` e `itens_carrinho`**: Registram o que o usuário quer comprar antes de finalizar.
- **`cupons`**: Sistema simples de descontos, permitindo valor fixo ou porcentagem.
- **`pedidos` e `itens_pedido`**: Registram o momento em que a compra é fechada. **Atenção aqui:** os itens do pedido possuem os preços "fotografados". Se o preço do produto original mudar depois, o valor pago no histórico do pedido não será alterado.

### 2. A Lógica do Carrinho
Centralizada no `CarrinhoController`.
Quando um usuário adiciona um produto:
- O sistema verifica se ele já tem um carrinho aberto.
- Se o produto já está lá, apenas aumenta a quantidade.
- Caso contrário, cria um novo item atrelando ao preço promocional (ou normal) do momento.
- Toda essa validação ocorre de forma direta para manter o fluxo fácil de entender, sem precisar navegar por várias camadas de "Services".

### 3. O Fluxo de Checkout (Finalização de Compra)
A lógica mais importante do e-commerce está no `CheckoutController`. 
Para garantir a integridade dos dados (como não deixar um pedido ser gerado sem baixar o estoque corretamente), utilizamos as **Transações de Banco de Dados (`DB::transaction`)**:
- O sistema calcula o subtotal com base nos itens.
- Valida o cupom de desconto (caso o usuário tenha inserido um).
- Cria o registro na tabela de `pedidos` (copiando os dados do endereço de entrega de forma definitiva para o pedido).
- Varre o carrinho, salva tudo em `itens_pedido` e, crucialmente, **diminui o estoque daquele produto**.
- Por fim, limpa o carrinho antigo do usuário.
- Se qualquer erro acontecer durante esse processo, a transação é desfeita de forma segura (Rollback) garantindo que nenhum dinheiro seja cobrado indevidamente ou produto fique travado.

### 4. Segurança Adotada
- **Proteção contra Mass Assignment:** Todos os Models usam as propriedades `$fillable` com rigor, para evitar que um usuário mal-intencionado force a injeção de parâmetros (como virar "admin" no meio do cadastro).
- **Validações Diretas:** Uso do Form Request Validation injetado, obrigando tipos certos (ex: quantidade mínima, textos e e-mails autênticos).
- **Autorização (Auth):** Áreas críticas como Checkout, Carrinho e Painel de Controle possuem Middlewares bloqueando o acesso de visitantes. O sistema sempre cruza o ID do usuário logado (`Auth::id()`) com o dono dos dados requeridos para barrar acessos indevidos.

---
*Este sistema foca no principal valor de um MVP: o fluxo limpo, seguro e funcional.*
