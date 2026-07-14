# E-commerce Laravel


### Passo a Passo para Instalação

**1. Clone o Repositório:**
```bash
git clone git@github.com:seu-usuario/store-commerce.git
cd store-commerce
```

**2. Instalação de Dependências (Composer):**
A instalação usará o Composer do seu ambiente local (ou via container, caso já possua).
```bash
composer install
```

**3. Configuração de Variáveis e Banco de Dados (Resolução de Conflitos de Porta):**
Crie seu arquivo de ambiente local:
```bash
cp .env.example .env
```
Abra o arquivo `.env`. O Laravel Sail tenta subir o container do banco de dados expondo a porta `3306` na sua máquina. **Caso você já tenha um MySQL rodando localmente (usando a 3306), isso causará um erro.**

Para contornar isso, adicione ou modifique a variável `FORWARD_DB_PORT` no `.env` para usar uma porta alternativa (ex: `3307`). As conexões internas dos containers não serão afetadas.

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=store_commerce
DB_USERNAME=sail
DB_PASSWORD=password

# Altere a porta exposta na máquina host (sua máquina local) para evitar conflitos:
FORWARD_DB_PORT=3307
```

**4. Orquestração e Inicialização da Aplicação:**
Suba a infraestrutura completa de containers e realize o bootstrap do Laravel:
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan storage:link
```

**5. Compilação Front-end Moderno (HMR Ativo):**
Injeta o Tailwind e as animações GSAP em tempo real via Vite:
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev 
```

**6. Validação de Build:**
Execute a pipeline de testes para garantir a integridade do seu ambiente local recém-criado:
```bash
./vendor/bin/sail artisan test
```

> **Acesso**: A aplicação estará disponível em `http://localhost`.
