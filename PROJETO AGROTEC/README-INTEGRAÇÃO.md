Integração PHP - AgroTec (carrot)

Resumo
------
Estes arquivos adicionam uma integração básica PHP/MySQL para a página de produto `carrot`.

Arquivos adicionados
- `db.php`: conexão PDO (configure DB_USER e DB_PASS conforme seu ambiente).
- `carrot.php`: versão dinâmica da página que busca o produto `Cenoura` na tabela `produtos`.
- `add_to_cart.php`: endpoint que manipula carrinho via sessão (recebe JSON).
- `buy.php`: endpoint que registra uma venda, itens_vendas e atualiza estoque (transacional).
- `migrate_add_preco.sql`: migração para adicionar coluna `preco` na tabela `produtos`.

Como testar localmente (Windows, XAMPP)
1. Copie a pasta `PROJETO AGROTEC` para `C:\xampp\htdocs\agrotec` (ou use seu diretório htdocs).
2. Inicie o Apache e MySQL pelo painel do XAMPP.
3. Importe o schema/seed do banco se ainda não estiver criado (use `agrotech.sql` que existe no projeto). Se precisar adicionar a coluna de preço, execute `migrate_add_preco.sql` no banco.
4. Abra no navegador: http://localhost/agrotec/carrot.php

Configurações importantes
- Em `db.php`, ajuste `DB_USER` e `DB_PASS`.
- O script `buy.php` assume que as tabelas `vendas`, `itens_vendas` e `produtos` existem (conforme `agrotech.sql`). Faça backup antes de rodar em produção.

Notas e próximos passos
- Melhorar autenticação de usuários e associar `vendas.id_clienteFK` a um cliente autenticado.
- Implementar paginação/visualização do carrinho e checkout real com gateway (MercadoPago, etc.).
- Validar e sanitizar todas as entradas antes de usar em produção.
