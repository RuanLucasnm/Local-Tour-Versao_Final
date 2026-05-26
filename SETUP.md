# 🚀 Guia Rápido de Instalação - Local Tour

## Pré-requisitos
- PHP 8.0+
- Composer
- Git (opcional)

## Instalação em 5 Passos

### 1️⃣ Extrair o Projeto
```bash
unzip Projeto-Turismo-main.zip
cd Projeto-Turismo-main
```

### 2️⃣ Instalar Dependências
```bash
composer install
```

### 3️⃣ Configurar Ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Preparar Banco de Dados
```bash
php artisan migrate:fresh --seed
```

> Se existir o arquivo `database/database.sqlite`, o projeto usa SQLite automaticamente (sem precisar ajustar `DB_CONNECTION`).

### 5️⃣ Iniciar Servidor
```bash
php artisan serve
```

## ✅ Pronto!

Acesse: **http://localhost:8000**

## 👤 Credenciais de Teste

### Admin
- Email: `admin@localtour.com`
- Senha: `admin123`

### Cliente
- Email: `cliente@localtour.com`
- Senha: `cliente123`

## 🎯 Próximos Passos

1. Explore a **Landing Page**
2. Navegue pelo **Catálogo de Pacotes**
3. Teste o **Carrinho de Compras**
4. Faça **Login** e **Checkout**
5. Acesse o **Painel Admin** para gerenciar

## 🆘 Problemas?

**Erro na instalação?**
```bash
composer dump-autoload
php artisan cache:clear
php artisan config:clear
```

**Banco de dados corrompido?**
```bash
php artisan migrate:fresh --seed
```

**Porta 8000 em uso?**
```bash
php artisan serve --port=8001
```

---

**Desenvolvido com ❤️ para Local Tour**
