-- migrate_add_preco.sql
-- Adiciona coluna 'preco' à tabela produtos (execute apenas uma vez)
ALTER TABLE IF EXISTS produtos
ADD COLUMN IF NOT EXISTS preco DECIMAL(8,2) NOT NULL DEFAULT 0 AFTER nome;

-- Exemplo: atualizar preços iniciais (ajuste conforme necessário)
UPDATE produtos SET preco = 29.90 WHERE nome LIKE '%Cenoura%';
