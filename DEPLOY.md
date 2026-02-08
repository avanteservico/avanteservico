# 🚀 Guia de Deploy no Railway

Este guia vai te ensinar a colocar seu projeto **Avante Serviço** online usando o Railway.

## 📋 O Que Você Vai Precisar

1. Conta no GitHub (você já tem ✅)
2. Conta no Railway (vamos criar juntos)
3. Seus arquivos já estão no GitHub (feito ✅)

---

## 🎯 Passo a Passo Completo

### 1️⃣ Criar Conta no Railway

1. Acesse: https://railway.app
2. Clique em **"Start a New Project"** ou **"Login"**
3. Escolha **"Login with GitHub"**
4. Autorize o Railway a acessar sua conta do GitHub
5. Pronto! Conta criada ✅

### 2️⃣ Criar Novo Projeto

1. No painel do Railway, clique em **"New Project"**
2. Escolha **"Deploy from GitHub repo"**
3. Selecione o repositório: **`nerisfarias/avante_servico`**
4. Clique em **"Deploy Now"**

O Railway vai começar a fazer o deploy automaticamente! 🎉

### 3️⃣ Adicionar Banco de Dados MySQL

1. No seu projeto do Railway, clique em **"+ New"**
2. Escolha **"Database"**
3. Selecione **"Add MySQL"**
4. Aguarde a criação (leva alguns segundos)

### 4️⃣ Configurar Variáveis de Ambiente

Agora você precisa conectar seu código ao banco de dados:

1. Clique no serviço do seu **aplicativo** (não no MySQL)
2. Vá na aba **"Variables"**
3. Clique em **"+ New Variable"** e adicione cada uma dessas:

```
DB_HOST = (copie do MySQL: MYSQLHOST)
DB_NAME = (copie do MySQL: MYSQLDATABASE)
DB_USER = (copie do MySQL: MYSQLUSER)
DB_PASS = (copie do MySQL: MYSQLPASSWORD)
DB_PORT = (copie do MySQL: MYSQLPORT)
APP_ENV = production
```

**Como copiar as variáveis do MySQL:**
- Clique no serviço **MySQL** no seu projeto
- Vá na aba **"Variables"**
- Copie os valores de `MYSQLHOST`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLPORT`
- Cole nas variáveis do seu aplicativo

4. Clique em **"Deploy"** para aplicar as mudanças

### 5️⃣ Importar o Banco de Dados

Agora você precisa criar as tabelas no banco de dados:

1. No serviço **MySQL**, vá na aba **"Data"**
2. Clique em **"Query"**
3. Abra o arquivo `database.sql` do seu projeto no computador
4. Copie todo o conteúdo
5. Cole na área de query do Railway
6. Clique em **"Run"**

Pronto! Suas tabelas foram criadas ✅

### 6️⃣ Acessar Seu Site

1. Clique no serviço do seu **aplicativo**
2. Vá na aba **"Settings"**
3. Em **"Domains"**, clique em **"Generate Domain"**
4. O Railway vai criar um link tipo: `seu-projeto.up.railway.app`
5. Clique no link para abrir seu site! 🎉

---

## 🔄 Como Atualizar o Site (Depois de Fazer Mudanças)

Sempre que você modificar o código no seu computador e quiser atualizar o site:

```bash
# 1. Preparar
git add .

# 2. Nomear
git commit -m "Descrição da mudança"

# 3. Enviar
git push
```

**O Railway detecta automaticamente** e faz o deploy da nova versão! 🚀

---

## ⚙️ Arquivos de Configuração Criados

Estes arquivos foram adicionados ao seu projeto para funcionar no Railway:

- **`railway.json`** - Configuração do Railway
- **`nixpacks.toml`** - Configuração do PHP
- **`.env.example`** - Template de variáveis de ambiente
- **`app/Config/config.php`** - Adaptado para usar variáveis de ambiente

---

## 🆘 Problemas Comuns

### Erro: "Application failed to respond"
- Verifique se as variáveis de ambiente estão corretas
- Certifique-se de que o banco de dados foi importado

### Erro: "Database connection failed"
- Verifique se copiou corretamente as variáveis do MySQL
- Confirme que o serviço MySQL está rodando

### Site não atualiza após fazer push
- Vá no Railway, aba "Deployments"
- Veja se o deploy foi bem-sucedido
- Verifique os logs em caso de erro

---

## 💰 Custos

O Railway oferece:
- **$5 de crédito grátis por mês** (suficiente para projetos pequenos)
- Depois disso, cobra por uso (aproximadamente $5-10/mês para projetos pequenos)

---

## ✅ Checklist Final

Antes de considerar o deploy completo, verifique:

- [ ] Projeto criado no Railway
- [ ] Banco de dados MySQL adicionado
- [ ] Variáveis de ambiente configuradas
- [ ] Arquivo `database.sql` importado
- [ ] Domínio gerado
- [ ] Site acessível e funcionando
- [ ] Login funcionando
- [ ] Dados sendo salvos corretamente

---

## 🎉 Parabéns!

Seu projeto agora está **online e acessível de qualquer lugar**! 🌍

Qualquer dúvida, consulte a documentação do Railway: https://docs.railway.app
