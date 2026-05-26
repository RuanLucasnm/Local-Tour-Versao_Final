# Local Tour - Sistema de Pacotes de Viagem

Bem-vindo ao **Local Tour**, uma plataforma completa de pacotes de viagem desenvolvida com Laravel e SQLite.

## 🚀 Características

- **Landing Page** com carrossel de pacotes em destaque
- **Catálogo de Pacotes** com filtros por destino e preço
- **Detalhes do Pacote** com roteiro, descrição e avaliações
- **Sistema de Carrinho** com aplicação de cupons
- **Checkout Completo** com informações de pagamento
- **Autenticação de Usuários** com login e registro
- **Histórico de Reservas** para clientes
- **Sistema de Avaliações** (0 a 5 estrelas)
- **Painel Administrativo** para gerenciar pacotes, usuários e reservas
- **Banco de Dados Local (SQLite)** - 100% portátil

## 📋 Requisitos

- PHP 8.0 ou superior
- Composer
- Node.js (opcional, para frontend)

## 🔧 Instalação

### 1. Extrair o Projeto
```bash
unzip Projeto-Turismo-main.zip
cd Projeto-Turismo-main
```

### 2. Instalar Dependências
```bash
composer install
```

### 3. Configurar o Ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Executar Migrations e Seeds
```bash
php artisan migrate:fresh --seed
```

Isso criará:
- **Usuário Admin**: `admin@localtour.com` / `admin123`
- **Usuário Cliente**: `cliente@localtour.com` / `cliente123`
- **5 Cidades** com pacotes de exemplo
- **5 Pacotes de Viagem** para teste

### 5. Iniciar o Servidor
```bash
php artisan serve
```

O aplicativo estará disponível em `http://localhost:8000`

## 🎯 Como Usar

### Para Clientes
1. Acesse a **Landing Page** para ver pacotes em destaque
2. Navegue pelo **Catálogo** e filtre por destino ou preço
3. Clique em **Ver Detalhes** para mais informações
4. Adicione pacotes ao **Carrinho**
5. Aplique cupons (ex: `DESCONTO10` para 10% de desconto)
6. Faça **Login** ou **Registre-se**
7. Finalize a compra no **Checkout**
8. Acesse **Minhas Reservas** para ver seu histórico
9. Avalie os pacotes que você comprou

### Para Administradores
1. Faça login com: `admin@localtour.com` / `admin123`
2. Acesse o **Painel Admin** no menu
3. Gerencie:
   - **Pacotes**: Criar, editar, deletar
   - **Promoções**: Gerenciar cupons (em desenvolvimento)
   - **Usuários**: Listar e deletar
   - **Reservas**: Acompanhar vendas
   - **Avaliações**: Moderar comentários (em desenvolvimento)

## 📁 Estrutura do Projeto

```
Projeto-Turismo-main/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PacoteController.php
│   │   │   ├── ReservaController.php
│   │   │   ├── AvalicoesController.php
│   │   │   └── UserController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Pacote.php
│       ├── Reserva.php
│       ├── Avaliacao.php
│       ├── Cidade.php
│       └── Transporte.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite (banco de dados local)
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── pacote/
│       ├── carrinho/
│       ├── checkout/
│       ├── reservas/
│       └── admin/
├── routes/
│   └── web.php
└── .env
```

## 🔐 Segurança

- Senhas são criptografadas com bcrypt
- CSRF protection em todos os formulários
- Middleware de autenticação para áreas protegidas
- Middleware de admin para painel administrativo

## 💾 Banco de Dados

O projeto utiliza **SQLite** para máxima portabilidade. O arquivo `database/database.sqlite` contém:

- **users**: Usuários do sistema
- **cidade**: Cidades de destino
- **transporte**: Tipos de transporte
- **pacote**: Pacotes de viagem
- **reserva**: Reservas/Compras
- **avaliacao**: Avaliações de clientes

## 🎨 Customização

### Adicionar Novo Pacote
1. Acesse o Painel Admin
2. Clique em "Pacotes"
3. Clique em "+ Novo Pacote"
4. Preencha os dados e salve

### Adicionar Nova Cidade
Edite o arquivo `database/seeders/DatabaseSeeder.php` e execute:
```bash
php artisan migrate:fresh --seed
```

## 🐛 Troubleshooting

### Erro: "SQLSTATE[HY000]: General error: 1 no such table"
Execute as migrations:
```bash
php artisan migrate
```

### Erro: "Class not found"
Regenere o autoloader:
```bash
composer dump-autoload
```

### Porta 8000 já está em uso
Use outra porta:
```bash
php artisan serve --port=8001
```

## 📞 Suporte

Para dúvidas ou problemas, verifique:
1. Se o PHP está instalado: `php -v`
2. Se o Composer está instalado: `composer -v`
3. Se o banco de dados existe: `database/database.sqlite`

## 📝 Licença

Este projeto é fornecido como está para fins educacionais e comerciais.

---

**Desenvolvido por Ruan e Eduardo**

Versão: 1.0.0 | Última atualização: Maio 2026
# Local-Tour-Versao_Final
