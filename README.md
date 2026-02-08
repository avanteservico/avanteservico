# 🏗️ Avante Serviço

Sistema web para gestão e controle de obras da construção civil.

## 📋 Sobre o Projeto

O **Avante Serviço** é um sistema completo de gerenciamento de obras que permite:

- ✅ Controle de obras e projetos
- 👥 Gestão de equipes e membros
- 📝 Gerenciamento de tarefas (Kanban)
- 💰 Controle financeiro (receitas, despesas e pagamentos)
- 📊 Relatórios e exportação de dados
- 📱 Interface responsiva (mobile-first)

## 🚀 Tecnologias Utilizadas

- **Backend:** PHP 8+
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Estilo:** Tailwind CSS
- **Arquitetura:** MVC (Model-View-Controller)

## 📦 Requisitos

- PHP 8.0 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx)
- Composer (opcional, para dependências futuras)

## ⚙️ Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/nerisfarias/avante_servico.git
cd avante_servico
```

### 2. Configure o banco de dados
1. Crie um banco de dados MySQL
2. Importe o arquivo `database.sql`:
   ```bash
   mysql -u seu_usuario -p nome_do_banco < database.sql
   ```

### 3. Configure a aplicação
1. Copie o arquivo de configuração:
   ```bash
   cp app/Config/config.example.php app/Config/config.php
   ```
2. Edite `app/Config/config.php` com suas credenciais do banco de dados

### 4. Configure o servidor web
- Se estiver usando XAMPP, coloque o projeto na pasta `htdocs`
- Acesse via navegador: `http://localhost/avante_servico`

## 📁 Estrutura do Projeto

```
avante_servico/
├── app/
│   ├── Controllers/     # Controladores da aplicação
│   ├── Models/          # Modelos de dados
│   ├── Views/           # Templates e páginas
│   └── Config/          # Arquivos de configuração
├── public/              # Arquivos públicos (CSS, JS, imagens)
├── database.sql         # Script do banco de dados
├── index.php            # Ponto de entrada da aplicação
└── README.md            # Este arquivo
```

## 👤 Acesso ao Sistema

Após a instalação, você pode criar um usuário administrador diretamente no banco de dados ou através da interface de cadastro.

## 🤝 Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para:

1. Fazer um fork do projeto
2. Criar uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abrir um Pull Request

## 📝 Licença

Este projeto é de uso privado.

## 📧 Contato

Para dúvidas ou sugestões, entre em contato através do GitHub.

---

Desenvolvido com ❤️ para facilitar a gestão de obras
