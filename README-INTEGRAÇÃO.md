# 🌱 AgroTec — Plataforma para Apoio a Pequenas Empresas Rurais

Bem-vindo ao repositório do **Projeto AgroTec**, um sistema web desenvolvido com foco em ajudar **pequenas empresas e agricultores familiares** a organizarem e apresentarem seus produtos de forma simples, eficiente e acessível.

Este projeto é parte do curso **TSI — Tecnologia em Sistemas para Internet** do **Instituto Federal de Brasília (IFB)**.

## 👥 Integrantes da Equipe

* **Pedro Neto**
* **Felipe Dias**
* **Endryo Matos**
* **Felipe Madson**

## 🏢 Instituição

**Instituto Federal de Brasília — IFB**

## 🚀 Tecnologias Utilizadas

O AgroTec foi desenvolvido usando:

* **HTML** — Estrutura das páginas
* **CSS** — Estilização do layout
* **JavaScript** — Interatividade do front-end
* **PHP** — Lógica de negócio e comunicação com o banco de dados
* **MySQL** — Banco de dados

---

# 📁 Estrutura Completa do Projeto

A organização do projeto segue um padrão profissional para facilitar manutenção, escala e entendimento de novos colaboradores.

```
PROJETO-AGROTEC/
│
└── src/
    │
    ├── views/                    ← Páginas que o usuário vê (HTML/PHP)
    │     index.php
    │     login.php
    │     cadastro.php
    │     redefinir-senha.php
    │     selecionarLocal.php
    │     vendedor.php
    │     verificar.php
    │     img/                   ← Páginas PHP específicas
    │         galeria.php
    │         carro.php
    │
    ├── controllers/             ← Processamento e regras de negócio
    │     loginController.php
    │     cadastroController.php
    │     verificarController.php
    │     compraController.php
    │
    ├── includes/                ← Trechos reutilizáveis
    │     header.php
    │     footer.php
    │     menu.php
    │     auth.php
    │
    ├── config/                  ← Configurações gerais
    │     db.php
    │     logs/
    │     database/
    │         agrotech.sql       ← Schema do banco de dados
    │         migrate_add_preco.sql
    │
    └── public/                  ← Arquivos acessíveis pelo navegador
          └── assets/
              ├── css/
              ├── js/
              └── img/
```

### ✨ O que significa cada pasta

* **views/** — Telas do sistema e páginas PHP que exibem conteúdo.
* **controllers/** — Arquivos responsáveis pela lógica e ações do usuário.
* **includes/** — Cabeçalho, rodapé, menus e códigos repetidos.
* **config/** — Conexão com banco, migrações e logs.
* **public/** — Arquivos acessados pelo navegador (CSS, JS, imagens).
* **assets/** — Organização interna dentro do public.

---

# 🔧 Integração PHP — AgroTec (carrot)

Resumo dos arquivos responsáveis pela integração dinâmica com MySQL:

* **db.php** — Conexão PDO com MySQL.
* **carrot.php** — Página dinâmica que retorna dados do produto "Cenoura".
* **add_to_cart.php** — Gerencia itens do carrinho usando sessões.
* **buy.php** — Realiza vendas, insere itens e atualiza estoque.
* **migrate_add_preco.sql** — Adiciona coluna `preco` à tabela produtos.

---

# 🖥️ Como rodar o projeto localmente (Windows — XAMPP)

## 1. Instalar o XAMPP

Baixe e instale: [https://www.apachefriends.org/](https://www.apachefriends.org/)

## 2. Colocar o projeto no htdocs

Coloque a pasta **PROJETO-AGROTEC** dentro de:

```
C:/xampp/htdocs/agrotec
```

## 3. Iniciar servidores

Abra o painel do XAMPP e clique em:

* ✔ Apache
* ✔ MySQL

## 4. Importar o banco de dados

No phpMyAdmin:

* Crie um banco chamado `agrotech`
* Importe **agrotech.sql**
* Caso necessário, execute **migrate_add_preco.sql**

## 5. Acessar no navegador

```
http://localhost/agrotec/index.php
```

---

# 🌐 Como rodar usando o GitHub Pages

> ⚠ GitHub Pages só funciona com HTML/CSS/JS.
> Arquivos PHP **não rodam** no GitHub Pages.

Mesmo assim, você pode usar o Pages para a parte visual (HTML/CSS/JS):

## 1. Baixe o repositório (ZIP ou git clone)

```
git clone https://github.com/seuUsuario/seuRepositorio.git
```

## 2. Coloque os arquivos estáticos (HTML/CSS/JS) na raiz do repositório

Exemplo:

```
/index.html
/assets/css/
/assets/js/
/assets/img/
```

## 3. Vá ao GitHub → Settings → Pages

* Build from: **Main Branch**
* Pasta: **root**

## 4. GitHub gera um link como:

```
https://seuUsuario.github.io/seuRepositorio/
```

---

# 🔥 Como ver o site funcionando pelo VSCode (Live Server)

1. Instale a extensão **Live Server**.
2. Clique com botão direito no arquivo `index.php` ou `index.html`.
3. Se for HTML: **Open with Live Server**.
4. Se for PHP: Instale a extensão **PHP Server** e clique em:

   * **PHP Server: Serve Project**.

Pronto — site funcionando localmente.

---

# 📌 Próximos passos do projeto

* Implementar sistema de login real com níveis de acesso.
* Criar carrinho de compras totalmente funcional.
* Adicionar páginas para vendedores.
* Melhorar responsividade.
* Integrar com Gateway de Pagamento (MercadoPago / PagSeguro).
* Criar painel administrativo.

---

# 🤝 Contribuições

Sinta-se à vontade para contribuir abrindo issues ou pull requests.

# 📄 Licença

Este projeto é educacional e de uso livre para fins acadêmicos.

---

Feito com ❤️ pela equipe AgroTec

