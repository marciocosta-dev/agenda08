-- =====================================================================
--  banco.sql  |  Sistema de Cadastro de Amigos da Gabi
-- ---------------------------------------------------------------------
--  Como usar: abra o phpMyAdmin (aba SQL) ou o MySQL Workbench,
--  cole todo este conteúdo e execute.
--  Pode ser executado várias vezes sem problemas.
-- =====================================================================

-- ---------------------------------------------------------------------
--  1) Banco de dados
-- ---------------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS cadastro_amigos
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE cadastro_amigos;

-- ---------------------------------------------------------------------
--  2) Tabela de usuários (login do sistema)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  usuario    VARCHAR(80)  NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,              -- hash bcrypt, nunca a senha pura
  criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------------
--  3) Tabela de amigos
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS amigos (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nome       VARCHAR(120) NOT NULL,
  telefone   VARCHAR(30)  NULL,
  email      VARCHAR(190) NULL,
  criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------------
--  4) Conta demonstrativa para o primeiro acesso
--       usuário: gabi
--       senha:   password
--     Se o usuário já existir, apenas atualiza o hash da senha.
-- ---------------------------------------------------------------------
INSERT INTO usuarios (usuario, senha_hash)
VALUES ('gabi', '$2y$10$5Wbtmol4S4VMo3h6.R1n5eXWY10cqlx/aGpcfXZ8uJRihqpiiorJK')
ON DUPLICATE KEY UPDATE senha_hash = VALUES(senha_hash);
