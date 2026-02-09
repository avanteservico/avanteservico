# 🚀 Guia Completo: Deploy no Render

## 📖 Índice
1. [O que é o Render?](#o-que-é-o-render)
2. [Por que usar o Render?](#por-que-usar-o-render)
3. [Passo a Passo Completo](#passo-a-passo-completo)
4. [Configuração do Banco de Dados](#configuração-do-banco-de-dados)
5. [Solução de Problemas](#solução-de-problemas)
6. [Próximos Passos](#próximos-passos)

---

## 🌐 O que é o Render?

O Render é uma plataforma de hospedagem moderna que permite colocar seu site na internet de forma simples e gratuita. Pense nele como um "Google Drive para sites" - você conecta seu código do GitHub e ele cuida do resto!

## ✅ Por que usar o Render?

- ✅ **100% Gratuito** para começar (plano free permanente)
- ✅ **Suporta PHP e MySQL** nativamente (perfeito para seu projeto!)
- ✅ **Deploy automático** - sempre que você fizer `git push`, o site atualiza sozinho
- ✅ **Interface simples** - muito mais fácil que outras plataformas
- ✅ **SSL grátis** - seu site terá HTTPS automaticamente
- ✅ **Sem cartão de crédito** necessário para começar

---

## 🎯 Passo a Passo Completo

### Passo 1: Criar Conta no Render

1. **Acesse:** https://render.com
2. Clique em **"Get Started for Free"** (Começar Grátis)
3. Escolha **"Sign up with GitHub"** (Cadastrar com GitHub)
4. **Autorize o Render** a acessar sua conta do GitHub
5. Pronto! Conta criada ✅

**Tempo:** 2 minutos

---

### Passo 2: Criar Banco de Dados MySQL

Antes de criar o site, vamos criar o banco de dados:

1. No painel do Render, clique em **"New +"** (no canto superior direito)
2. Selecione **"PostgreSQL"**

> ⚠️ **IMPORTANTE:** O Render oferece PostgreSQL gratuito, mas não MySQL gratuito. Temos 2 opções:
> 
> **Opção A (Recomendada):** Usar PostgreSQL gratuito do Render
> - Precisa adaptar o código (eu posso fazer isso para você)
> - Totalmente gratuito
> 
> **Opção B:** Usar MySQL externo gratuito
> - Usar FreeSQLDatabase.com ou db4free.net
> - Mantém o código como está
> - Pode ter limitações de performance

**Qual opção você prefere?** (Recomendo Opção A - PostgreSQL)

---

### Passo 3: Criar o Web Service (Seu Site)

1. No painel do Render, clique em **"New +"**
2. Selecione **"Web Service"**
3. Clique em **"Build and deploy from a Git repository"**
4. Clique em **"Next"**

5. **Conecte seu repositório:**
   - Procure por: `nerisfarias/avante_servico`
   - Clique em **"Connect"**

6. **Configure o serviço:**
   - **Name:** `avante-servico` (ou o nome que preferir)
   - **Region:** Escolha a mais próxima (ex: Ohio, USA)
   - **Branch:** `master`
   - **Root Directory:** (deixe vazio)
   - **Environment:** `PHP`
   - **Build Command:** `chmod +x build.sh && ./build.sh`
   - **Start Command:** `php -S 0.0.0.0:$PORT -t public`

7. **Escolha o plano:**
   - Selecione **"Free"** (Grátis)

8. Clique em **"Create Web Service"**

**Tempo:** 5 minutos

---

### Passo 4: Configurar Variáveis de Ambiente

Agora você precisa conectar seu site ao banco de dados:

1. No seu Web Service, vá na aba **"Environment"** (no menu lateral esquerdo)
2. Clique em **"Add Environment Variable"**
3. Adicione cada uma dessas variáveis:

#### Se você escolheu PostgreSQL (Opção A):

```
DB_HOST = (copie do PostgreSQL: Internal Database URL - apenas o host)
DB_NAME = (copie do PostgreSQL: Database)
DB_USER = (copie do PostgreSQL: Username)
DB_PASS = (copie do PostgreSQL: Password)
DB_PORT = 5432
APP_ENV = production
```

**Como copiar as variáveis do PostgreSQL:**
- Vá no serviço **PostgreSQL** que você criou
- Na aba **"Info"**, você verá:
  - **Internal Database URL:** `postgresql://usuario:senha@host:5432/database`
  - Extraia: host, database, username, password
- Cole nas variáveis do seu Web Service

#### Se você escolheu MySQL Externo (Opção B):

```
DB_HOST = (host do MySQL externo)
DB_NAME = (nome do banco)
DB_USER = (usuário)
DB_PASS = (senha)
DB_PORT = 3306
APP_ENV = production
```

4. Clique em **"Save Changes"**

O Render vai fazer o **redeploy automático** com as novas variáveis!

**Tempo:** 3 minutos

---

### Passo 5: Importar o Banco de Dados

#### Se você escolheu PostgreSQL:

1. Vá no serviço **PostgreSQL**
2. Clique na aba **"Shell"**
3. Conecte ao banco usando o comando que aparece lá
4. Execute os comandos SQL do seu `database.sql` (adaptados para PostgreSQL)

> 💡 **Dica:** Se precisar de ajuda para converter o SQL de MySQL para PostgreSQL, me avise!

#### Se você escolheu MySQL Externo:

1. Use o phpMyAdmin do serviço de MySQL externo
2. Importe o arquivo `database.sql` normalmente

**Tempo:** 5 minutos

---

### Passo 6: Acessar Seu Site Online! 🎉

1. Volte para o seu **Web Service**
2. No topo da página, você verá uma URL tipo:
   ```
   https://avante-servico.onrender.com
   ```
3. **Clique na URL** para abrir seu site!

**Parabéns! Seu site está na internet!** 🌍

---

## 🔄 Como Atualizar o Site (Depois de Fazer Mudanças)

Sempre que você modificar o código no seu computador:

```bash
# 1. Preparar
git add .

# 2. Nomear
git commit -m "Descrição da mudança"

# 3. Enviar
git push
```

**O Render detecta automaticamente** e faz o deploy da nova versão em 2-3 minutos! 🚀

---

## 🆘 Solução de Problemas

### ❌ Erro: "Build failed"

**Causa:** Problema no script de build

**Solução:**
1. Vá na aba **"Logs"** do seu Web Service
2. Veja qual linha deu erro
3. Verifique se o arquivo `build.sh` existe no GitHub

### ❌ Erro: "Application failed to respond"

**Causa:** Servidor PHP não está iniciando

**Solução:**
1. Verifique o **Start Command:** `php -S 0.0.0.0:$PORT -t public`
2. Certifique-se de que a pasta `public` existe no projeto

### ❌ Erro: "Database connection failed"

**Causa:** Variáveis de ambiente incorretas

**Solução:**
1. Vá na aba **"Environment"**
2. Verifique se todas as variáveis estão corretas
3. Copie novamente as credenciais do banco de dados
4. Salve e aguarde o redeploy

### ❌ Site demora muito para carregar (primeira vez)

**Causa:** No plano gratuito, o Render "dorme" o site após 15 minutos de inatividade

**Solução:**
- É normal! O primeiro acesso demora ~30 segundos
- Depois disso, fica rápido
- Para evitar isso, você pode:
  - Fazer upgrade para plano pago ($7/mês)
  - Usar um serviço de "ping" para manter o site ativo

---

## 💰 Custos

### Plano Gratuito (Free)
- ✅ **Custo:** $0/mês
- ✅ **Inclui:** 750 horas/mês (suficiente para 1 site)
- ✅ **PostgreSQL:** Grátis (até 1GB)
- ⚠️ **Limitação:** Site "dorme" após 15min de inatividade

### Plano Pago (Starter)
- 💵 **Custo:** $7/mês por serviço
- ✅ **Site sempre ativo** (não dorme)
- ✅ **Melhor performance**
- ✅ **Mais recursos**

---

## ✅ Checklist Final

Antes de considerar o deploy completo, verifique:

- [ ] Conta no Render criada
- [ ] Banco de dados criado (PostgreSQL ou MySQL externo)
- [ ] Web Service criado e conectado ao GitHub
- [ ] Variáveis de ambiente configuradas
- [ ] Banco de dados importado
- [ ] Site acessível pela URL do Render
- [ ] Login funcionando
- [ ] Dados sendo salvos corretamente

---

## 🎓 Resumo Rápido

1. **Criar conta** no Render (2min)
2. **Criar banco de dados** PostgreSQL (3min)
3. **Criar Web Service** conectando ao GitHub (5min)
4. **Configurar variáveis** de ambiente (3min)
5. **Importar banco** de dados (5min)
6. **Acessar site** online! 🎉

**Tempo total:** ~20 minutos

---

## 📚 Links Úteis

- **Render Dashboard:** https://dashboard.render.com
- **Documentação Oficial:** https://render.com/docs
- **Status do Render:** https://status.render.com
- **Suporte:** https://render.com/support

---

## 🤔 Precisa de Ajuda?

Se tiver qualquer dúvida durante o processo:

1. **Consulte a seção "Solução de Problemas"** acima
2. **Veja os logs** na aba "Logs" do Render
3. **Me chame** - estou aqui para ajudar!

---

## 🎉 Parabéns!

Seguindo este guia, seu projeto **Avante Serviço** estará online e acessível de qualquer lugar do mundo! 🌍

Boa sorte com o deploy! 🚀
